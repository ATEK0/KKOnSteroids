<script setup>

import NavBar from '@/components/Navbar.vue'
import NotFound from '@/components/NotFound.vue'
import FooterBar from '@/components/Footer.vue'

</script>

<template>

    <NavBar />

    <div v-if="result == ''">
        <NotFound />

    </div>

    <div v-else class="container card my-4 p-4">

        <section class="row">
            <div class="col-sm d-flex align-items-center justify-content-center">
                <img :src="result.productImage" :alt="result.name" class="img-fluid p-2">
            </div>
            <div class="col-sm text-start py-4 d-flex justify-content-center flex-column">

                <h3 class="text-capitalize">{{ result.name }}</h3>
                <small>{{ result.slug }}</small>

                <p class="mt-3">{{ result.brand }}</p>
                <br><br>

                <small>best price</small>
                <div class="bestPrice">{{ result.lowerprice }} €</div>

                <button class="btn btn-primary w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="20" viewBox="0 0 512 512">
                        <path
                            d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                    </svg>
                    Add to wishlist</button>


            </div>

        </section>

        <hr>
        <section class="websites link mt-3">

            <h3 class="text-start">Markets</h3>
            <div class="market-card m-2" v-for="market in markets">

                <div class="gap-4 d-flex flex-row justify-content-around w-100 p-3"
                    style="background-color: whitesmoke;font-size:20px">
                    <div class="info col-3 text-start align-items-center d-flex text-bold">{{ market.hostname }}</div>
                    <div class="info col-3 align-items-center justify-content-center d-flex fw-bold"
                        style="color: var(--main-yellow);">{{ market.product_price }} €</div>
                    <div class="info col-3">
                        <a :href="market.link"><button class="btn btn-primary">View Store</button></a>
                    </div>
                </div>

            </div>
            <br>
            <hr>
            <h5 class="text-start p-2">Product Description</h5>
            <p v-html='result.description' class="text-start p-2"></p>

            <hr>

            <div class="price-chart text-start">
                <h5>Price Chart over the time</h5>

            </div>

            <div class="interests text-start">
                <h2 class="font-weight-light">You might also like</h2>
                <div class="d-flex align-items-center">
                    <div class="d-flex flex-row gap-2 p-2 pb-4" style="overflow-x:scroll;" id="container-most-view">

                        <div class="card product-card col-2 justify-content-end p-2 mb-0"
                            v-for="product in recommendedProducts">
                            <img :src="product.productImage" alt="" class="img-fluid m-auto p-2">
                            <h6 class="product-title"><a :href="'/product/' + product.slug">{{ product.name.slice(0, 20)
                                    }}</a></h6>
                            <small class="product-description text-start">{{ product.description.slice(0, 45)
                                }}...</small>
                            <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2 px-2">
                                <span class="price">{{ product.lowerprice }}€</span>
                                <a :href="'/product/' + product.slug"><button class="btn btn-primary">Ver</button></a>
                            </div>
                        </div>

                    </div>
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="20px" @click="scrollproductCarroussel"
                            id="most-view" viewBox="0 0 320 512">
                            <path
                                d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                        </svg></span>
                </div>
            </div>
        </section>
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
        this.loadProduct()
    },
    data() {
        return {
            username: '',
            result: ' ',
            markets: '',
            recommendedProducts: ''
        };
    },
    methods: {
        loadProduct() {
            axios.post(apiLink + "/api/getProduct", { slug: this.$route.params.slug })
                .then(({ data }) => {

                    this.result = data

                    this.loadMarkets(data.id)

                });
        },
        loadMarkets(id) {
            axios.post(apiLink + "/api/getMarkets", { id })
                .then(({ data }) => {

                    this.markets = data

                    this.getRecomendedProducts()

                });

        },
        getRecomendedProducts() {
            axios.post(apiLink + "/api/getRecomendedProducts", { category_id: this.result.categories })
                .then(({ data }) => {

                    this.recommendedProducts = data

                });
        }
    }
};
</script>