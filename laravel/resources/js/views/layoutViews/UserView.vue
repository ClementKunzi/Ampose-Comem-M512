<script setup>
import { CircleX, Pencil, LogOut, User } from 'lucide-vue-next';
import CardItinerary from '../../components/CardItinerary.vue';
import { storeItineraries } from '../../stores/StoreItineraries.js';
import { onMounted, ref } from 'vue';
import { UserLocalStorage } from '@/classes/UserLocalStorage.js';
import { logOut } from '../../utils/apiCalls/apiCalls.js';
import axios from 'axios';

const user = new UserLocalStorage();
const userImage = ref(user.getUserImageProfile());

onMounted(() => {


});

</script>
<script>

export default {
  name: 'Itineraries',
  computed: {
    itineraries() {
      return storeItineraries.itineraries;
    },
  },
};
</script>

<template>

  <div class="p-4 flex flex-col grow bg-tv-eggshell text-tv-wine">
    <IconManager :icons="icons" default-size="24" />
    <div class="mb-6 flex justify-between gap-4">
      <button @click="$router.go(-1)" class="mr-auto btn-iconContainer" aria-label="Retour">
        <CircleX aria-hidden="true" :size="32" />
      </button>
      <button @click="() => { logOut(), $router.push('/') }" class="btn-iconContainer" aria-label="Se déconnecter">
        <LogOut aria-hidden="true" :size="32" />
      </button>
      <router-link to="/user/edit" aria-label="Editer le profile" class="btn-iconContainer">
        <Pencil aria-hidden="true" :size="32" />
      </router-link>
    </div>
    <div class="mb-1 flex justify-center">
      <div class="max-w-40 max-h-40 h-40 w-40">
        <img class="h-full w-full rounded-full object-cover" :src="userImage" alt="">
      </div>
    </div>
    <div class="mb-12 text-center">
      <h1 class="h2 ">{{ user.getUserName() }}</h1>
      <p aria-label="Adresse mail du compte">{{ user.getEmail() }}</p>
    </div>

    <div>
      <h2 class="h3 text-tv-wine">Mes sentiers</h2>
      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <router-link v-for="itinerary in itineraries" :key="itinerary.id" :to="`/itinerary/${itinerary.id}`">
          <CardItinerary :itinerary="itinerary" :image="itinerary.image.url" />
        </router-link>
      </div>
    </div>

    <!-- <router-link to="/user/auth">Login or register</router-link>    -->
  </div>
</template>