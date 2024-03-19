<script setup>
import { userLogged } from '@/stores/loggedUserInfo.js';
import NavBar from '@/components/Navbar.vue'
import testImage from '/assets/image.png'
import FooterBar from '@/components/Footer.vue'

import HomePageCarousel from '@/components/homepagecarousel.vue'

let userInfo = userLogged()

</script>

<template>
  <main>

    <NavBar />

    <div class="container mt-3">

      <HomePageCarousel />

      <h4>Categories</h4>

      <div class="d-flex gap-2">
        <div class="category card p-2" style="width: fit-content;" v-for="category in categories">
          {{ category.name }}
        </div>
      </div>

      <div class="py-2">
        <h2 class="font-weight-light">Most Viewed</h2>
        <div class="d-flex align-items-center">
          <div class="d-flex flex-row gap-2" style="overflow-x:scroll;" id="container-most-view">
            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>


          </div>
          <span><svg xmlns="http://www.w3.org/2000/svg" width="20px" @click="scrollproductCarroussel" id="most-view"
              viewBox="0 0 320 512">
              <path
                d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
            </svg></span>
        </div>
      </div>

      <div class="py-2">
        <h2 class="font-weight-light">Most Viewed</h2>
        <div class="d-flex align-items-center">
          <div class="d-flex flex-row gap-2" style="overflow-x: scroll;" id="container-most-view">
            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
            </div>

            <div class="card card-body product-card">
              <img :src="testImage" alt="" sizes="" srcset="">
              <h6 class="product-title"><a href="/product/1234">Name...</a></h6>
              <small class="product-description">Small description about this product to test if it TU TU TU TU MAX
                VERSTAPPEN M...</small>
              <div class="d-flex flex-row justify-content-between w-100 align-items-center my-2">
                <span class="price">1000,99€</span>
                <a href="/product/1234"><button class="btn btn-primary">Ver</button></a>
              </div>
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
      categories: []
    };
  },
  beforeMount() {
    axios.post(apiLink + "/api/getCategories")
      .then(({ data }) => {

        this.categories = data
        console.log(this.categories[0].name)

      })
      .catch(error => {

      });
  },
  methods: {
    scrollproductCarroussel(event) {
      console.log(event.target.id)
      let container = document.getElementById(`container-most-view`)
      container.scrollLeft = container.scrollLeft + 50

    }
  }
};
</script>
