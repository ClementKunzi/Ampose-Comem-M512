// store.js
import { reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { ApiPostItineraries } from '../utils/apiCalls/ApiPostItinerary';
import { UserLocalStorage } from '../classes/UserLocalStorage';
const currentUser = new UserLocalStorage();

export const storeItineraryForm = reactive({
    main: reactive({
        name: '',
        image: '',
        category: '',
        accessibility: '',
        estimated_time: '',        
        difficulty: '',
        description: '',
        source: '',
        type:'',
        length: '',
        pdf_url: '',        
    }),
    steps: reactive([]),

    addMainData(data) {
        this.main = {
            name: data.name,
            image: data.image,
            category: data.category,
            accessibility: data.accessibility,
            estimated_time: data.estimated_time,
            difficulty: data.difficulty,
            description: data.description,
            source: 'Communauté',
            length: 10,
        };
        console.log(this.main);
        this.sendForm();
    },

    addStep(data) {
        this.steps.push(data);
        console.log(this);
    },

    displayData() {
        console.log("Main; ", this.main);
        console.log("Step; ", this.steps);
    },

    sendForm() {
        const data = new FormData();
        
        data.append('name', this.main.name);
        data.append('description', this.main.description);
        data.append('type', 'Point A / B');
        data.append('length', this.main.length);
        data.append('estimated_time', this.main.estimated_time);
        data.append('difficulty', this.main.difficulty);
        data.append('source', this.main.source);
        data.append('image', this.main.image); // Assuming you're using Node.js for server-side code
        data.append('image_description', 'Image Description');
        data.append('pdf_url', 'https://r.mtdv.me/videos/HUcHKsy3Lw');
        data.append('categories', this.main.category);
        data.append('accessibilities', this.main.accessibility);

        // Adding steps
        for (let i = 0; i < this.steps.length; i++) {
            data.append(`steps[${i}][name]`, this.steps[1].name);
            data.append(`steps[${i}][description]`, this.steps[1].description);
            data.append(`steps[${i}][address]`, 'Rue de l’industrie 4 - 1000 Lausanne');
            data.append(`steps[${i}][latitude]`, this.steps[1].coordinate[0]._value);
            data.append(`steps[${i}][longitude]`, this.steps[1].coordinate[1]._value);
            data.append(`steps[${i}][order]`, 'Order Value');
            data.append(`steps[${i}][external_link]`, 'External Link Value');
            data.append(`steps[${i}][stepImage]`, this.steps[1].image);
            data.append(`steps[${i}][image_description]`,this.steps[1].image_description);
            data.append(`steps[${i}][order]`, i);            
        }


        console.log(data);
        ApiPostItineraries(data);
    }
});


