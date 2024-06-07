import axios from 'axios';
import { UserLocalStorage } from '../../classes/UserLocalStorage'; // Assuming this is where you manage user tokens

const userLocalStorage = new UserLocalStorage(); // Initialize your user token manager

const ApiPostItineraries = async (data) => {
    try {
        const response = await axios.post('http://terravaud.ch/api/itinareries/add', data, {
            headers: {
                'Content-Type': 'multipart/form-data',
                Authorization: `Bearer ${userLocalStorage.getAccessToken()}`, // Assuming you have a way to retrieve the access token
            },
        });

        console.log('API Response:', response.data);
        return response.data;

    } catch (error) {
        console.error('Error:', error.response? error.response.data : error.message);
        return error.response? error.response.data : error.message;
    }
};

export { ApiPostItineraries };