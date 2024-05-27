<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    itineraryName: String,
});
</script>

<template>

    <div
        class="max-w bg-slate-500 min-h-[220px] rounded-3xl bg-gradient-to-r from-violet-500 to-fuchsia-500 mb-2 p-6 flex flex-col justify-between">
        <div class="flex justify-between">
            <div>
                <span>cat 1</span>
                <span>cat 2</span>
            </div>
            <div>
                <button>
                    bookmark
                </button>
            </div>
        </div>
        <div class="flex justify-between">
            <div>
                <h3>{{ itineraryName }}</h3>
                <p>Lieux</p>
            </div>

            <div>
                <p>4.8</p>
                <p>Distance</p>
                <p>Difficulté</p>
            </div>
        </div>
    </div>

</template>

<style scoped></style>