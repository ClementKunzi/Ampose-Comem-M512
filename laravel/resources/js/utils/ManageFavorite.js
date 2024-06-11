import { ApiGetFavorites } from './apiCalls/ApiGetFavorites';
import { ApiPostFavorite } from './apiCalls/ApiPostFavorite';
import { ApiDeleteFavorite } from './apiCalls/ApiDeleteFavorite';
import { UserLocalStorage } from '../classes/UserLocalStorage';
import { setFavorites } from '../stores/StoreFavoriteIcon';

// Définition de la fonction ManageFavorite
async function ManageFavorite(itinerary_id) {
    try {
        // Création d'une instance de UserLocalStorage
        const user = new UserLocalStorage();

        // Récupération de l'ID de l'utilisateur
        const userId = user.getUserId();

        // Appel à la méthode ApiGetFavorites avec l'ID de l'utilisateur
        const favorites = await ApiGetFavorites(userId);

        //console.log(favorites);
        // Vérification si l'itinéraire est déjà en favoris
        const isFavorite = favorites.some(favorite => favorite.itinerary_id === itinerary_id);
                
        if (isFavorite) {
            //console.log('L\'itinéraire est déjà en favoris.');
            //console.log(favorites);
            const favoriteId = await findFavoriteIdsByItineraryId(favorites, itinerary_id);
            //console.log(favoriteId[0]);
            // Gestion du cas où l\'itinéraire est déjà en favoris
            // Par exemple, afficher un message à l'utilisateur
            const deleteFavorite = await ApiDeleteFavorite(favoriteId[0])
        } else {
            //console.log('L\'itinéraire n\'est pas en favoris.');
            // Si l'itinéraire n'est pas en favoris, l'ajoutez-le
            const newFavorite = await ApiPostFavorite({itinerary_id});
        }
        setFavorites(favorites);
        return isFavorite;
    } catch (error) {
        console.error('Erreur lors de la vérification des favoris:', error);
        // Gestion de l'erreur
    }
}

async function findFavoriteIdsByItineraryId(favorites, itineraryId) {
    // Filtrer les favoris basés sur l'itinerary_id spécifié
    const filteredFavorites = favorites.filter(favorite => favorite.itinerary_id === itineraryId);

    // Extraire les IDs des favoris filtrés
    const favoriteIds = filteredFavorites.map(favorite => favorite.id)

    return favoriteIds;
}

// Exportation de la fonction ManageFavorite
export default ManageFavorite;