<script setup>

import NavBar from '@/components/Navbar.vue'

</script>

<template>
    <NavBar />

    <div class="container mt-3">
        <div class="card p-2 text-start">
            <h3 class="">Request New Product</h3>
            <form class="card-body" @submit.prevent="validateFormData" action="/api/requestNewProduct">
                <label for="product-name">Product Name</label>
                <input type="text" v-model="product.name" required name="product-name" id="product-name"
                    class="form-control mb-2">

                <label for="product-brand">Brand</label>
                <input type="text" v-model="product.brand" required name="product-brand" id="product-brand"
                    class="form-control mb-2">

                <label for="product-categories">Size</label>
                <input type="text" v-model="product.size" required name="product-size" id="product-size"
                    class="form-control mb-2">

                <label>Links to get information from <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        width="15px" class="add-product-link" @click="addLinkRow">
                        <path
                            d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                    </svg></label>

                <div class="product-links-container d-flex gap-2 flex-column" id="product-links-container">

                    <div class="product d-flex gap-2" :id="'link-' + index" v-for="link, index in linkCounter">
                        <input type="text" required :placeholder="'Link '" class="form-control"
                            :id="'linkinp-' + index">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15px" role="button"
                            class="remove-product-link" @click="removeLinkRow(index)">
                            <path
                                d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z" />
                        </svg>

                    </div>
                </div>

                <div class="w-100 d-flex justify-content-end gap-2">
                    <button class="btn btn-primary-outlined mt-3">Cancel</button>
                    <button type="submit" class="btn btn-primary mt-3">Request</button>
                </div>
            </form>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import { apiLink } from '../config.js';
import { toast } from "vue3-toastify";

export default {
    name: 'UserInfo',

    data() {
        return {
            username: '',
            linkCounter: 1,
            product: {
                name: '',
                categories: [],
                brand: '',
                size: '',
                links: []
            },
            categoryList: {}
        };
    },
    beforeMount() {
        this.checkIfLogged();

        axios.post(apiLink + "/api/getCategories")
            .then(({ data }) => {

                this.categoryList = data

            });

    },
    methods: {
        addLinkRow() {
            this.linkCounter = this.linkCounter + 1;
        },
        removeLinkRow(index) {
            const element = document.getElementById(`link-${index}`);
            element.remove();
        },
        validateFormData() {
            const result = Array.from(document.querySelectorAll("[id^='linkinp-']"), ({ value }) => value);
            for (var i = 0; i <= result.length - 1; i++) {
                this.product.links.push(result[i])
            }

            if (this.product.links.length == 0) {
                toast("You need to send at least one link", {
                    "theme": "light",
                    "type": "default",
                    "transition": "zoom",
                    "dangerouslyHTMLString": true
                })

                return ''
            }
            console.log(this.product)

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/requestProduct", this.product)
                .then(({ data }) => {

                    toast("Request created", {
                        "theme": "light",
                        "type": "default",
                        "transition": "zoom",
                        "dangerouslyHTMLString": true
                    })

                    setTimeout(() => { this.$router.push("/") }, 1000)


                })
                .catch(error => {
                    toast("An error ocurred, try again", {
                        "theme": "light",
                        "type": "default",
                        "transition": "zoom",
                        "dangerouslyHTMLString": true
                    })
                });


        }
    }
};
</script>