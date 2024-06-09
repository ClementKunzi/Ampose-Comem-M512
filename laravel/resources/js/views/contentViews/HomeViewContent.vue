<script setup>
import { ref, onMounted } from 'vue';
import CardItinerary from '../../components/CardItinerary.vue';
import { storeItineraries } from '../../stores/StoreItineraries.js';

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
  <h2 class="h3 text-tv-wine"> {{ $route.meta.title }}</h2>

  <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    <router-link v-for="itinerary in itineraries" :key="itinerary.id" :to="`/itinerary/${itinerary.id}`">
      <CardItinerary :itinerary="itinerary" :image="itinerary.image.url" />
    </router-link>
  </div>

</template>