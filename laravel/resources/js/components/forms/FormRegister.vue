<template>
  <form @submit.prevent="submitForm">
    <div class="flex flex-col gap-6">
      <div v-for="(field, index) in formFields" :key="index">
        <label :for="field.name">{{ field.label }}</label>
        <input :id="field.name" :name="field.name" v-model.type="field.value" :type="field.type"
          :placeholder="field.placeholder" />
        
      </div>
      <button type="submit" class="btn self-center">Se connecter</button>
    </div>
  </form>
  
</template>

<script setup>
  import { submitForm } from '@/composables/FormValidation.js';
</script>
<script>
export default {
  data() {
    return {
      formFields: [
        { name: 'userName', label: 'Nom d\'utilisateur', value: '', type: 'text', placeholder: 'Username', isValid: true, },
        { name: 'lastName', label: 'Nom', value: '', type: 'text', placeholder: 'Last Name', isValid: true, },
        { name: 'firstName', label: 'Prénom', value: '', type: 'text', placeholder: 'First Name', isValid: true, },
        { name: 'email', label: 'Email', value: '', type: 'email', placeholder: 'Email Address', isValid: true, },
        { name: 'password', label: 'Password', value: '', type: 'password', isValid: true, },
        // Add more form fields as needed
      ],
      
      
    };
  },

  methods: {
    submitForm() {
      console.log(this.formFields);
      // Handle form submission
    },
    
  },
  
};
</script>