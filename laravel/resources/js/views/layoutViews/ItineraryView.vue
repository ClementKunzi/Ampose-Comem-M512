<script setup>
import { onMounted } from 'vue';
const emit = defineEmits(['requireNav']);

onMounted(() => {
  emit('requireNav', true); 
});
</script>

<template>
  
  <h2>Itinerary View</h2>
  <h3>{{ $route.params.id }}</h3>
</template>