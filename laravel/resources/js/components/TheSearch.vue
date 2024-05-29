<script setup>

</script>

<template>
     <div class="sticky z-50 top-4 mb-9">
          <div class="mb-2 flex justify-between gap-2">
               <input class="btn grow" type="text" v-model="input" placeholder="Rechercher" />

               <router-link aria-label="Profile utilisateur" to="/user/profile">
                    <img class="max-w-12 rounded-full" src="https://loremflickr.com/300/300" alt="">
               </router-link>
               <!-- <router-link to="/onboarding">Onboarding</router-link> -->
          </div>

          <div>
               <ul class="overflow-scroll w-[calc(100%+2rem)] pl-4 ml-[-1rem] pb-4 mb-[-1rem] flex gap-1.5">
                    <li class="shrink-0" v-for="i in 15" :key="i">
                         <button class="btn">cat {{ i }}</button>
                    </li>
               </ul>
          </div>
     </div>


</template>

<style scoped></style>