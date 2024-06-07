<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import SearchBar from '../../components/TheSearch.vue';

import "leaflet/dist/leaflet.css"
import * as L from 'leaflet';
import 'leaflet-routing-machine';
import 'leaflet-routing-machine/dist/leaflet-routing-machine.css';
import 'leaflet-control-geocoder/dist/Control.Geocoder.js';
import 'leaflet-control-geocoder/dist/Control.Geocoder.css';
import 'lrm-graphhopper';
import { storeItineraries } from '../../stores/StoreItineraries.js';
import { storeItinerary, storeItineraryById } from '../../stores/StoreItinerary.js';
// https://medium.com/@smhabibjr/implement-an-interactive-map-in-the-vue-js-8a865010fb41

// https://github.com/perliedman/lrm-graphhopper
// const initialMap = ref(null);

// https://docs.graphhopper.com/#operation/getRoute
const itineraries = async () => {
  return await storeItineraries.itineraries;
};
const route = useRoute();
const router = useRouter();

// Declare itinerariesOnMap as a ref
let itinerariesOnMap = [

 
];

// Function to resolve data and push each item into itinerariesOnMap
const resolveData = async () => { 
  const resolvedValue = await itineraries();
  resolvedValue.forEach(item => {
    itinerariesOnMap.push(
      {
        id: item.id,
        name: item.name,
        description: item.description,
        markers: item.markers.map(marker => [marker[0], marker[1]])}
    );
  });
  console.log('itinerariesOnMap', itinerariesOnMap);

  console.log('Populated itinerariesOnMap:', itinerariesOnMap);
  let map = L.map('map').setView([46.5794109, 5.3376684], 8);
  let mapInfoContainer = document.getElementById('map-info');
  let mapInfoTitle = document.getElementById('map-infoTitle');
  let mapInfoDesc = document.getElementById('map-infoDesc');
  let mapInfoBtn = document.getElementById('map-infoBtn');  

  // add a tile layer to add to our map
  L.tileLayer('http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // Declare a marker
  // let marker = L.marker([46.78, 6.6442309]).addTo(map);


  let filterStartMarker = (itineraries) => {
    let newArray = [];
    itineraries.forEach(element => {
      newArray.push({
        id: element.id,
        description: element.description,
        marker: element.markers[0]
      });
    });
    return newArray;
  };

  let displayItineraryRoute = (markerData, itineraries) => {
    let itinerary = itineraries.find(itinerary => itinerary.id === markerData.id);
    let waypoints = itinerary.markers.map(marker => L.latLng(marker[0], marker[1]));
    mapInfoTitle.textContent = itinerary.name;
    mapInfoDesc.textContent = itinerary.description;
    mapInfoBtn.addEventListener('click', () => {
    router.push(`/itinerary/${itinerary.id}`);
  });
    mapInfoContainer.classList.remove('hidden');

    // Remove other markers from the map
    markersOnMap.forEach(marker => map.removeLayer(marker));
    markersOnMap = [];

    // Remove the routing control from the map on click
    let onMapClick = (e) => {
      map.removeControl(control);
      addMarkersToMap(firstMarkers, itinerariesOnMap);
      mapInfoContainer.classList.add('hidden');
    }
    // Attach the click event listener to the map
    map.on('click', onMapClick);


    let control = L.Routing.control({
      waypoints,
      serviceUrl: "http://routing.openstreetmap.de/routed-foot/route/v1",
      language: 'fr',
    }).addTo(map);
    
  };

  let addMarkersToMap = (markers, itineraries) => {
    markers.forEach(markerData => {
      let marker = L.marker(markerData.marker).addTo(map);
      markersOnMap.push(marker);
      marker.on('click', () => displayItineraryRoute(markerData, itineraries));
    });
  };



  let firstMarkers = filterStartMarker(itinerariesOnMap);
  let markersOnMap = [];

  addMarkersToMap(firstMarkers, itinerariesOnMap);  

  let control = L.Routing.control({
    // router: new L.Routing.GraphHopper(orsToken),
    serviceUrl: "https://routing.openstreetmap.de/routed-foot/route/v1",
    language: 'fr',
    // serviceUrl: `https://graphhopper.com/api/1/route?key=1894ebf9-bfe5-4ab1-80b2-e8ccf733ab5e`,
    // waypoints: [
    //   L.latLng(46.777933, 6.6442309),
    //   L.latLng(46.7779608, 6.6306562)
    // ],

    routeWhileDragging: false,
    geocoder: L.Control.Geocoder.nominatim(),
    addWaypoints: false,
    reverseWaypoints: false,
    showInstructions: false,
    profile: 'foot'
  }).addTo(map);

  // let waypoints = control.getWaypoints();
  // console.log(waypoints);

  L.Control.geocoder().addTo(map);
};

// Call resolveData when the component is mounted
onMounted(async () => {
  await resolveData();
});



onMounted(() => {
  


});



</script>

<template>
  <div class="p-4">
    <SearchBar />
    <div id="map" class="map map-fullscreen map-noUi"></div>
    
     <!-- {{ itinerary }} -->
    <div id="map-info" class="hidden fixed bottom-3 left-1/2 translate-x-[-50%] z-50 w-[calc(100%-2rem)] min-h-24 bg-tv-eggshell p-4 rounded-3xl shadow-tv flex flex-col">
      <p id="map-infoTitle" class="h3">lolilol</p>
      <p id="map-infoDesc">asfjhasdifosdafjiasfd</p>
      <button id="map-infoBtn" class="btn mt-4 self-center">Voir le parcours</button>
    </div>
  </div>

</template>