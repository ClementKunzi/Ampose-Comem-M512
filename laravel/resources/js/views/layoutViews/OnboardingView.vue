<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { MapPinned, Castle, Route, Smile, Droplet, TriangleAlert } from 'lucide-vue-next';
import Cookies from 'js-cookie';

const currentStep = ref(0);
const router = useRouter();
const route = useRoute();

function nextStep() {
  currentStep.value++;
}

const redirectToHome = () => {
  // window.location.href = 'http://localhost:8000/#/';
  router.push(`/`);
};

onMounted(() => {
  // Check if the user has completed the onboarding process within the last 30 days
  if (Cookies.get('onboarding_completed') && new Date(Cookies.get('onboarding_last_seen')) > new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000)) {
    // Redirect to home or skip the onboarding process
    redirectToHome();
  }
});

// Function to mark the onboarding as completed
function completeOnboarding() {
  Cookies.set('onboarding_completed', 'true', { expires: 30 }); // Set the cookie to expire in 30 days
  Cookies.set('onboarding_last_seen', new Date().toISOString()); // Record the last seen time
  redirectToHome(); // Optionally redirect to home after completing the onboarding
}

</script>



<template>
  <div class="onboarding-container-welcome text-tv-eggshell tv-text-shadow py-8 px-10">
    <div class="flex flex-col h-full">
      <div class="flex justify-center mb-10" v-if="currentStep === 0">
        <img src="/images/logo/logo-tv-blanc.svg" alt="Terravaud Logo"/>
      </div>
      
      <h2 class="h2 mb-10" v-if="currentStep === 0">Bienvenue sur <br><span class="">Terravaud</span></br></h2>
      <p class="body-regular-sm md:body-medium-lg mb-16" v-if="currentStep === 0">Votre guide pour découvrir les trésors culturels du canton de Vaud</p>
        
      <!-- <div v-if="currentStep === 0" class="step-indicators mb-2 mt-auto">
        <span class="active"></span>
        <span></span>
        <span></span>
      </div> -->
      
      <div class="flex flex-col items-center justify-center mt-auto" v-if="currentStep === 0">
        <button class="btn mb-2" @click="nextStep" :disabled="currentStep === 3">Commencer</button>
        <button class="opacity-50 underline body-regular-sm" @click="redirectToHome">Passer</button>
      </div>
    </div>

    <div class="flex-col-h-full" v-if="currentStep >= 1">
      <h3 v-if="currentStep === 1">Utiliser Terravaud...</h3>
      <p class="body-regular-sm mb-16" v-if="currentStep === 1">Laissez-nous vous montrer comment profiter au mieux.</p>
      <ul class="mb-16" v-if="currentStep === 1">
        <li class="mb-4 flex flex-col items-center justify-center">
          <MapPinned class="mb-2" size="32"/> <span>Trouvez et sélectionnez des sentiers adaptés à vos envies</span>
        </li>
        <li class="mb-4 flex flex-col items-center justify-center">
          <Route class="mb-2" size="32"/> <span>Découvrez des points d’intérêt et des informations pratiques</span>
        </li>
        <li class="mb-4 flex flex-col items-center justify-center">
          <Castle class="mb-2" size="32"/> <span>Ajoutez vos propres sentiers et partagez vos découvertes</span>
        </li>
      </ul>

      <!-- <div v-if="currentStep === 1" class="step-indicators mb-2 mt-auto">
        <span></span>
        <span class="active"></span>
        <span></span>
      </div> -->
      
      <div class="flex flex-col items-center justify-center mt-auto" v-if="currentStep === 1">
        <button class="btn mb-2" @click="nextStep" :disabled="currentStep === 3">Suivant</button>
        <button class="opacity-50 underline body-regular-sm" @click="redirectToHome">Passer</button>
      </div>
    </div>

    <div class="flex-col-h-full" v-if="currentStep === 2">
      <h3>Encore une chose</h3>
      <p class="body-regular-sm mb-16">Instructions et comportements</p>
      <ul v-if="currentStep === 2">
        <li class="mb-4 flex flex-col items-center justify-center">
          <Smile class="mb-2" size="32"/> <span>Respecter les sites et les propriétés que vous visitez</span>
        </li>
        <li class="mb-4 flex flex-col items-center justify-center">
          <Droplet class="mb-2" size="32"/> <span>Assurez-vous d'être bien préparé pour votre balade</span>
        </li>
        <li class="mb-4 flex flex-col items-center justify-center">
          <TriangleAlert class="mb-2" size="32"/> <span>Utilisez l'application pour signaler les obstacles, les dangers ou autre</span>
        </li>
      </ul>

      <!-- <div class="step-indicators mb-2 mt-auto">
        <span></span>
        <span></span>
        <span class="active"></span>
      </div> -->
      
      <div class="flex flex-col items-center justify-center mt-auto">
        <button class="btn" @click="completeOnboarding">Explorez Maintenant</button>
      </div>
    </div>
  </div>
</template>


<style scoped>

.onboarding-container-welcome {
  text-align: center;
  background-image: url('/images/onboarding-background1.png');
  background-size: cover;
  background-position: left;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding-bottom: 20px;
}

.flex-col-h-full {
  display: flex;
  flex-direction: column;
  height: auto; /* Adjusts based on content */
}

/* Ensures the container does not push other elements down when empty */
.flex-col-h-full:not(:empty) {
  min-height: 100%; /* Applies minimum height only when there is content */
}
</style>