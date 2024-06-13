<script setup>
import TheNav from './TheNav.vue';
import TheNavDesktop from './TheNavDesktop.vue';
import { isDesktop } from  '../utils/Breakpoints.js';

</script>

<template>
<header v-if="$route.meta.requireNav && isDesktop.value" class="desktop-header w-full">
    
    

</header>   

    
</template>

<style scoped>
</style>