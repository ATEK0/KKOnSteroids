<script setup>

import { userLogged } from '@/stores/loggedUserInfo.js';
import NavBar from '@/components/Navbar.vue'
import FooterBar from '@/components/Footer.vue'

let userInfo = userLogged()

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
                <div class="card product-card col-2 justify-content-end p-2 mb-0" v-for="product in products">
                    <img :src="product.productImage" alt="" class="img-fluid m-auto p-2">
                    <h6 class="product-title"><a :href="'/product/' + product.slug ">{{ product.name.slice(0,20)}}</a></h6>
                    <small class="product-description">{{ product.description.slice(0, 40) }}...</small>
                    <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                        <span class="price">{{ product.lowerprice }}€</span>
                        <a :href="'/product/' + product.slug"><button class="btn btn-primary">Ver</button></a>
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
            axios.post(apiLink + "/api/getProductsByCategory", {category: this.$route.params.category})
                .then(({ data }) => {
                    console.log(data)

                    this.products = data

                })
                .catch(error => {

                });
        },

    }
};
</script>