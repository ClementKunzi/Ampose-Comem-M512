<script setup>
import FormNewItinerary from '@/components/forms/FormNewItinerary.vue';
import { CircleX } from 'lucide-vue-next';


</script>

<template>
  
  <div class="p-4">
    <button @click="$router.go(-1)"
        class="mr-auto btn-iconContainer" aria-label="Retour">        
          <CircleX aria-hidden="true" :size="32" />              
      </button>
    <h1 class="h3 pb-4 text-tv-wine text-center">Nouveau parcours</h1 class="h3">
  <FormNewItinerary />
  </div>
</template>