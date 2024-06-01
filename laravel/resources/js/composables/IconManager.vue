<template>
    <div class="icon-container">
        <component v-for="(icon, index) in processedIcons" :key="index" :is="icon.wrapper" class="icon-wrapper"
            @click="icon.action" :to="icon.to" aria-label="icon.label">
            <component :is="icon.component" :size="icon.size || defaultSize" class="icon" />
        </component>
    </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { Home, Users, Map, Plus, Bookmark } from 'lucide-vue-next';


export default {
    props: {
        icons: {
            type: Array,
            required: true,
        },
        defaultSize: {
            type: Number,
            default: 18,
        },
    },
    computed: {
        processedIcons() {
            return this.icons.map((icon) => ({
                ...icon,
                component: defineAsyncComponent(() =>
                    import(`@lucide/vue/icons/${icon.name}`)
                ),
            }));
        },
    },
};
</script>

<style scoped>
.icon-container {
    display: flex;
    gap: 1rem;
}

.icon-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 28px;
    height: 28px;
    background-color: #f5f5f5;
    border-radius: 50%;
}

.icon {
    color: #754043;
}
</style>