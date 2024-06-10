// store.js
import { reactive } from 'vue';
import { ApiCallAccessibility } from '../utils/apiCalls/ApiCallAccessibility.js';

export const storeAccessibility = reactive({
    accessibilities: [],
});

if (storeAccessibility.accessibilities.length === 0) {
    storeAccessibility.accessibilities = await ApiCallAccessibility();
}
