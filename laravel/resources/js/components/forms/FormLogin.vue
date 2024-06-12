<template>
    <form @submit.prevent="() => {
        logIn(formFields[0].value, formFields[1].value);
        $router.go(-1);
    }">
        <div class="flex flex-col gap-6">
            <div v-for="(field, index) in formFields" :key="index">
                <label :for="field.name">{{ field.label }}</label>
                <input :id="field.name" :name="field.name" v-model.type="field.value" :type="field.type"
                    :placeholder="field.placeholder" required />

            </div>
            <button type="submit" class="btn self-center">Se connecter</button>
        </div>
    </form>

</template>

<script setup>
import { ref, defineExpose } from 'vue'; // Import defineExpose
import axios from 'axios';
import {logIn} from '@/utils/apiCalls/apiCalls.js';
import { UserLocalStorage } from '@/classes/UserLocalStorage.js';


const formFields = [
    { name: 'email', label: 'Email', value: 'nicolas.aerny@cool.ch', type: 'email', placeholder: 'Email Address', isValid: true },
    { name: 'password', label: 'Password', value: '12345678', type: 'password', isValid: true },
];
const submitForm = async () => {
    try {
        const response = await axios.post('http://localhost:8000/api/auth/login', {
            email: formFields[0].value,
            password: formFields[1].value,
        });

        console.log('Response:', response.data);
        const accessToken = response.data.accessToken;

        // Create an instance of UserLocalStorage
        const userLocalStorage = new UserLocalStorage();
        // Call initializeUserLocalStorage
        userLocalStorage.setAccessToken(accessToken);

        const userData = await userLocalStorage.getUserDataFromApi();
        console.log('userData', userData);

        userLocalStorage.setEmail(userData.email)
        userLocalStorage.setId(userData.id)
        userLocalStorage.setUserName(userData.username)
        userLocalStorage.setFirstName(userData.first_name)
        userLocalStorage.setLastName(userData.last_name)

        // const localStorageBuilder = UserLocalStorage.getInstance();
        // localStorageBuilder.initializeUserLocalStorage()            
        //     .setEmail(userData.email)
        //     .setId(userData.id)
        //     .setUserName(userData.username)
        //     .setFirstName(userData.first_name)
        //     .setLastName(userData.last_name)
        //     .save();

        // console.log(JSON.parse(localStorage.getItem('terraVaud')));




        // Handle success (e.g., redirecting to another page)
    } catch (error) {
        console.error('Error:', error.response ? error.response.data : error.message);
        // Handle error (e.g., showing an error message)
    }
};

// Expose submitForm to the template
defineExpose({ submitForm });
</script>