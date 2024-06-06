import { storeItineraryForm } from "../stores/StoreItineraryForm";

class ItineraryFormManager {
    constructor(store) {
      this.store = store;
    }

    addMainDataToStore(data) {
        const newMainData = {
            name: data.name,
            image: data.image,
            category: data.category,
            accessibility: data.accessibility,
            duration:  data.duration,
            difficulty: data.difficulty,
            description: data.description,
          };
    // console.log( newMainData);
    
    }
  
    submitForm(mainItinerary, steps) {
      // Update the mainItinerary in the store
      this.store.dispatch('updateMainItinerary', mainItinerary);
  
      // Clear existing steps and add new ones
      this.store.commit('CLEAR_STEPS');
      steps.forEach(step => this.store.dispatch('addStep', step));
  
      // Finalize and send the form to an API endpoint
      // Example: axios.post('/api/itineraries', this.store.state);
      console.log(this.store.state);
    }
  }
  
  export {ItineraryFormManager} ;