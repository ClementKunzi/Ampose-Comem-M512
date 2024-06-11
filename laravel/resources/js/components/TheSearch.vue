<script setup>
import { computed, ref, watch, defineEmits, onMounted } from 'vue';
import Filters from '@/components/TheFilters.vue';
import { storeCategories } from '../stores/StoreItineraryCategories.js';
import { useSelectedCategoryStore } from '../stores/StoreSelectedCategories.js';
import { UserLocalStorage } from '../classes/UserLocalStorage.js'
const currentUser = new UserLocalStorage()

const categories = computed(() => storeCategories.categories);

const { setSelectedCategoryIds, selectedCategoryIds } = useSelectedCategoryStore();

const selectedCategory = ref([]);

// Utilisez watchEffect ou watch pour réagir aux changements dans selectedCategoryIds
watch(selectedCategoryIds, (newVal) => {
  selectedCategory.value = newVal ? [...newVal] : [];
}, { immediate: true });

const searchQuery = ref('');

const emit = defineEmits(['updateSearch']);

watch(searchQuery, (newValue) => {
  emit('updateSearch', newValue);
});

const handleCategoryClick = (categoryId, selectAllCondition = false) => {
  if (selectAllCondition) {
    selectedCategory.value = storeCategories.categories.map(cat => cat.id);
  } else {
    if (categoryId === null) {
      selectedCategory.value = [];
    } else {
      const index = selectedCategory.value.indexOf(categoryId);
      if (index > -1) {
        selectedCategory.value.splice(index, 1);
      } else {
        selectedCategory.value.push(categoryId);
      }
    }
    // Force Vue to react to the update
    selectedCategory.value = [...selectedCategory.value];
  }
  // Mise à jour du store
  setSelectedCategoryIds(selectedCategory.value.length > 0 ? selectedCategory.value : null);
};
</script>

<template>
    <div class="sticky z-50 top-4 mb-9">
        <div class="mb-2 flex justify-between gap-2">
            <input id="searchInput" class="btn grow" type="text" v-model="searchQuery" placeholder="Rechercher" />
            <Filters />
            <router-link aria-label="Profile utilisateur" to="/user/profile">
              <div class="max-w-12 h-full">
                <img class="h-full rounded-full object-cover" :src="currentUser.getUserImageProfile()" alt="">
              </div>               
            </router-link>
        </div>

        <div>
            <ul class="overflow-scroll w-[calc(100%+2rem)] pl-4 ml-[-1rem] pb-4 mb-[-1rem] flex gap-1.5">
                <li class="shrink-0">
<button @click="handleCategoryClick(null)" :class="{'active': selectedCategory.length === 0}" class="btn flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="lucide lucide-rows-2 w-4 h-4">
        <rect width="18" height="18" x="3" y="3" rx="2" />
        <path d="M3 12h18" />
    </svg> Tous
</button>
                </li>
                <li class="shrink-0" v-for="(category, index) in categories" :key="category.id">
                    <button @click="() => handleCategoryClick(category.id)" :class="{'active': selectedCategory.includes(category.id)}" class="btn flex items-center gap-2">
                        <img :src="`storage/icons/${category.taxonomy.icon}`" alt="" class="w-4 h-4"> {{
                            category.taxonomy.name }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.active {
    background-color: rgb(117 64 67); /* Exemple de couleur de fond pour l'élément actif */
    color: white; /* Couleur du texte pour l'élément actif */
}
</style>


