import { createRouter, createWebHistory } from 'vue-router'
import Homepage from '../views/Homepage.vue'

import Register from '../components/Register.vue'
import Login from '@/components/Login.vue'
import Logout from '@/components/Logout.vue'
import UserInfo from '@/views/UserInfo.vue'
import Account from '@/views/Account.vue'
import AdminDashboard from '@/views/ADMIN/Dashboard.vue'
import ProductIndividual from '@/views/products/ProductIndividual.vue'
import RequestProductForm from '@/views/RequestProductForm.vue'
import ProductRequestDashboard from '@/views/ADMIN/product requests/Index.vue'
import ProductRequestSingular from '@/views/ADMIN/product requests/RequestSingular.vue'

import CategoriesDashboard from '@/views/ADMIN/categories/Index.vue'

import UsersAdminDashboard from '@/views/ADMIN/users/Index.vue'

import ProductsAdminDashboard from '@/views/ADMIN/products/Index.vue'
import CreateNewProduct from '@/views/ADMIN/products/CreateProduct.vue'
import EditProduct from '@/views/ADMIN/products/EditProduct.vue'


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
      component: Register
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/userinfo',
      name: 'userinfo',
      component: UserInfo
    },
    {
      path: '/logout',
      name: 'logout',
      component: Logout
    },
    {
      path: '/account',
      name: 'account',
      component: Account
    },
    {
      path: '/admin',
      name: 'adminDashboard',
      component: AdminDashboard
    },
    {
      path: '/admin/categories',
      name: 'categoriesDashboard',
      component: CategoriesDashboard
    },
    {
      path: '/product/:slug',
      name: 'productIndividual',
      component: ProductIndividual
    },
    {
      path: '/product/request',
      name: 'requestProduct',
      component: RequestProductForm,
    },
    {
      path: '/admin/requests',
      name: 'ProductRequestDashboard',
      component: ProductRequestDashboard
    },
    {
      path: '/admin/request/:requestID',
      name: 'ProductRequestSingular',
      component: ProductRequestSingular
    },
    {
      path: '/admin/users',
      name: 'usersList',
      component: UsersAdminDashboard
    },
    {
      path: '/admin/products',
      name: 'productsList',
      component: ProductsAdminDashboard
    },
    {
      path: '/admin/products/new',
      name: 'createNewProduct',
      component: CreateNewProduct
    },
    {
      path: '/admin/products/edit/:id',
      name: 'editProduct',
      component: EditProduct
    },
  ]
})

export default router
