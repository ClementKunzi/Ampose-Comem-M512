<template>
  <form @submit.prevent="submitForm">
      <!-- Existing form fields -->
      <button type="submit" class="btn self-center">Se connecter</button>
  </form>

  <!-- Confirmation Modal -->
  <div v-if="showModal" class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
      <div class="modal-content bg-white p-6 rounded-lg shadow-lg">
          <h2>Login Successful!</h2>
          <p>You have successfully logged in.</p>
          <button @click="showModal = false" class="btn-confirm">Retour à l'accueil</button>
      </div>
  </div>
</template>
