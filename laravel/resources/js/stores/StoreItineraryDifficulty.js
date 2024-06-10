// store.js
import { reactive } from 'vue';

import { ApiCallDifficulty } from '../utils/apiCalls/ApiCallDifficulty.js';

// const cool = ApiCallItineraries();
// console.log(cool);

export const storeDifficulty = reactive({
    difficulties: [],
});

if (storeDifficulty.difficulties.length === 0) {
    storeDifficulty.difficulties = await ApiCallDifficulty();
}



