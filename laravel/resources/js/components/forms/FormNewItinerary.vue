<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';

const formFields = reactive({
    name: '',
    image: '',
    category: '',
    accessibility: '',
    duration: '',
    difficulty: '',
    description: '',
});

const submitForm = async () => {
    try {
        await axios.post('YOUR_API_ENDPOINT', formFields);
        console.log('Form submitted successfully');
    } catch (error) {
        console.error('Failed to submit form:', error);
    }
};

</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="flex flex-col gap-6">
            <div>
                <label class="h4" for="name">Name:</label>
                <input class="btn" id="name" v-model="formFields.name" type="text" placeholder="Nom du parcours" />
            </div>
            <div>
                <label class="h4" for="name">Image:</label>
                <input type="file" name="img" v-on:change="formFields.description" accept="image/*" class="btn" />
            </div>
            <div>
                <label class="h4" for="category">Category:</label>
                <select class="btn" id="category" v-model="formFields.category">
                    <option value="undefined" disabled>Select a category</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>
            <div>
                <label class="h4" for="difficulty">Difficulty:</label>
                <select class="btn" id="difficulty" v-model="formFields.difficulty">
                    <!-- Difficulty options here -->
                </select>
            </div>
            <div>
                <label class="h4" for="name">Description:</label>
                <textarea class="btn" name="description" rows="5" v-model="formFields.description"
                    placeholder="Description"></textarea>
            </div>
            <button type="submit" class="btn self-center">Submit</button>
        </div>
    </form>
</template>