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
                            <h1>Update {{ name }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/admin/products">Products</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <form @submit.prevent="submitForm" class=" mt-3 d-flex flex-column gap-4">

                <FloatLabel>
                    <InputText id="name" class="w-100" v-model="name" required />
                    <label for="name">Product Name</label>
                </FloatLabel>

                <FloatLabel>
                    <InputText id="name" class="w-100" v-model="imageLink" required />
                    <label for="name">Image Link</label>
                </FloatLabel>

                <FloatLabel>
                    <Textarea v-model="description" required rows="5" cols="30" class="w-100" />
                    <label>Description</label>
                </FloatLabel>
                <div class="d-flex flex-row gap-3 w-100">

                    <FloatLabel class="w-50">
                        <InputText id="size" class="w-100" v-model="size" required />
                        <label for="size">Size</label>
                    </FloatLabel>

                    <FloatLabel class="w-50">
                        <InputText id="brand" class="w-100" v-model="brand" required />
                        <label for="brand">Brand</label>
                    </FloatLabel>

                </div>

                <MultiSelect v-model="selectedCategories" display="chip" :options="categories" optionLabel="name"
                    required placeholder="Select Categories" :maxSelectedLabels="5" class="w-full md:w-20rem" />

                <h3 class="w-fit">Links for the product
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15px" class="add-product-link"
                        @click="addLinkRow">
                        <path
                            d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                    </svg>

                </h3>


                <div v-for="link, index in links" class="w-100 d-flex flex-row gap-1">
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
                        <InputText :id="'html-' + index" class="w-100"
                            v-model="htmlElements[index].HTML_price_element" />
                        <label :for="'html-' + index">Element {{ index + 1 }}</label>
                    </FloatLabel>

                    <span verified="false" :id="'verified-' + index" class="d-none"></span>

                    <button class="btn btn-primary-outlined" @click="testLink(index)" type="button"
                        :id="'test-' + index">Test</button>
                </div>

                <div class="d-flex gap-1 flex-row-reverse">
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
            productID: '',
            name: '',
            brand: '',
            description: '',
            size: '',
            links: [{}],
            htmlElements: [{ HTML_price_element: '' }],
            selectedCategories: null,
            categories: [],
            productSlug: '',
            imageLink: '',
        };
    },

    mounted() {
        this.productSlug = this.$route.params.slug
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

            axios.post(apiLink + "/api/getProduct", { slug: this.productSlug })
                .then(({ data }) => {

                    this.productID = data.id
                    this.name = data.name
                    this.description = data.description
                    this.size = data.size
                    this.brand = data.brand
                    this.selectedCategories = data.categories
                    this.links = data.links
                    this.htmlElements = data.HTMLelements,
                    this.imageLink = data.productImage

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
                    'id': this.productID,
                    'name': this.name,
                    'brand': this.brand,
                    'description': this.description,
                    'size': this.size,
                    'category': this.selectedCategories,
                    'links': this.links,
                    'htmlElements': this.htmlElements
                }

                axios.defaults.headers.common["Authorization"] =
                    "Bearer " + $cookies.get('jwtoken');
                axios.post(apiLink + "/api/updateProduct", { payload })
                    .then(({ data }) => {

                        toast("Product updated", {
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
