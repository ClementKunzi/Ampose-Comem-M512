import './bootstrap';

// import { createRouter } from 'vue-router';
import { createApp } from 'vue';
import App from './App.vue';
import router from '@/router/router.js';

import L from "leaflet";
import 'leaflet/dist/leaflet.css';

// import './ressources/css/app.css'

createApp(App)
    .use(router)
    .mount('#app');


// var map = L.map('map').setView([51.505, -0.09], 13);

// L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     maxZoom: 19,
//     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
// }).addTo(map);

// var marker = L.marker([51.5, -0.09]).addTo(map);

// var circle = L.circle([51.508, -0.11], {
//     color: 'red',
//     fillColor: '#f03',
//     fillOpacity: 0.5,
//     radius: 500
// }).addTo(map);