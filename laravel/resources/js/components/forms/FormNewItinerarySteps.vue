<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const formFields = reactive({
    name: '',
    image: '',
    coordinate: '',
    link: '',
});

const submitForm = () => {
    // router.push('/create/steps');
}

</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="flex flex-col gap-6">
            <div>
                <label for="name">Name:</label>
                <input id="name" v-model="formFields.name" type="text" placeholder="Nom de l'étape" />
            </div>
            <div>
                <label for="name">Image:</label>
                <input type="file" name="img" v-on:change="formFields.image" accept="image/*" />
            </div>                                   
            <div>
                <label for="name">Description:</label>
                <textarea name="description" rows="5" v-model="formFields.description"
                    placeholder="Description"></textarea>
            </div>
            <div>
                <label for="name">Lien utile:</label>
                <input id="link" v-model="formFields.link" type="text" placeholder="https://cool.io" />
            </div>
            <!-- <button type="submit" class="btn self-center">Submit</button> -->
        </div>
    </form>
</template>