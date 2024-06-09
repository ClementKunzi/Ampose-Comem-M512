import { createRouter, createWebHashHistory, useRoute } from 'vue-router';
import { watch } from 'vue';
import HomeView from '@/views/layoutViews/HomeView.vue';
import HomeViewContent from '@/views/contentViews/HomeViewContent.vue';
import CommunityViewContent from '@/views/contentViews/CommunityViewContent.vue';
import MapView from '@/views/layoutViews/MapView.vue';
import ItineraryCreationView from '@/views/layoutViews/ItineraryCreationView.vue';
import BookmarkView from '@/views/layoutViews/BookmarkView.vue';
import ItineraryView from '@/views/layoutViews/ItineraryView.vue';
import ItineraryStepView from '@/views/layoutViews/ItineraryStepView.vue';
import UserView from '@/views/layoutViews/UserView.vue';
import UserAuthView from '@/views/layoutViews/UserAuthView.vue';
import OnboardingView from '@/views/layoutViews/OnboardingView.vue';
import UserEditView from '@/views/layoutViews/UserEditView.vue';
import ItineraryCreationStepView from '@/views/layoutViews/ItineraryCreationStepView.vue';
import { getUserAccessToken } from '../utils/UserAccessToken.js';
import { storeItineraryById } from '../stores/StoreItinerary.js';
import { showMarker } from '../utils/MarkersVisibility.js';

// Function to check if the user is authenticated
function isAuthenticated() {
  // Example: Check for an accessToken in localStorage
  return getUserAccessToken();
}

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomeView,
    meta: {
      title: 'Tous les sentiers',
      requireNav: true,
    },

    children: [
      {
        path: '',
        component: HomeViewContent,
      },
      // {
      //   path: 'itinerary/:id',
      //   name: 'home.itinerary.view',
      //   component: ItineraryView,
      // },
    ],
  },
  {
    path: '/community',
    name: 'Community',
    component: HomeView,
    meta: {
      title: 'Tous les sentiers de la commu',
      requireNav: true,
    },

    children: [
      {
        path: '',
        component: CommunityViewContent,
      },      
    ],
  },
  {
    path: '/map',
    name: 'Map',
    component: MapView,
    meta: {      
      requireNav: true,      
    },
  },
  {
    path: '/create',
    name: 'ItineraryCreationView',
    component: ItineraryCreationView,   
    meta: {
      requiresAuth: true,
    }, 
  },
  {
    path: '/create/steps',
    name: 'ItineraryCreationStepView',
    component: ItineraryCreationStepView,    
  },
  {
    path: '/favoris',
    name: 'Bookmarks',
    component: BookmarkView,
    meta: {
      title: 'Mes favoris',
      requireNav: true,
      requiresAuth: true,
    },
  },
  {
    path: '/itinerary/:id',
    name: 'itinerary.view',
    component: ItineraryView,
    beforeEnter: async (to, from, next) => {
      const itineraryId = to.params.id;
      
      try {
        storeItineraryById(itineraryId);
        console.log('Itinerary data fetched:', storeItineraryById(itineraryId));
        window.addEventListener('popstate', function(event) {
          // Trigger showMarker function when navigating back
          showMarker();
      });
      
        next(); // Proceed to the route
      } catch (error) {
        console.error('Failed to fetch itinerary data:', error);
        next(false);
      }
    },
    children: [
      {
        path: 'step/:stepId',
        name: 'itinerary.step.view',
        // component: StepView,
        // You can also use props to pass route params as props to the component
        props: true
      }
    ],
  },
  // {
  //   path: '/itinerary/:id/step/:stepId',
  //   name: 'itinerary.step.view',
  //   component: ItineraryView,
  // },
  {
    path: '/user/profile',
    name: 'user.view',
    component: UserView,
    meta: {
      requiresAuth: true,
    }
  },
  {
    path: '/user/auth',
    name: 'user.auth.view',
    component: UserAuthView,    
  },
  {
    path: '/user/edit',
    name: 'user.edit.view',
    component: UserEditView,
  },
  {
    path: '/onboarding',
    name: 'onboarding.view',
    component: OnboardingView,
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

const route = useRoute();

// authentified user redirection
router.beforeEach((to, from, next) => {
  // Check if the route requires authentication
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  
  // If the route requires auth and the user is not authenticated,
  // redirect to the login page.
  if (requiresAuth &&!isAuthenticated()) {
      next('/user/auth'); // Redirect to login page
  } else if (
      // If the user is already authenticated and tries to access the login page,
      // redirect them to the home page or another suitable page.
      to.path === '/user/auth' && isAuthenticated()
  ) {
      next('/');
  } else {
      // Proceed with the route transition
      next();
  }
});



// watch(() => route.params.id, (newId, oldId) => {
//   if(newId !== oldId) {
//     console.log('Route changed:', newId);
//   }
// }), { immediate: true };

  export default router;