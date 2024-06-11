// stores/storeUser.js
import { ref } from 'vue';
import { logOut, logIn, register } from '@/utils/apiCalls/apiCalls';

const user = ref(null);
const errors = ref(null);

export function useUserStore() {
  const setUser = (userData) => {
    user.value = userData;
  };

  const clearUser = () => {
    user.value = null;
  };

  const setErrors = (errorData) => {
    console.log('Setting errors:', errorData);
    errors.value = errorData;
  };

  const clearErrors = () => {
    errors.value = null;
  };

  // Validation du pseudo
  const validateUsername = (username) => {
    console.log('Validating username:', username);
    const regex = /^\d+$/;
    if (regex.test(username)) {
      setErrors({ userName: ["Le nom d'utilisateur ne peut pas être composé uniquement de chiffres."] });
      return false;
    }
    return true;
  };

  // Validation de la longueur du mot de passe
  const validatePasswordLength = (password) => {
    console.log('Validating password length:', password);
    if (password.length < 8) {
      setErrors({ password: ["Le mot de passe doit contenir au moins 8 caractères."] });
      return false;
    }
    return true;
  };


  // Validation de la taille du fichier
  const validateFileSize = (file, maxSize = 2 * 1024 * 1024) => {
    console.log('Validating file size:', file);
    if (file.size > maxSize) {
      setErrors({ userImage: ["La taille du fichier dépasse la limite autorisée de 2MB."] });
      return false;
    }
    return true;
  };

  const performLogOut = async () => {
    try {
      await logOut();
      clearUser();
    } catch (error) {
      setErrors(error.response ? error.response.data : error.message);
    }
  };

  const performLogIn = async (email, password) => {
    try {
      const response = await logIn(email, password);
      setUser(response);
      clearErrors();
    } catch (error) {
      setErrors(error.response ? error.response.data : error.message);
    }
  };

  const performRegister = async (username, userImage, lastName, firstName, email, password) => {
    clearErrors();

    if (!validateUsername(username) || 
        !validatePasswordLength(password) || 
        !validateFileSize(userImage)) {
      return false;
    }

    try {
      await register(username, userImage, lastName, firstName, email, password);
      return true;
    } catch (error) {
      setErrors(error.response ? error.response.data : error.message);
      return false;
    }
  };

  return {
    user,
    errors,
    setUser,
    clearUser,
    setErrors,
    clearErrors,
    performLogOut,
    performLogIn,
    performRegister,
  };
}