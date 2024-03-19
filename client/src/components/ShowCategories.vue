<template>
    <main>

    </main>
</template>

<script>
import axios from 'axios';
import { apiLink } from '../config.js';

export default {
    name: 'showCategories',
    data() {
        return {
            categories: ''
        };
    },
    beforeMount() {
        axios.post(apiLink + "/api/getCategories")
            .then(({ data }) => {

                console.log(data)

                this.categories = data

            })
            .catch(error => {

            });
    }
};
</script>
