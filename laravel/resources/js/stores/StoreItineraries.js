// store.js
import { reactive } from "vue";
import { ApiCallItineraries } from "../utils/apiCalls/ApiGetItineraries.js";

export const storeItineraries = reactive({
    itineraries: [],
    async reloadItineraries() {
        this.itineraries = []; // Vide le tableau
        try {
            const itineraries = await ApiCallItineraries(); // Récupère les itinéraires à nouveau
            this.itineraries = itineraries; // Met à jour le tableau avec les nouvelles données
        } catch (error) {
            console.error(
                "Erreur lors du rechargement des itinéraires:",
                error
            );
        }
    },
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
