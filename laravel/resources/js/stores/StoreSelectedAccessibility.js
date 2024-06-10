// StoreSelectedCategories.js
import { ref } from 'vue';

// Utilisez un tableau pour stocker les identifiants des catégories sélectionnées
const selectedAccessibilityIds = ref([]);

export function useSelectedAccessibilityStore() {
    // Fonction pour ajouter ou supprimer un identifiant de la liste
    function setSelectedAccessibilityIds(ids) {
        selectedAccessibilityIds.value = ids;
    }

    // Fonction pour ajouter un identifiant à la liste s'il n'est pas déjà présent,
    // ou pour le supprimer s'il est déjà présent
    function toggleAccessibilityId(id) {
        const index = selectedAccessibilityIds.value.indexOf(id);
        if (index > -1) {
            // L'identifiant est déjà présent, le supprimer
            selectedAccessibilityIds.value.splice(index, 1);
        } else {
            // L'identifiant n'est pas présent, l'ajouter
            selectedAccessibilityIds.value.push(id);
        }
    }

    return {
        selectedAccessibilityIds,
        setSelectedAccessibilityIds,
        toggleAccessibilityId,
    };
}
