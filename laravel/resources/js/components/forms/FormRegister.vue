<template>
  <form @submit.prevent="handleSubmit">
    <div class="flex flex-col gap-6">
      <div v-for="(field, index) in formFields" :key="index">
        <label :for="field.name">{{ field.label }}</label>
        <input 
          v-if="field.type === 'file'" 
          :id="field.name" 
          :name="field.name" 
          type="file" 
          accept="image/*" 
          @change="updateImage($event, index)" 
          :placeholder="field.placeholder" 
          required 
        />
        <input 
          v-else 
          :id="field.name" 
          :name="field.name" 
          v-model="field.value" 
          :type="field.type" 
          :placeholder="field.placeholder" 
          required 
        />
        <span v-if="errors && errors[field.name]" class="text-tv-eggshell flex gap-2 pt-2 items-center body-regular-sm"><TriangleAlert/>{{ errors[field.name][0] }}</span>
      </div>
      <button type="submit" class="btn self-center">S'inscrire</button>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/StoreUser';
import {TriangleAlert} from 'lucide-vue-next';

const { errors, performRegister } = useUserStore();
const router = useRouter();

// Définition des champs de formulaire avec leurs types et valeurs initiales
const formFields = ref([
  { name: 'userName', label: 'Nom d\'utilisateur', type: 'text', placeholder: 'Username', isValid: true, value: '' },
  { name: 'userImage', label: 'Image du profile', type: 'file', placeholder: '', isValid: true, file: null },
  { name: 'lastName', label: 'Nom', type: 'text', placeholder: 'Last Name', isValid: true, value: '' },
  { name: 'firstName', label: 'Prénom', type: 'text', placeholder: 'First Name', isValid: true, value: '' },
  { name: 'email', label: 'Email', type: 'email', placeholder: 'Email Address', isValid: true, value: '' },
  { name: 'password', label: 'Password', type: 'password', isValid: true, value: '' },
]);

const handleSubmit = async () => {
  const success = await performRegister(
    formFields.value[0].value,
    formFields.value[1].file,
    formFields.value[2].value,
    formFields.value[3].value,
    formFields.value[4].value,
    formFields.value[5].value
  );

  if (success) {
    // Redirection ou autre action après succès
    router.push('/');
  }
};

const updateImage = (event, index) => {
  formFields.value[index].file = event.target.files[0];
};
</script>
