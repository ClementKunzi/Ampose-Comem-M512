<template>
  <div class="p-4">
    <SearchBar v-model="searchQuery" />
    
    <div id="map" class="map-fullscreen map-noUi"></div>
    <MapModal v-if="modalIsVisible" >
      <template #title>Super Cool</template>
      <template #desc>Cool</template>
    </MapModal>
  </div>
  
</template>

<script>
import { ref, onMounted, reactive } from 'vue';

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet-routing-machine';
import SearchBar from '../../components/TheSearch.vue';
import MapModal from '../../components/MapModal.vue';
import { storeMap } from '../../stores/storeMap.js';


export default {
  components: {
    SearchBar,
    MapModal, 
  },
  setup() {
    const mapInstance = ref(null);
    const routingControl = ref(null);
    const modalIsVisible = ref(false);

    function toggleModalVisibility() {
    modalIsVisible.value =!modalIsVisible.value; // Toggle the visibility
  }

    // Data from itineraries API
    const itineraries = ref([
      [[51.505, -0.09], [51.51, -0.1], [51.52, -0.08]], // Itinerary 1
      [[51.5, -0.1], [52.48, 13.40], [52.45, 13.35]], // Itinerary 2
      [[51.51, -0.08], [50.5, 11.40], [50.45, 14.35]]
    ]);

    // Sotre the first points of each itineraries to use later as markers
    const firstPointOfEachItineraries = ref(itineraries.value.map(itinerary => itinerary[0]));

    // We set the const markers to use in map manipulation
    // Is used later in onMounted to display markers on map
    const initialMarkers = ref(firstPointOfEachItineraries.value);

    const waypoints = ref([]);
    const newWaypoints = ref([]);

    // used to get the itinerary based on the clicked marker index
    function getItineraryByIndex(index) {
      return itineraries.value[index - 1];
    }

    onMounted(() => {     
      // Create map instance
      // mapInstance.value = L.map('map').setView(initialMarkers.value[0], 13);
      mapInstance.value = L.map('map').setView(storeMap.setViewLondon, storeMap.ZoomDefault);
      L.tileLayer('http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      }).addTo(mapInstance.value);

      // Create routing control (routing machine)
      routingControl.value = L.Routing.control({        
        serviceUrl: "http://routing.openstreetmap.de/routed-foot/route/v1",
        language: 'fr',      
      }).addTo(mapInstance.value);

      // Display markers/first points from markers array
      createMarkers();
      // click event on the map to remove waypoints
      clikOnMap();
    });

    function createMarkers() {
      initialMarkers.value.forEach((marker, index) => {
        
        const singleMarker = L.marker(marker).addTo(mapInstance.value);
        singleMarker.on('click', () => {
          // Update the waypoints array with the new itinerary based on the clicked marker index
          newWaypoints.value = getItineraryByIndex(index + 1).map(coords => L.latLng(...coords));
          // alert(`Marker ${index + 1} clicked`);
          displayWaypoints(newWaypoints);                          
          toggleModalVisibility();              
        });
      });
    }

    // map click to remove waypoints and revert to initial markers
    function clikOnMap() {
      mapInstance.value.on('click', function (e) {
        // alert(`You clicked the map at ${e.latlng}`);
        modalIsVisible.value ? toggleModalVisibility() : null;
        const map = mapInstance.value;

        // Remove all overlays (including the route polyline)
        map.eachLayer(function (layer) {
          if (layer instanceof L.LayerGroup || layer instanceof L.FeatureGroup) {
            layer.remove();
          }
        });   
        // remove reamaining markers
        mapInstance.value.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
          layer.remove();
        }
      });           
        // Display markers/first points from markers array
        createMarkers();
      });

    }

    // Create a new instance of routing that will be used in the click event of the markers to display the new itinerary
    function displayWaypoints(newWaypoints) {
      // Remove existing markers
      mapInstance.value.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
          layer.remove();
        }
      });

      // Update the waypoints array
      waypoints.value = newWaypoints.value;

      // Re-initialize the routing control with the updated waypoints
      // Note: Depending on your setup, you might need to destroy the existing routing control before re-initializing it.
      routingControl.value = L.Routing.control({
        waypoints: waypoints.value,
        serviceUrl: "http://routing.openstreetmap.de/routed-foot/route/v1",
        language: 'fr',
      }).on('waypointcreated', function (e) {
        const marker = L.marker(e.waypoint.latlng).addTo(mapInstance.value);
        // Customize the marker as needed
      }).addTo(mapInstance.value);
    }

    // setTimeout(() => {
    //   displayWaypoints(newWaypoints);
    // }, 2000);

    return { mapInstance, initialMarkers, modalIsVisible };
  },
};
</script>