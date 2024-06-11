import { reactive } from 'vue';

// Initialisation de l'état des favoris
const favoritesState = reactive({
  favorites: []
});

// Exportation des méthodes pour interagir avec l'état des favoris
export const getFavorites = () => favoritesState.favorites;

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