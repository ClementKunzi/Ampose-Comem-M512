// router/index.js
import { createRouter, createWebHashHistory } from 'vue-router';
import HomeView from '@/views/layoutViews/HomeView.vue';
import HomeViewContent from '@/views/contentViews/HomeViewContent.vue';
import CommunityViewContent from '@/views/contentViews/CommunityViewContent.vue';
import MapView from '@/views/layoutViews/MapView.vue';
import ItineraryCreationView from '@/views/layoutViews/ItineraryCreationView.vue';
import BookmarkView from '@/views/layoutViews/BookmarkView.vue';
import ItineraryView from '@/views/layoutViews/ItineraryView.vue';
import UserView from '@/views/layoutViews/UserView.vue';
import UserAuthView from '@/views/layoutViews/UserAuthView.vue';
import OnboardingView from '@/views/layoutViews/OnboardingView.vue';
import UserEditView from '@/views/layoutViews/UserEditView.vue';
import ItineraryCreationStepView from '@/views/layoutViews/ItineraryCreationStepView.vue';
import { getUserAccessToken } from '../utils/UserAccessToken.js';

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
      // {
      //   path: 'itinerary/:id',
      //   name: 'community.itinerary.view',
      //   component: ItineraryView,
      // },
    ],
  },
  {
    path: '/map',
    name: 'Map',
    component: MapView,
    meta: {      
      requireNav: true,
      requiresAuth: true,
    },
  },
  {
    path: '/create',
    name: 'ItineraryCreationView',
    component: ItineraryCreationView,    
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
  },
  {
    path: '/user/profile',
    name: 'user.view',
    component: UserView,
  },
  {
    path: '/user/auth',
    name: 'user.auth.view',
    component: UserAuthView,
  },
  {
    path: '/user/edit',
    name: 'user.aueditth.view',
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

// Global beforeEach guard
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

export default router;
