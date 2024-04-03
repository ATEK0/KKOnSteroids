<script setup>

import NavAdmin from '@/components/NavAdmin.vue'
import FloatLabel from 'primevue/floatlabel';

</script>

<style>
.card {
    border: none !important;
    text-align: center;
    border-radius: 15px;
}
</style>
<template>
    <main>

        <NavAdmin>
            <template v-slot>
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Edit Homepage Banners</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="/admin/categories">Homepage</a></li>
                                    <li class="breadcrumb-item active">Edit Banners</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="d-flex mt-2 gap-1 h-100">

                    <div v-for="banner, index in banners"
                        class="d-flex flex-column justify-content-between col-3 border rounded text-center">
                        <img :src="banner.imageLink" alt="" class="img-fluid">
                        <div class="d-flex justify-content-center align-content-center my-3 gap-2">
                            <p class="d-flex justify-content-center align-content-center p-0 m-0">Banner {{ index + 1 }}
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="" width="13"
                                @click="deleteBanner(banner.id)" fill="var(--main-yellow)">
                                <path
                                    d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                            </svg>
                        </div>
                    </div>

                    <div data-bs-toggle="modal" data-bs-target="#modalAddBanner"
                        class="col-3 border rounded text-center d-flex flex-column justify-content-center align-items-center"
                        style="color: var(--main-yellow);fill: var(--main-yellow);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="70px">
                            <path
                                d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM200 344V280H136c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                        </svg>
                        <label for="">Add Banner</label>
                    </div>

                </div>

            </template>
        </NavAdmin>


        <!-- Modal -->
        <div class="modal fade" id="modalAddBanner" tabindex="-1" aria-labelledby="modalAddBanner" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddBanner">Add banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label>Image Link</label>
                        <input type="text" class="w-100" v-model="bannerImage" :class="'form-control'" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="createBanner">Add</button>
                    </div>
                </div>
            </div>
        </div>

    </main>
</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js'
import { toast } from "vue3-toastify";

export default {
    name: 'BannerDashboard',
    data() {
        return {
            bannerImage: '',
            banners: ''
        };
    },
    beforeMount() {
        this.loadBanners()
    },
    methods: {
        loadBanners() {
            axios.get(apiLink + "/api/getBanners")
                .then(({ data }) => {

                    this.banners = data

                })
                .catch(error => {

                });
        },
        createBanner() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/createBanner", { imageLink: this.bannerImage })
                .then(({ data }) => {

                    this.bannerImage = '';
                    this.closeAllModals();
                    toast('Banner Created', {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })
                    this.loadBanners()
                })
                .catch(error => {
                    console.log("error")
                });
        },
        deleteBanner(bannerID) {

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/deleteBanner", { id: bannerID })
                .then(({ data }) => {

                    this.loadBanners();
                    toast('Banner Deleted', {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })

                })
                .catch(error => {
                    console.log("error")
                });

        },
        closeAllModals() {

            // get modals
            const modals = document.getElementsByClassName('modal');

            // on every modal change state like in hidden modal
            for (let i = 0; i < modals.length; i++) {
                modals[i].classList.remove('show');
                modals[i].setAttribute('aria-hidden', 'true');
                modals[i].setAttribute('style', 'display: none');
            }

            // get modal backdrops
            const modalsBackdrops = document.getElementsByClassName('modal-backdrop');

            // remove every modal backdrop
            for (let i = 0; i < modalsBackdrops.length; i++) {
                document.body.removeChild(modalsBackdrops[i]);
            }
        },
    }
};
</script>
