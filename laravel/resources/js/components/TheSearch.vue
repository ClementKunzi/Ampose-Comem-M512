<script setup>

</script>

<template>
     <div class="sticky top-4">
          <div class="mb-4 flex justify-between gap-4">
               <input class="btn grow" type="text" v-model="input" placeholder="Rechercher" />

               <router-link to="/user/profile">
                    <img class="max-w-12 rounded-full" src="https://loremflickr.com/300/300" alt="">
               </router-link>
               <!-- <router-link to="/onboarding">Onboarding</router-link> -->
          </div>

          <div>
               <ul class="overflow-scroll w-[calc(100%+1rem)] flex gap-1.5">
                    <li class="shrink-0" v-for="i in 15" :key="i">
                         <button class="btn">cat {{ i }}</button>
                    </li>
               </ul>
          </div>
     </div>


</template>

<style scoped></style>