<script setup>
import { CircleX } from 'lucide-vue-next';
import FormLogin from '@/components/forms/FormLogin.vue';

import { ref } from 'vue';
import FormRegister from '../../components/forms/FormRegister.vue';

const isVisible = ref(true);

function toggleVisibility() {
  isVisible.value = !isVisible.value;
}
</script>

<template>  
  <div v-show="isVisible" class="min-h-[400px] bg-no-repeat bg-cover bg-center p-4"
    style="background-image: url(/images/login.jpg)">
    <button @click="$router.go(-1)"
        class="mr-auto btn-iconContainer" aria-label="Retour">        
          <CircleX aria-hidden="true" :size="32" />              
      </button>
  </div>
  <div v-show="!isVisible" class="min-h-[200px] bg-no-repeat bg-center  bg-tv-wine p-4"
  style="background-image: url(/images/logo/logo-tv-blanc.svg)">
  <button @click="$router.go(-1)"
        class="mr-auto btn-iconContainer" aria-label="Retour">        
          <CircleX aria-hidden="true" :size="32" />              
      </button>  
  </div>
  <div class="p-4 flex flex-col justify-center grow bg-tv-wine text-tv-eggshell lg:w-full">
    <div class="grow flex flex-col justify-center">
      <h1 class="h2 text-center">{{ isVisible ? 'Se connecter' : 'S\'inscrire' }}</h1>
      <FormLogin v-show="isVisible" />
      <FormRegister v-show="!isVisible" />      
    </div>
    <button @click="toggleVisibility" class="mt-2 link text-tv-eggshell self-center">{{isVisible? 'S\'inscrire' : 'Se connecter'}}</button>
  </div>
</template>