<script setup>
import NavBar from '@/components/Navbar.vue';
</script>

<template>
    <main>

        <NavBar />

        <div class="container mt-2">

            <h3>Wishlist {{ wishlist.name }}</h3>

            <div v-for="product in wishlist.content" class="border rounded my-1 p-3 d-flex justify-content-start col-12"
                style="background-color: white;">
                <div class="col-1 d-flex justify-content-center align-items-center">
                    <svg @click="removeProductFromWishlist(product.id)" xmlns="http://www.w3.org/2000/svg"
                        style="z-index: 6;fill: var(--main-yellow);cursor: pointer;" viewBox="0 0 384 512" width="12px"
                        class="m-0">
                        <path
                            d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                    </svg>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <div class="center-image">
                        <img :src="product.productImage" alt="" class="img-fluid">
                    </div>
                </div>

                <div class="col-7 d-flex flex-column justify-content-center">
                    <h5>{{ product.name }}</h5>
                    <p>{{ product.brand }}</p>
                    <p style="color: var(--main-yellow);font-weight: bold;">{{ product.lowerprice }} €</p>
                </div>

                <div class="col-2 d-flex flex-column justify-content-center align-items-center">
                    <a :href="'/product/' + product.slug" class="w-100">
                        <button class="btn btn-primary w-100 ">
                            View
                        </button>
                    </a>
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
    name: 'WishlistIndividual',
    beforeMount() {
        this.loadWishlistData()
    },
    data() {
        return {
            wishlist: '',
        };
    },
    methods: {
        loadWishlistData() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getWishlist", { slug: this.$route.params.slug })
                .then(({ data }) => {

                    this.wishlist = data

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
        removeProductFromWishlist(productID) {
            // console.log(this.wishlist.id)
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/removeProductFromWishlist", { productID: productID, wishlistID: this.wishlist.id })
                .then(({ data }) => {

                    toast("Product removed", {
                        "theme": "light",
                        "type": "default",
                        "transition": "zoom",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })

                    this.loadWishlistData()

                });
        }
    }
};
</script>
