import { createRouter, createWebHistory } from 'vue-router'
import { userLogged } from '@/stores/loggedUserInfo.js';


import Homepage from '../views/Homepage.vue'

import Register from '@/views/auth/Register.vue'
import Login from '@/views/auth/Login.vue'
import Logout from '@/views/auth/Logout.vue'
import Account from '@/views/Account.vue'
import ProductIndividual from '@/views/products/ProductIndividual.vue'
import RequestProductForm from '@/views/RequestProductForm.vue'
import ProductList from "@/views/products/ProductList.vue"
import ProductListByCategory from '@/views/products/ProductListByCategory.vue'

import AdminDashboard from '@/views/ADMIN/Dashboard.vue'

import ProductRequestDashboard from '@/views/ADMIN/product requests/Index.vue'
import ProductRequestSingular from '@/views/ADMIN/product requests/RequestSingular.vue'

import CategoriesDashboard from '@/views/ADMIN/categories/Index.vue'

import UsersAdminDashboard from '@/views/ADMIN/users/Index.vue'

import Banners from '@/views/ADMIN/Banners.vue'

import ProductsAdminDashboard from '@/views/ADMIN/products/Index.vue'
import CreateNewProduct from '@/views/ADMIN/products/CreateProduct.vue'
import EditProduct from '@/views/ADMIN/products/EditProduct.vue'

import WishlistIndividual from '@/views/WishlistIndividual.vue'

import NotFound from '@/views/errors/NotFound.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Homepage
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: {
        requiresNoAuth: true,
      }
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: {
        requiresNoAuth: true,
      }
    },
    {
      path: '/logout',
      name: 'logout',
      component: Logout,
      meta: {
        requiresAuth: true,
      }
    },
    {
      path: '/account',
      name: 'account',
      component: Account,
      meta: {
        requiresAuth: true,
      }
    },
    {
      path: '/admin',
      name: 'adminDashboard',
      component: AdminDashboard,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/product/:slug',
      name: 'productIndividual',
      component: ProductIndividual
    },
    {
      path: '/products',
      name: 'productList',
      component: ProductList
    },
    {
      path: '/product/request',
      name: 'requestProduct',
      component: RequestProductForm,
      meta: {
        requiresAuth: true,
      }
    },
    {
      path: '/category/:category',
      name: 'ProductListByCategory',
      component: ProductListByCategory,
    },
    {
      path: '/wishlist/:slug',
      name: 'WishlistIndividual',
      component: WishlistIndividual,
      meta: {
        requiresAuth: true,
      }
    },
    {
      path: '/admin/categories',
      name: 'categoriesDashboard',
      component: CategoriesDashboard,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/admin/requests',
      name: 'ProductRequestDashboard',
      component: ProductRequestDashboard,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/admin/request/:requestID',
      name: 'ProductRequestSingular',
      component: ProductRequestSingular,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/admin/users',
      name: 'usersList',
      component: UsersAdminDashboard,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/admin/products',
      name: 'productsList',
      component: ProductsAdminDashboard,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/admin/products/new',
      name: 'createNewProduct',
      component: CreateNewProduct,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/admin/products/edit/:slug',
      name: 'editProduct',
      component: EditProduct,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/admin/banners',
      name: 'configureBanners',
      component: Banners,
      meta: {
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    { 
      path: '/:pathMatch(.*)*', 
      component: NotFound 
    },  
  ]
})

router.beforeEach((to, from, next) => {
  // Check if the route requires no authentication
  if (to.matched.some(record => record.meta.requiresNoAuth)) {
    if (isAuthenticated()) {
      next({
        path: '/',
      });
    }
  }

  // Check if the route requires authentication
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // Check if the user is authenticated
    if (!isAuthenticated()) {
      // If not authenticated, redirect to login page
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      });
    } else {
      // Check if the route requires admin privileges
      if (to.matched.some(record => record.meta.requiresAdmin)) {
        // Check if the user is an admin
        if (!isAdmin()) {
          // If not an admin, redirect to unauthorized page or any other logic
          next({
            path: '/not-found',
          });
        } else {
          // If authenticated and admin, proceed to the route
          next();
        }
      } else {
        // If authenticated and not admin-required route, proceed to the route
        next();
      }
    }
  } else {
    // If the route doesn't require authentication, proceed as usual
    next();
  }
});

function isAuthenticated() {

  if (!$cookies.get("jwtoken")) {
    return false;
  }

  return true;
  
}

function isAdmin() {

  let userInfo = userLogged()

  if (userInfo.role == 'Admin') {
    return true;
  }

  return false;

}


export default router
