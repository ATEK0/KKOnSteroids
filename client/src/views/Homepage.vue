<script setup>

import NavBar from '@/components/Navbar.vue'
import FooterBar from '@/components/Footer.vue'

import HomePageCarousel from '@/components/homepagecarousel.vue'

</script>

<template>
  <main>

    <NavBar />

    <div class="container mt-3">

      <HomePageCarousel />


      <h4 class="mt-3">Categories</h4>
      <div class="overflow-auto d-flex" style="-ms-overflow-style: none;scrollbar-width: none;">
        <div v-for="category in categories" class="gap-1 col-6 col-sm-4 col-md-3 col-lg-2">
          <a :href="'/category/' + category.name">
            <div class="p-2 text-center"
              style="display: flex;align-items: center;justify-content: center;flex-direction: column;">
              <img :src="category.imageLink" width="100%" style="object-fit: cover;width: 150px;height: 150px;"
                class="img-fluid rounded-lg">
              <span class="fw-bold">{{ category.name }}</span>
            </div>
          </a>
        </div>
      </div>

      <div class="card w-100 rounded my-5"
        style="background-color: white;color: var(--platform-black);border: 2.5px solid var(--main-yellow) !important;">
        <div class="row">

          <div class="col-12 col-md-4 col-lg-4 p-3 m-auto">
            <img :src="hotDeal.productImage" class="img-fluid rounded-lg">
          </div>
          <div class="col-12 col-md-8 col-lg-8 text-start  p-3" style="background-color: var(--main-yellow);">
            <h3 class="fw-bold">Todays Hot Deal</h3>

            <p>{{ hotDeal.name }}</p>

            <h5>{{ hotDeal.brand }}</h5>

            <h2 class="fw-bold">{{ hotDeal.lowerprice }}€</h2>

            <a :href="'/product/' + hotDeal.slug"><button class="btn btn-primary" style="border-color: white;">See
                Product</button></a>
            <br>
            <small style="font-family:Arial, Helvetica, sans-serif;font-weight: bold;"> Este produto deixa o destaque em
              {{ dayCounter }} </small>

          </div>

        </div>
      </div>

      <div class="py-2">
        <h2 class="font-weight-light">Most Viewed</h2>
        <div class="d-flex align-items-center">
          <div class="d-flex flex-row gap-2 p-2" style="overflow-x:scroll;" id="container-most-view">

            <div class="card product-card col-2 justify-content-end p-3 pb-0 mb-0" v-for="product in mostViewList">
              <img :src="product.productImage" alt="" class="img-fluid m-auto p-2">
              <h6 class="product-title"><a :href="'/product/' + product.slug">{{ product.name.slice(0, 20) }}</a>
              </h6>
              <small class="product-description text-start">{{ product.description.slice(0, 40) }}...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center mb-1 mt-4">
                <span class="price fw-bold">{{ product.lowerprice }}€</span>
                <div class="d-flex gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="var(--main-yellow)" width="20" viewBox="0 0 512 512">
                    <path
                      d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z">
                    </path>
                  </svg>
                  <a :href="'/product/' + product.slug" class="h-fit"><button
                      class="btn btn-primary py-1">Ver</button></a>
                </div>
              </div>
              <small>Available in X stores</small>
            </div>

          </div>
          <span><svg xmlns="http://www.w3.org/2000/svg" width="20px" @click="scrollproductCarroussel" id="most-view"
              viewBox="0 0 320 512">
              <path
                d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
            </svg></span>
        </div>
      </div>

    </div>

  </main>

  <FooterBar />
</template>

<script>
import axios from 'axios';
import { apiLink } from '../config.js';

export default {
  name: 'navbar',
  data() {
    return {
      user: '',
      categories: [],
      mostViewList: [],
      hotDeal: '',
      dayCounter: ''
    };
  },
  beforeMount() {
    axios.post(apiLink + "/api/getCategories")
      .then(({ data }) => {

        const shuffleArray = (array) => {
          return array.sort(() => Math.random() - 0.5);
        };
        this.categories = shuffleArray(data)
      });

    axios.post(apiLink + "/api/mostView")
      .then(({ data }) => {

        console.log(data)
        this.mostViewList = data

      });

    axios.post(apiLink + "/api/getHotDeal")
      .then(({ data }) => {

        this.hotDeal = data

      });

    setInterval(() => {
      var toDate = new Date();
      var tomorrow = new Date();
      tomorrow.setHours(24, 0, 0, 0);
      var diffMS = tomorrow.getTime() / 1000 - toDate.getTime() / 1000;
      var diffHr = Math.floor(diffMS / 3600);
      diffMS = diffMS - diffHr * 3600;
      var diffMi = Math.floor(diffMS / 60);
      diffMS = diffMS - diffMi * 60;
      var diffS = Math.floor(diffMS);
      var result = ((diffHr < 10) ? "0" + diffHr : diffHr);
      result += ":" + ((diffMi < 10) ? "0" + diffMi : diffMi);
      result += ":" + ((diffS < 10) ? "0" + diffS : diffS);
      this.dayCounter = result

    }, 1000);

  },
  methods: {
    scrollproductCarroussel(event) {

      let container = document.getElementById(`container-most-view`)
      container.scrollLeft = container.scrollLeft + 50

    }
  }
};
</script>
