<script setup>
import { ref, reactive, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { storeItineraryForm } from '../../stores/StoreItineraryForm';
import { storeCategories } from "../../stores/StoreItineraryCategories.js";
import { storeDifficulty } from "../../stores/StoreItineraryDifficulty.js";
import { storeAccessibilities } from "../../stores/StoreItineraryAccessibility.js";

const router = useRouter();

const categories = computed(() => storeCategories.categories);
const difficulties = computed(() => storeDifficulty.difficulties);
const accessibilities = computed(() => storeAccessibilities.accessibilities);

const updateImage = (event) => {
    formFields.image = event.target.files[0];
};

const formFields = reactive({
    name: '',
    image: '',
    category: [],
    accessibility: [],
    estimated_time: '',    
    difficulty: '',
    description: '',
});
</script>

<template>
    <form @submit.prevent="storeItineraryForm.addMainData(formFields)">
        <div class="flex flex-col gap-6">
            <div>
                <label for="name">Nom du parcours</label>
                <input id="name" v-model="formFields.name" type="text" placeholder="Nom du parcours" required />
            </div>
            <div>
                <label for="name">Image</label>
                <input type="file" name="img" @change="updateImage" ref="imageInput" accept="image/*" required />
            </div>
            <div>                                          
                <label for="category">Catégories</label>
                <select id="category" v-model="formFields.category" required multiple>
                    <!-- <option value="" disabled selected>Choisir une catégorie</option>                 -->
                    <option v-for="category in categories" :value="category.taxonomy.name" :key="category.id">{{ category.taxonomy.name }}</option>                    
                </select>
            </div>
            <div>                
                <label for="difficulty">Difficulté</label>
                <select id="difficulty" v-model="formFields.difficulty" required>
                    <option value="" disabled selected>Choisir une difficulté</option>  
                    <option v-for="difficulty in difficulties" :value="difficulty">{{ difficulty }}</option>              
                </select>
            </div>
            <div>                
                <label for="accessibility">Accessibilité</label>
                <select id="accessibility" v-model="formFields.accessibility" required multiple>
                    <option v-for="accessibility in accessibilities" :value="accessibility.taxonomy.name" :key="accessibility.id">{{ accessibility.taxonomy.name }}</option>              
                </select>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea name="description" rows="5" v-model="formFields.description"
                    placeholder="Description" required></textarea>
            </div>
            <div>
                <label for="estimated_time">Temps estimé</label>
                <input id="estimated_time" v-model="formFields.estimated_time" type="number" placeholder="Temps estimé en minutes" required />
            </div>
            <button type="submit" class="btn self-center btn-itineraryMain pointer-events-none absolute z-[-10]">Ajouter les étapes</button>
        </div>
    </form>
    <form @submit.prevent="$emit('toggleVisibility')">
        <button @submit.prevent="$emit('toggleVisibility')" type="submit"
            class="btn self-center mt-8 ml-auto mr-auto">Ajouter les étapes</button>
    </form>
</template>
