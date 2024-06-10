// store.js
import { reactive, computed } from 'vue'; 
import { watch } from 'vue';
import { useRoute } from 'vue-router';
import { ApiGetItinerary } from '../utils/apiCalls/ApiGetItinerary.js';
import { getIdFromUrl } from '../utils/IdFromUrl.js';

const route = useRoute();

export const storeItinerary = reactive({
  itinerary: [],
});

let currentItinerary = getIdFromUrl(window.location.href);

export async function storeItineraryById(id) {
  storeItinerary.itinerary = await ApiGetItinerary(id);
}
// Iniital call to get currentItinerary data
if(storeItinerary.itinerary.length === 0) {
  
}

// Watch for url change, call api to update currentitinerary data
window.addEventListener('popstate', async function (event) {
  currentItinerary = getIdFromUrl(window.location.href);
  storeItinerary.itinerary = await ApiGetItinerary(currentItinerary);
});



