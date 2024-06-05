import axios from "axios";
import { UserLocalStorage } from '../../classes/UserLocalStorage';

const userLocalStorage = new UserLocalStorage();

const ApiGetItinerary = async (id) => {
    try {
        const response = await axios.get(`http://localhost:8000/api/itineraries/${id}`,{
            headers: {
                Authorization: `Bearer ${userLocalStorage.getAccessToken()}`,
            },            
        });
        console.log('Response:', response.data);                

        return response.data;
        // unsetUserAccessToken()
        // Handle success (e.g., redirecting to another page)
    } catch (error) {
        console.error('Error:', error.response ? error.response.data : error.message);
        return error.response ? error.response.data : error.message;
        // Handle error (e.g., showing an error message)
    }
};

export { ApiGetItinerary }