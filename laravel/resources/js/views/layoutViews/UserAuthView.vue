<script setup>
</script>

<template>
  
  <h2>User Auth View</h2>
  <p>This is where we login or register</p>
  This part should switch between components for both forms.

  <div>
    <button @click="switchForm">Switch Form</button>
    <keep-alive>
      <component :is="currentForm" />
    </keep-alive>
  </div>

</template>

<script>
import LoginForm from '@/components/LoginForm.vue';
import RegisterForm from '@/components/RegisterForm.vue';

export default {
  components: {
    LoginForm,
    RegisterForm,
  },
  data() {
    return {
      currentForm: 'LoginForm',
    };
  },
  methods: {
    switchForm() {
      this.currentForm = this.currentForm === 'LoginForm'? 'RegisterForm' : 'LoginForm';
    },
  },
};
</script>