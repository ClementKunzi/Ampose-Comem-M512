<script setup>
import { onMounted, ref, computed } from 'vue';
import SearchBar from '../../components/TheSearch.vue';
import CardItinerary from '../../components/CardItinerary.vue';
import { storeItineraries } from '../../stores/StoreItineraries.js';
import { getLocalStorageUser } from '../../utils/LocalStorageUser';
import { ApiGetFavorites } from '../../utils/apiCalls/ApiGetFavorites';
import ManageFavorite from '../../utils/ManageFavorite';

const favorites = ref([]);
const filteredItineraries = ref([]);

const fetchFavorites = async () => {
  try {
    const user = getLocalStorageUser();
    if (user && user.userData && user.userData.id) {
      const userFavorites = await ApiGetFavorites(user.userData.id);
      favorites.value = userFavorites.map(fav => fav.itinerary_id);
      filterItineraries();
    }
  } catch (error) {
    console.error('Erreur lors de la récupération des favoris:', error);
  }
};

const filterItineraries = () => {
  filteredItineraries.value = storeItineraries.itineraries.filter(itinerary =>
    favorites.value.includes(itinerary.id)
  );
};

const toggleFavorite = async (itineraryId) => {
  await ManageFavorite(itineraryId);
  fetchFavorites(); // Refresh the list of favorites
};

const refreshFavorites = async () => {
  await fetchFavorites();
};

onMounted(() => {
  fetchFavorites();
});

const itineraries = computed(() => filteredItineraries.value);
</script>

<template>
  <div class="p-4">
    <SearchBar />
    <router-view />
    <h2 class="h3 text-tv-wine">Mes Favoris</h2>
    <div v-if="itineraries.length > 0" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-24">
      <div v-for="itinerary in itineraries" :key="itinerary.id" class="relative">
        <router-link :to="`/itinerary/${itinerary.id}`">
          <CardItinerary :itinerary="itinerary" :image="itinerary.image.url" :isFavoriteFilled="true" @favoriteToggled="refreshFavorites" />
        </router-link>

      </div>
    </div>
    <div v-else class="text-center text-gray-500 mt-5">
      Vous n'avez pas de parcours favori pour le moment.
    </div>
  </div>
</template>

<style scoped>
.favorites-container {
  padding: 20px;
}

.favorite-item {
  margin-bottom: 20px;
}

button {
  position: absolute;
  top: 10px;
  right: 10px;
}
</style>
