import axios from "axios";
import { UserLocalStorage } from '../../classes/UserLocalStorage';

const userLocalStorage = new UserLocalStorage();

const ApiDeleteFavorite = async (favoriteId) => {
    try {
        const response = await axios.delete(`http://localhost:8000/api/favorites/${favoriteId}`, {
            headers: {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${userLocalStorage.getAccessToken()}`,
            },
        });

        console.log('API Response:', response.data);
        return response.data;

    } catch (error) {
        console.error('Error:', error.response? error.response.data : error.message);
        return error.response? error.response.data : error.message;
    }
};

export { ApiDeleteFavorite };