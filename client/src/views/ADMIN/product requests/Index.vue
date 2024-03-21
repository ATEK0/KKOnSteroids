<script setup>
import { userLogged } from '@/stores/loggedUserInfo.js';
import NavBar from '@/components/Navbar.vue'

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

import SideNavBar from '@/components/NavAdmin.vue'

let userInfo = userLogged()

if (!userInfo.role) {
    window.location.href = '/'
}
</script>
<template>

    <SideNavBar>
        <template v-slot>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Product Requests</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/admin/requests">Product Requests</a></li>
                                <li class="breadcrumb-item active">Manage</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>


            <input v-model="searchQuery" type="text" placeholder="Search product" class="form-control mt-3 w-25">
            <DataTable :value="filteredRequests" @row-click="cellClicked($event, $event.data)" stripedRows
                resizableColumns columnResizeMode="fit" removableSort paginator :rows="15"
                :rowsPerPageOptions="[15, 25, 50, 100]" tableStyle="min-width: 50rem;cursor:pointer;"
                paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                row-key="id" currentPageReportTemplate="{first} to {last} of {totalRecords}" class="mt-3">

                <Column field="name" sortable header="Product" style="width: 20%">
                    <template #loading>
                        <div class="flex align-items-center"
                            :style="{ height: '17px', 'flex-grow': '1', overflow: 'hidden' }">
                        </div>
                    </template>
                </Column>
                <Column field="requested_at" sortable header="Requested at" style="width: 20%">
                    <template #loading>
                        <div class="flex align-items-center"
                            :style="{ height: '17px', 'flex-grow': '1', overflow: 'hidden' }">
                        </div>
                    </template>
                </Column>
                <Column field="status" sortable header="Status" style="width: 20%">
                    <template #loading>
                        <div class="flex align-items-center"
                            :style="{ height: '17px', 'flex-grow': '1', overflow: 'hidden' }">
                        </div>
                    </template>
                </Column>
                <Column field="brand" sortable header="Brand" style="width: 20%">
                    <template #loading>
                        <div class="flex align-items-center"
                            :style="{ height: '17px', 'flex-grow': '1', overflow: 'hidden' }">
                        </div>
                    </template>
                </Column>
                <Column field="requested_by" sortable header="Requested By" style="width: 20%">
                    <template #loading>
                        <div class="flex align-items-center"
                            :style="{ height: '17px', 'flex-grow': '1', overflow: 'hidden' }">
                        </div>
                    </template>
                </Column>
            </DataTable>
        </template>
    </SideNavBar>

</template>

<script>
import axios from 'axios';
import { apiLink } from '@/config.js'

export default {
    name: 'ProductRequestList',
    components: {
        DataTable,
        Column,
    },
    data() {
        return {
            requests: [],
            searchQuery: ''
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
        axios.defaults.headers.common["Authorization"] =
            "Bearer " + $cookies.get('jwtoken');
        axios.post(apiLink + "/api/getRequestProducts")
            .then(({ data }) => {
                this.requests = data
            })
            .catch(error => {
                console.log("error")
            });
    },
    methods: {
        cellClicked(event, rowData) {
            this.$router.push({ path: '/admin/request/' + rowData.id })
        },
    }
};
</script>
