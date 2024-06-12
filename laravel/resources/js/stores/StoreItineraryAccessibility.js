// store.js
import { reactive } from "vue";
import { ApiCallAccessibility } from "../utils/apiCalls/ApiCallAccessibility.js";

export const storeAccessibilities = reactive({
    accessibilities: [],
    isLoading: true, // Ajoutez une propriété pour suivre l'état de chargement
});
async function initializeStoreData() {
    try {
        const accessibilities = await ApiCallAccessibility();
        storeAccessibilities.accessibilities = accessibilities;
        storeAccessibilities.isLoading = false; // Mettre à jour l'état de chargement une fois les données chargées
    } catch (error) {
        console.error("Erreur lors du chargement des accessibilités:", error);
        storeAccessibilities.value.isLoading = false; // Gestion des erreurs
    }
}

initializeStoreData();
