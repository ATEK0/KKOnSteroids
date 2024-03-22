<script setup>

import NavAdmin from '@/components/NavAdmin.vue'

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
                            <h1>Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/admin/categories">Dashboard</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-lightblue">
                            <div class="inner">
                                <h3>{{ productsCount }}</h3>

                                <p>Products</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-tag"></i>
                            </div>

                            <a href="/admin/products" class="small-box-footer">Details <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-lightblue">
                            <div class="inner">
                                <h3>{{ requestsCount }}</h3>

                                <p>Product Requests</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-inbox"></i>
                            </div>
                            <a href="/admin/requests" class="small-box-footer">Details <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-lightblue">
                            <div class="inner">
                                <h3>{{ categoriesCount }}</h3>

                                <p>Categories</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-boxes"></i>
                            </div>
                            <a href="/admin/categories" class="small-box-footer">Details <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-lightblue">
                            <div class="inner">
                                <h3>{{ userCount }}</h3>

                                <p>Users</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <a href="/admin/users" class="small-box-footer">Details <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

            </template>
        </NavAdmin>
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

                    window.location.href = '/'

                }

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
