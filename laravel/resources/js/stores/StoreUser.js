// storeUser.js
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
    errors.value = errorData;
  };

  const clearErrors = () => {
    errors.value = null;
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
    try {
      await register(username, userImage, lastName, firstName, email, password);
      clearErrors();
    } catch (error) {
      setErrors(error.response ? error.response.data : error.message);
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
