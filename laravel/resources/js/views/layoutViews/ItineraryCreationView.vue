<script setup>
import FormNewItinerary from '@/components/forms/FormNewItinerary.vue';
import { CircleX } from 'lucide-vue-next';


</script>

<template>
  
  <div class="p-4">
    <button @click="$router.go(-1)" class="mr-auto bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
        aria-label="Retour">
        <CircleX aria-hidden="true" stroke="#754043" :size="18" />
      </button>
    <h1 class="h3 text-tv-wine text-center">Nouveau parcours</h1 class="h3">
  <FormNewItinerary />
  </div>
</template>