// store.js
import { reactive } from "vue";
import { ApiCallDifficulty } from "../utils/apiCalls/ApiGetDifficulty.js";

export const storeDifficulty = reactive({
    difficulties: [],
});

// Encapsuler le code asynchrone dans une fonction asynchrone immédiatement invoquée (IIFE)
(async () => {
    if (storeDifficulty.difficulties.length === 0) {
        storeDifficulty.difficulties = await ApiCallDifficulty();
    }
})();
