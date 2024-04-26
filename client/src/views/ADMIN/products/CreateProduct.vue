<script setup>

import SideNavBar from '@/components/NavAdmin.vue'

</script>
<template>
    <SideNavBar>
        <template v-slot>

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Create</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/admin/products">Products</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <form @submit.prevent="submitForm" class=" d-flex flex-column card p-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" required v-model="name">

                <label for="imgLink" class="form-label mt-2">Image Link</label>
                <input type="text" class="form-control" id="imgLink" required v-model="productImage">

                <label for="description" class="form-label mt-2">Description</label>
                <textarea type="text" class="form-control" id="description" required v-model="description"></textarea>

                <div class="d-flex flex-row gap-3 w-100">

                    <div class="d-flex flex-column w-100">
                        <label for="size" class="form-label mt-2">Size</label>
                        <input type="text" class="form-control" id="size" required v-model="size">
                    </div>

                    <div class="d-flex flex-column w-100">
                        <label for="brand" class="form-label mt-2">Brand</label>
                        <input type="text" class="form-control" id="brand" required v-model="brand">
                    </div>

                </div>

                <label for="categories" class="form-label mt-2">Categories</label>
                <MultiSelect v-model="selectedCategories" display="chip" :options="categories" optionLabel="name"
                    required placeholder="Select Categories" :maxSelectedLabels="5" class="w-full md:w-20rem" />


                <div class="d-flex">
                    <label for="description" class="form-label mt-2 me-2">Description</label>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15px" class="add-product-link"
                        @click="addLinkRow">
                        <path
                            d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                    </svg>
                </div>

                <div v-for="link, index in links" class="w-100 d-flex flex-row gap-1 mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15px" role="button"
                        class="remove-product-link" @click="removeLinkRow(index)">
                        <path
                            d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z" />
                    </svg>
                    <FloatLabel class="w-75">
                        <InputText :id="'link-' + index" class="w-100" v-model="link.link" />
                        <label :for="'link-' + index">Link {{ index + 1 }}</label>
                    </FloatLabel>

                    <FloatLabel class="w-25">
                        <InputText :id="'html-' + index" class="w-100" v-model="htmlElements[index]" />
                        <label :for="'html-' + index">Element {{ index + 1 }}</label>
                    </FloatLabel>

                    <span verified="false" :id="'verified-' + index" class="d-none"></span>

                    <button class="btn btn-primary-outlined" @click="testLink(index)" type="button"
                        :id="'test-' + index">Test</button>
                </div>

                <div class="d-flex gap-1 flex-row-reverse mt-2">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary">Cancel</button>
                </div>

            </form>
        </template>
    </SideNavBar>
</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js'
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import MultiSelect from 'primevue/multiselect';
import { toast } from "vue3-toastify";
import Textarea from 'primevue/textarea';

export default {
    name: 'CreateNewProduct',
    data() {
        return {
            name: '',
            brand: '',
            description: '',
            size: '',
            links: [{}],
            htmlElements: [],
            selectedCategories: null,
            categories: [],
            productImage: ''
        };
    },

    mounted() {
        this.loadPageData()
    },
    methods: {
        loadPageData() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');

            axios.post(apiLink + "/api/getCategories")
                .then(({ data }) => {

                    this.categories = data

                });
        },
        testLink(index) {
            let link = document.getElementById("link-" + index).value
            let element = document.getElementById("html-" + index).value

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/scrapper", { url: link, element: element })
                .then(({ data }) => {

                    if (data == 'error') {
                        document.getElementById('test-' + index).classList.remove('btn-primary-outlined')
                        document.getElementById('test-' + index).classList.remove('btn-success')
                        document.getElementById('test-' + index).classList.add('btn-danger')
                        document.getElementById('verified-' + index).setAttribute('verified', "false")

                        toast("Data could not be acquired", {
                            "type": "error",
                            "autoClose": 1000,
                            "dangerouslyHTMLString": true
                        })
                    } else {
                        document.getElementById('test-' + index).classList.remove('btn-danger')
                        document.getElementById('test-' + index).classList.remove('btn-primary-outlined')
                        document.getElementById('test-' + index).classList.add('btn-success')
                        document.getElementById('verified-' + index).setAttribute('verified', "true")

                        toast("Success, price " + data.price, {
                            "type": "success",
                            "autoClose": 1000,
                            "dangerouslyHTMLString": true
                        })
                    }

                });


        },
        addLinkRow() {
            this.links.push({ "link": "" })
        },
        removeLinkRow(index) {
            this.links.splice(index, 1)
        },
        submitForm() {

            let linksVerified = document.querySelectorAll("span[verified='true']");

            if (linksVerified.length == this.links.length) {

                let payload = {
                    'request_id': 0,
                    'name': this.name,
                    'brand': this.brand,
                    'description': this.description,
                    'size': this.size,
                    'category': this.selectedCategories,
                    'links': this.links,
                    'htmlElements': this.htmlElements,
                    'productImage': this.productImage
                }

                axios.defaults.headers.common["Authorization"] =
                    "Bearer " + $cookies.get('jwtoken');
                axios.post(apiLink + "/api/createProduct", { payload })
                    .then(({ data }) => {

                        toast("Product created", {
                            "type": "success",
                            "autoClose": 1000,
                            "dangerouslyHTMLString": true
                        })

                        setTimeout(() => { window.location.href = '/admin/products' },
                            1200)

                    });

            } else {
                toast("You need to test & verify all the links", {
                    "type": "error",
                    "autoClose": 2000,
                    "dangerouslyHTMLString": true
                })
            }
        },

    }
};
</script>
