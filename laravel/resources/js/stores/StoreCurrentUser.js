// store.js
import { reactive, watch } from 'vue'; 

import { UserLocalStorage } from '../classes/UserLocalStorage';

const currentUser = new UserLocalStorage();
export const storeCurrentUser = reactive({
  user: [
    {
      id: '',
      email: '',
      username: '',
      first_name: '',
      last_name: '',
      profile_picture: currentUser.getUserImageProfile(),
    }
  ],
});



