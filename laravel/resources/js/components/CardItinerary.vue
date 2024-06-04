<script setup>
import { defineProps, computed } from 'vue';
import { Bookmark, Star } from 'lucide-vue-next';

const props = defineProps({
    itinerary: Array,
});
const imageUrl = computed(() => itinerary.image.url);
</script>

<template>

    <article
    class="relative max-w min-h-[220px] rounded-3xl mb-6 shadow-tv p-3 pb-5 bg-center text-tv-eggshell flex flex-col justify-between
    bg-[linear-gradient(to_top,rgba(0,0,0,1),rgba(0,0,0,0)50%),url('https://loremflickr.com/500/300')]">
            <div class="flex justify-between">                
            <ul class="flex gap-3">
                <li class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
                    aria-label="Nom catégorie">
                    <Bookmark aria-hidden="true" stroke="#754043" :size="18" />
                </li>

                <li class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
                    aria-label="Nom catégorie">
                    <Bookmark aria-hidden="true" stroke="#754043" :size="18" />
                </li>
            </ul>
            <div>
                <button aria-label="Ajouter le parcours aux favoris">
                    <div class="bg-tv-wine rounded-full w-[28px] h-[28px] flex justify-center items-center"
                        aria-hidden="true">
                        <Bookmark stroke="#f5f5f5" :size="18" />
                    </div>
                </button>
            </div>
        </div>
        <div class="flex justify-between">
            <div>
                <h3 aria-label="Nom du parcours">{{ itinerary.name }}</h3>
                <address class="not-italic">Lausanne</address>
            </div>
            <div class="flex flex-col items-end">
                <div class="flex items-center gap-1">                    
                        <Star stroke="#f5f5f5" :size="18" />                    
                    <p aria-label="Note du parcours sur 5">
                        4.8</p>
                </div>
                <div class="flex items-center gap-1.5">
                    <p aria-label="Distance du parcours">

                        {{ itinerary.length }} km</p>
                    <div class="w-1 h-1 mt-[.3rem] bg-tv-eggshell rounded-full"></div>
                    <p aria-label="Difficulté du parcours" class="capitalize">{{ itinerary.difficulty }}</p>
                </div>
            </div>
        </div>
        
    </article>

</template>

<style scoped></style>