<script setup>


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
  <h2>Tous les sentiers de la communauté</h2> 
  <!-- <Card /> -->
  <router-link v-for="itinerary in itineraries" :key="itinerary.id" :to="`/itinerary/${itinerary.slug}`">
  <div class="max-w bg-slate-500 min-h-[220px] rounded-3xl bg-gradient-to-r from-violet-500 to-fuchsia-500 mb-2 p-6 flex flex-col justify-between">
        <div class="flex justify-between">
            <div>
                <span>cat 1</span>
                <span>cat 2</span>
            </div>
            <div>
                <button>
                    bookmark
                </button>
            </div>
        </div>
        <div class="flex justify-between">
            <div>
                <h3>{{ itinerary.name }}</h3>
                <p>Lieux</p>
            </div>

            <div>
                <p>4.8</p>
                <p>Distance</p>
                <p>Difficulté</p>
            </div>
        </div>
    </div>
  </router-link>
  
</template>