// router/index.js
import { createRouter, createWebHistory } from 'vue-router';
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
    },
  },
  {
    path: '/create',
    name: 'ItineraryCreationView',
    component: ItineraryCreationView,    
  },
  {
    path: '/favoris',
    name: 'Bookmarks',
    component: BookmarkView,
    meta: {
      title: 'Mes favoris',
      requireNav: true,
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
  history: createWebHistory(),
  routes,
});

export default router;