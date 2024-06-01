<script setup>
import { CircleX, Pencil, LogOut } from 'lucide-vue-next';
import CardItinerary from '../../components/CardItinerary.vue';

</script>
<script>
import sourceData from '../../../../data_temp.json';

export default {
  data() {
    return {
      itineraries: sourceData.destinations,      
    };
  }
};
</script>

<template>

  <div class="p-4 flex flex-col grow bg-tv-eggshell text-tv-wine">
    <IconManager
    :icons="icons"
    default-size="24"
  />
    <div class="mb-6 flex justify-between gap-4">
      <button @click="$router.go(-1)"
        class="mr-auto btn-iconContainer" aria-label="Retour">        
          <CircleX aria-hidden="true" :size="32" />              
      </button>
      <button @click="$router.go(-1)"
        class="btn-iconContainer" aria-label="Se déconnecter">
        <LogOut aria-hidden="true" :size="32" />
      </button>
      <router-link to="/user/edit" aria-label="Editer le profile" class="btn-iconContainer">
        <Pencil aria-hidden="true" :size="32" />
      </router-link>     
    </div>
    <div class="mb-1 flex justify-center">
      <img class="max-w-40 rounded-full" src="https://loremflickr.com/300/300" alt="">
    </div>
    <div class="mb-12 text-center">
      <h1 class="h2 ">Maxime Peretti</h1>
      <p aria-label="Adresse mail du compte">maxime@cool.sugus</p>
    </div>

    <div>
      <h2 class="h3 text-tv-wine">Mes sentiers</h2>

      <!-- <Card /> -->
      <router-link v-for="itinerary in itineraries" :key="itinerary.id" :to="`/itinerary/${itinerary.slug}`">
        <CardItinerary :itinerary-name="itinerary.name" />
      </router-link>
    </div>

    <router-link to="/user/auth">Login or register</router-link>   
  </div>
</template>