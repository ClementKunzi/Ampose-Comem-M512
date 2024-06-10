<script setup>
import { computed, ref, watch, defineEmits } from 'vue';
import Filters from '@/components/TheFilters.vue';
import { storeCategories } from '../stores/StoreItineraryCategories.js';
import { useSelectedCategoryStore } from '../stores/StoreSelectedCategories.js';

const categories = computed(() => storeCategories.categories);

const { setSelectedCategoryIds } = useSelectedCategoryStore();

const selectedCategory = ref([]);
const searchQuery = ref(''); // Déclaration de searchQuery comme une ref

const emit = defineEmits(['updateSearch']);

watch(searchQuery, (newValue) => {
  emit('updateSearch', newValue);
});

const handleCategoryClick = (categoryId) => {
  if (selectedCategory.value[0] === categoryId || categoryId === null) {
    selectedCategory.value = [];
  } else {
    selectedCategory.value = [categoryId];
  }
  console.log("Catégories sélectionnées:", selectedCategory.value);
};

watch(selectedCategory, (newVal) => {
  if (newVal.length === 0) {
    setSelectedCategoryIds(null);
  } else {
    setSelectedCategoryIds(newVal);
  }
  console.log("Catégories sélectionnées IDs:", newVal.length > 0? newVal : null);
});
</script>

<template>
    <div class="sticky z-50 top-4 mb-9">
        <div class="mb-2 flex justify-between gap-2">
            <input id="searchInput" class="btn grow" type="text" v-model="searchQuery" placeholder="Rechercher" />
            <Filters />
            <router-link aria-label="Profile utilisateur" to="/user/profile">
                <img class="max-w-12 rounded-full" src="https://loremflickr.com/300/300" alt="">
            </router-link>
        </div>

        <div>
            <ul class="overflow-scroll w-[calc(100%+2rem)] pl-4 ml-[-1rem] pb-4 mb-[-1rem] flex gap-1.5">
                <li class="shrink-0">
                    <button @click="handleCategoryClick(null)" class="btn flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-rows-2 w-4 h-4">
                            <rect width="18" height="18" x="3" y="3" rx="2" />
                            <path d="M3 12h18" />
                        </svg> Tous
                    </button>
                </li>
                <li class="shrink-0" v-for="(category, index) in categories" :key="category.id">
                    <button @click="() => handleCategoryClick(category.id)" class="btn flex items-center gap-2">
                        <img :src="`storage/icons/${category.taxonomy.icon}`" alt="" class="w-4 h-4"> {{
                            category.taxonomy.name }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped></style>
