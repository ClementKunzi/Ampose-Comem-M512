import { getLocalStorageUser, setLocalStorageUser } from './LocalStorageUser.js';

function setUserAccessToken(accessToken) {
    const user = getLocalStorageUser();
    user.userConnexion.accessToken = accessToken;
    localStorage.setItem('terraVaud', JSON.stringify(user));
}

function unsetUserAccessToken() {
    const user = getLocalStorageUser();
    user.userConnexion.accessToken = null;
    localStorage.setItem('terraVaud', JSON.stringify(user));
}

function getUserAccessToken() {
    return getLocalStorageUser().userConnexion.accessToken;
}



// Set the local storage user on first visit
// setLocalStorageUser();

export { setUserAccessToken, getUserAccessToken, unsetUserAccessToken };