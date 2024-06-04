<template>
  <form @submit.prevent="register(
    formFields[0].value,
    formFields[1].value,
    formFields[2].value,
    formFields[3].value,
    formFields[4].value)">
    <div class="flex flex-col gap-6">
      <div v-for="(field, index) in formFields" :key="index">
        <label :for="field.name">{{ field.label }}</label>
        <input :id="field.name" :name="field.name" v-model.type="field.value" :type="field.type"
          :placeholder="field.placeholder" />

      </div>           
      <button type="submit" class="btn self-center">S'inscire</button>
    </div>
  </form>

</template>

<script setup>
import { ref, defineExpose } from 'vue'; // Import defineExpose
import axios from 'axios';
import { register } from '@/utils/apiCalls/apiCalls.js';

const formFields = [
    { name: 'userName', label: 'Nom d\'utilisateur', value: 'Bingo', type: 'text', placeholder: 'Username', isValid: true },
    { name: 'lastName', label: 'Nom', value: 'Dugard', type: 'text', placeholder: 'Last Name', isValid: true },
    { name: 'firstName', label: 'Prénom', value: 'Phil', type: 'text', placeholder: 'First Name', isValid: true },
    { name: 'email', label: 'Email', value: 'nicolas.aerny@cool.com', type: 'email', placeholder: 'Email Address', isValid: true },
    { name: 'password', label: 'Password', value: '12345678', type: 'password', isValid: true },
];

const submitForm = async () => {
  
    try {
        const response = await axios.post('http://localhost:8000/api/auth/register', {
          username: formFields[0].value,
            last_name: formFields[1].value,
            first_name: formFields[2].value,
            email: formFields[3].value,
            password: formFields[4].value,
        });

        console.log('Response:', response.data);
        // Handle success (e.g., redirecting to another page)
    } catch (error) {
        console.error('Error:', error.response? error.response.data : error.message);
        // Handle error (e.g., showing an error message)
    }
};

// Expose submitForm to the template
defineExpose({ submitForm });
</script>