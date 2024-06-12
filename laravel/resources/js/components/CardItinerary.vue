<script setup>
import { defineProps, defineEmits } from 'vue';
import { Bookmark, Star } from 'lucide-vue-next';
import ManageFavorite from '../utils/ManageFavorite.js';

const props = defineProps({
  itinerary: Object,
  isFavoriteFilled: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['favoriteToggled']);

const handleFavoriteClick = async () => {
  await ManageFavorite(props.itinerary.id);
  emit('favoriteToggled', props.itinerary.id); // Emit the event with the itinerary ID
};
</script>

<template>
  <article
    class="tv-text-shadow relative max-w min-h-[220px] rounded-3xl shadow-tv p-3 pb-5 bg-center text-tv-eggshell flex flex-col justify-between    
    before:content-[''] before:absolute before:top-0 before:left-0 before:h-full before:w-full before:rounded-3xl before:bg-[linear-gradient(to_top,rgba(0,0,0,1),rgba(0,0,0,0)50%)]"
    :style="{ backgroundImage: 'url(storage/images/' + itinerary.image.url + ')' }">
    <div class="flex justify-between z-10">                
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
      <div class="flex gap-2">
        <div class="flex items-center gap-1">
          <Star stroke="#f5f5f5" :size="18" />
          <p aria-label="Note du parcours sur 5">4.8</p>
        </div>
        <button aria-label="Ajouter le parcours aux favoris" @click.prevent="handleFavoriteClick">
          <div class="bg-tv-wine rounded-full w-[28px] h-[28px] flex justify-center items-center" aria-hidden="true">
            <Bookmark :fill="isFavoriteFilled ? '#f5f5f5' : 'transparent'" stroke="#f5f5f5" :size="18" />
          </div>
        </button>
      </div>
    </div>
    <div class="flex flex-col z-10">
      <div class="flex">
        <h3 class="body-bold-lg" aria-label="Nom du parcours">{{ itinerary.name }}</h3>
      </div>
      <div class="flex">
        <p class="mr-auto"><address class="not-italic">Lausanne</address></p>
        <div class="flex items-center gap-1.5">
          <p aria-label="Distance du parcours">{{ itinerary.length }} km</p>
          <div class="w-1 h-1 mt-[.3rem] bg-tv-eggshell rounded-full"></div>
          <p aria-label="Difficulté du parcours" class="capitalize">{{ itinerary.difficulty }}</p>
        </div>
      </div>
    </div>
  </article>
</template>

<style scoped></style>
