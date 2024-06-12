<script setup>
import { onMounted, computed, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { Bookmark, CircleX, Share, Download, Star, MapPin, Footprints, Route, Clock, Mountain, Accessibility, TriangleAlert, SquareArrowOutUpRight } from 'lucide-vue-next';
import { hideMarker } from '../../utils/MarkersVisibility.js';

//gestion des favoris
import ManageFavorite from '../../utils/ManageFavorite.js'; 
import { getFavorites } from '../../stores/StoreFavoriteIcon.js';
import { getFavoritesFromId } from '../../stores/StoreFavoriteIcon.js';
import { getLocalStorageUser } from '../../utils/LocalStorageUser';
import { ApiGetFavorites } from '../../utils/apiCalls/ApiGetFavorites';

import "leaflet/dist/leaflet.css";
import * as L from 'leaflet';
import 'leaflet-routing-machine';
import 'leaflet-routing-machine/dist/leaflet-routing-machine.css';
import { storeItinerary } from '../../stores/StoreItinerary.js';

const route = useRoute();
const router = useRouter();
const routeItinerary = computed(() => route.name === 'itinerary.view');
const stepId = computed(() => route.params.stepId - 1);

const itinerary = computed(() => storeItinerary.itinerary.data);
const steps = computed(() => storeItinerary.itinerary.data.steps);
const step = computed(() => storeItinerary.itinerary.data.steps[stepId.value]);

// Function to check if user is logged in
const isLoggedIn = () => {
  const user = getLocalStorageUser();
  return user && user.userConnexion && user.userConnexion.accessToken !== null;
};

//gestion des favoris
const props = defineProps({
  itinerary: Object,
});

const isFavorite = computed(() => getFavorites().some(favorite => favorite.itinerary_id === props.itinerary?.id));

const emit = defineEmits(['requireNav']);

const stepAccess = (id) => {
  router.push(`${route.fullPath}/step/${id + 1}`);
}

const itineraryId = ref(props.itinerary?.id);

const bookmarkIconRef = ref(null);

const isFavoriteState = ref(false); // Initialisation par défaut à false

defineExpose({ bookmarkIconRef, isFavoriteState });

const changeFavorite = async (itineraryId) => {
  await ManageFavorite(itineraryId);
  isFavoriteState.value = !isFavoriteState.value;
};

const checkIfFavorite = async () => {
  const user = getLocalStorageUser();
  if (user && user.userData && user.userData.id && props.itinerary?.id) {
    const favorites = await ApiGetFavorites(user.userData.id);
    isFavoriteState.value = favorites.some(fav => fav.itinerary_id === props.itinerary.id);
  }
};

const fillFavorite = (itineraryId) => {
  getFavoritesFromId(itineraryId);
};
hideMarker(stepId);

onMounted(() => {
  let coordinates = steps.value.map(step => [step.latitude, step.longitude]);
  let stepTitles = steps.value.map(step => step.name);

  const orsToken = '1894ebf9-bfe5-4ab1-80b2-e8ccf733ab5e';
  var map = L.map('map', {
    scrollWheelZoom: false,
  });

  L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  let waypoints = coordinates.map(coord => L.latLng(coord[0], coord[1]));

  var customIcon = L.icon({
    iconUrl: '/images/map/marker.png',
    iconSize: [38, 38], // size of the icon
    shadowSize: [50, 64], // size of the shadow
    iconAnchor: [19, 38], // point of the icon which will correspond to marker's location
  });

  let control = L.Routing.control({
    waypoints,
    serviceUrl: "http://routing.openstreetmap.de/routed-foot/route/v1",
    language: 'fr',
    routeWhileDragging: false,
    createMarker: function (i, wp, nWps) {
      return L.marker(wp.latLng)
        .bindPopup(stepTitles[i]).on('click', function (e) {
          stepAccess(i)
          hideMarker(i)
        });
    },
    createMarker: function (i, waypoint, n) {
      return L.marker(waypoint.latLng, {
        draggable: false,
        icon: customIcon,
      });
    },
    lineOptions: {
      styles: [{ color: '#754043', opacity: .8, weight: 3 }] // Set the color of the route line
    },
    addWaypoints: false,
    draggableWaypoints: false,
    showInstructions: false,
  }).addTo(map);

  L.Control.geocoder().addTo(map);

  if (props.itinerary) {
    itineraryId.value = props.itinerary.id;
  }

  checkIfFavorite(); // Vérifiez l'état des favoris lors du montage du composant
  fillFavorite();
});
</script>

<template>
  <div class="md:mr-[15%] md:ml-[15%]">
    <div>
      <div
        v-if="routeItinerary"
        :style="{ 'background-image': 'url(storage/images/' + itinerary.image.url + ')' }"
        class="bg-center w-full h-[250px] p-4 flex"
      >
        <button
          @click="$router.go(-1)"
          class="mr-auto bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
          aria-label="Retour"
        >
          <CircleX aria-hidden="true" stroke="#754043" :size="18" />
        </button>
        <button
          class="mr-2 bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
          aria-label="Télécharger"
        >
          <Share aria-hidden="true" stroke="#754043" :size="18" />
        </button>
        <button v-if="isLoggedIn()"
          class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
          :aria-label="isFavoriteState ? 'Supprimer des favoris' : 'Ajouter aux favoris'"
          @click="changeFavorite(itinerary.id)"
        >
          <Bookmark :fill="isFavoriteState ? '#754043' : 'transparent'" stroke="#754043" :size="18" />
        </button>
      </div>
      <div
        v-else
        :style="{ 'background-image': 'url(storage/images/' + step.images[0].url + ')' }"
        class="bg-center w-screen h-[250px] p-4 flex"
      ></div>
    </div>
    <div class="p-4">
      <ul class="mt-[-2rem] flex gap-3">
        <li class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center" aria-label="Nom catégorie">
          <Bookmark aria-hidden="true" stroke="#754043" :size="18" />
        </li>

        <li class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center" aria-label="Nom catégorie">
          <Bookmark aria-hidden="true" stroke="#754043" :size="18" />
        </li>
      </ul>

      <div class="flex justify-between">
        <h1 class="h3 text-tv-wine">
          <span v-if="routeItinerary">{{ itinerary.name }}</span>
          <span v-else>{{ step.name }}</span>
        </h1>
        <div v-if="routeItinerary" class="flex items-center gap-1 text-tv-wine">
          <Star stroke="#754043" :size="18" />
          <p aria-label="Note du parcours sur 5">4.8</p>
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
          <p aria-label="Difficulté du parcours">{{ itinerary.difficulty }}</p>
        </div>
      </div>
      <div v-else class="flex items-center gap-2 mb-16 text-tv-wine">
        <address class="not-italic">{{ step.adress }}</address>
      </div>

      <div v-if="routeItinerary" class="mb-16 bg-tv-wine text-tv-eggshell rounded-3xl p-8 flex justify-between">
        <div class="flex flex-col items-center flex-wrap">
          <div class="w-full flex items-center gap-1 text-tv-beige">
            <Route stroke="#FAF0CA" :size="18" />
            <p>Distance</p>
          </div>
          <p>4.5 km</p>
        </div>

        <div class="flex flex-col items-center flex-wrap">
          <div class="w-full flex items-center gap-1 text-tv-beige">
            <Clock stroke="#FAF0CA" :size="18" />
            <p>Durée</p>
          </div>
          <p><time>{{ itinerary.estimated_time }}</time></p>
        </div>

        <div class="flex flex-col items-center flex-wrap">
          <div class="w-full flex items-center gap-1 text-tv-beige">
            <Mountain stroke="#FAF0CA" :size="18" />
            <p>Dénivelé</p>
          </div>
          <p>234m</p>
        </div>
      </div>

      <div class="mb-16">
        <h3 class="text-tv-wine">Description</h3>
        <p v-if="routeItinerary">{{ itinerary.description }}</p>
        <p v-else>{{ step.description }}</p>
      </div>
      <div class="mb-16">
        <h3 class="text-tv-wine">Parcours</h3>
        <div :class="{'map-step': !routeItinerary}">
          <div id="map" class="map-pageLayout map-noUi map-noSearch"></div>
        </div>
      </div>
      <div v-if="routeItinerary" class="text-tv-wine">
        <h3>Accessibilité</h3>
        <ul class="flex flex-col gap-3">
          <li class="flex items-center gap-1">
            <Accessibility aria-hidden="true" stroke="#754043" :size="18" />
            <p>Accès en fauteuil roulant</p>
          </li>
          <li class="flex items-center gap-1">
            <Accessibility aria-hidden="true" stroke="#754043" :size="18" />
            <p>Accès en fauteuil roulant</p>
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
          <p aria-label="Note du parcours sur 5">4.8</p>
        </div>
        <div>
          <div class="border-t border-solid border-tv-wine py-4" v-for="i in 3" :key="i">
            <div class="mb-4 flex gap-4">
              <div class="w-11 h-11">
                <img class="rounded-full" src="https://loremflickr.com/88/88" alt="" />
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
