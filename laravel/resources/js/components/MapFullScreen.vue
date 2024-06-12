<template>
    <div class="p-4">
        <div id="map" class="map-fullscreen map-noUi"></div>
        <MapModal
            v-if="modalIsVisible"
            :itineraryId="selectedItinerary ? selectedItinerary.id : ''"
        >
            <template #title>{{
                selectedItinerary ? selectedItinerary.name : "Super Cool"
            }}</template>
            <template #desc>{{
                selectedItinerary ? selectedItinerary.description : "Cool"
            }}</template>
        </MapModal>
    </div>
</template>

<script>
import { ref, onMounted, computed, watch, toRaw, watchEffect } from "vue";

import L from "leaflet";
import "leaflet/dist/leaflet.css";
import SearchBar from "../components/TheSearch.vue";
import "leaflet-routing-machine";
import MapModal from "./MapModal.vue";
import { storeMap } from "../stores/storeMap.js";
import { storeItineraries } from "../stores/StoreItineraries.js";
import { useRoute } from "vue-router";
import { useSelectedCategoryStore } from "../stores/StoreSelectedCategories.js";
import { useSelectedAccessibilityStore } from "../stores/StoreSelectedAccessibility.js";

export default {
    components: {
        MapModal,
    },
    setup() {
        const markers = ref([]);
        const selectedItinerary = ref(null);
        const mapInstance = ref(null);
        const routingControl = ref(null);
        const modalIsVisible = ref(false);
        const route = useRoute();
        const searchQuery = ref("");
        const selectedCategoryStore = useSelectedCategoryStore();
        const selectedCategoryIds = selectedCategoryStore.selectedCategoryIds;
        const selectedAccessibilityStore = useSelectedAccessibilityStore();
        const selectedAccessibilityIds =
            selectedAccessibilityStore.selectedAccessibilityIds;

        function toggleModalVisibility() {
            modalIsVisible.value = !modalIsVisible.value; // Toggle the visibility
        }

        // Define filteredItineraries function first
        function filteredItineraries() {
            const { selectedCategoryIds } = useSelectedCategoryStore();
            const categoryIds = selectedCategoryIds.value || [];

            const { selectedAccessibilityIds } =
                useSelectedAccessibilityStore();
            const accessibilityIds = selectedAccessibilityIds.value || [];

            return storeItineraries.itineraries.filter(
                (itinerary) =>
                    (categoryIds.length === 0 ||
                        itinerary.tag_categorie.some((tag) =>
                            categoryIds.includes(tag.id)
                        )) &&
                    (accessibilityIds.length === 0 ||
                        itinerary.tag_accessibility.some((tag) =>
                            accessibilityIds.includes(tag.id)
                        )) &&
                    (searchQuery.value === "" ||
                        itinerary.name
                            .toLowerCase()
                            .includes(searchQuery.value.toLowerCase()) ||
                        itinerary.description
                            .toLowerCase()
                            .includes(searchQuery.value.toLowerCase()) ||
                        itinerary.image.alt_attr
                            .toLowerCase()
                            .includes(searchQuery.value.toLowerCase()) ||
                        itinerary.difficulty
                            .toLowerCase()
                            .includes(searchQuery.value.toLowerCase()) ||
                        itinerary.type
                            .toString()
                            .includes(searchQuery.value.toLowerCase()))
            );
        }

        onMounted(() => {
            // Assurez-vous que les itinéraires sont chargés
            if (storeItineraries.itineraries.length > 0) {
                storeItineraries.itineraries = filteredItineraries();
                markers.value = extractMarkersFromItineraries();
            } else {
                watch(
                    () => storeItineraries.itineraries,
                    (newItineraries) => {
                        if (newItineraries.length > 0) {
                            markers.value = extractMarkersFromItineraries();
                        }
                    },
                    {
                        immediate: false, // Ne pas exécuter immédiatement, attendre le changement
                        deep: true, // Observer les changements profonds dans l'objet
                    }
                );
            }
            mapInstance.value = L.map("map", { zoomControl: false }).setView(
                storeMap.setViewVaud,
                storeMap.ZoomDefault
            );
            L.tileLayer(
                "http://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png",
                {
                    attribution:
                        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                }
            ).addTo(mapInstance.value);
            // Create routing control (routing machine)
            routingControl.value = L.Routing.control({
                serviceUrl:
                    "https://routing.openstreetmap.de/routed-foot/route/v1",
                language: "fr",
            }).addTo(mapInstance.value);

            // Display markers/first points from markers array
            createMarkers();
            watch(
                markers,
                (newMarkers) => {
                    if (newMarkers.length > 0) {
                        createMarkers();
                    }
                },
                {
                    immediate: false,
                    deep: true,
                }
            );
            // click event on the map to remove waypoints
            clikOnMap();
        });

        function extractMarkersFromItineraries() {
            const newItineraries = []; // Étape 1

            storeItineraries.itineraries.forEach((itinerary) => {
                // Convertit chaque marker de Proxy à sa valeur réelle si nécessaire
                const realMarkers = itinerary.markers.map((marker) => {
                    // Utilisez Vue.toRaw(marker) si vous travaillez avec Vue 3 pour obtenir la valeur réelle
                    // Pour d'autres contextes, vous devrez adapter cette ligne
                    return toRaw(marker);
                });

                // Ajoute les markers convertis au tableau des nouveaux itinéraires
                newItineraries.push(realMarkers);
            });

            // Étape 2: Ici, vous pouvez choisir de retourner newItineraries ou de le stocker/le traiter comme nécessaire
            console.log(`Nouveaux itinéraires extraits :`, newItineraries);

            return newItineraries;
        }

        const firstPointOfEachItineraries = ref(
            markers.value.map((itinerary) => itinerary[0])
        );
        const initialMarkers = ref(firstPointOfEachItineraries.value);

        // We set the const markers to use in map manipulation
        // Is used later in onMounted to display markers on map

        const waypoints = ref([]);
        const newWaypoints = ref([]);

        // used to get the itinerary based on the clicked marker index
        function getItineraryByIndex(index) {
            return itineraries.value[index - 1];
        }

        function createMarkers() {
            mapInstance.value.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    layer.remove();
                }
            });
            console.log("Markers to display:", markers.value); // Utilisez .value pour accéder aux données
            markers.value.forEach((itinerary, index) => {
                const firstCoord = itinerary[0]; // Prendre la première coordonnée de chaque itinéraire
                const singleMarker = L.marker(firstCoord, {
                    draggable: false, // Assurez-vous que cette option est bien définie ici
                }).addTo(mapInstance.value);
                singleMarker.on("click", () => {
                    newWaypoints.value = itinerary.map((coords) =>
                        L.latLng(...coords)
                    ); // Utiliser l'itinéraire complet
                    displayWaypoints(newWaypoints);
                    toggleModalVisibility();
                    selectedItinerary.value =
                        storeItineraries.itineraries[index];
                });
            });
            makeMarkersNonDraggable();
        }

        function clikOnMap() {
            mapInstance.value.on("click", function (e) {
                // alert(`You clicked the map at ${e.latlng}`);
                modalIsVisible.value ? toggleModalVisibility() : null;
                const map = mapInstance.value;

                // Remove all overlays (including the route polyline)
                map.eachLayer(function (layer) {
                    if (
                        layer instanceof L.LayerGroup ||
                        layer instanceof L.FeatureGroup
                    ) {
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

        function displayWaypoints(newWaypoints) {
            console.log("Waypoints to display:", newWaypoints.value);

            // Remove existing markers
            mapInstance.value.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    layer.remove();
                }
            });

            // Update the waypoints array
            waypoints.value = newWaypoints.value;

            // Re-initialize the routing control with the updated waypoints
            routingControl.value = L.Routing.control({
                waypoints: waypoints.value,
                addWaypoints: false,
                serviceUrl:
                    "https://routing.openstreetmap.de/routed-foot/route/v1",
                language: "fr",
            })
                .on("waypointcreated", function (e) {
                    const marker = L.marker(e.waypoint.latlng, {
                        draggable: false, // Assurez-vous que draggable est false ici
                    }).addTo(mapInstance.value);
                    // Customize the marker as needed
                })
                .addTo(mapInstance.value);
            makeMarkersNonDraggable();
        }

        function makeMarkersNonDraggable() {
            mapInstance.value.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    // Vérifie si la propriété dragging existe avant de l'utiliser
                    if (layer.dragging) {
                        layer.dragging.disable();
                    }
                }
            });
        }
        watch(
            [selectedCategoryIds, selectedAccessibilityIds, searchQuery],
            () => {
                if (mapInstance.value) {
                    mapInstance.value.eachLayer(function (layer) {
                        if (layer instanceof L.Marker) {
                            layer.remove();
                        }
                    });
                    storeItineraries.itineraries = filteredItineraries();
                    markers.value = extractMarkersFromItineraries();
                    createMarkers();
                }
            },
            {
                immediate: true,
                deep: true,
            }
        );
    },
};
</script>
