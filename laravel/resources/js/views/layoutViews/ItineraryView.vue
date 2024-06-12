<script setup>
import axios from 'axios';
import { onMounted, computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { Bookmark, Share, Download, Star, MapPin, Footprints, Route, Clock, Mountain, Accessibility, TriangleAlert, SquareArrowOutUpRight, ChevronDown, ChevronUp, X } from 'lucide-vue-next';
import { hideMarker } from "../../utils/MarkersVisibility.js";

//gestion des favoris
import ManageFavorite from '../../utils/ManageFavorite.js'; 
import { getFavorites } from '../../stores/StoreFavoriteIcon.js';
import { getFavoritesFromId } from '../../stores/StoreFavoriteIcon.js';
import { getLocalStorageUser } from '../../utils/LocalStorageUser';
import { ApiGetFavorites } from '../../utils/apiCalls/ApiGetFavorites';

import "leaflet/dist/leaflet.css";
import * as L from 'leaflet';
import 'leaflet-routing-machine';
import 'leaflet-routing-machine/dist/leaflet-routing-machine.css';
import { storeItinerary } from '../../stores/StoreItinerary.js';
import { storeItineraries } from '../../stores/StoreItineraries.js';
import { ApiGetItinerary } from '../../utils/apiCalls/ApiGetItinerary.js';
import MapItinerary from '../../components/MapItinerary.vue';

const route = useRoute();
const router = useRouter();
const routeItinerary = computed(() => {
    return route.name === "itinerary.view";
});
const stepId = computed(() => route.params.stepId - 1);

//gestion des favoris
const props = defineProps({
  itinerary: Object,
});

const isFavorite = computed(() => getFavorites().some(favorite => favorite.itinerary_id === props.itinerary?.id));


const itinerary = computed(() => storeItinerary.itinerary.data);
const myItinerary = async () => {
  return await storeItinerary.itinerary.data;  
};
const steps = [];

// const resolveData = async () => {
//   const resolvedValue = await myItinerary();
//   console.log('Resolved value:', resolvedValue);
//   // steps.forEach(element => {
//   //   console.log('element', element);
//   // });
// }
// resolveData();






// onMounted(() => {
  
// })
const itineraryId = ref(props.itinerary?.id);

const bookmarkIconRef = ref(null);

// Définition de isFavoriteState comme une ref
const isFavoriteState = ref(isFavorite.value); // Initialisation avec la valeur actuelle de isFavorite

const changeFavorite = (itineraryId) => {
  console.log(itineraryId);
  if (getFavorites().some(favorite => favorite.itinerary_id === itineraryId)) {
    //console.log("l'itinéraire existe");
    //toggleFavorite(itineraryId);
    ManageFavorite(itineraryId);
    isFavoriteState.value = false;
  } else {
    //console.log("l'itinéraire n'existe pas");
    //toggleFavorite(itineraryId);
    ManageFavorite(itineraryId);
    isFavoriteState.value = true;
  }
};

const fillFavorite = (itineraryId) => {
  getFavoritesFromId(itineraryId);
};
hideMarker(stepId);

// Exposition de la ref pour qu'elle soit accessible depuis le template
defineExpose({ bookmarkIconRef, isFavoriteState });

const emit = defineEmits(['requireNav']);

const stepAccess = (id) => {
    router.push(`${route.fullPath}/step/${id + 1}`);
};

function downloadPdf() {
    const route = "storage/itineraries/pdf/";
    const nom = itinerary.value.pdf_url; // Modifié pour utiliser directement la variable réactive
    // Concaténation de la route et du nom pour former le lien complet
    const link = document.createElement("a");
    link.href = `${route}${nom}`; // Modification ici pour inclure le nom dans le lien
    link.setAttribute("download", `${nom}.pdf`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

<script>
import { ref } from 'vue';
const showAllComments = ref(false);
let comments = ref([
  { username: 'Utilisateur1', rating: 5, review: 'La marche culturelle à Lausanne était incroyablement enrichissante. J\'ai adoré découvrir les différents aspects de la ville.', timestamp: '11.11.2023' },
  { username: 'Utilisateur2', rating: 4, review: 'Bien que j\'aie aimé certains aspects de la marche, il manquait un peu de variété dans les attractions proposées.', timestamp: '12.11.2023' },
  { username: 'Utilisateur3', rating: 5, review: 'Excellente découverte de Lausanne grâce à cette marche culturelle. Les guides étaient passionnants et les lieux visités étaient magnifiques.', timestamp: '13.11.2023' },
  { username: 'Utilisateur4', rating: 3, review: 'J\'ai trouvé la marche assez standard. Il aurait été intéressant d\'avoir plus de surprises ou de découvertes imprévues.', timestamp: '14.11.2023' },
  { username: 'Utilisateur5', rating: 4, review: 'La marche culturelle à Lausanne m\'a permis de découvrir des aspects de la ville que je n\'aurais pas explorés autrement. Un bon choix pour les amateurs de culture.', timestamp: '15.11.2023' },
  { username: 'Utilisateur6', rating: 5, review: 'Cette marche culturelle a vraiment fait ressortir la beauté de Lausanne. Chaque arrêt était une nouvelle surprise et les guides étaient super compétents.', timestamp: '16.11.2023' },
  { username: 'Utilisateur7', rating: 2, review: 'Malgré mes attentes, la marche ne m\'a pas convaincu. Je préfère explorer les villes par moi-même sans guide.', timestamp: '17.11.2023' },
  { username: 'Utilisateur8', rating: 4, review: 'La marche culturelle à Lausanne était très instructive. J\'ai apprécié les anecdotes historiques et les explications sur l\'art local.', timestamp: '18.11.2023' },
  { username: 'Utilisateur9', rating: 5, review: 'Une expérience inoubliable! La marche culturelle à Lausanne nous a offert une vision unique de la ville, mêlant histoire, art et architecture.', timestamp: '19.11.2023' },
  { username: 'Utilisateur10', rating: 4, review: 'La marche culturelle a bien structuré notre journée. Cependant, j\'aurais aimé avoir plus de temps libre pour explorer certains lieux.', timestamp: '20.11.2023' },
  { username: 'Utilisateur11', rating: 3, review: 'Bien que la marche ait été intéressante, elle manquait de profondeur. Plus de discussions approfondies auraient rendu l\'expérience plus enrichissante.', timestamp: '21.11.2023' },
  { username: 'Utilisateur12', rating: 5, review: 'La marche culturelle à Lausanne a été une véritable découverte. Les guides ont su captiver notre attention avec leurs connaissances passionnées.', timestamp: '22.11.2023' },
  { username: 'Utilisateur13', rating: 4, review: 'La marche culturelle a été une excellente introduction à Lausanne. Les guides étaient très engageants et les lieux visités étaient impressionnants.', timestamp: '23.11.2023' },
  { username: 'Utilisateur14', rating: 5, review: 'Un moment inoubliable! La marche culturelle à Lausanne a été une expérience mémorable, mettant en valeur la richesse culturelle de la ville.', timestamp: '24.11.2023' },
  { username: 'Utilisateur15', rating: 4, review: 'La marche culturelle a été une belle façon de découvrir Lausanne. Les guides étaient très compétents et les lieux visités étaient impressionnants.', timestamp: '25.11.2023' },
  { username: 'Utilisateur16', rating: 3, review: 'Bien que la marche ait été intéressante, elle manquait de profondeur. Plus de discussions approfondies auraient rendu l\'expérience plus enrichissante.', timestamp: '26.11.2023' },
  { username: 'Utilisateur17', rating: 5, review: 'La marche culturelle à Lausanne a été une véritable découverte. Les guides étaient très compétents et les lieux visités étaient impressionnants.', timestamp: '27.11.2023' },
  { username: 'Utilisateur18', rating: 4, review: 'La marche culturelle a été une belle façon de découvrir Lausanne. Les guides étaient très compétents et les lieux visités étaient impressionnants.', timestamp: '28.11.2023' },
  { username: 'Utilisateur19', rating: 5, review: 'La marche culturelle a été une véritable découverte. Les guides étaient très compétents et les lieux visités étaient impressionnants.', timestamp: '29.11.2023' },
]);
function toggleComments() {
  showAllComments.value =!showAllComments.value;
  buttonText.value = showAllComments.value? 'Afficher moins de commentaires' : 'Afficher plus de commentaires';
}
const buttonText = ref('Afficher plus de commentaires');
</script>

<template>
  <div class="md:mr-[15%] md:ml-[15%]">
    <div>
      <div v-if="routeItinerary" :style="{ 'background-image': 'url(storage/images/' + itinerary?.image.url + ')' }"
        class="bg-center w-full h-[250px] p-4 flex">
        <button @click="$router.go(-1)" class="mr-auto btn-iconContainer flex justify-center items-center"
          aria-label="Retour">
          <X aria-hidden="true" stroke="#754043" :size="18" />
        </button>
        <button class="mr-2 btn-iconContainer flex justify-center items-center"
        aria-label="Télécharger">
          <Share aria-hidden="true" stroke="#754043" :size="18" />
        </button>
        <button 
  class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
  :aria-label="isFavoriteState? 'Supprimer des favoris' : 'Ajouter aux favoris'"
  @click="changeFavorite(itinerary.id)"
>
  <Bookmark 
    :fill="isFavoriteState? '#754043' : 'transparent'" 
    stroke="#754043"
    :size="18" 
  />
</button>
      </div>
      <div v-else :style="{ 'background-image': 'url(storage/images/' + step.images[0].url + ')' }"
        class="bg-center w-screen h-[250px] p-4 flex"></div>
    </div>
    <div class="p-4">
      <ul class="mt-[-2rem] flex gap-3">
        <li v-for="tag in itinerary?.tag_categorie" :key="tag.id"
          class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center"
          aria-label="tag.taxonomy.name">
          <img :src="`storage/icons/${tag.taxonomy.icon}`" :alt="tag.taxonomy.description"
            style="width: 20px; height: 20px;">
        </li>
      </ul>

      <div class="flex justify-between">
        <h1 class="h3 text-tv-wine">
          <span v-if="routeItinerary">
            {{ itinerary?.name }}
          </span>
          <span v-else>
            {{ step.name }}
          </span>
        </h1>
        <div v-if="routeItinerary" class="flex items-center gap-1 text-tv-wine">
          <Star stroke="#754043" :size="18" />
          <p aria-label="Note du parcours sur 5">
            4.8</p>
        </div>
      </div>
      <div v-if="routeItinerary" class="flex items-center gap-2 mb-16">
        <div class="flex items-center gap-1 text-tv-wine">
          <MapPin stroke="#754043" :size="18" />
          <address class="not-italic">Lausanne</address>
        </div>
        <div class="w-1 h-1 mt-[.3rem] bg-tv-wine rounded-full"></div>
        <div class="flex items-center gap-1 text-tv-wine">
          <Footprints stroke="#754043" :size="18" />
          <p aria-label="Difficulté du parcours" class="capitalize">{{ itinerary?.difficulty }}</p>
        </div>
      </div>
      <div v-else class="flex items-center gap-2 mb-16 text-tv-wine">
        <address class="not-italic">{{ step.adress }}</address>
      </div>

      <div v-if="routeItinerary" class="mb-16 bg-tv-wine text-tv-eggshell rounded-3xl p-8 flex justify-between">
        <div class="flex flex-col items-center flex-wrap">
          <div class="w-full flex items-center gap-1 text-tv-beige">
            <Route stroke="#FAF0CA" :size="18" />
            <p>Distance
            </p>
          </div>
          <p>4.5 km</p>
        </div>

        <div class="flex flex-col items-center flex-wrap">
          <div class="w-full flex items-center gap-1 text-tv-beige">
            <Clock stroke="#FAF0CA" :size="18" />
            <p>Durée
            </p>
          </div>
          <p><time>{{ itinerary?.estimated_time }}</time></p>
        </div>

        <div class="flex flex-col items-center flex-wrap">
          <div class="w-full flex items-center gap-1 text-tv-beige">
            <Mountain stroke="#FAF0CA" :size="18" />
            <p>Dénivelé
            </p>
          </div>
          <p>234m</p>
        </div>

      </div>

      <div class="mb-16">
        <h3 class="text-tv-wine">Description</h3>
        <p v-if="routeItinerary">{{ itinerary?.description }}</p>
        <p v-else>{{ step.description }}</p>
      </div>
      <div class="mb-16">
        <h3 class="text-tv-wine">Parcours</h3>  
        {{ route.para }}           
        <MapItinerary :itineraryId="route.params.id">

        </MapItinerary>
      </div>
      <div v-if="routeItinerary" class="text-tv-wine">
        <h3 class="mb-2">Accessibilité</h3>
        <ul class="flex flex-col 4 mb-16 gap-4">
          <li v-for="tag in itinerary?.tag_accessibility" :key="tag.id" class="flex items-center gap-1">
            <img :src="`storage/icons/${tag.taxonomy.icon}`" :alt="tag.taxonomy.description">
            <p>{{ tag.taxonomy.name }}</p>
          </li>
        </ul>
      </div>
      <div v-if="routeItinerary" class="mb-16 flex justify-center">
        <button class="btn" @click="downloadPdf(itineraire)">
          <Download aria-hidden="true" stroke="#754043" :size="18" />
          Télécharger le parcours
        </button>
      </div>
      <div v-else class="mb-16 flex justify-center">
        <a href="" class="btn">
          <SquareArrowOutUpRight aria-hidden="true" stroke="#754043" :size="18" />
          En savoir plus
        </a>
      </div>
      <div v-if="routeItinerary">
        <h3 class="text-tv-wine">Avis de la communauté <span>(8)</span></h3>
        <div class="flex items-center gap-1 text-tv-wine">
          <Star stroke="#754043" :size="18" />
          <p aria-label="Note du parcours sur 5">
            4.8</p>
        </div>
        <div class="mb-16">
        <div class="border-t border-solid border-tv-wine py-8" v-for="(comment, index) in showAllComments? comments : comments.slice(0, 3)" :key="index">
          <div class="mb-3 flex gap-4">
            <div class="w-11 h-11">
              <img class="rounded-full" src="https://loremflickr.com/88/88" alt="">
            </div>
            <div>
              <h4>{{ comment.username }}</h4>
              <div class="flex items-center gap-1" aria-label="Note de l'utilisateur: 5 étoiles sur 5">
                <Star aria-hidden="true" stroke="#754043" :size="18" />
                <Star aria-hidden="true" stroke="#754043" :size="18" />
                <Star aria-hidden="true" stroke="#754043" :size="18" />
                <Star aria-hidden="true" stroke="#754043" :size="18" />
                <Star aria-hidden="true" stroke="#754043" :size="18" />
              </div>
            </div>
          </div>
          <p class="mb-4">{{ comment.review }}</p>
          <p class="body-regular-sm text-right"><time aria-label="{{ comment.timestamp }}">{{ comment.timestamp }}</time></p>
        </div>
        <div class="flex justify-center items-center">
          <button class="body-regular-sm flex justify-between items-center gap-1" @click="toggleComments">
            <span v-if="showAllComments" class="underline">Afficher moins de commentaires</span>
            <span v-else class="underline">Afficher plus de commentaires</span>
            <span v-if="showAllComments"><ChevronUp stroke="#754043" :size="14" /></span>
            <span v-else><ChevronDown stroke="#754043" :size="14" /></span>
          </button>
        </div>
      </div>
      <div>
        <a href="#" class="link justify-center">
          <TriangleAlert aria-hidden="true" stroke="#754043" :size="18" />
          Signaler un problème avec ce parcours
        </a>
      </div>
    </div>
  </div>
</div>
  

</template>

