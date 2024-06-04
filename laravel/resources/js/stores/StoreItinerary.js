// store.js
import { reactive } from 'vue'; 

import { ApiGetItineraries } from '../utils/apiCalls/ApiGetItineraries.js';

export const storeItinerary = reactive({
  itinerary: [],
});

if(storeItinerary.itinerary.length === 0) {
  storeItinerary.itinerary = await ApiGetItineraries();
}



