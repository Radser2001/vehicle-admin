<template>
    <AppLayout title="User Management">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body row">
                        <div class="col-lg-8 align-items-center py-4">
                            <h6 class="h2 text-dark d-inline-block mb-0">User Management</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-block ">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item">
                                        <Link href="/">
                                        <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                        </Link>
                                    </li>
                                    <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                        User Management
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-4 text-right py-4" v-if="can('create_users')">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#newUserModal"
                                class="btn btn-sm btn-neutral float-end">
                                <font-awesome-icon icon="fa-solid fa-circle-plus" /> ADD NEW
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #content>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="py-3 mx-3 text-sm card-body">
                            <div class="flex">
                                <div class="flex items-center text-muted">
                                    Search:
                                    <div class="inline-block ml-2">
                                        <input type="text" class="form-control form-control-sm" v-model="search"
                                            @keyup="getSearch" />
                                    </div>
                                </div>
                                <div class="flex text-muted ml-auto">
                                    Show
                                    <div class="inline-block mx-2">
                                        <select class="form-control form-control-sm per-page-entry" :value="25"
                                            v-model="pageCount" @change="perPageChange">
                                            <option v-for="perPageCount in perPage" :key="perPageCount"
                                                :value="perPageCount" v-text="perPageCount" />
                                        </select>
                                    </div>
                                    entries
                                </div>
                            </div>
                        </div>

                        <div class="row mx-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th :class="textClassHead">Name</th>
                                            <th :class="textClassHead">Email</th>
                                            <th :class="textClassHead">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users" :key="user.id" :class="rowClass"
                                            @click.prevent="editUser(user.id)">
                                            <td :class="textClassBody">
                                                {{ user.name }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ user.email }}
                                            </td>
                                            <td :class="iconClassBody">
                                                <span v-if="user.deleted_at != null"
                                                    class="badge badge-danger">Inactive</span>
                                                <span v-if="user.deleted_at == null"
                                                    class="badge badge-success">Active</span> <i v-if="user.status == 1"
                                                    class="badge badge-info" aria-hidden="true">Active</i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="flex mt-1 mx-1 px-3 card-footer table-footer align-items-center">
                            <div class="col-sm-12 col-md-6 p-0">
                                <div class="dataTables_info column__left___padding" id="DataTables_Table_0_info"
                                    role="status" aria-live="polite">
                                    Showing {{ pagination.from }} to
                                    {{ pagination.to }} of
                                    {{ pagination.total }} entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 p-0">
                                <div class="dataTables_paginate paging_simple_numbers column__right___padding"
                                    id="DataTables_Table_0_paginate">
                                    <nav aria-label="Page navigation" style="float: right">
                                        <ul class="pagination">
                                            <li class="page-item" :class="pagination.current_page == 1 ? 'disabled' : ''">
                                                <a class="page-link" href="javascript:void(0)"
                                                    @click="setPage(pagination.current_page - 1)">
                                                    <i class="fa-solid fa-angles-left"></i>
                                                </a>
                                            </li>
                                            <template v-for="(page, index) in pagination.last_page">
                                                <template
                                                    v-if="page == 1 || page == pagination.last_page || Math.abs(page - pagination.current_page) < 5">
                                                    <li class="page-item" :key="index"
                                                        :class="pagination.current_page == page ? 'active' : ''">
                                                        <a class="page-link" @click="setPage(page)">{{ page }}</a>
                                                    </li>
                                                </template>
                                            </template>
                                            <li class="page-item"
                                                :class="pagination.current_page == pagination.last_page ? 'disabled' : ''">
                                                <a class="page-link" href="javascript:void(0)"
                                                    @click="setPage(pagination.current_page + 1)">
                                                    <i class="fa-solid fa-angles-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #modals>
            <div class="modal fade" id="newUserModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newUserModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                New User</h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="card-plain">
                                <div class="card-body m-2">
                                    <form role="form text-left" @submit.prevent="createUser" enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="user.name" placeholder="Name" required>
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="email" class="col-md-3 col-form-label">EMAIL</div>
                                            <div class="col-md-9">
                                                <input type="email" class="form-control form-control-sm" name="email"
                                                    id="email" v-model="user.email" placeholder="Email" required>
                                                <small v-if="validationErrors.email" id="msg_email"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.email
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="password" class="col-md-3 col-form-label">PASSWORD</div>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control form-control-sm" name="password"
                                                    id="password" v-model="user.password" placeholder="Password" required
                                                    autocomplete="new-password">
                                                <small v-if="validationErrors.password" id="inp_password"
                                                    class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.password
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2" v-if="can('create_users')">
                                            <button type="submit" class="btn btn-round btn-outline-primary btn-sm mb-0">
                                                <font-awesome-icon icon="fa-solid fa-floppy-disk" />
                                                CREATE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Multiselect from 'vue-multiselect';
import Swal from "sweetalert2";

import { library } from '@fortawesome/fontawesome-svg-core';
import { faHouse, faFloppyDisk, faXmark, faPlusCircle, } from '@fortawesome/free-solid-svg-icons';

export default {
    components: {
        AppLayout,
        Link,
        library,
        Multiselect,
    },
    data() {
        return {
            textClassHead: "text-start text-uppercase",
            textClassBody: "text-start",
            iconClassHead: "text-start",
            iconClassBody: "text-start",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [25, 50, 100],
            pageCount: 25,
            pagination: {},

            user: {},
            select_purchase_uom: null,
            select_stock_uom: null,
            units: [],
            select_type: null,
            userTypes: [],
            users: [],
        };
    },
    beforeMount() {
        library.add(faHouse);
        library.add(faFloppyDisk);
        library.add(faPlusCircle);
        library.add(faXmark);
        this.getUsers();
    },
    methods: {
        async setPage(page) {
            this.page = page;
            this.reload();
        },
        async getSearch() {
            this.page = 1;
            this.reload();
        },
        async perPageChange() {
            this.reload();
        },
        async reload() {
            const tableData = (
                await axios.get(route("user.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.users = tableData.data;
            this.pagination = tableData.meta;
        },
        async getUOMs() {
            const units = (await axios.get(route("measurement.all"))).data;
            this.units = units.data;
        },
        async getUsers() {
            const tableData = (await axios.get(route("user.all"))).data;
            this.users = tableData.data;
            this.pagination = tableData.meta;
        },
        async createUser() {
            this.resetValidationErrors();
            try {
                const user = (await axios.post(route("user.store"), this.user)).data;
                window.location.href = route('user.edit', user.id);
                $("#newUserModal").modal("hide");
                this.user = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "User created successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async editUser(userId) {
            // this.$inertia.visit(route('user.edit', userId));
            window.location.href = route('user.edit', userId);
        },
    },
}
</script>

<style lang="scss" scoped>
.breadcrumb-text {
    color: #6343e9 !important;
}
</style>
