<script setup>

import whatULooking from '/assets/not found image.png'
import NavBar from '@/components/Navbar.vue'

</script>

<template>

    <NavBar />

    <div class="container d-flex justify-content-center align-items-center flex-column" style="height: 80vh">
        <h1 style="color: var(--darker-yellow);font-size: 150px;font-weight: bold;">404</h1>
        <p>The page you are looking for does not exist</p>
        <p>Maybe you wrote something wrong, try to search for it again</p>
        <img :src="whatULooking" alt="" class="img-fluid">
        <a href="/"><button class="btn btn-primary">Back to Home</button></a>
    </div>

</template>

<script>

export default {
    name: 'notFound',
};
</script>