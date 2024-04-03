<script setup>
import NavBar from '@/components/Navbar.vue'

</script>
<template>
    <NavBar />
    <div class="container"
        style="height: 70vh;display: flex;justify-content: center;align-items: center;flex-direction: column;">

        <div class="card p-5">
            <h2 class="mb-3 fw-bold " style="color: var(--main-yellow);">KKOnSteroids</h2>
            <h5 class="mb-3">Create your account</h5>
            <div class="w-100" style="max-width: 600px;">
                <div class="card-body text-center">
                    <form @submit.prevent="registerUser">

                        <input type="text" placeholder="Name" v-model="user.name" name="name" id="name"
                            class="form-control mb-4">

                        <input type="email" placeholder="Email" name="email" id="email" v-model="user.email"
                            class="form-control mb-4">

                        <input type="password" placeholder="Password" name="password" id="password"
                            class="form-control mb-4" v-model="user.password">

                        <input type="password" placeholder="Confirm Password" name="password" id="password"
                            class="form-control mb-4" v-model="user.passwordC">

                        <input type="submit" value="Create" class="w-100 btn btn-primary mt-3">

                    </form>

                    <small>Already have an account? Get in it <a href="/login">here</a></small>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { apiLink } from '../config.js';
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
    name: 'Register',
    data() {
        return {
            result: {},
            user: {
                name: '',
                email: '',
                password: '',
                passwordC: ''
            }
        };
    },
    beforeMount() {
        if ($cookies.get("jwtoken")) {
            window.location.href = '/account'
        }
    },
    methods: {
        registerUser() {
            axios.post(apiLink + "/api/register", this.user)
                .then(({ data }) => {

                    toast("Account created", {
                        "theme": "light",
                        "type": "success",
                        "transition": "zoom",
                        "dangerouslyHTMLString": true,
                        "autoClose": 2900,
                    })

                    setTimeout(() => {
                        window.location.href = '/login'
                    }, 3000)

                })
                .catch(error => {

                    toast("Something went wrong", {
                        "theme": "light",
                        "type": "default",
                        "transition": "zoom",
                        "dangerouslyHTMLString": true
                    })

                });
        }
    }
};
</script>