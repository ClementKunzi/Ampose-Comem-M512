function setLocalStorageUser() {
    if (localStorage.getItem('terraVaud') === null) {
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
}

function getLocalStorageUser() {
    return JSON.parse(localStorage.getItem('terraVaud'));
}


// Set the local storage user on first visit
// setLocalStorageUser();

export { getLocalStorageUser, setLocalStorageUser };