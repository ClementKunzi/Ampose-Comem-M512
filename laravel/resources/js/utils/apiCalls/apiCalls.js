import axios from 'axios';
import { UserLocalStorage } from '../../classes/UserLocalStorage';
const userLocalStorage = new UserLocalStorage();

const logOut = async () => {  
    try {
        const response = await axios.get('http://localhost:8000/api/auth/logout', {
            headers: {
                Authorization: `Bearer ${userLocalStorage.getAccessToken()}`,
            },            
        });
        console.log('Response:', response.data);        
        userLocalStorage.clearAccessToken();
                
        return response.data;        
    } catch (error) {
        console.error('Error:', error.response ? error.response.data : error.message);
        return error.response ? error.response.data : error.message;
        // Handle error (e.g., showing an error message)
    }
};

const logIn = async (emailValue, passwordValue) => {
    try {
        const response = await axios.post('http://localhost:8000/api/auth/login', {
            email: emailValue,
            password: passwordValue,
        });
        console.log('Response:', response.data);
        const accessToken = response.data.accessToken;
        
        // Call initializeUserLocalStorage
        userLocalStorage.setAccessToken(accessToken);
        
        const userData = await userLocalStorage.getUserDataFromApi();
        console.log('userData', userData);

        userLocalStorage.setEmail(userData.email)
        userLocalStorage.setId(userData.id)
        userLocalStorage.setUserName(userData.username)
        userLocalStorage.setFirstName(userData.first_name)
        userLocalStorage.setLastName(userData.last_name)       

        // Handle success (e.g., redirecting to another page)
    } catch (error) {
        console.error('Error:', error.response ? error.response.data : error.message);
        // Handle error (e.g., showing an error message)
    }
};

const register = async (usernameValue, userImageValue, lastNameValue, firstNameValue, emailValue, passwordValue) => {
    console.log('userImageValue', userImageValue);
    const data = new FormData();
    data.append('username', usernameValue);
    data.append('last_name', lastNameValue);
    data.append('first_name', firstNameValue);
    data.append('email', emailValue);
    data.append('password', passwordValue);
    data.append('profile_picture', userImageValue);

    console.log('data', data);

    try {
        const response = await axios.post('http://localhost:8000/api/auth/register', data, {
            headers: {
                'Content-Type': 'multipart/form-data',
            }
        //   username: usernameValue,
        //     last_name: lastNameValue,
        //     first_name: firstNameValue,
        //     email: emailValue,
        //     password: passwordValue,
        //     profile_picture: userImageValue
        
        });

        console.log('Response:', response.data);
        // Handle success (e.g., redirecting to another page)
    } catch (error) {
        console.error('Error:', error.response? error.response.data : error.message);
        // Handle error (e.g., showing an error message)
    }
};

export { logOut, logIn, register }