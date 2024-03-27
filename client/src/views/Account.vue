<script setup>
import { userLogged } from '@/stores/loggedUserInfo.js';
import NavBar from '@/components/Navbar.vue';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';

let userInfo = userLogged();

</script>

<template>
  <main>

    <NavBar />

    <div class="container mt-2">
      <h3>Hey {{ userInfo.name }}</h3>
      <br>
      <span>Your wishlists</span>
      <br>
      <br>
      <div class="wishlist-wrapper d-flex flex-row ">
        <div class="col-3" v-for="wishlist in wishlists">
          <a :href="'/wishlist/' + wishlist.slug">
            <div
              class="d-flex h-100 flex-column justify-content-center align-items-center p-2 pb-3 fw-bold wishlist shadow-sm">
              <div class="container row d-flex justify-content-center align-items-center">
                <div v-for="prod in wishlist.content.slice(0, 4)"
                  class="col-5 d-flex justify-content-center align-items-center"
                  style="padding-bottom: 7.5px;padding-top: 7.5px;">
                  <img :src="prod.productImage" class="img-fluid">
                </div>
              </div>
              <div class="mt-3">{{ wishlist.name }}</div>
            </div>
          </a>
        </div>

        <div class="col-3" data-bs-toggle="modal" data-bs-target="#wishlistCreateModal">
          <div
            class="d-flex flex-column justify-content-center align-items-center p-2 py-5 fw-bold create-wishlist shadow-sm h-100">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="60" class="mb-3">
              <path
                d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9l2.6-2.4C267.2 438.6 256 404.6 256 368c0-97.2 78.8-176 176-176c28.3 0 55 6.7 78.7 18.5c.9-6.5 1.3-13 1.3-19.6v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5zM432 512a144 144 0 1 0 0-288 144 144 0 1 0 0 288zm16-208v48h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V384H368c-8.8 0-16-7.2-16-16s7.2-16 16-16h48V304c0-8.8 7.2-16 16-16s16 7.2 16 16z" />
            </svg>
            <span>Create New Wishlist</span>
          </div>
        </div>
      </div>

      <!-- Modal create wishlist -->
      <div class="modal fade" id="wishlistCreateModal" tabindex="-1" aria-labelledby="wishlistCreateModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="wishlistCreateModal">Create Wishlist</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <FloatLabel class="w-100 mt-1">
                <InputText class="w-100" v-model="wishlistNameCreate" />
                <label>Wishlist Name</label>
              </FloatLabel>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" @click="createWishlist">Create Wishlist</button>
            </div>
          </div>
        </div>
      </div>


    </div>
  </main>
</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js';
import { toast } from "vue3-toastify";


export default {
  name: 'Account',
  beforeMount() {
    this.loadWishlists()
  },
  data() {
    return {
      wishlists: [],
      wishlistNameCreate: ''
    };
  },
  methods: {
    loadWishlists() {
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + $cookies.get('jwtoken');
      axios.post(apiLink + "/api/getWishlists")
        .then(({ data }) => {

          this.wishlists = data
          console.log(data)

        });
    },
    createWishlist() {
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + $cookies.get('jwtoken');
      axios.post(apiLink + "/api/createWishlist", { name: this.wishlistNameCreate })
        .then(({ data }) => {

          toast(data, {
            "type": "success",
            "autoClose": 1000,
            "dangerouslyHTMLString": true
          })
          this.wishlistNameCreate = ''
          this.loadWishlists()

          this.closeAllModals()

        });
    },
    deleteWishlist() {
      axios.defaults.headers.common["Authorization"] =
        "Bearer " + $cookies.get('jwtoken');
      axios.post(apiLink + "/api/deleteWishlist")
        .then(({ data }) => {


          this.loadWishlists()

        });
    },
    closeAllModals() {

      const modals = document.getElementsByClassName('modal');

      for (let i = 0; i < modals.length; i++) {
        modals[i].classList.remove('show');
        modals[i].setAttribute('aria-hidden', 'true');
        modals[i].setAttribute('style', 'display: none');
      }

      const modalsBackdrops = document.getElementsByClassName('modal-backdrop');

      for (let i = 0; i < modalsBackdrops.length; i++) {
        document.body.removeChild(modalsBackdrops[i]);
      }
    },
  }
};
</script>
