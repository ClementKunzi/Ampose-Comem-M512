<script setup>
import { onMounted, ref } from 'vue';
import SearchBar from '../../components/TheSearch.vue';
import axios from 'axios';

const data = ref(null); // Create a reactive data property

onMounted(async () => {
  // try {
  //   const response = await axios.get('https://data.sbb.ch/api/explore/v2.1/catalog/datasets/stadtefahrplan/records?limit=20');
  //   data.value = response.data;
  //   console.log('data', + data) // Update the data property
  // } catch (error) {
  //   console.error(error);
  // }
});
</script>

<template>
  <div class="p-4">
    <!-- <div>Data: {{ data }}</div> -->
    <SearchBar />
    <router-view />
  </div>

</template>