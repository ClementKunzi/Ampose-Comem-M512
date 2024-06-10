// store.js
import { reactive } from 'vue';

import { ApiCallCategory } from '../utils/apiCalls/ApiCallCategory.js';

// const cool = ApiCallItineraries();
// console.log(cool);

export const storeCategories = reactive({
    categories: [],
});

if (storeCategories.categories.length === 0) {
    storeCategories.categories = await ApiCallCategory();
}



