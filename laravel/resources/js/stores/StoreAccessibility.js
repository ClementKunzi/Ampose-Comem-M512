// store.js
import { ref } from 'vue';
import { ApiCallAccessibility } from '../utils/apiCalls/ApiCallAccessibility.js';

export const storeAccessibility = ref({ accessibilities: [], isLoading: true });

async function initializeStoreData() {
    try {
        const accessibilities = await ApiCallAccessibility();
        storeAccessibility.value.accessibilities = accessibilities;
        storeAccessibility.value.isLoading = false; // Mettre à jour l'état de chargement une fois les données chargées
    } catch (error) {
        console.error("Erreur lors du chargement des accessibilités:", error);
        storeAccessibility.value.isLoading = false; // Gestion des erreurs
    }
}

initializeStoreData();
