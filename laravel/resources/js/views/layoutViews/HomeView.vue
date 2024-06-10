<script setup>
import { onMounted, ref } from 'vue';
import SearchBar from '../../components/TheSearch.vue';
import axios from 'axios';
import CardItinerary from '../../components/CardItinerary.vue';
import { storeItineraries } from '../../stores/StoreItineraries.js';


const data = ref(null); // Create a reactive data property

onMounted(async () => {
});
</script>

<script>

export default {
  name: 'Itineraries',
  computed: {
    itineraries() {
      const sourceFilter = this.$route.meta.sourceItinerary;

      return storeItineraries.itineraries.filter(itinerary => itinerary.source === sourceFilter);
    },
  },
};
</script>

<template>
  <div class="p-4">

    <SearchBar />
    <router-view />
    <h2 class="h3 text-tv-wine"> {{ $route.meta.title }}</h2>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <router-link v-for="itinerary in itineraries" :key="itinerary.id" :to="`/itinerary/${itinerary.id}`">
        <CardItinerary :itinerary="itinerary" :image="itinerary.image.url" />
      </router-link>
    </div>
  </div>

</template>
