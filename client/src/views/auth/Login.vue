<script setup>
import NavBar from '@/components/Navbar.vue'
</script>
<template>
    <NavBar />

    <div class="container"
        style="height: 70vh;display: flex;justify-content: center;align-items: center;flex-direction: column;">

        <div class="card p-5">
            <h2 class="mb-3 fw-bold " style="color: var(--main-yellow);">KKOnSteroids</h2>
            <h5 class="mb-3">Login into your account</h5>

            <div class="w-100" style="max-width: 600px;">
                <div class="card-body text-center">
                    <form @submit.prevent="processLogin">
                        <input type="email" placeholder="Email" name="email" id="email" v-model="student.email"
                            class="form-control mb-4">

                        <input :type="canSeePwd ? 'text' : 'password'" placeholder="Password" name="password"
                            id="password" class="form-control mb-1" v-model="student.password">
                        <div>
                            <input type="submit" value="Login" class="btn btn-primary mt-3 w-100">
                            <svg v-if="this.canSeePwd" @click="togglePassword" xmlns="http://www.w3.org/2000/svg"
                                style="fill: var(--main-yellow);position: absolute;transform: translateY(-28px) translateX(-25px);"
                                width="16px" viewBox="0 0 640 512">
                                <path
                                    d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z" />
                            </svg>

                            <svg v-if="!this.canSeePwd" @click="togglePassword" xmlns="http://www.w3.org/2000/svg"
                                width="15px"
                                style="fill: var(--main-yellow);position: absolute;transform: translateY(-28px) translateX(-25px);"
                                viewBox="0 0 576 512">
                                <path
                                    d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                            </svg>

                        </div>
                    </form>
                    <small>Dont have an account? Create one <a href="/register" style="text-decoration: underline;">here</a></small>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { apiLink } from '../../config.js';
import { toast } from "vue3-toastify";
import { userLogged } from '@/stores/loggedUserInfo.js';

export default {
    name: 'Login',
    data() {
        return {
            result: {},
            student: {
                name: '',
                email: '',
                password: ''
            },
            canSeePwd: false,
        };
    },
    onMounted() {
        if ($cookies.get("jwtoken")) {
            this.$router.push('/account')
        }
    },
    methods: {
        togglePassword() {
            this.canSeePwd = !this.canSeePwd
        },
        processLogin() {

            axios.post(apiLink + "/api/login", this.student)
                .then(({ data }) => {

                    $cookies.set("jwtoken", data['token'], 14400);

                    this.populatePineaWithUserInfo(data['token'])

                    toast("Login successful", {
                        "theme": "light",
                        "type": "default",
                        "transition": "zoom",
                        "dangerouslyHTMLString": true
                    })

                })
                .catch(error => {

                    toast("Invalid credentials", {
                        "theme": "light",
                        "type": "default",
                        "transition": "zoom",
                        "dangerouslyHTMLString": true
                    })
                });
        },
        populatePineaWithUserInfo(jwtoken) {
            const userStore = userLogged()

            axios.defaults.headers.common["Authorization"] =
                "Bearer " + jwtoken;
            axios.post(apiLink + "/api/me")
                .then(({ data }) => {
                    userStore.id = data['id']
                    userStore.name = data['name']
                    userStore.email = data['email']
                    userStore.role = data['role']
                    userStore.created_at = data['created_at']

                    if (userStore.role == 'Admin') {
                        this.$router.push('/admin')
                    } else {
                        this.$router.push('/')
                    }

                });
        }
    }
};
</script>