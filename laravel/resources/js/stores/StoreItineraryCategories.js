// store.js
import { reactive } from 'vue';
import { ApiCallCategory } from '../utils/apiCalls/ApiCallCategory.js';

export const storeCategories = reactive({
    categories: [],
    isLoading: true, // Ajoutez une propriété pour suivre l'état de chargement
});

// Utilisez une fonction asynchrone pour initialiser vos données
async function initializeStoreData() {
    try {
        const categories = await ApiCallCategory();
        storeCategories.categories = categories;
        storeCategories.isLoading = false; // Mettez à jour l'état de chargement une fois les données chargées
    } catch (error) {
        console.error("Erreur lors du chargement des catégories:", error);
        storeCategories.isLoading = false; // Gestion des erreurs
    }
}

initializeStoreData();

// Dans votre composant Vue, vous pouvez maintenant vérifier l'état de chargement et afficher le contenu conditionnellement
