<script setup>
import { onMounted, ref } from 'vue';
import { Home, Users, Map, Plus, Bookmark } from 'lucide-vue-next';
import { isDesktop } from '../utils/Breakpoints.js'; // Ensure you have a utility function to detect desktop devices
import { Menu } from 'lucide-vue-next';


</script>

<template>
    <header v-if="$route.meta.requireNav && isDesktop.value" class="desktop-header">
      <div class="p-4">
        <div class="flex justify-between items-center">
          <!-- Logo -->
          <!-- <a href="#"><img src="/../../images/logo/logo-tv-brun.svg" alt=""></a> -->
          
          <!-- Navigation Links -->
          <nav class="hidden md:flex space-x-8 md:flex-row">
            <a href="#"><img src="/../../images/logo/logo-tv-brun.svg" alt=""></a>

            <router-link class="hover:text-[#754043]" aria-label="Accueil" to="/">
              <span aria-hidden="true">Accueil</span>
            </router-link>
            <router-link class="hover:text-[#754043]" aria-label="Parcours de la communauté" to="/community">
              <span aria-hidden="true">Communauté</span>
            </router-link>
            <router-link class="hover:text-[#754043]" aria-label="Carte des parcours" to="/map">
              <span aria-hidden="true">Carte</span>
            </router-link>
          </nav>
          
          <!-- Right Side Content -->
          <div class="flex items-center space-x-4">
            <button class="btn">Créer un parcours</button>
            <span class="btn placeholder-icon">
              <Menu stroke="#000" :size="24" /> <!-- Burger menu icon -->
              <img src="https://loremflickr.com/300/300" alt="Profile Picture" class="rounded-full h-6 w-6" /> <!-- Profile picture -->
            </span> <!-- End of placeholder-icon span -->
          </div>
        </div>
      </div>
    </header>
  </template>
  

<style scoped>
.desktop-header {
  background-color: #F5F5F5; /* Background color */
}

/* Placeholder for an icon */
.placeholder-icon {
  display: flex;
  align-items: center;
  gap: 8px;
}

</style>
