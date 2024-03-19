<script setup>
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
</script>

<template>

    <div class="col-md-3 mt-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex flex-column gap-2">
                <small>Categories</small>
                <h2>{{ categoriesCount }}</h2>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                        data-bs-target="#categoryAddModal">
                        Create
                    </button>
                    <a href="/admin/categories" class="w-100"><button type="button" class="btn btn-primary w-100">Manage
                            </button></a>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="categoryAddModal" tabindex="-1" aria-labelledby="categoryAddModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryAddModal">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <FloatLabel class="w-100 mt-3">
                        <InputText class="w-100" v-model="categoryName" />
                        <label>Category Name</label>
                    </FloatLabel>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="createCategory">Create Category</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js'
import { toast } from "vue3-toastify";


export default {
    name: 'CategoriesDashboardCard',
    data() {
        return {
            categoriesCount: '',
            categoryName: '',
        };
    },
    beforeMount() {

        axios.defaults.headers.common["Authorization"] =
            "Bearer " + $cookies.get('jwtoken');
        axios.post(apiLink + "/api/checkIfAdmin")
            .then(({ data }) => {

                if (data) {

                    this.loadStatistics()

                    setTimeout(() => {
                        this.loadStatistics()
                    }, 30000);

                } else {

                    this.$router.push('/')

                }

            })
            .catch(error => {

            });

    },
    methods: {

        loadStatistics() {

            axios.post(apiLink + "/api/getCategoriesCount")
                .then(({ data }) => {
                    this.categoriesCount = data;
                })
                .catch(error => {
                    console.log("error")
                });

        },
        createCategory() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + $cookies.get('jwtoken');
            axios.post(apiLink + "/api/createCategory", { name: this.categoryName })
                .then(({ data }) => {

                    if (data == 'created') {

                        toast("Category Created", {
                            "type": "success",
                            "autoClose": 1000,
                            "dangerouslyHTMLString": true
                        })

                        this.closeAllModals()
                        this.loadStatistics()
                        this.categoryName = ''


                    }

                })
                .catch(error => {

                });
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
        }

    }
};
</script>
