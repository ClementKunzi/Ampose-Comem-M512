// store.js
import { reactive } from 'vue';
import { ApiCallItineraries } from '../utils/apiCalls/ApiGetItineraries.js';

export const storeItineraries = reactive({
    itineraries: [],
});

async function initializeItineraries() {
    try {
        const itineraries = await ApiCallItineraries();
        storeItineraries.itineraries = itineraries;
    } catch (error) {
        console.error("Erreur lors du chargement des itinéraires:", error);
    }
}

initializeItineraries();
