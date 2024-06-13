import axios from "axios";

const ApiCallSources = async () => {
    try {
        const response = await axios.get(
            "https://terravaud.chapi/itinerary-sources",
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

export { ApiCallSources };
