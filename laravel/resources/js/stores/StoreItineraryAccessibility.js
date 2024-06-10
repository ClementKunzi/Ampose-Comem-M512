// store.js
import { reactive } from 'vue';

import { ApiCallAccessibility } from '../utils/apiCalls/ApiCallAccessibility.js';
import { storeAccessibility } from './StoreAccessibility.js';
import { Accessibility } from 'lucide-vue-next';

// const cool = ApiCallItineraries();
// console.log(cool);

export const storeAccessibility = reactive({
    accessibilities: [],
});

if (storeAccessibility.accessibilities.length === 0) {
    storeAccessibility.accessibilities = await ApiCallAccessibility();
}



