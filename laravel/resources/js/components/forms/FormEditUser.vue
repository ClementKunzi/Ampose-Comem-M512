<template>
    <form @submit.prevent="submitForm">
        <div class="flex flex-col gap-6">

            <div id="inputImageLoader">
                <label for="name" class="hidden">Image:</label>
                <div class="relative">
                    <input type="file" name="img" v-on:change="formFields.image" accept="image/*"
                        class="absolute opacity-0" />
                    <img @click="handleClick" class="max-w-40 rounded-full" src="https://loremflickr.com/300/300"
                        alt="">
                    <Pencil stroke="#f5f5f5" :size="30"
                    class="absolute top-1/2 left-1/2 translate-y-[-50%] translate-x-[-50%]" />
                </div>
            </div>

            <div v-for="(field, index) in formFields" :key="index">
                <label :for="field.name">{{ field.label }}</label>
                <input :id="field.name" :name="field.name" v-model="field.value" :type="field.type"
                    :placeholder="field.placeholder" />
            </div>
            <button type="submit" class="btn self-center">Valider les modifications</button>
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
        },

        handleClick()  {
            console.log('Image clicked!');
            document.querySelector('#inputImageLoader input').click();
        },


    },
};
</script>
<script setup>
import { Pencil } from 'lucide-vue-next';
</script>