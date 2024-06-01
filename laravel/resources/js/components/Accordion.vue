<template>
    <div class="accordion flex flex-col gap-4">
        <slot></slot>
    </div>
</template>

<script setup>
import { ref, provide, watch } from 'vue';

const activeIndex = ref(null);

const setActiveIndex = (index) => {
  activeIndex.value = index;
};

provide('activeIndex', activeIndex);
provide('setActiveIndex', setActiveIndex);
</script>

<style scoped>
.accordion {
    width: 100%;
}
</style>