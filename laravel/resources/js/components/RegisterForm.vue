<script setup>  </script>
<template>
  <form class="flex flex-col space-y-4">
    <label for="name">Name</label>
    <input type="text" id="name" v-model="name" />
    <label for="email">Email</label>
    <input type="email" id="email" v-model="email" />
    <label for="password">Password</label>
    <input type="password" id="password" v-model="password" />
    <button type="submit">Register</button>
  </form>
  </template>