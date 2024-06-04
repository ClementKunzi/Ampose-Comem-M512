// store.js
import { reactive } from 'vue'; 

import { ApiCallItineraries } from '../utils/apiCalls/ApiGetItineraries.js';

// const cool = ApiCallItineraries();
// console.log(cool);

export const storeItineraries = reactive({
  itineraries: [],
});

if(storeItineraries.itineraries.length === 0) {
  storeItineraries.itineraries = await ApiCallItineraries();
}



