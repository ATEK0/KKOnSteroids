<script setup>
import { userLogged } from '@/stores/loggedUserInfo.js';

let userInfo = userLogged()
</script>

<template>
    <main>

        <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#FFBE0B;">
            <div class="container gap-2">
                <a class="navbar-brand" href="/">KKOnSteroids</a>

                <form @submit.stop.prevent="submit" class="d-flex w-100 flex-sm-row align-items-center gap-3">
                    <div class="searchResults" id="searchResults" :hidden="!show_x"
                        style="background-color: white;border-radius: 0 0 5px 5px;position: absolute;top:30px;z-index: 5;padding-top: 20px;">

                        <a :href="'product/' + product.slug" class="" v-for="product in searchBarProducts">
                            <div class="searchBarResult d-flex align-items-center justify-content-center my-2">
                                <img :src="product.productImage" alt="" class="img-fluid col-2">
                                <p class="col-10">{{ product.name }}</p>
                            </div>
                        </a>

                    </div>

                    <input v-model="search_query" @blur="checkX" @click="checkX" @focus="checkX" @keydown="checkX" @keypress="checkX"
                        @keyup="checkX" id='navbar-search' class="navbar-search" type="search" placeholder="Search"
                        aria-label="Search" style="z-index: 6;">


                    <svg v-if="show_x" @click.stop="eraseSearch" xmlns="http://www.w3.org/2000/svg" style="z-index: 6;"
                        viewBox="0 0 384 512" class="erase-icon-nav">
                        <path
                            d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                    </svg>
                    <svg v-if="!show_x" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="z-index: 6;"
                        class="search-icon-nav">
                        <path
                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                    </svg>
                </form>
                <div v-if="userInfo.name" class="nav-menus">

                    <span class="nav-btn text-center">{{ (userInfo.name) }}</span>
                    <div class="user-dropdown"
                        style="position:absolute;width: 100px;text-align:center;transform: translateX(-25%p);">
                        <a href="/account"><label class="p-2">Account</label></a>
                        <a href="/logout"><label class="p-2">Logout</label></a>
                    </div>
                </div>

                <div v-else>

                    <a href="/login"><button class="nav-btn">Login</button></a>

                </div>




            </div>
        </nav>

    </main>
</template>

<script>
import axios from 'axios';
import { apiLink } from '../config.js';

export default {
    name: 'navbar',
    data() {
        return {
            show_x: false,
            search_query: '',
            user: '',
            searchBarProducts: []
        };
    },
    mounted() {
        this.adjustSearchResultsWidth()

        window.addEventListener('resize', this.adjustSearchResultsWidth);
    },
    destroyed() {
        window.removeEventListener('resize', this.adjustSearchResultsWidth);
    },
    methods: {
        checkX() {
            if (this.search_query == '') {
                this.show_x = false;
                this.searchBarProducts = ''
            } else {
                this.show_x = true;
            }
            this.adjustSearchResultsWidth()


        },
        eraseSearch() {
            this.search_query = ''
            this.searchBarProducts = ''
            this.checkX()
        },
        search() {
            axios.post(apiLink + "/api/searchQueryFromSearchBar", { searchQuery: this.search_query })
                .then(({ data }) => {

                    console.log(data)
                    if (data.length == 0) {
                        this.searchBarProducts = [{ 'name': 'No results found for ' + this.search_query, 'productImage': 'https://static-00.iconduck.com/assets.00/magnifying-glass-icon-2048x2048-nyrpioom.png' }]
                    }
                    else {
                        this.searchBarProducts = data
                    }

                });
        },
        submit() {
            window.location.href = "/products?search=" + this.search_query;

        },
        adjustSearchResultsWidth() {

            const searchInput = document.getElementById('navbar-search');
            const searchResults = document.getElementById('searchResults');

            if (searchInput && searchResults) {
                const inputWidth = searchInput.offsetWidth;
                searchResults.style.width = inputWidth + 'px';
            }

            this.search()

        },
    }
};
</script>
