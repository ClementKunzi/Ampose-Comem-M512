<template>
  <div class="p-5">
    <h1 class="text-center text-4xl font-bold mb-5">Mes Favoris</h1>
    <div v-if="filteredItineraries.length" class="flex flex-wrap gap-5 justify-center">
      <CardItinerary
        v-for="itinerary in filteredItineraries"
        :key="itinerary.id"
        :itinerary="itinerary"
        @toggle-favorite="toggleFavorite(itinerary.id)"
      />
    </div>
    <div v-else>
      <p class="text-center">Vous n'avez aucun favori.</p>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { getFavorites, toggleFavorite } from '../../stores/StoreFavoriteIcon';
import { getLocalStorageUser } from '../../utils/LocalStorageUser';
import { ApiGetFavorites } from '../../utils/apiCalls/ApiGetFavorites';
import { ApiCallItineraries } from '../../utils/apiCalls/ApiGetItineraries';
import CardItinerary from '../../components/CardItinerary.vue';

export default {
  components: {
    CardItinerary
  },
  setup() {
    const itineraries = ref([]);
    const favorites = ref([]);
    const filteredItineraries = ref([]);

    const fetchItineraries = async () => {
      try {
        const allItineraries = await ApiCallItineraries();
        itineraries.value = allItineraries;
        filterItineraries();
      } catch (error) {
        console.error('Erreur lors de la récupération des itinéraires:', error);
      }
    };

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
      filteredItineraries.value = itineraries.value.filter(itinerary =>
        favorites.value.includes(itinerary.id)
      );
    };

    const toggleFavoriteHandler = async (itineraryId) => {
      await toggleFavorite(itineraryId);
      await fetchFavorites();
    };

    onMounted(() => {
      fetchItineraries();
      fetchFavorites();
    });

    return {
      filteredItineraries,
      toggleFavorite: toggleFavoriteHandler
    };
  }
};
</script>