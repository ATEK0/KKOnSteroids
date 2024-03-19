<script setup>
import { userLogged } from '@/stores/loggedUserInfo.js';
import NavBar from '@/components/Navbar.vue'
import Badge from 'primevue/badge';

let userInfo = userLogged()

if (!userInfo.role == 'Admin') {
    window.location.href = '/'
}
</script>
<template>

    <NavBar />
    <form @submit.prevent="submitForm" class="container mt-3 d-flex flex-column gap-4">

        <h4 class="d-flex align-items-center gap-2"> ID - {{ request.id }}
            <Badge v-if="request.status == 'Open'" severity="success">{{ request.status }}</Badge>
            <Badge v-if="request.status == 'Accepted'" severity="primary">{{ request.status }}</Badge>
            <Badge v-if="request.status == 'Refused'" severity="danger">{{ request.status }}</Badge>
        </h4>

        <h3>Request information</h3>

        <FloatLabel>
            <InputText id="name" :disabled="isDisabled" class="w-100" v-model="request.name" required />
            <label for="name">Product Name</label>
        </FloatLabel>

        <FloatLabel>
            <Textarea v-model="description" required :disabled="isDisabled" rows="5" cols="30" class="w-100" />
            <label>Description</label>
        </FloatLabel>
        <div class="d-flex flex-row gap-3 w-100">

            <Dropdown v-model="newStatus" :disabled="isDisabled" :options="status" optionLabel="name"
                placeholder='Status' class="w-25" />

            <FloatLabel class="w-25">
                <InputText id="size" :disabled="isDisabled" class="w-100" v-model="request.size" required />
                <label for="size">Size</label>
            </FloatLabel>

            <FloatLabel class="w-25">
                <InputText id="brand" :disabled="isDisabled" class="w-100" v-model="request.brand" required />
                <label for="brand">Brand</label>
            </FloatLabel>

            <FloatLabel class="w-25">
                <InputText id="requestedBy" class="w-100" disabled v-model="request.requested_by" required />
                <label for="requestedBy">Requested By</label>
            </FloatLabel>

        </div>

        <MultiSelect v-model="selectedCategories" :disabled="isDisabled" display="chip" :options="categories"
            optionLabel="name" required placeholder="Select Categories" :maxSelectedLabels="5"
            class="w-full md:w-20rem" />


        <h3 class="w-fit">Links for the product
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15px" class="add-product-link"
                @click="addLinkRow" v-if="!isDisabled">
                <path
                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
            </svg>

        </h3>


        <div v-for="link, index in request.links" class="w-100 d-flex flex-row gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15px" role="button"
                class="remove-product-link" @click="removeLinkRow(index)" v-if="!isDisabled">
                <path
                    d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z" />
            </svg>
            <FloatLabel class="w-75">
                <InputText :id="'link-' + index" :disabled="isDisabled" class="w-100" v-model="link.link" />
                <label :for="'link-' + index">Link {{ index + 1 }}</label>
            </FloatLabel>

            <FloatLabel class="w-25">
                <InputText :id="'html-' + index" :disabled="isDisabled" class="w-100" v-model="htmlElements[index]" />
                <label :for="'html-' + index">Element {{ index + 1 }}</label>
            </FloatLabel>

            <span verified="false" :id="'verified-' + index" class="d-none"></span>

            <button class="btn btn-primary-outlined" @click="testLink(index)" type="button" :id="'test-' + index"
                :disabled="isDisabled">Test</button>
        </div>

        <div class="d-flex gap-1 flex-row-reverse">
            <button type="submit" v-if="request.status == 'Open'" class="btn btn-primary">Approve</button>
            <button type="button" v-if="request.status == 'Open'" @click="rejectRequest"
                class="btn btn-danger">Refuse</button>
            <button type="button" v-if="request.status == 'Refused'" @click="activateRequest"
                class="btn btn-success">Activate</button>
            <button type="button" class="btn btn-secondary">Cancel</button>
        </div>

    </form>

</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js'
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import Dropdown from 'primevue/dropdown';
import MultiSelect from 'primevue/multiselect';
import { toast } from "vue3-toastify";
import Textarea from 'primevue/textarea';

export default {
    name: 'RequestSingular',
    data() {
        return {
            isDisabled: false,
            request: '',
            description: '',
            status: [{ name: 'Open', code: '1' },
            { name: 'Accepted', code: '2' },
            { name: 'Refused', code: '3' }],
            newStatus: '',
            htmlElements: [],
            selectedCategories: null,
            categories: []
        };
    },
    computed: {

    },
    mounted() {
        this.loadPageData()
    },
    methods: {
        loadPageData() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getRequest", { requestID: this.$route.params.requestID })
                .then(({ data }) => {

                    console.log(data)
                    this.request = data
                    this.newStatus = data.status

                    if (this.request.status == 'Refused') {
                        this.isDisabled = true
                    } else if (this.request.status == 'Open') {
                        this.isDisabled = false
                    } else {
                        this.isDisabled = true
                    }

                })
                .catch(error => {


                });

            axios.post(apiLink + "/api/getCategories")
                .then(({ data }) => {

                    this.categories = data

                })
                .catch(error => {

                });
        },
        testLink(index) {
            let link = document.getElementById("link-" + index).value
            let element = document.getElementById("html-" + index).value

            console.log(link, element)

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

                })
                .catch(error => {

                });


        },
        addLinkRow() {
            this.request.links.push({ "link": "" })
        },
        removeLinkRow(index) {
            this.request.links.splice(index, 1)
        },
        submitForm() {

            let linksVerified = document.querySelectorAll("span[verified='true']");

            if (linksVerified.length == this.request.links.length) {

                let payload = {
                    'request_id': this.request.id,
                    'name': this.request.name,
                    'requested_by': this.request.requested_by,
                    'brand': this.request.brand,
                    'description': this.description,
                    'size': this.request.size,
                    'category': this.categories,
                    'links': this.request.links,
                    'htmlElements': this.htmlElements
                }

                axios.defaults.headers.common["Authorization"] =
                    "Bearer " + $cookies.get('jwtoken');
                axios.post(apiLink + "/api/createProduct", { payload })
                    .then(({ data }) => {

                        toast("Request accepted and product created", {
                            "type": "success",
                            "autoClose": 1000,
                            "dangerouslyHTMLString": true
                        })

                        setTimeout(() => {window.location.reload()},
                        1200)
                        

                    })
                    .catch(error => {
                    });



            } else {
                toast("You need to test & verify all the links", {
                    "type": "error",
                    "autoClose": 2000,
                    "dangerouslyHTMLString": true
                })
            }
        },

        rejectRequest() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/refuseRequest", { requestID: this.$route.params.requestID })
                .then(({ data }) => {

                    this.loadPageData()

                })
                .catch(error => {
                });

        },

        activateRequest() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/activateRequest", { requestID: this.$route.params.requestID })
                .then(({ data }) => {

                    this.loadPageData()

                })
                .catch(error => {
                });
        }
    }
};
</script>