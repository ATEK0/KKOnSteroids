<script setup>

import NavBar from '@/components/Navbar.vue'
import NotFound from '@/views/errors/NotFound.vue'
import FooterBar from '@/components/Footer.vue'

import PriceChart from "@/components/PriceChart.vue"

import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
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

                <div class="d-flex justify-content-between mt-2 mb-3" style="color: gray;fill: gray;">
                    <span class="product_actions" @click="setClickedProd(0)" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 512 512">
                            <path
                                d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                        </svg>
                        <small class="ms-1">Add to Wishlist</small>
                    </span>

                    <span class="product_actions" @click="setClickedProd(0)" data-bs-toggle="modal"
                        data-bs-target="#price_alert">
                        <svg xmlns="http://www.w3.org/2000/svg" v-if="target_price == 'No target'" width="18"
                            viewBox="0 0 448 512">
                            <path
                                d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416H424c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112v25.4c0 47.9 13.9 94.6 39.7 134.6H72.3C98.1 328 112 281.3 112 233.4V208c0-61.9 50.1-112 112-112zm64 352H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" v-else width="18" viewBox="0 0 448 512">
                            <path
                                d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z" />
                        </svg>
                        <small class="ms-1" v-if="target_price == 'No target'">Create Price Alert</small>
                        <small class="ms-1" v-else>Change Price Alert</small>
                    </span>

                    <span class="product_actions" @click="copyLink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" viewBox="0 0 640 512">
                            <path
                                d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z" />
                        </svg>
                        <small class="ms-1">Share Product</small>
                    </span>

                    <span class="product_actions">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 512 512">
                            <path
                                d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64V400c0 44.2 35.8 80 80 80H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H80c-8.8 0-16-7.2-16-16V64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z" />
                        </svg>
                        <small class="ms-1"><a href="#priceChart" class="product_actions">Check Price
                                History</a></small>
                    </span>


                </div>

                <p>{{ result.brand }}</p>
                <br><br>

                <small>best price</small>
                <div class="bestPrice">{{ result.lowerprice }} €</div>



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

            <div class="price-chart text-start my-4" id="priceChart">
                <h5 class="mb-3">Lowest prices over the last 30 days</h5>
                <PriceChart />
            </div>

            <hr>

            <div class="interests text-start">
                <h2 class="font-weight-light">You might also like</h2>
                <div class="d-flex align-items-center">
                    <div class="d-flex flex-row gap-2 p-2 pb-4" style="overflow-x:scroll;" id="container-most-view">

                        <div class="card product-card col-2 justify-content-end p-2 mb-0"
                            v-for="product in recommendedProducts">
                            <img :src="product.productImage" alt="" class="img-fluid m-auto p-3">
                            <h6 class="product-title"><a :href="'/product/' + product.slug">{{ product.name.slice(0, 20)
                                    }}</a>
                            </h6>
                            <small class="product-description">{{ product.description.slice(0, 40) }}...</small>
                            <div class="d-flex flex-row justify-content-between w-100 align-items-center mb-1 mt-4">
                                <span class="price fw-bold">{{ product.lowerprice }}€</span>
                                <div class="d-flex gap-1">
                                    <a :href="'/product/' + product.slug" class="h-fit"><button
                                            class="btn btn-primary py-1">Ver</button></a>
                                </div>
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

        <!-- Modal add product to wishlist-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">Add to wishlist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="wishlist-list-item text-start py-3 d-flex justify-content-between align-items-center"
                            style="border-bottom: 1px solid lightgray;fill: var(--main-yellow);"
                            v-for="wishlist in wishlists">
                            {{ wishlist.name }}


                            <svg v-if="productPresences.includes(wishlist.id)" xmlns="http://www.w3.org/2000/svg"
                                x="0px" y="0px" width="25" height="25" @click="removeFromWishlist(wishlist.id)"
                                viewBox="0 0 30 30">
                                <path
                                    d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M21.707,12.707l-7.56,7.56 c-0.188,0.188-0.442,0.293-0.707,0.293s-0.52-0.105-0.707-0.293l-3.453-3.453c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0 l2.746,2.746l6.853-6.853c0.391-0.391,1.023-0.391,1.414,0S22.098,12.316,21.707,12.707z">
                                </path>
                            </svg>

                            <svg v-else xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25"
                                @click="addToWishlist(wishlist.id)" viewBox="0 0 30 30">
                                <path
                                    d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M21,16h-5v5 c0,0.553-0.448,1-1,1s-1-0.447-1-1v-5H9c-0.552,0-1-0.447-1-1s0.448-1,1-1h5V9c0-0.553,0.448-1,1-1s1,0.447,1,1v5h5 c0.552,0,1,0.447,1,1S21.552,16,21,16z">
                                </path>
                            </svg>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="/account"><button class="btn btn-primary ms-2" style="padding: 5px;">Create New
                                Wishlist</button></a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal create price alert -->
        <div class="modal fade" id="price_alert" tabindex="-1" aria-labelledby="price_alert" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title" id="price_alert">Create Price Alert</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <FloatLabel class="w-100 mt-2">
                            <InputText class="w-100" v-model="target_price" />
                            <label>Target Price</label>
                        </FloatLabel>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary ms-2" @click="setTargetPrice" style="padding: 5px;">Set
                            Alert</button>
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
import { toast } from "vue3-toastify";

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
            recommendedProducts: '',
            wishlists: [],
            clickedProduct: '',
            productPresences: [], // this stores all the IDs of the wishlists where this product was found (only into user wishlists)
            target_price: ''
        };
    },
    methods: {
        loadProduct() {
            axios.post(apiLink + "/api/getProduct", { slug: this.$route.params.slug })
                .then(({ data }) => {

                    this.result = data

                    this.loadMarkets(data.id)
                    this.getTargetPrice()

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
                    this.getWishlists()

                });
        },
        setClickedProd(productID) {
            if (productID == 0) {
                this.clickedProduct = this.result.id
            } else {
                this.clickedProduct = productID
            }
        },
        getWishlists() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getWishlists")
                .then(({ data }) => {

                    this.wishlists = data
                    this.getProductPresences()
                });
        },
        addToWishlist(wishlistID) {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/addProductToWishlist", { wishlistID: wishlistID, productID: this.clickedProduct })
                .then(({ data }) => {

                    toast(data, {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })
                    this.wishlistNameCreate = ''

                    this.getWishlists()

                });
        },
        removeFromWishlist(wishlistID) {

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/removeProductFromWishlist", { wishlistID: wishlistID, productID: this.clickedProduct })
                .then(({ data }) => {

                    toast(data, {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })

                    this.getWishlists()

                });

        },
        getProductPresences() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getProductPresences", { productID: this.clickedProduct })
                .then(({ data }) => {
                    this.productPresences = []
                    data.forEach(element => {
                        this.productPresences.push(element.wishlistID)
                    });


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
        getTargetPrice() {

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getTargetPrice", { productID: this.result.id })
                .then(({ data }) => {
                    
                    this.target_price = data

                });

        },
        setTargetPrice() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/setTargetPrice", { productID: this.result.id, target_price: this.target_price })
                .then(({ data }) => {

                    toast(data, {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })
                    this.closeAllModals()

                });
            this.getTargetPrice()
        },
        copyLink() {
            try {
                navigator.clipboard.writeText(document.baseURI);
                toast("URL copied to clipboard", {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })

            } catch ($e) {
                alert('Cannot copy');
            }
        }
    }
};
</script>