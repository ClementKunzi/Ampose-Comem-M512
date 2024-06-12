<script setup>
import { useRoute } from 'vue-router';
import MapItineraryStep from '../../components/MapItineraryStep.vue';
import { ExternalLink } from 'lucide-vue-next';

const itinerary = JSON.parse(localStorage.getItem('currentItinerary'));

const route = useRoute();
console.log('route', route.params.stepId);
const stepId = route.params.stepId - 1;
const step = itinerary.data.steps[stepId]
console.log('step', step);

</script>
<template>  
  <div :style="{ 'background-image': 'url(storage/images/' + step.images[0].url + ')' }"
    class="bg-center w-screen h-[250px] p-4 flex">
  </div>
  <div class="p-4">
    <div class="mb-16">
      <h1 class="h3 text-tv-wine">
      {{ step.name }}
    </h1>
    <address class="not-italic text-tv-wine">{{ step.adress }}</address>
    </div>

    <div class="mb-16">
      <h3 class="text-tv-wine h4">Description</h3>
      <p>{{ step.description }}</p>
    </div>

    <div class="mb-16">
      <h3 class="text-tv-wine h4">Emplacement</h3>
      <MapItineraryStep />
    </div>

    <div class="flex justify-center">     
      <a :href="step.external_link" rel="noopener" target="_blank" class="btn">
        <button class="mr-2 bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
          aria-label="Télécharger">
          <ExternalLink aria-hidden="true" stroke="#754043" :size="18" />
        </button>
        Plus d'infos</a>
    </div>    
  </div>


</template>