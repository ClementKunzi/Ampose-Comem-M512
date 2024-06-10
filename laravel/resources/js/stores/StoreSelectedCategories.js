// StoreSelectedCategories.js
import { ref } from 'vue';

// Utilisez un tableau pour stocker les identifiants des catégories sélectionnées
const selectedCategoryIds = ref([]);

export function useSelectedCategoryStore() {
    // Fonction pour ajouter ou supprimer un identifiant de la liste
    function setSelectedCategoryIds(ids) {
        selectedCategoryIds.value = ids;
    }

    // Fonction pour ajouter un identifiant à la liste s'il n'est pas déjà présent,
    // ou pour le supprimer s'il est déjà présent
    function toggleCategoryId(id) {
        const index = selectedCategoryIds.value.indexOf(id);
        if (index > -1) {
            // L'identifiant est déjà présent, le supprimer
            selectedCategoryIds.value.splice(index, 1);
        } else {
            // L'identifiant n'est pas présent, l'ajouter
            selectedCategoryIds.value.push(id);
        }
    }

    return {
        selectedCategoryIds,
        setSelectedCategoryIds,
        toggleCategoryId,
    };
}
