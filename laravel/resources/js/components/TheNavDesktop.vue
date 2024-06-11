<script setup>
import { onMounted, ref } from 'vue';
import { Home, Users, Map, Plus, Bookmark } from 'lucide-vue-next';
import { isDesktop } from '../utils/Breakpoints.js'; // Ensure you have a utility function to detect desktop devices
import { Menu } from 'lucide-vue-next';
import { UserLocalStorage } from '@/classes/UserLocalStorage.js';
const currentUser = new UserLocalStorage();

</script>

<template>

    <div v-if="isDesktop.value" class="p-4">
        <div class="flex justify-between items-center">

            <!-- Navigation Links -->
            <nav class="hidden md:flex space-x-8 md:flex-row">
                <router-link  aria-label="Accueil" to="/">
                    <!-- <Home stroke="#f5f5f5" :size="30" />
                    <span aria-hidden="true">Accueil</span> -->
                    <img src="/images/logo/logo-tv-brun.svg" alt="Logo Terra Vaud">
                </router-link>                
               
                <router-link class="opacity-60 hover:opacity-100 flex items-center" aria-label="Parcours de la communauté" to="/community">
                    <span aria-hidden="true">Communauté</span>
                </router-link>
                <router-link class="opacity-60 hover:opacity-100 flex items-center" aria-label="Carte des parcours" to="/map">
                    <span aria-hidden="true">Carte</span>
                </router-link>
            </nav>

            <!-- Right Side Content -->
            <div class="flex items-center space-x-4">
                <router-link class="btn" aria-label="Créer un parcours" to="/create">
                    <span aria-hidden="true">Créer un parcours</span>
                </router-link>                
                <!-- <span class="btn placeholder-icon">
                    <Menu stroke="#000" :size="24" /> 
                    <img src="https://loremflickr.com/300/300" alt="Profile Picture" class="rounded-full h-6 w-6" />
                </span> -->
                <router-link v-if="isDesktop.value" aria-label="Profile utilisateur" to="/user/profile">
              <div class="max-w-12 h-12">
                <img class="h-full rounded-full object-cover" :src="currentUser.getUserImageProfile()" alt="">
              </div>               
            </router-link>
            </div>
        </div>
    </div>

</template>


<style scoped>
.desktop-header {
    background-color: #F5F5F5;
    /* Background color */
}

/* Placeholder for an icon */
.placeholder-icon {
    display: flex;
    align-items: center;
    gap: 8px;
}
</style>