<script setup>
import { ref, computed, watch } from 'vue';
import { Filter, CircleX } from 'lucide-vue-next';
import { storeCategories } from '../stores/StoreItineraryCategories.js'
import { useSelectedCategoryStore } from '../stores/StoreSelectedCategories.js'
import { storeAccessibility } from '../stores/StoreAccessibility.js';
import { useSelectedAccessibilityStore } from '../stores/StoreSelectedAccessibility.js';

const isButtonClicked = ref(false);
const isOpen1 = ref(false);

const category1Options = computed(() => storeCategories.categories);
const category2Options = computed(() => storeAccessibility.accessibilities);

const selectedCategory1 = ref([]);
const selectedCategory2 = ref([]);

const { setSelectedCategoryIds } = useSelectedCategoryStore();
const { setSelectedAccessibilityIds} = useSelectedAccessibilityStore();

watch(selectedCategory1, (newVal) => {
  setSelectedCategoryIds(newVal);
  console.log("Catégories sélectionnées IDs:", newVal);
});

watch(selectedCategory2, (newVal) => {
    setSelectedAccessibilityIds(newVal);
  console.log("Accessibilités sélectionnées IDs:", newVal);
});
</script>

<template>
    <button aria-label="menu de catégories" @click="isButtonClicked = !isButtonClicked"
        class="absolute right-[74px] top-[16px]">
        <Filter v-if="!isButtonClicked" stroke="#754144" :size="16" />
        <CircleX v-if="isButtonClicked" stroke="#754144" :size="16" />
    </button>
    <div v-if="isButtonClicked"
        class="absolute top-14 left-0 p-6 w-full bg-tv-eggshell rounded-3xl border-2 border-solid border-tv-wine text-tv-wine flex flex-col gap-6">
        <details class="accordion-section border-b-1 border-solid border-tv-wine" @toggle="isOpen1 = !isOpen1">
            <summary class="cursor-pointer mb-6">
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
        <details class="accordion-section border-b-1 border-solid border-tv-wine" @toggle="isOpen1 = !isOpen1">
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
