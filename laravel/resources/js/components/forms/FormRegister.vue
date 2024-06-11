<template>
  <form @submit.prevent="handleSubmit">
    <div class="flex flex-col gap-6">
      <div v-for="(field, index) in formFields" :key="index">
        <label :for="field.name">{{ field.label }}</label>
        <input v-if="field.type === 'file'" :id="field.name" :name="field.name" v-model="field.value" :type="field.type" accept="image/*" @change="updateImage" :placeholder="field.placeholder" required />
        <input v-else :id="field.name" :name="field.name" v-model="field.value" :type="field.type" :placeholder="field.placeholder" required />
        <span v-if="errors && errors[field.name]" class="error">{{ errors[field.name][0] }}</span>
      </div>
      <button type="submit" class="btn self-center">S'inscrire</button>
    </div>
  </form>

</template>

<script setup>
import { ref, computed } from 'vue';
import { useUserStore } from '@/stores/StoreUser';
import { useRouter } from 'vue-router';

const { errors, performRegister } = useUserStore();
const router = useRouter();

const formFields = ref([
  { name: 'userName', label: 'Nom d\'utilisateur', value: 'Jimbo', type: 'text', placeholder: 'Username', isValid: true },
  { name: 'userImage', label: 'Image du profile', value: '', type: 'file', placeholder: '', isValid: true },
  { name: 'lastName', label: 'Nom', value: 'Dugard', type: 'text', placeholder: 'Last Name', isValid: true },
  { name: 'firstName', label: 'Prénom', value: 'Phil', type: 'text', placeholder: 'First Name', isValid: true },
  { name: 'email', label: 'Email', value: 'nicolas.aerny@cool.com', type: 'email', placeholder: 'Email Address', isValid: true },
  { name: 'password', label: 'Password', value: '12345678', type: 'password', isValid: true },
]);

const handleSubmit = async () => {
  try {
    await performRegister(
      formFields.value[0].value,
      formFields.value[1].value,
      formFields.value[2].value,
      formFields.value[3].value,
      formFields.value[4].value,
      formFields.value[5].value
    );
    // Redirection ou autre action après succès
    router.push('/');
  } catch (error) {
    // Les erreurs sont déjà gérées dans le store
  }
};

const updateImage = (event) => {
  formFields.value[1].value = event.target.files[0];
}; 
</script>