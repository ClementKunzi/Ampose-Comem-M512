<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { Filter, CircleX } from 'lucide-vue-next';
import { storeCategories } from '../stores/StoreItineraryCategories.js'
import { useSelectedCategoryStore } from '../stores/StoreSelectedCategories.js'
import { storeAccessibility } from '../stores/StoreAccessibility.js';
import { useSelectedAccessibilityStore } from '../stores/StoreSelectedAccessibility.js';

const isButtonClicked = ref(false);
const isOpen1 = ref(false);
const isOpen2 = ref(false);

const category1Options = computed(() => storeCategories.categories);
const category2Options = computed(() => storeAccessibility.value.accessibilities);

const selectedCategory1 = ref([]);
const selectedCategory2 = ref([]);

const selectedCategoryStore = useSelectedCategoryStore();

const { setSelectedCategoryIds , selectedCategoryIds} = useSelectedCategoryStore();
const { setSelectedAccessibilityIds} = useSelectedAccessibilityStore();



watch(selectedCategoryIds, (newVal, oldVal) => {
    // Vérifie si la nouvelle valeur est différente de l'ancienne pour éviter la récursivité
    if (JSON.stringify(newVal) !== JSON.stringify(oldVal)) {
        selectedCategory1.value = newVal ? [...newVal] : [];
        if (selectedCategory1.value.length > 0) {
        isOpen1.value = true;
        console.log("isOpen1:", isOpen1.value);
    }else{
        isOpen1.value = false;
        console.log("isOpen1:", isOpen1.value);
    }
    }
}, { immediate: true });

watch(selectedCategory1, (newVal, oldVal) => {
    // Vérifie si la nouvelle valeur est différente de l'ancienne avant de mettre à jour
    if (JSON.stringify(newVal) !== JSON.stringify(oldVal)) {
        setSelectedCategoryIds(newVal);
        console.log("Catégories sélectionnées IDs:", newVal);
    }
});

watch(selectedCategory2, (newVal) => {
    setSelectedAccessibilityIds(newVal);
    if (selectedCategory2.value.length > 0) {
        isOpen2.value = true;
        console.log("isOpen2:", isOpen2.value);
    }else{
        isOpen2.value = false;
        console.log("isOpen2:", isOpen2.value);
    }
    console.log("Accessibilités sélectionnées IDs:", newVal);
});

// Fonction pour réinitialiser les filtres
function clearFilters() {
    selectedCategory1.value = [];
    selectedCategory2.value = [];
    setSelectedCategoryIds([]);
    setSelectedAccessibilityIds([]);
}

const isFilterSelected = computed(() => selectedCategory1.value.length > 0 || selectedCategory2.value.length > 0);
const isOneFilterSelected = computed(() => selectedCategory1.value.length > 0 || selectedCategory2.value.length > 0);


</script>

<template>
    <button aria-label="menu de catégories" @click="isButtonClicked = !isButtonClicked"
        class="absolute right-[74px] top-[16px]">
        <Filter v-if="!isButtonClicked && !isFilterSelected" stroke="#754144" :size="16" />
        <Filter v-if="!isButtonClicked && isFilterSelected" fill="#754144" stroke=none :size="16" />
        <CircleX v-if="isButtonClicked" stroke="#754144" :size="16" />
    </button>
    <div v-if="isButtonClicked"
        class="absolute top-14 left-0 p-6 w-full bg-tv-eggshell rounded-3xl border-2 border-solid border-tv-wine text-tv-wine flex flex-col gap-6">
        <details class="accordion-section border-b-1 border-solid border-tv-wine" :open="isOpen1" @toggle="toggleFilter">            <summary class="cursor-pointer mb-6">
                <h3 class="body-bold-base">Catégories de Sentiers</h3>
                <!-- <Home stroke="red" :size="30"  :class="{ 'rotate-180': isOpen1 }" /> -->
            </summary>
            <ul class="flex flex-wrap gap-y-4 mb-6">
                <li class="w-1/2 flex gap-3" v-for="(category, index) in category1Options" :key="category.id">
                    <input type="checkbox" :value="category.id" v-model="selectedCategory1" >
                    <label>{{ category.taxonomy.name }}</label>
                </li>
            </ul>
        </details>
        <details class="accordion-section border-b-1 border-solid border-tv-wine" @toggle="toggleFilter" :open="isOpen2">
            <summary class="cursor-pointer mb-6">
                <h3 class="body-bold-base">Accessibilité</h3>
                <!-- <Home stroke="red" :size="30"  :class="{ 'rotate-180': isOpen1 }" /> -->
            </summary>
            <ul class="flex flex-wrap gap-y-4 mb-6">
                <li class="w-full flex gap-3" v-for="(accessibility, index) in category2Options" :key="accessibility.id">
                    <input type="checkbox" :value="accessibility.id" v-model="selectedCategory2">
                    <label>{{ accessibility.taxonomy.name }}</label>
                </li>
            </ul>
                </details>
                <div v-if="isButtonClicked && isFilterSelected">
                    <a @click="clearFilters" class=" text-tv-wine underline text-center block mx-auto">Effacer les filtres</a></div>
                </div>


</template>



<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}

details>summary {
    position: relative;
    display: flex;

    &::after {
        content: '';
        background-image: url('images/svg/chevron-down.svg');
        width: 24px;
        height: 24px;
        background-size: 24px 24px;
        position: absolute;
        right: 0;
    }
}

details[open]>summary {
    &::after {
        transform: rotate(180deg);
    }
}
</style>
