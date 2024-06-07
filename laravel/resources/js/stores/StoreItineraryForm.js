// store.js
import { reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { ApiPostItineraries } from '../utils/apiCalls/ApiPostItinerary';

export const storeItineraryForm = reactive({
    main: reactive({
        name: '',
        image: '',
        category: '',
        accessibility: '',
        estimated_time: '',
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
        sendForm();
    },

    addStep(data) {
        this.steps.push(data);
        console.log(this);
    },

    displayData() {
        console.log(this.main);
        console.log(this.steps);
    },

    sendForm() {
        const data = new FormData();
        data.append('name', this.main.name);
        data.append('description', this.main.description);
        data.append('type', 'Communauté');
        data.append('length', '');
        data.append('estimated_time', this.main.estimated_time);
        data.append('difficulty', this.main.difficulty);
        data.append('source', 'Source Value');
        data.append('image', fs.createReadStream('/path/to/file')); // Assuming you're using Node.js for server-side code
        data.append('image_description', 'Image Description');

        // Adding steps
        data.append('steps[0][name]', this.steps[0].name);
        data.append('steps[0][description]', this.steps[0].description);
        data.append('steps[0][address]', 'Step Address');
        data.append('steps[0][latitude]', 'Latitude Value');
        data.append('steps[0][longitude]', 'Longitude Value');
        data.append('steps[0][order]', 'Order Value');
        data.append('steps[0][external_link]', 'External Link Value');
        data.append('steps[0][stepImage]', fs.createReadStream('/path/to/step/image')); // File read stream for step image

        // Adding tags
        data.append('tagCategories[0]', 'Tag Category Value');
        data.append('tagAccessibilities[0]', 'Tag Accessibility Value');

        console.log('data', data);
    }
});


