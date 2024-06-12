<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { Filter, X } from "lucide-vue-next";
import { storeCategories } from "../stores/StoreItineraryCategories.js";
import { useSelectedCategoryStore } from "../stores/StoreSelectedCategories.js";
import { storeAccessibilities } from "../stores/StoreItineraryAccessibility.js";
import { useSelectedAccessibilityStore } from "../stores/StoreSelectedAccessibility.js";

const isButtonClicked = ref(false);
const isOpen1 = ref(false);
const isOpen2 = ref(false);

const category1Options = computed(() => storeCategories.categories);
const category2Options = computed(() => storeAccessibilities.accessibilities);

const selectedCategory1 = ref([]);
const selectedCategory2 = ref([]);

const selectedCategoryStore = useSelectedCategoryStore();

const { setSelectedCategoryIds, selectedCategoryIds } =
    useSelectedCategoryStore();
const { setSelectedAccessibilityIds, selectedAccessibilityIds } =
    useSelectedAccessibilityStore();

watch(
    selectedCategoryIds,
    (newVal, oldVal) => {
        // Vérifie si la nouvelle valeur est différente de l'ancienne pour éviter la récursivité
        if (JSON.stringify(newVal) !== JSON.stringify(oldVal)) {
            selectedCategory1.value = newVal ? [...newVal] : [];
            if (selectedCategory1.value.length > 0) {
                isOpen1.value = true;
                console.log("isOpen1:", isOpen1.value);
            } else {
                isOpen1.value = false;
                console.log("isOpen1:", isOpen1.value);
            }
        }
    },
    { immediate: true }
);

watch(selectedCategory1, (newVal, oldVal) => {
    // Vérifie si la nouvelle valeur est différente de l'ancienne avant de mettre à jour
    if (JSON.stringify(newVal) !== JSON.stringify(oldVal)) {
        setSelectedCategoryIds(newVal);
        console.log("Catégories sélectionnées IDs:", newVal);
    }
});

watch(
    selectedAccessibilityIds,
    (newVal, oldVal) => {
        // Vérifie si la nouvelle valeur est différente de l'ancienne pour éviter la récursivité
        if (JSON.stringify(newVal) !== JSON.stringify(oldVal)) {
            selectedCategory2.value = newVal ? [...newVal] : [];
            if (selectedCategory2.value.length > 0) {
                isOpen2.value = true;
                console.log("isOpen2:", isOpen2.value);
            } else {
                isOpen2.value = false;
                console.log("isOpen2:", isOpen2.value);
            }
        }
    },
    { immediate: true }
);

watch(selectedCategory2, (newVal, oldVal) => {
    // Vérifie si la nouvelle valeur est différente de l'ancienne avant de mettre à jour
    if (JSON.stringify(newVal) !== JSON.stringify(oldVal)) {
        setSelectedAccessibilityIds(newVal);
        console.log("Accessibilités sélectionnées IDs:", newVal);
    }
});

// Fonction pour réinitialiser les filtres
function clearFilters() {
    selectedCategory1.value = [];
    selectedCategory2.value = [];
    setSelectedCategoryIds([]);
    setSelectedAccessibilityIds([]);
}

const isFilterSelected = computed(
    () =>
        selectedCategory1.value.length > 0 || selectedCategory2.value.length > 0
);
</script>

<template>
    <button
        aria-label="menu de catégories"
        @click="isButtonClicked = !isButtonClicked"
        class="absolute right-5 top-[16px]"
    >
        <Filter
            v-if="!isButtonClicked && !isFilterSelected"
            stroke="#754144"
            :size="20"
        />
        <Filter
            v-if="!isButtonClicked && isFilterSelected"
            fill="#754144"
            stroke="none"
            :size="20"
        />
        <X v-if="isButtonClicked" stroke="#754144" :size="20" />
    </button>
    <div
        v-if="isButtonClicked"
        class="absolute top-14 left-0 p-6 w-full bg-tv-eggshell rounded-3xl border-2 border-solid border-tv-wine text-tv-wine flex flex-col gap-6"
    >
        <details
            class="accordion-section border-b-1 border-solid border-tv-wine"
            :open="isOpen1"
            @toggle="toggleFilter"
        >
            <summary class="summary-flex cursor-pointer mb-6">
                <h3 class="body-bold-base">Catégories de Sentiers</h3>
                <svg
                    class="chevron-icon ml-auto"
                    :class="{ 'rotate-180': isOpen1 }"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </summary>
            <ul class="flex flex-wrap gap-y-4 mb-6">
                <li
                    class="w-1/2 flex gap-3"
                    v-for="(category, index) in category1Options"
                    :key="category.id"
                >
                    <input
                        type="checkbox"
                        :value="category.id"
                        v-model="selectedCategory1"
                    />
                    <label>{{ category.taxonomy.name }}</label>
                </li>
            </ul>
        </details>
        <details
            class="accordion-section border-b-1 border-solid border-tv-wine"
            @toggle="toggleFilter"
            :open="isOpen2"
        >
            <summary class="summary-flex cursor-pointer mb-6">
                <h3 class="body-bold-base">Accessibilité</h3>
                <svg
                    class="chevron-icon ml-auto"
                    :class="{ 'rotate-180': isOpen2 }"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </summary>
            <ul class="flex flex-wrap gap-y-4 mb-6">
                <li
                    class="w-full flex gap-3"
                    v-for="(accessibility, index) in category2Options"
                    :key="accessibility.id"
                >
                    <input
                        type="checkbox"
                        :value="accessibility.id"
                        v-model="selectedCategory2"
                    />
                    <label>{{ accessibility.taxonomy.name }}</label>
                </li>
            </ul>
        </details>
        <div v-if="isButtonClicked && isFilterSelected">
            <a
                @click="clearFilters"
                class="text-tv-wine underline text-center block mx-auto"
                >Effacer les filtres</a
            >
        </div>
    </div>
</template>

<style scoped>
.summary-flex {
    display: flex;
    align-items: center; /* Centre verticalement le texte et l'icône */
}
.rotate-180 {
    transform: rotate(180deg);
}

.chevron-icon {
    width: 24px; /* Ajustez selon vos besoins */
    height: 24px; /* Ajustez selon vos besoins */
    transition: transform 0.2s; /* Animation douce */
}
</style>
