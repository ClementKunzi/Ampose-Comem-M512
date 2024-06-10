import axios from "axios";

const ApiCallDifficulty = async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/itinerary-difficulty', {});
        console.log('Response:', response.data);

        return response.data;

    } catch (error) {
        console.error('Error:', error.response ? error.response.data : error.message);
        return error.response ? error.response.data : error.message;
    }
};

export { ApiCallDifficulty }
