<script setup>
import { X, Settings } from 'lucide-vue-next';
import FormEditUser from '../../components/forms/FormEditUser.vue';
</script>

<template>
  <div class="p-4 bg-tv-wine text-tv-eggshell">
    <div class="mb-6 flex justify-between">
      <button @click="$router.go(-1)"
        class="bg-tv-eggshell rounded-full w-[28px] h-[28px] flex justify-center items-center" aria-label="Retour">
        <X aria-hidden="true" stroke="#754043" :size="18" />
      </button>      
    </div>

    <div>
      <h1 class="h3 text-center">Modifier mon profil</h1>
    </div>
    <div class="mb-6 flex justify-center">
      <FormEditUser />
    
    </div>
  </div>
  
  
  <router-link to="/">To Home</router-link>
</template>