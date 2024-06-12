import {
    getLocalStorageUser,
    setLocalStorageUser,
} from "./LocalStorageUser.js";
import { getUserAccessToken } from "./UserAccessToken.js";

const setUserData = async () => {
    try {
        const response = await axios.get("/api/auth/user", {
            headers: {
                Authorization: `Bearer ${getUserAccessToken()}`,
            },
        });

        console.log("Response:", response.data);

        // Handle success (e.g., redirecting to another page)
    } catch (error) {
        console.error(
            "Error:",
            error.response ? error.response.data : error.message
        );
        // Handle error (e.g., showing an error message)
    }
};
