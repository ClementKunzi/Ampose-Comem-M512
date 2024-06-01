<template>
    <form @submit.prevent="submitForm">
        <div class="flex flex-col gap-6">
      <div v-for="(field, index) in formFields" :key="index">
        <label :for="field.name">{{ field.label }}</label>
        <input :id="field.name" :name="field.name" v-model="field.value" :type="field.type" :placeholder="field.placeholder" />
      </div>
      <button type="submit" class="btn self-center">Se connecter</button>
    </div>
    </form>
  </template>
  
  <script>
  export default {
    data() {
      return {
        formFields: [
          { name: 'Nom d\'utilisateur', label: 'Nom d\'utilisateur', value: '', type: 'text', placeholder: 'Username' },
          { name: 'lastName', label: 'Nom', value: '', type: 'text', placeholder: 'Last Name' },
          { name: 'firstName', label: 'Prénom', value: '', type: 'text', placeholder: 'First Name' },
          { name: 'email', label: 'Email', value: '', type: 'email', placeholder: 'Email Address' },
          { name: 'password', label: 'Password', value: '', type: 'password' },
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