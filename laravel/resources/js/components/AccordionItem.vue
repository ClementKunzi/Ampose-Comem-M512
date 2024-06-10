<template>    
    <div class="accordion-item border-2 border-solid border-tv-wine rounded-3xl overflow-hidden flex flex-col shadow-tv"
        :class="{ active: isActive }">
        <button @click="toggleActive" class="rounded-3xl overflow-hidden">
            <div class="flex">
                <div class="w-1/3 min-w-[calc(100%/3)] bg-center bg-cover"
                :style="{ backgroundImage: 'url(' + imageUrl + ')' }">
                    <!-- <img class="object-cover h-full" :src="imageUrl" alt=""> -->
                </div>
                <div class="p-4 text-tv-wine grow text-left">
                    <h3 class="body-medium-base">Etape {{ index + 1 }}</h3>                                      
                    <h2 class="body-bold-xl">{{stepName ? stepName : 'Nom de l\'étape'}}</h2>                    
                </div>

            </div>
        </button>        
            <div v-show="isActive">
                <div class="mt-4">
                    <FormNewItineraryStep :isActive="isActive" :index="index" @updateName="handleUpdateName"
                    @updateImage="handleUpdateImage" />
                </div>

            </div>        
    </div>
    <slot v-if="itemLength > 2 && isActive"></slot>
</template>

<script setup>
import FormNewItineraryStep from '@/components/forms/FormNewItinerarySteps.vue';
import { ref, inject, watch, defineProps, defineExpose } from 'vue';

const props = defineProps({
    title: String,
    content: String,
    index: Number,
    isActive: Boolean,
    itemLength: Number,
});

const stepName = ref(null);
const imageUrl = ref('/images/placeholder-landscape.jpg');
const activeIndex = inject('activeIndex');
const setActiveIndex = inject('setActiveIndex');

const isActive = ref(false);

watch(activeIndex, (newIndex) => {
    isActive.value = props.index === newIndex;
});

const handleUpdateName = (name) => {    
    stepName.value = name;    
};

const handleUpdateImage = (imageFile) => {
    if (imageFile) {
        // Create a URL for the image file and update the reactive variable
        imageUrl.value = URL.createObjectURL(imageFile);
        // Optionally, emit the image URL or file to the parent component if needed      
        console.log(imageFile.value);  
    }
};

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
    @apply border-tv-eggshell bg-gray-200 p-2 pb-14;

    button {
        @apply bg-tv-wine;

        h2,
        h3 {
            @apply text-tv-eggshell;
        }
    }
}
</style>