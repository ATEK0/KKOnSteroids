<script setup>

import NavBar from '@/components/Navbar.vue'
import FooterBar from '@/components/Footer.vue'

</script>

<template>

    <NavBar />


    <div class="d-flex gap-2">
        <div class="searchFilters card p-3 text-start"
            style="border-radius: 0px !important;box-shadow: none;margin-bottom: 0px !important;width: 20%;">
            <h4>Filters</h4>

            <div class="filter-section mb-2">
                <div class="filter-title">Price</div>
                <div class="filter-options ps-2">
                    <div class="filter d-flex gap-2 justify-content-center align-items-center m-0">
                        <div class="">
                            <small>from</small>
                            <input type="number" name="apple" placeholder="€" v-model="fromPrice" id="apple"
                                class="form-control" @keyup="loadProducts()">
                        </div>
                        <div class="">
                            <small>to</small>
                            <input type="number" name="apple" placeholder="€" v-model="toPrice" id="apple"
                                class="form-control" @keyup="loadProducts()">
                        </div>
                    </div>
                </div>
            </div>

            <div class="filter-section mb-2">
                <div class="filter-title">Brands</div>
                <div class="filter-options ps-2" style="max-height: 100px;">
                    <div class="filter m-0 overflow-auto" v-for="brand in brands">
                        <input type="checkbox" :name="brand.brand" @change="brandClicked($event)" @select=""
                            :id="brand.brand" class="me-1">
                        <label :for="brand.brand" style="font-size: 15px;">{{ brand.brand }}</label>
                    </div>

                </div>
            </div>

        </div>
        <div class=" w-100 p-2">
            <div class="row gap-2">
                <h3>{{ title }}</h3>
                <div v-if="products" class="card product-card col-2 justify-content-end p-3 mb-0"
                    v-for="product in products">
                    <img :src="product.productImage" alt="" class="img-fluid m-auto p-3">
                    <h6 class="product-title"><a :href="'/product/' + product.slug">{{ product.name.slice(0, 18) }}</a>
                    </h6>
                    <small class="product-description text-start">{{ product.description.slice(0, 50) }}...</small>
                    <div class="d-flex flex-row justify-content-between w-100 align-items-center mb-1 mt-4">
                        <span class="price fw-bold">{{ product.lowerprice }}€</span>
                        <div class="d-flex gap-1">
                            <button id="openModalButton" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                style="visibility: hidden;"></button>
                            <svg @click="setProdClicked(product.id)" style="cursor: pointer;"
                                xmlns="http://www.w3.org/2000/svg" fill="var(--main-yellow)" width="20"
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
            <p>{{ notfound }}</p>
        </div>
    </div>


    <FooterBar />


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


                        <svg v-if="productPresences.includes(wishlist.id)" xmlns="http://www.w3.org/2000/svg" x="0px"
                            y="0px" width="25" height="25" @click="removeFromWishlist(wishlist.id)" viewBox="0 0 30 30">
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


</template>


<script>
import axios from 'axios';
import { apiLink } from '@/config.js';
import { toast } from "vue3-toastify";

export default {
    name: 'ProductIndividual',
    beforeMount() {
        this.loadProducts()
        this.loadFilters()
    },
    data() {
        return {
            productClicked: '',
            username: '',
            products: '',
            title: '',
            notfound: '',
            wishlists: [],
            productPresences: [],
            brands: [],
            categories: [],
            fromPrice: '',
            toPrice: '',
            selectedBrands: []
        };
    },
    methods: {
        loadProducts() {

            if (!this.$route.query.search) {
                axios.post(apiLink + "/api/getProductsByCategory", { category: this.$route.params.category, lowerPrice: this.fromPrice, highPrice: this.toPrice, brands: this.selectedBrands })
                    .then(({ data }) => {

                        this.products = data

                    });

            } else {

                axios.post(apiLink + "/api/getProductsFromSearch", { searchQuery: this.$route.query.search })
                    .then(({ data }) => {

                        this.products = data
                        this.title = 'Results for ' + this.$route.query.search
                        this.notfound = ''
                        if (data == '') {
                            this.notfound = 'No results found for that product'
                        }
                    });
            }
        },
        loadFilters() {

            this.getBrands()

        },
        getBrands() {
            axios.get(apiLink + "/api/getBrands")
                .then(({ data }) => {

                    this.brands = data
                });
        },
        setProdClicked(prodID) {
            this.productClicked = prodID

            this.getWishlists()

            document.getElementById("openModalButton").click();
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
            axios.post(apiLink + "/api/addProductToWishlist", { wishlistID: wishlistID, productID: this.productClicked })
                .then(({ data }) => {

                    toast(data, {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })
                    this.wishlistNameCreate = ''

                    // this.closeAllModals()
                    this.getWishlists()

                });
        },
        removeFromWishlist(wishlistID) {

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/removeProductFromWishlist", { wishlistID: wishlistID, productID: this.productClicked })
                .then(({ data }) => {

                    toast(data, {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })
                    // this.closeAllModals()
                    this.getWishlists()

                });

        },
        getProductPresences() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getProductPresences", { productID: this.productClicked })
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
        brandClicked(event) {
            if (event.target.checked) {
                this.selectedBrands.push(event.target.id)
            } else {
                for (var i = 0; i <= this.selectedBrands.length; i++) {
                    if (this.selectedBrands[i] === event.target.id) {
                        this.selectedBrands.splice(i, 1);
                    }
                }
            }

            this.loadProducts()

        },
        categoryClicked(event) {
            if (event.target.checked) {
                this.selectedCategories.push(event.target.id)
            } else {
                for (var i = 0; i <= this.selectedCategories.length; i++) {
                    if (this.selectedCategories[i] === event.target.id) {
                        this.selectedCategories.splice(i, 1);
                    }
                }
            }

            this.loadProducts()

        },

    }
};
</script>