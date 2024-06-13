import axios from "axios";
import { UserLocalStorage } from "../../classes/UserLocalStorage";

const userLocalStorage = new UserLocalStorage();

const ApiPostFavorite = async (itineraryIdObj) => {
    try {
        const itineraryId = itineraryIdObj.itinerary_id;

        const requestBody = {
            itinerary_id: itineraryId,
        };

        const response = await axios.post(
            "https://terravaud.ch/api/favorites/",
            requestBody,
            {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${userLocalStorage.getAccessToken()}`,
                },
            }
        );

        console.log("API Response:", response.data);
        return response.data;
    } catch (error) {
        console.error(
            "Error:",
            error.response ? error.response.data : error.message
        );
        return error.response ? error.response.data : error.message;
    }
};

export { ApiPostFavorite };
