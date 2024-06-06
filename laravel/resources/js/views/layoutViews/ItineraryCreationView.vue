<script setup>
import FormNewItinerary from '@/components/forms/FormNewItinerary.vue';
import { CircleX, ArrowLeft, Plus, Watch } from 'lucide-vue-next';
import { ref } from 'vue';
import AccordionItem from '@/components/AccordionItem.vue';
import Accordion from '@/components/Accordion.vue';

const isVisible = ref(true);

function toggleVisibility() {
  isVisible.value = !isVisible.value;
}

function triggerStepForms() {
  const btnNewItinerary = document.querySelector('.btn-itineraryMain');
  const btnElementsNodeList = document.querySelectorAll('#btn-itineraryStep');
    const btnElementsArray = Array.from(btnElementsNodeList);
    btnElementsArray.forEach(element => {
      element.click();
      // console.log(element.innerHTML);
    });
    btnNewItinerary.click();
}
</script>

<script>
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
  
  <div v-show="isVisible" class="p-4">
    <button @click="$router.go(-1)"
        class="mr-auto btn-iconContainer" aria-label="Retour">        
          <CircleX aria-hidden="true" :size="32" />              
      </button>
    <h1 class="h3 pb-4 text-tv-wine text-center">Nouveau parcours</h1 class="h3">
  <FormNewItinerary ref="childFormRef" @toggleVisibility="toggleVisibility" />
  </div>

  <div v-show="!isVisible" class="p-4 grow flex flex-col">
    <button @click="toggleVisibility()"
        class="mr-auto btn-iconContainer" aria-label="Retour">        
          <ArrowLeft aria-hidden="true" :size="32" />              
      </button>
    <h1 class="h3 pb-4 text-tv-wine text-center">Etapes</h1 class="h3">
    <accordion ref="childFormRef">
      <accordion-item ref="childFormRef" v-for="(item, index) in accordionItems" :key="index" :title="item.title" :content="item.content"
        :index="index"
         />
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
      <button @click="triggerStepForms" class="btn mt-6">Finaliser le parcours</button>
    </div>

  </div>
</template>