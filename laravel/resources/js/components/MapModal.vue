<script>
export default {
    props: {
        itineraryId: {
            type: Number,
            required: true,
        },
    },
};
</script>

<template>
    <div
        id="map-info"
        class="fixed bottom-3 left-1/2 translate-x-[-50%] z-50 w-[calc(100%-2rem)] min-h-24 bg-tv-eggshell p-4 rounded-3xl shadow-tv flex flex-col"
    >
        <p id="map-infoTitle" class="h3"><slot name="title"></slot></p>
        <p id="map-infoDesc"><slot name="desc"></slot></p>
        <router-link
            :to="`/itinerary/${itineraryId}`"
            id="map-infoBtn"
            class="btn mt-4 self-center"
            >Voir le parcours</router-link
        >
    </div>
</template>
