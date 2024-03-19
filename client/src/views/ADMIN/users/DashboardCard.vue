<script setup>
import { userLogged } from '@/stores/loggedUserInfo.js';
import NavBar from '@/components/Navbar.vue'

import CategoriesCard from '@/views/ADMIN/categories/DashboardCard.vue'
import ProductsCard from '@/views/ADMIN/products/DashboardCard.vue'

let userInfo = userLogged()

if (!userInfo.role) {
    window.location.href = '/'
}
</script>

<template>

    <div class="col-md-3 mt-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex flex-column gap-2">
                <small>USERS</small>
                <h2>{{ userCount }}</h2>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary w-100">Create</button>
                    <a href="/admin/users" class="w-100"><button type="button" class="btn btn-primary w-100">Manage</button></a>
                </div>

            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js'

export default {
    name: 'UsersCountCard',
    data() {
        return {
            userCount: '',
        };
    },
    beforeMount() {


        axios.defaults.headers.common["Authorization"] =
            "Bearer " + $cookies.get('jwtoken');
        axios.post(apiLink + "/api/checkIfAdmin")
            .then(({ data }) => {

                if (data) {

                    this.loadStatistics()

                    setTimeout(() => {
                        this.loadStatistics()
                    }, 30000);

                } else {

                    this.$router.push('/')

                }

            })
            .catch(error => {

            });
    },
    methods: {
        loadStatistics() {

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');

            axios.post(apiLink + "/api/getUsersCount")
                .then(({ data }) => {
                    this.userCount = data;
                })
                .catch(error => {
                    console.log("error")
                });

        }
    }
};
</script>
