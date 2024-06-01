<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const formFields = reactive({
    email: '',
    password: '',   
});

// const submitForm = async () => {
//     try {
//         await axios.post('YOUR_API_ENDPOINT', formFields);
//         console.log('Form submitted successfully');
//     } catch (error) {
//         console.error('Failed to submit form:', error);
//     }
// };
const submitForm = () => {
    // router.push('/create/steps');
}

</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="flex flex-col gap-6">
            <div>
                <label for="email">Email</label>
                <input type="email" v-model="formFields.email" placeholder="email" />
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <input type="password" v-model="formFields.password" placeholder="Mot de passe" />
            </div>                       
            <button type="submit" class="btn self-center">Se connecter</button>
        </div>
    </form>    
</template>