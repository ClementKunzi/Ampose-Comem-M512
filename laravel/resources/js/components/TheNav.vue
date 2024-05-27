<script setup>
import { onMounted, ref } from 'vue';
import { Home, Users, Map, Plus, Bookmark } from 'lucide-vue-next';

</script>

<template>
    <nav class="
    fixed bottom-4 left-4 
    bg-tv-wine w-[calc(100%-2rem)] rounded-full
    pt-3 pb-5 px-8
    flex justify-between">
        <router-link to="/">
            <Home stroke="#f5f5f5" :size="30" />
        </router-link>
        <router-link to="/community">
            <Users stroke="#f5f5f5" :size="30" />
        </router-link>
        <router-link to="/map">
            <Map stroke="#f5f5f5" :size="30" />
        </router-link>
        <router-link to="/create">
            <Plus stroke="#f5f5f5" :size="30" />
        </router-link>
        <router-link to="/favoris">
            <Bookmark stroke="#f5f5f5" :size="30" />
        </router-link>
    </nav>
</template>

<style scoped>
nav a:not(.router-link-active) {
    opacity: .6;
}
</style>