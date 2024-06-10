<script setup>
import { ref, reactive, defineExpose } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { storeItineraryForm } from '../../stores/StoreItineraryForm';

const router = useRouter();

const updateImage = (event) => {
    formFields.image = event.target.files[0];
};

const formFields = reactive({
    // name: '',
    // image: '',
    // category: '',
    // accessibility: '',
    // estimated_time: '',    
    // difficulty: '',
    // description: '',
    name: 'Jean',
    image: '',
    category: 'Architectural',
    accessibility: 'Pentu',
    estimated_time: 35,    
    difficulty: 'mordérée',
    description: 'Jolie description les amis.',
});

</script>

<template>
    <form @submit.prevent="storeItineraryForm.addMainData(formFields)">
        <div class="flex flex-col gap-6">
            <div>
                <label for="name">Nom du parcours</label>
                <input id="name" v-model="formFields.name" type="text" placeholder="Nom du parcours" />
            </div>
            <div>
                <label for="name">Image</label>
                <input type="file" name="img" @change="updateImage" ref="imageInput" accept="image/*" />

            </div>
            <div>
                <label for="category">Catégories</label>
                <select id="category" v-model="formFields.category">
                    <option value="undefined" disabled>Select a category</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </div>
            <div>
                <label for="difficulty">Difficulté</label>
                <select id="difficulty" v-model="formFields.difficulty">
                    <!-- Difficulty options here -->
                </select>
            </div>
            <div>
                <label for="name">Description</label>
                <textarea name="description" rows="5" v-model="formFields.description"
                    placeholder="Description"></textarea>
            </div>
            <div>
                <label for="name">Temps estimé</label>
                <input id="name" v-model="formFields.estimated_time" type="number" placeholder="Temps estimé en minutes" />
            </div>
            <button type="submit" class="btn self-center btn-itineraryMain pointer-events-none absolute z-[-10]">Ajouter les étapes</button>
        </div>
    </form>
    <form @submit.prevent="$emit('toggleVisibility')">
        <button @submit.prevent="$emit('toggleVisibility')" type="submit"
            class="btn self-center mt-8 ml-auto mr-auto">Ajouter les étapes</button>
    </form>
</template>