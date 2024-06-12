<template>
    <div id="map" class="map-pageLayout map-noUi"></div>
    <MapModal v-if="modalIsVisible" @close="toggleModalVisibility">
        <template #title>Super Cool</template>
        <template #desc>Cool</template>
    </MapModal>
</template>

<script setup>
import { ref, onMounted, watch, computed } from "vue";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet-routing-machine";
import "leaflet-routing-machine/dist/leaflet-routing-machine.css";
import { useRoute, useRouter } from "vue-router";
import MapModal from "./MapModal.vue";
import { storeMap } from "../stores/storeMap.js";
import { storeItineraries } from "../stores/StoreItineraries.js";

const route = useRoute();
const router = useRouter();

const currentItinerary =
    JSON.parse(localStorage.getItem("currentItinerary")) || {};
console.log("currentItinerary", currentItinerary.data.steps);
const steps = [];
currentItinerary.data.steps.forEach((element) => {
    steps.push([element.latitude, element.longitude]);
});

// Predefined itineraries array
const itineraries = ref([]);

if (route.params.stepId) {
    steps[route.params.stepId].forEach((step) => {
        itineraries.value.push(steps);
    });
} else {
    steps.forEach((step) => {
        itineraries.value.push(steps);
    });
}

const mapInstance = ref(null);
const routingControl = ref(null);
const modalIsVisible = ref(false);
const initialMarkers = ref([]);
const waypoints = ref([]);
const newWaypoints = ref([]);

// Function to toggle modal visibility
const toggleModalVisibility = () => {
    modalIsVisible.value = !modalIsVisible.value;
};

// Function to create markers on the map
const createMarkers = () => {
    initialMarkers.value.forEach((marker, index) => {
        const singleMarker = L.marker(marker).addTo(mapInstance.value);
        singleMarker.on("click", () => {
            newWaypoints.value = getItineraryByIndex(index + 1).map((coords) =>
                L.latLng(...coords)
            );
            displayWaypoints(newWaypoints);
            toggleModalVisibility();
        });
    });
};

// Function to get itinerary by index
const getItineraryByIndex = (index) => {
    return itineraries.value[index - 1];
};

// Function to display waypoints on the map
const displayWaypoints = (newWaypoints) => {
    // Remove existing markers
    mapInstance.value.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
            layer.remove();
        }
    });

    // Update the waypoints array
    waypoints.value = newWaypoints.value;

    // Destroy the existing routing control before re-initializing it.
    if (routingControl.value) {
        mapInstance.value.eachLayer(function (layer) {
            if (layer instanceof L.Marker) {
                layer.remove();
            }
        });
    }

    // Re-initialize the routing control with the updated waypoints
    // Note: Depending on your setup, you might need to destroy the existing routing control before re-initializing it.
    routingControl.value = L.Routing.control({
        waypoints: waypoints.value,
        serviceUrl: "https://routing.openstreetmap.de/routed-foot/route/v1",
        language: "fr",
    })
        .on("waypointcreated", function (e) {})
        .addTo(mapInstance.value);

    // Add click event listener to each waypoint marker
    // waypoints.value.forEach(waypoint => {
    //   L.marker(waypoint).addTo(mapInstance.value).on('click', function(e) {
    //     console.log(`You clicked on waypoint: `);
    //     // Perform any additional actions here, such as toggling a modal or displaying more details
    //   });
    // });

    for (let i = 0; i < waypoints.value.length; i++) {
        L.marker(waypoints.value[i])
            .addTo(mapInstance.value)
            .on("click", function (e) {
                router.push(`${route.fullPath}/step/${i + 1}`);
            });
    }
};

// Function to handle map click
const clikOnMap = () => {
    mapInstance.value.on("click", function (e) {
        // alert(`You clicked the map at ${e.latlng}`);
        modalIsVisible.value ? toggleModalVisibility() : null;
    });
};
// Lifecycle hook to initialize the map and markers
onMounted(() => {
    mapInstance.value = L.map("map").setView(
        storeMap.setViewVaud,
        storeMap.ZoomDefault
    );
    L.tileLayer("http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(mapInstance.value);

    routingControl.value = L.Routing.control({
        serviceUrl: "https://routing.openstreetmap.de/routed-foot/route/v1",
        language: "fr",
    }).addTo(mapInstance.value);

    // Initialize initialMarkers with the first point of each itinerary

    if (route.params.stepId) {
        initialMarkers.value = itineraries.value.map(
            (itinerary) => itinerary[0]
        );
        displayWaypoints({
            value: itineraries.value[0].map((coords) => L.latLng(...coords)),
        });
    } else {
        initialMarkers.value = itineraries.value.map(
            (itinerary) => itinerary[0]
        );
        displayWaypoints({
            value: itineraries.value[0].map((coords) => L.latLng(...coords)),
        });
    }

    clikOnMap();
});

// Expose what's needed to the template
defineExpose({
    mapInstance,
    initialMarkers,
    modalIsVisible,
    toggleModalVisibility,
});
</script>
