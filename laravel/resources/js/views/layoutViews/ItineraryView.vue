<script setup>
import { onMounted, computed, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { Bookmark, CircleX, Share, Download, Star, MapPin, Footprints, Route, Clock, Mountain, Accessibility, TriangleAlert, SquareArrowOutUpRight } from 'lucide-vue-next';
import { hideMarker } from '../../utils/MarkersVisibility.js';

import "leaflet/dist/leaflet.css"
import * as L from 'leaflet';
import 'leaflet-routing-machine';
import 'leaflet-routing-machine/dist/leaflet-routing-machine.css';
import { storeItinerary } from '../../stores/StoreItinerary.js';
import MapFullScreen from '../../components/MapFullScreen.vue';

const route = useRoute();
const router = useRouter();
const routeItinerary = computed(() => {
  return route.name === 'itinerary.view';
});
const stepId = computed(() => route.params.stepId-1);


const itinerary = computed(() => storeItinerary.itinerary.data);
const steps = computed(() => storeItinerary.itinerary.data.steps);
const step = computed(() => storeItinerary.itinerary.data.steps[stepId.value]);





const emit = defineEmits(['requireNav']);

const stepAccess = (id) => {
  router.push(`${route.fullPath}/step/${id+1}`);
}
</script>

<template>
  
  <div class="md:mr-[15%] md:ml-[15%]">
  <div>   
    <div v-if="routeItinerary" :style="{ 'background-image': 'url(storage/images/' + itinerary?.image.url + ')' }"
      class="bg-center w-full h-[250px] p-4 flex">
      <button @click="$router.go(-1)" class="mr-auto bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
        aria-label="Retour">
        <CircleX aria-hidden="true" stroke="#754043" :size="18" />
      </button>
      <button class="mr-2 bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
        aria-label="Télécharger">
        <Share aria-hidden="true" stroke="#754043" :size="18" />
      </button>
      <button class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
        aria-label="Ajouter aux favoris">
        <Bookmark aria-hidden="true" stroke="#754043" :size="18" />
      </button>
    </div>
    <div v-else :style="{ 'background-image': 'url(storage/images/' + step.images[0].url + ')' }"
      class="bg-center w-screen h-[250px] p-4 flex"></div>
  </div>
  <div class="p-4">
    <ul class="mt-[-2rem] flex gap-3">
        <li v-for="tag in itinerary?.tag_categorie" :key="tag.id" class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center" aria-label="tag.taxonomy.name">
                    <img :src="`storage/icons/${tag.taxonomy.icon}`" :alt="tag.taxonomy.description" style="width: 20px; height: 20px;">
                </li>
    </ul>

    <div class="flex justify-between">
      <h1 class="h3 text-tv-wine">
        <span v-if="routeItinerary">
          {{ itinerary?.name }}
        </span>
        <span v-else>
          {{ step.name }}
        </span>
      </h1>
      <div v-if="routeItinerary" class="flex items-center gap-1 text-tv-wine">
        <Star stroke="#754043" :size="18" />
        <p aria-label="Note du parcours sur 5">
          4.8</p>
      </div>
    </div>
    <div v-if="routeItinerary" class="flex items-center gap-2 mb-16">
      <div class="flex items-center gap-1 text-tv-wine">
        <MapPin stroke="#754043" :size="18" />
        <address class="not-italic">Lausanne</address>
      </div>
      <div class="w-1 h-1 mt-[.3rem] bg-tv-wine rounded-full"></div>
      <div class="flex items-center gap-1 text-tv-wine">
        <Footprints stroke="#754043" :size="18" />
        <p aria-label="Difficulté du parcours">{{ itinerary?.difficulty }}</p>
      </div>
    </div>
    <div v-else class="flex items-center gap-2 mb-16 text-tv-wine">
      <address class="not-italic">{{ step.adress }}</address>
    </div>

    <div v-if="routeItinerary" class="mb-16 bg-tv-wine text-tv-eggshell rounded-3xl p-8 flex justify-between">
      <div class="flex flex-col items-center flex-wrap">
        <div class="w-full flex items-center gap-1 text-tv-beige">
          <Route stroke="#FAF0CA" :size="18" />
          <p>Distance
          </p>
        </div>
        <p>4.5 km</p>
      </div>

      <div class="flex flex-col items-center flex-wrap">
        <div class="w-full flex items-center gap-1 text-tv-beige">
          <Clock stroke="#FAF0CA" :size="18" />
          <p>Durée
          </p>
        </div>
        <p><time>{{itinerary?.estimated_time}}</time></p>
      </div>

      <div class="flex flex-col items-center flex-wrap">
        <div class="w-full flex items-center gap-1 text-tv-beige">
          <Mountain stroke="#FAF0CA" :size="18" />
          <p>Dénivelé
          </p>
        </div>
        <p>234m</p>
      </div>

    </div>

    <div class="mb-16">
      <h3 class="text-tv-wine">Description</h3>
      <p v-if="routeItinerary">{{ itinerary?.description}}</p>
      <p v-else>{{ step.description }}</p>
    </div>
    <div class="mb-16">
      <h3 class="text-tv-wine">Parcours</h3>
      <div :class="{'map-step':!routeItinerary}">
        <div id="map" class="map-pageLayout map-noUi map-noSearch"></div>
      </div>
    </div>
    <div v-if="routeItinerary" class="text-tv-wine">
      <h3>Accessibilité</h3>
      <ul class="flex flex-col gap-3">
        <li v-for="tag in itinerary?.tag_accessibility" :key="tag.id" class="flex items-center gap-1">
                    <img :src="`storage/icons/${tag.taxonomy.icon}`" :alt="tag.taxonomy.description" >
                    <p>{{ tag.taxonomy.name }}</p>
                </li>
      </ul>
    </div>
    <div v-if="routeItinerary" class="mb-16 justify-center">
      <button class="btn">
        <Download aria-hidden="true" stroke="#754043" :size="18" />
        Télécharger le parcours
      </button>
    </div>
    <div v-else class="mb-16 flex justify-center">
      <a href="" class="btn">
        <SquareArrowOutUpRight aria-hidden="true" stroke="#754043" :size="18" />
        En savoir plus
      </a>
    </div>
    <div v-if="routeItinerary">
      <h3 class="text-tv-wine">Avis de la communauté <span>(8)</span></h3>
      <div class="flex items-center gap-1 text-tv-wine">
        <Star stroke="#754043" :size="18" />
        <p aria-label="Note du parcours sur 5">
          4.8</p>
      </div>
      <div>
        <div class="border-t border-solid border-tv-wine py-4" v-for="i in 3" :key="i">
          <div class="mb-4 flex gap-4">
            <div class="w-11 h-11">
              <img class="rounded-full" src="https://loremflickr.com/88/88" alt="">
            </div>
            <div>
              <h4>Username</h4>
              <div class="flex items-center gap-1" aria-label="Note de l'utilisateur: 5 étoiles sur 5">
                <Star aria-hidden="true" stroke="#754043" :size="18" />
                <Star aria-hidden="true" stroke="#754043" :size="18" />
                <Star aria-hidden="true" stroke="#754043" :size="18" />
                <Star aria-hidden="true" stroke="#754043" :size="18" />
                <Star aria-hidden="true" stroke="#754043" :size="18" />
              </div>
            </div>
          </div>
          <p class="mb-4">Pizza très bonne, je recommande Pizza très bonne, je recommande sdf kjbs dfksdj nf 👍</p>
          <p class="text-right"><time aria-label="">11.11.2023</time></p>
        </div>
        <button class="btn">Afficher plus de commentaires</button>
      </div>
      <div>
        <a href="#" class="link justify-center">
          <TriangleAlert aria-hidden="true" stroke="#754043" :size="18" />
          Signaler un problème avec ce parcours
        </a>
      </div>
    </div>
  </div>
</div>

</template>
