<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const formFields = reactive({
    name: '',
    image: '',
    category: '',
    accessibility: '',
    duration: '',
    difficulty: '',
    description: '',
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
    router.push('/create/steps');
}

</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="flex flex-col gap-6">
            <div>
                <label for="name">Name:</label>
                <input id="name" v-model="formFields.name" type="text" placeholder="Nom du parcours" />
            </div>
            <div>
                <label for="name">Image:</label>
                <input type="file" name="img" v-on:change="formFields.description" accept="image/*" />
            </div>
            <div>
                <label for="category">Category:</label>
                <select id="category" v-model="formFields.category">
                    <option value="undefined" disabled>Select a category</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>
            <div>
                <label for="difficulty">Difficulty:</label>
                <select id="difficulty" v-model="formFields.difficulty">
                    <!-- Difficulty options here -->
                </select>
            </div>
            <div>
                <label for="name">Description:</label>
                <textarea name="description" rows="5" v-model="formFields.description"
                    placeholder="Description"></textarea>
            </div>
            <button type="submit" class="btn self-center">Ajouter les étapes</button>
        </div>
    </form>
</template>