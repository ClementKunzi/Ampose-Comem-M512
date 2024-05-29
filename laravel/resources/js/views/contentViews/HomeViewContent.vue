<script setup>
import { ref, onMounted } from 'vue';
import CardItinerary from '../../components/CardItinerary.vue';
// import { store } from '../../../stores/StoreNav.js';
// const { requireNav } = useSimpleStore();
</script>

<script>
import sourceData from '../../../../data_temp.json';

export default {
  data() {
    return {
      itineraries: sourceData.destinations
    };
  }
};
</script>

<template>
  <h2 class="h3 text-tv-wine"> {{ $route.meta.title }}</h2>
  
  <!-- <Card /> -->
  <router-link v-for="itinerary in itineraries" :key="itinerary.id" :to="`/itinerary/${itinerary.slug}`">
    <CardItinerary :itinerary-name="itinerary.name" />
  </router-link>
  
</template>