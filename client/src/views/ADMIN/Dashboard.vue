<script setup>
import { userLogged } from '@/stores/loggedUserInfo.js';
import NavBar from '@/components/Navbar.vue'

import SideNavBar from '@/components/NavAdmin.vue'

import CategoriesCard from '@/views/ADMIN/categories/DashboardCard.vue'
import ProductsCard from '@/views/ADMIN/products/DashboardCard.vue'
import UsersCard from '@/views/ADMIN/users/DashboardCard.vue'
import RequestsCard from '@/views/ADMIN/product requests/DashboardCard.vue'

import ProfileImage from '@/assets/images/profile/user-1.jpg'

let userInfo = userLogged()

if (!userInfo.role) {
    window.location.href = '/'
}
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

        <SideNavBar>
            <template v-slot>
                <div>
                    <h1>Main Content</h1>
                    <p>This is the main content of the page.</p>
                </div>
            </template>
        </SideNavBar>



        <!-- <NavBar />

        <div class="container">

            <div class="card mt-3 shadow-sm p-5 text-start">
                <h2>Hello Admin</h2>
                <p>Welcome to your admin dashboard. Feel free to manage all your website from here.</p>
            </div>

            <div class="row mb-3">

                <ProductsCard />

                <RequestsCard />

                <UsersCard />

                <CategoriesCard />

            </div>


        </div> -->

    </main>
</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js'

export default {
    name: 'AdminDashboard',
    data() {
        return {
            information: '',
            productsCount: '',
            requestsCount: '',
            userCount: '',
            categoriesCount: ''
        };
    },
    beforeMount() {


        axios.defaults.headers.common["Authorization"] =
            "Bearer " + $cookies.get('jwtoken');
        axios.post(apiLink + "/api/checkIfAdmin")
            .then(({ data }) => {

                if (data) {

                    this.information = "Congrats admin!"
                    this.loadStatistics()

                    setTimeout(() => {
                        this.loadStatistics()
                    }, 30000);

                } else {

                    this.$router.push('/')
                    // window.location.href = '/'

                }

            })
            .catch(error => {

            });
    },
    methods: {
        loadStatistics() {

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getProductsCount")
                .then(({ data }) => {
                    this.productsCount = data;
                })
                .catch(error => {
                    console.log("error")
                });


            axios.post(apiLink + "/api/getRequestsCount")
                .then(({ data }) => {
                    this.requestsCount = data;
                })
                .catch(error => {
                    console.log("error")
                });


            axios.post(apiLink + "/api/getUsersCount")
                .then(({ data }) => {
                    this.userCount = data;
                })
                .catch(error => {
                    console.log("error")
                });

            axios.post(apiLink + "/api/getCategoriesCount")
                .then(({ data }) => {
                    this.categoriesCount = data;
                })
                .catch(error => {
                    console.log("error")
                });

        }
    }
};
</script>
