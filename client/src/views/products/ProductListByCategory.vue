<script setup>

import NavBar from '@/components/Navbar.vue'
import FooterBar from '@/components/Footer.vue'

</script>

<template>

    <NavBar />

    <div class="d-flex gap-2">
        <div class="searchFilters card w-25"
            style="border-radius: 0px !important;box-shadow: none;margin-bottom: 0px !important;">
            Brand
        </div>
        <div class=" w-100 p-2">
            <div class="row gap-2">
                <h3>{{ this.$route.params.category }}</h3>
                <div class="card product-card col-2 justify-content-end p-3 mb-0" v-for="product in products">
                    <img :src="product.productImage" alt="" class="img-fluid m-auto p-2">
                    <h6 class="product-title"><a :href="'/product/' + product.slug">{{ product.name.slice(0, 20) }}</a>
                    </h6>
                    <small class="product-description text-start">{{ product.description.slice(0, 40) }}...</small>
                    <div class="d-flex flex-row justify-content-between w-100 align-items-center mb-1 mt-4">
                        <span class="price fw-bold">{{ product.lowerprice }}€</span>
                        <div class="d-flex gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="var(--main-yellow)" width="20"
                                viewBox="0 0 512 512">
                                <path
                                    d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z">
                                </path>
                            </svg>
                            <a :href="'/product/' + product.slug" class="h-fit"><button
                                    class="btn btn-primary py-1">Ver</button></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <FooterBar />


</template>


<script>
import axios from 'axios';
import { apiLink } from '@/config.js';
import "vue3-toastify/dist/index.css";

export default {
    name: 'ProductIndividual',
    beforeMount() {
        this.loadProducts()
    },
    data() {
        return {
            username: '',
            products: ''
        };
    },
    methods: {
        loadProducts() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getProductsByCategory", { category: this.$route.params.category })
                .then(({ data }) => {

                    this.products = data

                });
        },

    }
};
</script>