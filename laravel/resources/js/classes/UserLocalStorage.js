export class UserLocalStorage {
    constructor() {
        this.initializeUserLocalStorage();
    }

    // Static method to get the singleton instance
    static getInstance() {
        if (!UserLocalStorage.instance) {
            new UserLocalStorage();
        }
        return UserLocalStorage.instance;
    }

    // Method to initialize the terraVaud item if it doesn't exist
    initializeUserLocalStorage() {
        if (!localStorage.getItem('terraVaud')) {
            localStorage.setItem('terraVaud', JSON.stringify({
                userConnexion: {
                    accessToken: null,
                },
                userData: {
                    email: null,
                    first_name: null,
                    id: null,
                    last_name: null,
                    number_path_added: null,
                    profile_picture: null,
                    username: null,
                }
            }));
        }
        this.terraVaud = JSON.parse(localStorage.getItem('terraVaud')) || {};
    }

    // Methods to set properties
    setAccessToken(value) {
        this.terraVaud.userConnexion = this.terraVaud.userConnexion || {};
        this.terraVaud.userConnexion.accessToken = value;
        localStorage.setItem('terraVaud', JSON.stringify(this.terraVaud));
        return this;
    }

    getAccessToken() {
        return this.terraVaud.userConnexion.accessToken;
    }

    clearAccessToken() {
        this.terraVaud.userConnexion = this.terraVaud.userConnexion || {};
        this.terraVaud.userConnexion.accessToken = null;
        localStorage.setItem('terraVaud', JSON.stringify(this.terraVaud));
    }

    setEmail(value) {
        this.terraVaud.userData = this.terraVaud.userData || {};
        this.terraVaud.userData.email = value; // Use the passed value to set the email
        localStorage.setItem('terraVaud', JSON.stringify(this.terraVaud));
    }

    getEmail() {
        return this.terraVaud.userData.email;
    }

    setUserName(value) {
        this.terraVaud.userData = this.terraVaud.userData || {};
        this.terraVaud.userData.username = value; // Use the passed value to set the email
        localStorage.setItem('terraVaud', JSON.stringify(this.terraVaud));
    }

    getUserName() {
        return this.terraVaud.userData.username;
    }

    setFirstName(value) {
        this.terraVaud.userData = this.terraVaud.userData || {};
        this.terraVaud.userData.first_name = value; // Use the passed value to set the email
        localStorage.setItem('terraVaud', JSON.stringify(this.terraVaud));
    }

    setLastName(value) {
        this.terraVaud.userData = this.terraVaud.userData || {};
        this.terraVaud.userData.last_name = value; // Use the passed value to set the email
        localStorage.setItem('terraVaud', JSON.stringify(this.terraVaud));
    }

    setId(value) {
        this.terraVaud.userData = this.terraVaud.userData || {};
        this.terraVaud.userData.id = value; // Use the passed value to set the email
        localStorage.setItem('terraVaud', JSON.stringify(this.terraVaud));
    }

    async getUserDataFromApi() {
        try {
            const accessToken = this.getAccessToken();
            const response = await axios.get('http://localhost:8000/api/auth/user', {
                headers: {
                    Authorization: `Bearer ${accessToken}`,
                },            
            });
    
            return response.data;
        } catch (error) {
            console.error('Error fetching user data:', error);
            throw error; // Throw the error to be caught by the caller
        }
    }

    // Add more methods for other properties as needed

    // Finalize the builder and save to localStorage
    save() {
        localStorage.setItem('terraVaud', JSON.stringify(this.terraVaud));
    }
}

// Usage example
// const terraVaudBuilder = UserLocalStorage.getInstance()
//    .initializeUserLocalStorage()
//    .setAccessToken('your_access_token_here')
//    .setEmail('user@example.com')
//    .save();

// console.log(JSON.parse(localStorage.getItem('terraVaud')));