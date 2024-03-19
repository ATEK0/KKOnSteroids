<template>

    <div class="col-md-3 col-sm-6  mt-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex flex-column gap-2">
                <small>REQUESTS</small>
                <h2>{{ requestsCount }}</h2>

                <div class="d-flex gap-2 flex-sm-column flex-md-column flex-lg-row">
                    <a href="/product/request" class="w-100"><button type="button" class="btn btn-primary w-100">Create
                        </button></a>
                    <a href="/admin/requests" class="w-100"><button type="button" class="btn btn-primary w-100">Manage
                        </button></a>
                </div>


            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js'

export default {
    name: 'RequestsCountCard',
    data() {
        return {
            requestsCount: '',
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

            axios.post(apiLink + "/api/getRequestsCount")
                .then(({ data }) => {
                    this.requestsCount = data;
                })
                .catch(error => {
                    console.log("error")
                });

        }
    }
};
</script>
