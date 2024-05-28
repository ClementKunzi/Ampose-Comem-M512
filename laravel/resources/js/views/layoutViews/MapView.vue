<script setup>
import { ref, onMounted } from 'vue';
import SearchBar from '../../components/TheSearch.vue';

import "leaflet/dist/leaflet.css"
import * as L from 'leaflet';
import 'leaflet-routing-machine';
import 'leaflet-routing-machine/dist/leaflet-routing-machine.css';
import 'leaflet-control-geocoder/dist/Control.Geocoder.js';
import 'leaflet-control-geocoder/dist/Control.Geocoder.css';
import '../../scripts/L.Routing.OpenRouteService.js';
import 'lrm-graphhopper';
// https://medium.com/@smhabibjr/implement-an-interactive-map-in-the-vue-js-8a865010fb41

// https://github.com/perliedman/lrm-graphhopper
// const initialMap = ref(null);

onMounted(() => {

  const orsToken = '1894ebf9-bfe5-4ab1-80b2-e8ccf733ab5e';
  var map = L.map('map');

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
    geocoder: L.Control.Geocoder.nominatim(),
    addWaypoints: true,
    reverseWaypoints: true,
    showInstructions: false,
    profile: 'foot'
  }).addTo(map);

  let waypoints = control.getWaypoints();
  console.log(waypoints); 

  L.Control.geocoder().addTo(map);

});



</script>

<template>    
  <div class="p-4">
    <SearchBar />    
    <div id="map" class="map"></div>
  </div>

</template>