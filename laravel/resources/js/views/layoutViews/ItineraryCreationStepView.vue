<script setup>
 import { ArrowLeft, Plus } from 'lucide-vue-next';
</script>
<script>
import AccordionItem from '@/components/AccordionItem.vue';
import Accordion from '@/components/Accordion.vue';

export default {
  components: {
    Accordion,
    AccordionItem,
  },
  data() {
    return {
      accordionItems: [
        { title: 'Item 1', content: 'Content 1' },
      ],
    };
  },
  methods: {
    addAccordionItem() {
      const newIndex = this.accordionItems.length;
      this.accordionItems.push({ title: `Item ${newIndex + 1}`, content: `Content ${newIndex + 1}` });
    },
  },
};
</script>

<template>
  <div class="p-4 grow flex flex-col">
    <button @click="$router.go(-1)"
        class="mr-auto btn-iconContainer" aria-label="Retour">        
          <ArrowLeft aria-hidden="true" :size="32" />              
      </button>
    <h1 class="h3 pb-4 text-tv-wine text-center">Etapes</h1 class="h3">
    <accordion>
      <accordion-item v-for="(item, index) in accordionItems" :key="index" :title="item.title" :content="item.content"
        :index="index" />
    </accordion>

    <div class="mt-4 flex justify-center items-center gap-2">
      <button @click="addAccordionItem"
        class="flex justify-center items-center gap-2"
        aria-label="Ajouter une étape">
        <div aria-hidden="true">
          <h3 class="body-bold-base text-tv-wine">Ajouter une étape</h3>
        </div>
        <div class="btn-iconContainer btn-iconContainerWine">
          <Plus aria-hidden="true" :size="32" />
        </div>
        
      </button>
    </div>
    <div class="flex justify-center mt-auto">
      <button class="btn mt-6">Finaliser le parcours</button>
    </div>

  </div>
</template>
