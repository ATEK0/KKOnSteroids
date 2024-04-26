<script setup>
import { userLogged } from '@/stores/loggedUserInfo.js';
import { searchHistory } from '@/stores/userHistory.js';

let userInfo = userLogged()
let searchHistoryStore = searchHistory()

</script>

<template>
    <main>

        <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#FFBE0B;">
            <div class="container gap-2">
                <a class="navbar-brand" href="/">KKOnSteroids</a>

                <form @submit.stop.prevent="submit('')" class="d-flex w-100 flex-sm-row align-items-center gap-3">
                    <div class="searchResults" id="searchResults" :hidden="!show_x"
                        style="background-color: white;border-radius: 0 0 5px 5px;position: absolute;top:30px;z-index: 5;padding-top: 20px;">

                        <a :href="'/product/' + product.slug" class="" @click="submit(product.name)"
                            v-for="product in searchBarProducts">
                            <div class="searchBarResult d-flex align-items-center justify-content-center my-2">
                                <img :src="product.productImage" alt="" class="img-fluid col-2">
                                <p class="col-10">{{ product.name }}</p>
                            </div>
                        </a>
                        <p class="ml-4">Recent Searches</p>
                        <a :href="'/products?search=' + search"
                            v-for="(search, index) in searchHistoryStore.searchHistory"
                            v-if="searchHistoryStore.searchHistory.length > 0">
                            <div class="searchBarResult d-flex align-items-center justify-content-center p-1 gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="17">
                                    <path
                                        d="M75 75L41 41C25.9 25.9 0 36.6 0 57.9V168c0 13.3 10.7 24 24 24H134.1c21.4 0 32.1-25.9 17-41l-30.8-30.8C155 85.5 203 64 256 64c106 0 192 86 192 192s-86 192-192 192c-40.8 0-78.6-12.7-109.7-34.4c-14.5-10.1-34.4-6.6-44.6 7.9s-6.6 34.4 7.9 44.6C151.2 495 201.7 512 256 512c141.4 0 256-114.6 256-256S397.4 0 256 0C185.3 0 121.3 28.7 75 75zm181 53c-13.3 0-24 10.7-24 24V256c0 6.4 2.5 12.5 7 17l72 72c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-65-65V152c0-13.3-10.7-24-24-24z" />
                                </svg>
                                <p class="col-10 p-0 m-0">{{ search }}</p>
                                <svg @click.prevent="eraseSearchHistoryItem(index)" xmlns="http://www.w3.org/2000/svg"
                                    style="z-index: 6;" viewBox="0 0 384 512" width="10">
                                    <path
                                        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                </svg>
                            </div>
                        </a>
                        <p class="ml-4" v-else>No recent searches</p>

                    </div>

                    <input v-model="search_query" @blur="checkX" @click="checkX" @focus="checkX" @keydown="checkX"
                        @keypress="checkX" @keyup="checkX" id='navbar-search' class="navbar-search" type="search"
                        placeholder="Search" aria-label="Search" style="z-index: 6;">


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
import { searchHistory } from '@/stores/userHistory.js';

export default {
    name: 'navbar',
    data() {
        return {
            show_x: false,
            search_query: '',
            user: '',
            searchBarProducts: [],
            searchHistoryStore: searchHistory()

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

                    if (data.length == 0) {
                        this.searchBarProducts = [{ 'name': 'No results found for ' + this.search_query, 'productImage': 'https://i.pinimg.com/736x/19/65/ab/1965ab7ef7de87fe748b3c66efbfc73a.jpg' }]
                    }
                    else {
                        this.searchBarProducts = data
                    }


                });
        },
        submit(name) {

            if (this.searchHistoryStore.searchHistory.length > 10) {
                this.searchHistoryStore.searchHistory.pop()
            }

            if (name) {

                if (this.searchHistoryStore.searchHistory[0] != name) {

                    this.searchHistoryStore.searchHistory.unshift(name)
                }

            } else {

                if (this.searchHistoryStore.searchHistory[0] != this.search_query) {

                    this.searchHistoryStore.searchHistory.unshift(this.search_query)
                }

            }


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
        eraseSearchHistoryItem(historyID) {
            this.searchHistoryStore.searchHistory.splice(historyID, 1);
        }
    }
};
</script>
