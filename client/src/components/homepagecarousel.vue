<template>
    <main>

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div v-for="(banner, index) in banners" :class="{ 'carousel-item': true, 'active': index === 0 }">
                    <img :src="banner.imageLink"
                        class="d-block w-100" alt="">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls"
                data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleControls"
                data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>

    </main>
</template>

<script>

import axios from 'axios';
import { apiLink } from '@/config.js';


export default {
    name: 'homecarousel',
    data() {
        return {
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
    }
};
</script>
