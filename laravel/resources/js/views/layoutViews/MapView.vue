<template>
  <div class="p-4">    
    <SearchBar v-model="searchQuery" />
    <MapFullScreen />
  </div>
  
</template>

<script setup>
import { ref, onMounted } from 'vue';

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet-routing-machine';
import MapFullScreen from '../../components/MapFullScreen.vue';
import SearchBar from '../../components/TheSearch.vue';
import { storeMap } from '../../stores/storeMap.js';

</script>