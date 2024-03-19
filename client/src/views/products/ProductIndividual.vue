<script setup>

import { userLogged } from '@/stores/loggedUserInfo.js';
import NavBar from '@/components/Navbar.vue'
import NotFound from '@/components/NotFound.vue'
import testImage from '/assets/image.png'
import FooterBar from '@/components/Footer.vue'

let userInfo = userLogged()

</script>

<template>

    <NavBar />

    <div v-if="result == ''">
        <NotFound />

    </div>

    <div v-else class="container card my-4">

        <section class="row">
            <div class="col-sm">
                <img :src="testImage" :alt="result.name" class="img-fluid">
            </div>
            <div class="col-sm text-start py-4 d-flex justify-content-center flex-column">

                <h3 class="text-capitalize">{{ result.name }}</h3>
                <small>{{ result.slug }}</small>

                <p class="mt-3">Brand: {{ result.brand }}</p>
                <br><br>

                <small>best price</small>
                <div class="bestPrice">{{ result.lowerprice }} €</div>

                <p>{{ result.description }}</p>

            </div>

        </section>

        <hr>
        <section class="websites link">

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

            <hr>

            <div class="price-chart text-start">
                <h5>Price Chart over the time</h5>

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
        };
    },
    methods: {
        loadProduct() {

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getProduct", { slug: this.$route.params.slug })
                .then(({ data }) => {
                    console.log(data)

                    this.result = data

                    this.loadMarkets(data.id)

                })
                .catch(error => {

                });
        },
        loadMarkets(id) {

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getMarkets", { id })
                .then(({ data }) => {

                    this.markets = data

                })
                .catch(error => {

                });

        }
    }
};
</script>