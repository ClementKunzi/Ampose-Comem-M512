<script setup>
import { onMounted, ref } from 'vue';
import { Home, Users, Map, Plus, Bookmark } from 'lucide-vue-next';

</script>

<template>        
    <nav
    v-if="$route.meta.requireNav"
    class="
    z-50 fixed bottom-4 left-4 
    bg-tv-wine w-[calc(100%-2rem)] rounded-full
    pt-3 pb-4 px-8
    flex justify-between
    text-tv-eggshell text-[.8rem]">
        <router-link class="flex flex-col items-center" aria-label="Accueil" to="/">
            <Home stroke="#f5f5f5" :size="30" />
            <span aria-hidden="true">Accueil</span>
        </router-link>
        <router-link class="flex flex-col items-center" aria-label="Parcours de la communauté" to="/community">
            <Users stroke="#f5f5f5" :size="30" />
            <span aria-hidden="true">Commu</span>
        </router-link>
        <router-link class="flex flex-col items-center" aria-label="Carte des parcours" to="/map">
            <Map stroke="#f5f5f5" :size="30" />
            <span aria-hidden="true">Carte</span>
        </router-link>
        <router-link class="flex flex-col items-center" aria-label="Créer un parcours" to="/create">
            <Plus stroke="#f5f5f5" :size="30" />
            <span aria-hidden="true">Ajouter</span>
        </router-link>
        <router-link class="flex flex-col items-center" aria-label="Favoris" to="/favoris">
            <Bookmark stroke="#f5f5f5" :size="30" />
            <span aria-hidden="true">Favoris</span>
        </router-link>
    </nav>
</template>

<style scoped>
nav a:not(.router-link-active) {
    opacity: .6;
}
</style>