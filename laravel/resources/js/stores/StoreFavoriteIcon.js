import { reactive } from 'vue';
import { ApiGetFavorites } from '../utils/apiCalls/ApiGetFavorites';
import { UserLocalStorage } from '../classes/UserLocalStorage';

// Initialisation de l'état des favoris
const favoritesState = reactive({
  favorites: []
});

// Exportation des méthodes pour interagir avec l'état des favoris
export const getFavorites = () => favoritesState.favorites;

export const getFavoritesFromId = async ()  => {

    const user = new UserLocalStorage();

        // Récupération de l'ID de l'utilisateur
    const userId = user.getUserId();

    const favorites = await ApiGetFavorites(userId);
    console.log(favorites);
}

export const setFavorites = (newFavorites) => {
  favoritesState.favorites = newFavorites;
};

export const toggleFavorite = (itineraryId) => {
  const index = favoritesState.favorites.findIndex(favorite => favorite.itinerary_id === itineraryId);
  
  if (index!== -1) {
    favoritesState.favorites.splice(index, 1);
    console.log("splice");
  } else {
    favoritesState.favorites.push({ itinerary_id: itineraryId });
    console.log("push");
  }
};