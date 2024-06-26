<script setup>

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import SideNavBar from '@/components/NavAdmin.vue'

</script>
<template>


    <SideNavBar>
        <template v-slot>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Products</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/admin/products">Products</a></li>
                                <li class="breadcrumb-item active">Manage</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <div class="card p-4 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <input v-model="searchQuery" type="text" placeholder="Search product" class="form-control w-25">
                    <a href="/admin/products/new"><button class="btn btn-primary my-2">Add Product</button></a>
                </div>

                <DataTable :value="filteredRequests" @row-click="cellClicked($event.data)" stripedRows
                    columnResizeMode="fit" removableSort paginator :rows="15" :rowsPerPageOptions="[15, 25, 50, 100]"
                    tableStyle="min-width: 50rem;cursor:pointer;"
                    paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    row-key="id" currentPageReportTemplate="{first} to {last} of {totalRecords}" class="mt-3">

                    <Column field="id" sortable header="ID" style="width: 10%">
                        <template #loading>
                            <div class="flex align-items-center"
                                :style="{ height: '17px', 'flex-grow': '1', overflow: 'hidden' }">
                            </div>
                        </template>
                    </Column>
                    <Column field="name" sortable header="Name" style="width: 60%">
                        <template #loading>
                            <div class="flex align-items-center"
                                :style="{ height: '17px', 'flex-grow': '1', overflow: 'hidden' }">
                            </div>
                        </template>
                    </Column>

                    <Column field="lowerprice" sortable header="Lower Price" style="width: 20%">
                        <template #loading>
                            <div class="flex align-items-center"
                                :style="{ height: '17px', 'flex-grow': '1', overflow: 'hidden' }">
                            </div>
                        </template>
                    </Column>

                    <Column header="Actions" style="width: 30%; text-align: center;">
                        <template #body="rowData">
                            <button @click="editProduct(rowData)" data-bs-toggle="modal"
                                data-bs-target="#categoryUpdateModal" class="btn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18px">
                                    <path
                                        d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z" />
                                </svg>
                            </button>
                            <button @click="trashIconClicked(rowData)" class="btn" data-bs-toggle="modal"
                                data-bs-target="#categoryDeleteModal">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="18px">
                                    <path
                                        d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z" />
                                </svg>
                            </button>
                        </template>
                    </Column>
                </DataTable>
            </div>

            <!-- Modal update category -->
            <div class="modal fade" id="categoryUpdateModal" tabindex="-1" aria-labelledby="categoryUpdateModal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="categoryUpdateModal">Edit {{ productClicked[1] }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <FloatLabel class="w-100 mt-3">
                                <InputText class="w-100" v-model="productName" />
                                <label>Category Name</label>
                            </FloatLabel>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" @click="updateProduct">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- model confirm delete category -->
            <div class="modal fade" id="categoryDeleteModal" tabindex="-1" aria-labelledby="categoryDeleteModal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="categoryDeleteModal">Delete {{ productClicked[1] }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete {{ productClicked[1] }} ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" @click="deleteProduct">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

        </template>
    </SideNavBar>

</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js'
import { toast } from "vue3-toastify";


export default {
    name: 'ProductRequestList',
    components: {
        DataTable,
        Column,
    },
    data() {
        return {
            requests: [],
            searchQuery: '',
            productClicked: '',
            productName: ''
        };
    },
    computed: {
        filteredRequests() {
            return this.requests.filter(request =>
                request.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },
    beforeMount() {
        this.loadData()
    },
    methods: {
        editProduct(category) {
            event.stopPropagation()

            window.location.href = '/admin/products/edit/' + category.data.slug
        },
        updateProduct() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/updateProduct", { id: this.productClicked[0], name: this.productName })
                .then(({ data }) => {
                    this.closeAllModals()
                    this.productName = ''
                    this.loadData()

                    toast("Category Updated", {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })

                });
        },
        trashIconClicked(category) {
            event.stopPropagation()
            this.productClicked = [category.data.id, category.data.name]
            this.productName = category.data.name
        },
        closeAllModals() {

            // get modals
            const modals = document.getElementsByClassName('modal');

            // on every modal change state like in hidden modal
            for (let i = 0; i < modals.length; i++) {
                modals[i].classList.remove('show');
                modals[i].setAttribute('aria-hidden', 'true');
                modals[i].setAttribute('style', 'display: none');
            }

            // get modal backdrops
            const modalsBackdrops = document.getElementsByClassName('modal-backdrop');

            // remove every modal backdrop
            for (let i = 0; i < modalsBackdrops.length; i++) {
                document.body.removeChild(modalsBackdrops[i]);
            }
        },
        loadData() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/getProducts")
                .then(({ data }) => {
                    // console.log(data)
                    this.requests = data
                });
        },
        deleteProduct(category) {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/deleteProduct", { id: this.productClicked[0] })
                .then(({ data }) => {
                    this.closeAllModals()
                    this.productName = ''
                    this.loadData()

                    toast("Product Deleted", {
                        "type": "success",
                        "autoClose": 1000,
                        "dangerouslyHTMLString": true
                    })

                });
        },
        cellClicked(rowData) {
            window.location.href = '/product/' + rowData.slug
        }
    }
};
</script>