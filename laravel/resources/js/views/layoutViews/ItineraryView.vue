<script setup>
import { onMounted } from 'vue';
import { Bookmark, CircleX, Share, Download, Star, MapPin, Footprints, Route, Clock, Mountain, Accessibility, TriangleAlert } from 'lucide-vue-next';

import "leaflet/dist/leaflet.css"
import * as L from 'leaflet';
import 'leaflet-routing-machine';
import 'leaflet-routing-machine/dist/leaflet-routing-machine.css';

const emit = defineEmits(['requireNav']);

onMounted(() => {

  const orsToken = '1894ebf9-bfe5-4ab1-80b2-e8ccf733ab5e';
  var map = L.map('map', {
    scrollWheelZoom: false,
  });

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  let control = L.Routing.control({
    // router: new L.Routing.GraphHopper(orsToken),
    waypoints: [
      L.latLng(46.777933, 6.6442309),
      L.latLng(46.7779608, 6.6306562)
    ],

    routeWhileDragging: false,

    // geocoder: L.Control.Geocoder.nominatim(),
    // addWaypoints: true,
    // reverseWaypoints: true,
    showInstructions: false,


    profile: 'foot'
  }).addTo(map);

  let waypoints = control.getWaypoints();
  console.log(waypoints);

  L.Control.geocoder().addTo(map);

});

</script>

<template>
  <div>
    <div style="background-image: url('https://loremflickr.com/600/600');"
      class="bg-center w-screen h-[250px] p-4 flex">
      <button class="mr-auto bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
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
  </div>
  <div class="p-4">
    <ul class="mt-[-2rem] flex gap-3">
      <li class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
        aria-label="Nom catégorie">
        <Bookmark aria-hidden="true" stroke="#754043" :size="18" />
      </li>

      <li class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
        aria-label="Nom catégorie">
        <Bookmark aria-hidden="true" stroke="#754043" :size="18" />
      </li>
    </ul>

    <div class="flex justify-between">
      <h1 class="h3 text-tv-wine">{{ $route.params.id }}</h1>
      <div class="flex items-center gap-1 text-tv-wine">
        <Star stroke="#754043" :size="18" />
        <p aria-label="Note du parcours sur 5">
          4.8</p>
      </div>
    </div>
    <div class="flex items-center gap-2 mb-16">
      <div class="flex items-center gap-1 text-tv-wine">
        <MapPin stroke="#754043" :size="18" />
        <address class="not-italic">Lausanne</address>
      </div>
      <div class="w-1 h-1 mt-[.3rem] bg-tv-wine rounded-full"></div>
      <div class="flex items-center gap-1 text-tv-wine">
        <Footprints stroke="#754043" :size="18" />
        <p aria-label="Difficulté du parcours">Moyen</p>
      </div>
    </div>

    <div class="mb-16 bg-tv-wine text-tv-eggshell rounded-3xl p-8 flex justify-between">
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
        <p><time>1h30</time></p>
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
      <p>On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions,
        et empêche de se concentrer sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique
        comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en
        tout cas comparable avec celle du français standard.</p>
    </div>
    <div class="mb-16">
      <h3 class="text-tv-wine">Parcours</h3>
      <div id="map" class="map-pageLayout"></div>
    </div>
    <div class="text-tv-wine">
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
    <div class="mb-16">
      <button class="btn">
        <Download aria-hidden="true" stroke="#754043" :size="18" />
        Télécharger le parcours
      </button>
    </div>
    <div>
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
          Signaler un problème avec ce parcours</a>
      </div>
    </div>
  </div>


</template>