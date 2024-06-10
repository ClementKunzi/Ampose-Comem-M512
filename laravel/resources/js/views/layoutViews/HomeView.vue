<script setup>
import { computed, onMounted, ref } from 'vue';
import SearchBar from '../../components/TheSearch.vue';
import axios from 'axios';
import CardItinerary from '../../components/CardItinerary.vue';
import { storeItineraries } from '../../stores/StoreItineraries.js';
import { useSelectedCategoryStore } from '../../stores/StoreSelectedCategories.js';
import { useSelectedAccessibilityStore } from '../../stores/StoreSelectedAccessibility.js';
import { useRoute } from 'vue-router';

const route = useRoute();

const searchQuery = ref('');

const itineraries = computed(() => {
  let sourceFilter = '';
  if (route.meta && route.meta.sourceItinerary) {
    sourceFilter = route.meta.sourceItinerary;
  }

  const { selectedCategoryIds } = useSelectedCategoryStore();
  const categoryIds = selectedCategoryIds.value || [];

  const { selectedAccessibilityIds } = useSelectedAccessibilityStore();
  const accessibilityIds = selectedAccessibilityIds.value || [];


  return storeItineraries.itineraries.filter(itinerary =>
    (!sourceFilter || itinerary.source === sourceFilter) &&
    (categoryIds.length === 0 || itinerary.tag_categorie.some(tag => categoryIds.includes(tag.id))) &&
    (accessibilityIds.length === 0 || itinerary.tag_accessibility.some(tag => accessibilityIds.includes(tag.id))) &&
    itinerary.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

onMounted(async () => {
  // Logique de montage ici, si nécessaire
});
</script>


<template>
  <div class="p-4">
    <SearchBar v-model="searchQuery" />

    <router-view />
    <h2 class="h3 text-tv-wine"> {{ $route.meta.title }}</h2>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-24">
      <router-link v-for="itinerary in itineraries" :key="itinerary.id" :to="`/itinerary/${itinerary.id}`">
        <CardItinerary :itinerary="itinerary" :image="itinerary.image.url" />
      </router-link>
    </div>
  </div>
</template>
