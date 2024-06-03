<template>
    <div class="accordion-item border-2 border-solid border-tv-wine rounded-3xl overflow-hidden flex flex-col"
        :class="{ active: isActive }">
        <button @click="toggleActive" class="rounded-3xl overflow-hidden">
            <div class="flex">
                <div class="w-1/3 ">
                    <img src="https://loremflickr.com/300/300" alt="">
                </div>
                <div class="p-6 text-tv-wine grow text-left">
                    <h3 class="body-medium-base">Etape {{ index + 1 }}</h3>
                    <h2 class="body-bold-xl">Nom étape</h2>                    
                </div>

            </div>
        </button>        
            <div v-show="isActive">
                <div class="mt-4">
                    <FormNewItineraryStep :isActive="isActive" />
                </div>

            </div>        
    </div>
</template>

<script setup>
import FormNewItineraryStep from '@/components/forms/FormNewItinerarySteps.vue';
import { ref, inject, watch, defineProps } from 'vue';

const props = defineProps({
    title: String,
    content: String,
    index: Number,
    isActive: Boolean,
});

const activeIndex = inject('activeIndex');
const setActiveIndex = inject('setActiveIndex');

const isActive = ref(false);

watch(activeIndex, (newIndex) => {
    isActive.value = props.index === newIndex;
});

const toggleActive = () => {
    if (isActive.value) {
        setActiveIndex(null);
    } else {
        setActiveIndex(props.index);
    }
};
</script>

<style scoped>

.accordion-item.active {
    @apply border-tv-eggshell bg-gray-200 p-2;

    button {
        @apply bg-tv-wine;

        h2,
        h3 {
            @apply text-tv-eggshell;
        }
    }
}
</style>