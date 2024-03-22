<script setup>
import { userLogged } from '@/stores/loggedUserInfo.js';
import NavBar from '@/components/Navbar.vue'

let userInfo = userLogged()

</script>

<template>
  <main>

    <NavBar />

    <div class="container mt-2">
      <h3>Hey {{ userInfo.name }}</h3>
      <small>{{ userInfo.role }}</small>

      <div class="d-flex justify-content-between align-items-center">
        <span>Your wishlists</span>
        <button class="btn btn-primary d-flex gap-1 align-items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15px" fill="white"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>Create new</button>
      </div>
      
    </div>
  </main>
</template>

<script>


export default {
  name: 'account',
  data() {
    return {
      user: ''
    };
  }
};
</script>
