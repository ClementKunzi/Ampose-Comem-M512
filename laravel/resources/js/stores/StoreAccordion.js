import { reactive } from 'vue';
<script>
export default {
  data() {
    return {
      accordionItems: [], // Holds only IDs
      store: {}, // Maps IDs to actual accordion item objects
      // Example initial accordion item
      addItem: () => {
        const id = Date.now(); // Unique ID generation
        this.accordionItems.push(id);
        this.store[id] = { title: `Item ${id}`, content: `Content ${id}` };
      },
      removeItem: (id) => {
        this.accordionItems.splice(this.accordionItems.indexOf(id), 1);
        delete this.store[id];
      },
    };
  },
  watch: {
    'accordionItems.length': function(newLength, oldLength) {
      console.log(`Length of accordionItems changed from ${oldLength} to ${newLength}`);
      // Additional logic can go here
    }
  },
  mounted() {
    this.addItem(); // Add an initial item for demonstration
  }
};
</script>