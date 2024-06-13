import axios from "axios";
import { getLocalStorageUser } from "../../utils/LocalStorageUser";

const ApiDeleteItinerary = async (itineraryId) => {
    const user = getLocalStorageUser();
    try {
        const response = await axios.delete(
            `http://terravaud.ch/api/itineraries/${itineraryId}`,
            {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${user.userConnexion.accessToken}`,
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

export { ApiDeleteItinerary };