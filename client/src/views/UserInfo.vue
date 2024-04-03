
<template>
    <div class="userinfo" id="userinfo">
        <div v-if="!username">No user logged in</div>
        <div v-else>
            <ul id="example-1">
                <li v-for="(value, key) in Object.entries(username)" :key="key">
                    {{ value[0] }}: {{ value[1] }}
                </li>
            </ul>
        </div>

        <p>Info get by {{ userInfo.name }}</p>


    </div>
</template>

<script>
import axios from 'axios';
import { apiLink } from '../config.js';
import "vue3-toastify/dist/index.css";

export default {
    name: 'UserInfo',
    beforeMount() {
        this.saveData();
    },
    data() {
        return {
            username: '',
            pinia_info: ''
        };
    },
    methods: {
        saveData() {

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/me")
                .then(({ data }) => {

                    // console.log(data)

                    this.username = data

                });
        }
    }
};
</script>