<script setup>
import { ref, reactive, watch, onMounted, defineProps, defineEmits } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { storeItineraryForm } from '../../stores/StoreItineraryForm';

import "leaflet/dist/leaflet.css"
import * as L from 'leaflet';
import 'leaflet-routing-machine';
import 'leaflet-routing-machine/dist/leaflet-routing-machine.css';

const props = defineProps({
    isActive: Boolean,
    index: Number,
});

// const emits = defineEmits(['submit-form-fields']);

const router = useRouter();
let markerLat = ref(null);
let markerLng = ref(null);
const emits = defineEmits(['updateName, updateImage']);

const formFields = reactive({
    // id: props.index,
    // name: '',
    // image: '',
    // image_description: '',
    // coordinate: [markerLat, markerLng],
    // description: '',
    // link: '',
    id: props.index,
    name: 'Cool',
    image: '',
    image_description: 'Jolie description',
    coordinate: [markerLat, markerLng],
    description: 'Jolie description les amis.',
    link: 'https://cool.io',
});

watch(() => formFields.name, (newValue, oldValue) => {
    emits('updateName', newValue); // Correctly use emits to emit the updated name value to the parent component
});
watch(() => formFields.image, (newValue, oldValue) => {
    emits('updateImage', newValue); // Correctly use emits to emit the updated image value to the parent component
});

const updateImage = (event) => {
    formFields.image = event.target.files[0];
};

const removeStep = () => {
    console.log('event', event.target);
    event.target.closest('.accordion-item').remove();

}

// Example method to simulate form submission or any other action that updates formFields
// const updateFormField = (field, value) => {
//     formFields[field] = value;
    
// };

// Call updateFormField wherever you need to update a field in formFields

let mapInitialized = false;
const mapContainerRef = ref(null);
let marker;
let geocodeMarker;
var customIcon = L.icon({
    iconUrl: '/images/map/marker.png',
    iconSize: [38, 38], // size of the icon
    shadowSize: [50, 64], // size of the shadow
    iconAnchor: [19, 38], // point of the icon which will correspond to marker's location
    // shadowAnchor: [4, 62],  // the same for the shadow
    // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
  });

onMounted(() => {

   

    // Watcher for isActive changes
    watch(() => props.isActive, (newValue, oldValue) => {
        if (!mapInitialized && newValue) {
            setTimeout(() => {
                initializeMap();
            }, 100); // Initialize the map only if it hasn't been initialized before and isActive is true
            mapInitialized = true; // Mark the map as initialized
            // console.log('initialize')
        }

    }, { immediate: true });

    function initializeMap() {
        const mapContainer = document.getElementById('map'); // Assuming your map container has an ID of 'map'
        const map = L.map(mapContainerRef.value).setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);
        
        const geocoder = L.Control.geocoder().on('markgeocode', e => {
            if (geocodeMarker) {
                map.removeLayer(geocodeMarker);

            }

            // Create a new marker at the geocoded location
            var latLng = e.geocode.center;
            e.geocode.icon = customIcon;
            console.log('latLng', latLng);            
            marker = L.marker([latLng.lat, latLng.lng], {icon: customIcon}).addTo(map);
            console.log('geocodeMarker', marker);
            // marker = L.marker(latLng);
        }).addTo(map);

        // Handle map click to add marker
        map.on('click', e => {
            // Remove the existing marker if it exists
            if(geocodeMarker) {
                map.removeLayer(geocodeMarker);
            }
            if (marker && map.hasLayer(marker)) {
                console.log("Removing marker");
                map.removeLayer(marker);
            } else {
                console.log("Marker not found or already removed");
            }

            // Add a new marker at the clicked location
           marker = L.marker([e.latlng.lat, e.latlng.lng], {icon: customIcon}).addTo(map);
            markerLat.value = e.latlng.lat;
            markerLng.value = e.latlng.lng;
            console.log('marker', marker);
        });


        // Additional map configuration...
    }

});

</script>

<template>
    <form @submit.prevent="storeItineraryForm.addStep(formFields)" enctype="multipart/form-data">
        <div class="flex flex-col gap-6">
            <div>
                <label for="name">Nom de l'étape</label>
                <input id="name" v-model="formFields.name" type="text" placeholder="Nom de l'étape" />
            </div>
            <div>
                <label for="name">Image de l'étape</label>
                <input type="file" name="img" @change="updateImage" ref="imageInput" accept="image/*" />
            </div>
            <div>
                <label for="name">Description de l'image</label>
                <input id="name" v-model="formFields.image_description" type="text" placeholder="Que voit-on sur cette image?" />
            </div>
            <div>
                <label for="coordinate">Coordonnées</label>
                <input id="coordinate" class="opacity-0 pointer-events-none mb-[-48px]" v-model="formFields.coordinate"
                    type="text" placeholder="Rechercher une adresse" />
                <div ref="mapContainerRef" id="map" class="map-pageLayout map-norouteInstructions map-noZoom map-markerPicker"></div>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea name="description" rows="5" v-model="formFields.description"
                    placeholder="Description"></textarea>
            </div>
            <div>
                <label for="link">Lien utile:</label>
                <input id="link" v-model="formFields.link" type="text" placeholder="https://cool.io" />
            </div>            
            <button type="submit" id="btn-itineraryStep" class="btn self-center z-[-10] w-0
            h-0 absolute">Submit</button>
        </div>
    </form>
</template>