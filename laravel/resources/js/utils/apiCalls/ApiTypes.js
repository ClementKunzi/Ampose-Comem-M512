import axios from "axios";

const ApiCallTypes = async () => {
    try {
        const response = await axios.get(
            "https://terravaud.ch/api/itinerary-types",
            {}
        );
        console.log("Response:", response.data);

        return response.data;
    } catch (error) {
        console.error(
            "Error:",
            error.response ? error.response.data : error.message
        );
        return error.response ? error.response.data : error.message;
    }
};

export { ApiCallTypes };
