// store.js
import { reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export const storeItineraryForm = reactive({
    main: reactive({
        name: '',
        image: '',
        category: '',
        accessibility: '',
        duration: '',
        difficulty: '',
        description: '',
    }),
    steps: reactive([]),

    addMainData(data) {
        this.main = {
            name: data.name,
            image: data.image,
            category: data.category,
            accessibility: data.accessibility,
            duration: data.duration,
            difficulty: data.difficulty,
            description: data.description,
        };
        console.log(this.main);
    },

    updateStep(data) {
        if (this.steps.length === 0) {
            this.steps.push(data);
            console.log('1 ', this.steps);
            return;
        }

        // Iterate through the steps array
        this.steps.forEach((step, index) => {
            console.log(step);
            // Check if the current step's id matches the data.id
            if ((step.id) == data.id) {
                // Replace the step at the current index with the new data
                // this.steps[index] = data;
                step = data;
                console.log('2 ', this.steps);
                return; // Exit the loop after replacing the step
            } else if (data.id >= this.steps.length) {
                // If no matching id was found, push the new data to the end of the array
                this.steps.push(data);
                console.log('3 ', this.steps);
            }
        });


    },

    addStep(data) {
        this.steps.push(data);
        console.log(this);
    },

    displayData() {
        console.log(this.main);
        console.log(this.steps);
    }
});


