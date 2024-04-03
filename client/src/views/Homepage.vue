<script setup>

import NavBar from '@/components/Navbar.vue'
import FooterBar from '@/components/Footer.vue'

import HomePageCarousel from '@/components/homepagecarousel.vue'
import MostViewed from '@/components/MostViewed.vue'

</script>

<template>
  <main>

    <NavBar />

    <div class="container mt-3">

      <HomePageCarousel />


      <h4 class="mt-3" id="categories">Categories</h4>
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

      <MostViewed />

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
