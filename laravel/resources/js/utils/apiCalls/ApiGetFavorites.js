import axios from "axios";
import { UserLocalStorage } from "../../classes/UserLocalStorage";

const userLocalStorage = new UserLocalStorage();

const ApiGetFavorites = async (id) => {
    try {
        const response = await axios.get(
            `https://terravaud.chapi/favorites/${id}`,
            {
                headers: {
                    Authorization: `Bearer ${userLocalStorage.getAccessToken()}`,
                },
            }
        );

        // Vérifie si la réponse contient des données
        if (response.data && response.data.length > 0) {
            //console.log('Response:', response.data);
            return response.data; // Retourne les données des favoris trouvés
        } else {
            // Si aucune donnée n'est retournée, retourne un message ou un objet spécifique
            //console.log('Aucun favori trouvé pour cet ID.');
            return response.data.data;
        }
    } catch (error) {
        console.error(
            "Error:",
            error.response ? error.response.data : error.message
        );
        return error.response ? error.response.data : error.message;
    }
};

export { ApiGetFavorites };
