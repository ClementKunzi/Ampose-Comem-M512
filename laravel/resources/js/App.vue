<script setup>
import TheHeader from './components/TheHeader.vue';
import './utils/LocalStorageUser.js';
import { getUserAccessToken } from './utils/UserAccessToken.js';
import { UserLocalStorage } from '@/classes/UserLocalStorage.js';


// Create an instance of UserLocalStorage
const userLocalStorage = new UserLocalStorage();
// Call initializeUserLocalStorage
userLocalStorage.initializeUserLocalStorage();




if (getUserAccessToken() !== null) {
    // window.location.href = '/login';
    console.log('user connected ');
} else {
    console.log('user not connected ')}
</script>

<!-- Example of using Vue Router in a component -->
<template>
    <TheHeader />
    <main class="grow flex flex-col">

        <router-view />
    </main>
</template>


<style scoped>
/* Your component's CSS styles go here */
</style>