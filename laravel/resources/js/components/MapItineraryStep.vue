<template>
    <div id="map" class="map-pageLayout map-noUi"></div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet-routing-machine";
import "leaflet-routing-machine/dist/leaflet-routing-machine.css";
import { storeMap } from "../stores/storeMap";
import { useRoute } from "vue-router";

const route = useRoute();
console.log("route", route.params.stepId);
const mapInstance = ref(null);

const currentItinerary = ref();
currentItinerary.value =
    JSON.parse(localStorage.getItem("currentItinerary")) || {};
const step = ref();
step.value = currentItinerary.value.data.steps[route.params.stepId - 1];
console.log("step", step.value.latitude, step.value.longitude);
const customIcon = L.icon({
    iconUrl: "/images/map/marker.png",
    iconSize: [30, 30], // Taille de l'icône (largeur, hauteur)
    iconAnchor: [0, 15], // Point d'ancrage de l'icône (la partie basse au milieu de l'icône)
    popupAnchor: [0, -41], // Point d'ancrage de la popup (s'ouvre au-dessus de l'icône)
});

onMounted(() => {
    mapInstance.value = L.map("map").setView(
        storeMap.setViewVaud,
        storeMap.ZoomDefault
    ); // Example coordinates and zoom level
    L.tileLayer("http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(mapInstance.value);

    // Assuming you want to display a marker based on a specific step ID
    // For demonstration, let's say we always display the first step's location
    const stepCoordinates = [[step.value.latitude, step.value.longitude]]; // Replace with actual coordinates from your steps
    console.log("stepCoordinates", stepCoordinates);
    L.marker(stepCoordinates[0], { icon: customIcon }).addTo(mapInstance.value);
});
</script>
