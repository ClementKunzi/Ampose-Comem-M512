<template>
  <form @submit.prevent="() => {
    register(
    formFields[0].value,
    formFields[1],
    formFields[2].value,
    formFields[3].value,
    formFields[4].value,
    formFields[5].value);
    $router.push('/');
  }">
    <div class="flex flex-col gap-6">
      <div v-for="(field, index) in formFields" :key="index">
        <label :for="field.name">{{ field.label }}</label>
        <input :id="field.name" :name="field.name" v-model.type="field.value" :type="field.type"
          :accept="field.type === 'file' ? 'image/*' : ''" :placeholder="field.placeholder" />

      </div>
      <button type="submit" class="btn self-center">S'inscire</button>
    </div>
  </form>

</template>

<script setup>
import { ref, defineExpose } from 'vue'; // Import defineExpose
import axios from 'axios';
import { register } from '@/utils/apiCalls/apiCalls.js';
import { useRouter } from 'vue-router';


const router = useRouter();

const submitForm = async () => {
  // Existing registration logic...
  if (response.data.success) { // Assuming the API returns a success flag
    router.push('/dashboard'); // Redirect to dashboard or desired page
    emit('registerSuccess');
  }
};


const formFields = [
  { name: 'userName', label: 'Nom d\'utilisateur', value: 'Jimbo', type: 'text', placeholder: 'Username', isValid: true },
  { name: 'userImage', label: 'Image du profile', value: '', type: 'file', placeholder: '', isValid: true },
  { name: 'lastName', label: 'Nom', value: 'Dugard', type: 'text', placeholder: 'Last Name', isValid: true },
  { name: 'firstName', label: 'Prénom', value: 'Phil', type: 'text', placeholder: 'First Name', isValid: true },
  { name: 'email', label: 'Email', value: 'nicolas.aerny@cool.com', type: 'email', placeholder: 'Email Address', isValid: true },
  { name: 'password', label: 'Password', value: '12345678', type: 'password', isValid: true },
];




</script>