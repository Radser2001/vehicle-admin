<template>
    <AppLayout title="Warehouse Management">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center mb-3 mt-3">
                            <div class="col-lg-8">
                                <h6 class="h2 text-dark d-inline-block mb-0">
                                    Warehouse Management
                                </h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-block">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item">
                                            <Link :href="route('dashboard')">
                                            <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                            Warehouse Management
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-4 text-right" v-if="can('create_warehouses')">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#newWarehouseModal"
                                    class="btn btn-sm btn-neutral float-end">
                                    <font-awesome-icon icon="fa-solid fa-circle-plus" />
                                    ADD NEW
                                </a>
                            </div>
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
                                    <div class="inline-block mx-2">
                                        <select class="form-control form-control-sm per-page-entry" :value="25"
                                            v-model="pageCount" @change="perPageChange">
                                            <option v-for="perPageCount in perPage" :key="perPageCount"
                                                :value="perPageCount" v-text="perPageCount" />
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-4">
                            <div class="table-responsive">
                                <div class="d-flex flex-row mb-3 rounded">
                                    <div class="left d-flex">
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-clone"
                                                color="#505050" />
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon"
                                                icon="fa-solid fa-arrow-up-from-bracket" color="#505050" />
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-cloud-arrow-down"
                                                color="#505050" />
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-wrench"
                                                rotation="{270}" color="#505050" />
                                        </div>
                                        <div class="p-2 border icon_item" v-if="can('active_warehouses')">
                                            <a @click.prevent="
                                                activeSelectedItems(
                                                    checkWareItems
                                                )
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-check"
                                                    color="#0bd018" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="can('inactive_warehouses')">
                                            <a @click.prevent="
                                                inactiveSelectedItems(
                                                    checkWareItems
                                                )
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-minus"
                                                    color="#eb0505" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="this.checkWareItems.length > 0 && can('delete_warehouses')">
                                            <a href="javascript:void(0)"  @click.prevent="
                                                deleteSelectedItems(
                                                    checkWareItems
                                                )
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-trash"
                                                    color="#eb0505" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="right d-flex ml-auto">
                                        <div class="p-2 border icon_item">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-print"
                                                color="#505050" />
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="checkArea">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox" @click="selectAll"
                                                    v-if="this.warehouses.length > 0" :checked="this.checkAllItems.length==this.checkWareItems.length"  v-model="checkAllItems" />
                                                </div>
                                            </th>
                                            <th :class="iconClassHead">
                                                STATUS
                                            </th>
                                            <th :class="textClassHead">Code</th>
                                            <th :class="textClassHead">Name</th>
                                            <th :class="textClassHead">
                                                Contact
                                            </th>
                                            <th :class="textClassHead">
                                                Address
                                            </th>
                                            <th :class="textClassHead"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="warehouse in warehouses" :key="warehouse.id" :class="rowClass">
                                            <td class="checkArea">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox" v-model="checkWareItems"
                                                        v-bind:value="warehouse" v-bind:id="warehouse.id" />
                                                </div>
                                            </td>
                                            <td :class="iconClassBody">
                                                <span v-if="warehouse.status == 1"
                                                    class="badge bg-success text-white fw-bold">Active</span>
                                                <span v-if="warehouse.status == 0"
                                                    class="badge bg-warning text-white fw-bold">Deactive</span>
                                            </td>
                                            <td :class="textClassBody">
                                                {{ warehouse.code }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ warehouse.name }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ warehouse.contact }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ warehouse.address }}
                                            </td>
                                            <td :class="iconClassBody">
                                                <a href="javascript:void(0)" v-if="can('update_warehouses')" @click.prevent="
                                                    editWarehouse(
                                                        warehouse.id
                                                    )
                                                    " class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-pen" class="text-ash text-right" />
                                                </a>
                                                <a href="javascript:void(0)" v-if="can('delete_warehouses')" @click.prevent="
                                                    deleteWarehouse(
                                                        warehouse.id
                                                    )
                                                    " class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-trash"
                                                        class="text-ash text-right" />
                                                </a>
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
                                            <li class="page-item" :class="pagination.current_page == 1
                                                    ? 'disabled'
                                                    : ''
                                                ">
                                                <a class="page-link" href="javascript:void(0)" @click="
                                                    setPage(
                                                        pagination.current_page -
                                                        1
                                                    )
                                                    ">
                                                    <i class="fa-solid fa-angles-left"></i>
                                                </a>
                                            </li>
                                            <template v-for="(
                                                    page, index
                                                ) in pagination.last_page">
                                                <template v-if="page == 1 ||
                                                    page ==
                                                    pagination.last_page ||
                                                    Math.abs(
                                                        page -
                                                        pagination.current_page
                                                    ) < 5
                                                    ">
                                                    <li class="page-item" :key="index" :class="pagination.current_page ==
                                                            page
                                                            ? 'active'
                                                            : ''
                                                        ">
                                                        <a class="page-link" @click="
                                                            setPage(page)
                                                            ">{{ page }}</a>
                                                    </li>
                                                </template>
                                            </template>
                                            <li class="page-item" :class="pagination.current_page ==
                                                    pagination.last_page
                                                    ? 'disabled'
                                                    : ''
                                                ">
                                                <a class="page-link" href="javascript:void(0)" @click="
                                                    setPage(
                                                        pagination.current_page +
                                                        1
                                                    )
                                                    ">
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
            <div class="modal fade" id="newWarehouseModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newWarehouseModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                New Warehouse
                            </h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="card-plain">
                                <div class="card-body m-2">
                                    <form role="form text-left" @submit.prevent="createWarehouses"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="code" class="col-md-3 col-form-label">
                                                CODE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="warehouse.code" placeholder="Code" required />
                                                <small v-if="validationErrors.code" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.code
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">
                                                NAME
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="warehouse.name" placeholder="Name" required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="address" class="col-md-3 col-form-label">
                                                ADDRESS
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" v-model="warehouse.address"
                                                    class="form-control form-control-sm" name="address" id="address"
                                                    placeholder="Address" required />
                                                <small v-if="validationErrors.address
                                                    " id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.address
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="contact" class="col-md-3 col-form-label">
                                                CONTACT
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" v-model="warehouse.contact"
                                                    class="form-control form-control-sm" name="contact" id="contact"
                                                    placeholder="Contact" required />
                                                <small v-if="validationErrors.contact
                                                    " id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.contact
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2" v-if="can('create_warehouses')">
                                            <button type="submit" class="btn btn-round btn-outline--info btn-sm mb-0">
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
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import Swal from "sweetalert2";

import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faHouse,
    faFloppyDisk,
    faCirclePlus,
    faClone,
    faCloudArrowDown,
    faSquarePlus,
    faPrint,
    faWrench,
    faCircleCheck,
    faCircleMinus,
    faTrash,
    faArrowUpFromBracket,
    faXmark,
    faPen,
} from "@fortawesome/free-solid-svg-icons";

export default {
    components: {
        AppLayout,
        Link,
        library,
    },
    data() {
        return {
            textClassHead: "text-start text-uppercase",
            textClassBody: "text-start",
            iconClassHead: "text-center",
            iconClassBody: "text-center",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [25, 50, 100],
            pageCount: 25,
            pagination: {},
            warehouse: {},
            warehouses: [],
            edit_warehouse: {},
            checkWareItems: [],
            checkAllItems: false,
        };
    },
    beforeMount() {
        this.getWarehouses();
        library.add(faHouse);
        library.add(faFloppyDisk);
        library.add(faCirclePlus);
        library.add(faClone);
        library.add(faCloudArrowDown);
        library.add(faSquarePlus);
        library.add(faPrint);
        library.add(faArrowUpFromBracket);
        library.add(faWrench);
        library.add(faCircleCheck);
        library.add(faCircleMinus);
        library.add(faTrash);
        library.add(faXmark);
        library.add(faPen);
    },
    watch: {
        checkAllItems(value) {
            this.warehouses.forEach((item, index) => {
                if (index !== 0) {
                    item.selected = value;
                }
            });
            if (this.checkWareItems.length == this.warehouses.length) {
                this.checkWareItems = [];
            } else {
                this.checkWareItems = this.warehouses;
            }
        },
        checkWareItems(value) {
            if (this.checkWareItems.length != this.warehouses.length) {
                this.checkAllItems = false;
            }
        },
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
            this.$root.loader.start();
            const tableData = (
                await axios.get(route("warehouses.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.warehouses = tableData.data;
            this.pagination = tableData.meta;
            this.$root.loader.finish();
        },

        async createWarehouses() {
            this.resetValidationErrors();
            try {
                await axios.post(route("warehouses.store"), this.warehouse);
                this.reload();
                $("#newWarehouseModal").modal("hide");
                this.warehouse = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Warehouse created successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async getWarehouses() {
            this.$nextTick(() => {
                this.$root.loader.start();
            });
            const tableData = (await axios.get(route("warehouses.all"))).data;
            this.warehouses = tableData.data;
            this.pagination = tableData.meta;
            this.$nextTick(() => {
                this.$root.loader.finish();
            });
        },

        async deleteWarehouse(id) {
            try {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#C00202", // Green
                    cancelButtonColor: "#6CA925", // Secondary Color
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .delete(route("warehouses.delete", id))
                            .then((response) => {
                                this.reload();
                            });
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },

        selectAll: function (event) {
            if (event.target.checked == false) {
                this.checkWareItems = [];
            } else {
                this.warehouses.forEach((warehouse) => {
                    this.checkWareItems.push(warehouse.id);
                });
            }
        },

        async deleteSelectedItems(checkWareItems) {
            this.$root.loader.start();
            try {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#C00202", // Green
                    cancelButtonColor: "#6CA925", // Secondary Color
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const ids = this.checkWareItems.map(
                            (warehouse) => warehouse.id
                        );
                        axios
                            .post(
                                route(
                                    "warehouses.delete.selected",
                                    checkWareItems
                                ),
                                { ids }
                            )
                            .then((response) => {
                                this.reload();
                                // console.log('Items deleted successfully.')
                                // Update the list of items to reflect the changes
                            });
                        // Swal.fire(
                        //     "Deleted!",
                        //     `Warehouse has been deleted.`,
                        //     "success"
                        // );
                    }
                });
                this.$root.loader.finish();
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async editWarehouse(id) {
            window.location.href = route("warehouses.edit", id);
        },
        // async editWarehouse(id) {
        //     this.resetValidationErrors();
        //     try {
        //         const warehouse = (await axios.get(route('warehouses.get', id))).data
        //         this.edit_warehouse = warehouse.data
        //         $('#editWarehouseModal').modal('show')
        //     } catch (error) {
        //         this.convertValidationError(error)
        //     }
        // },
        // async updateWarehouse() {
        //     this.resetValidationErrors();
        //     try {
        //         await axios.post(route('warehouses.update', this.edit_warehouse.id), this.edit_warehouse);
        //         this.reload();
        //         $('#editWarehouseModal').modal('hide')
        //         this.edit_warehouse = {}
        //         this.$root.notify.success({
        //             title: 'Success',
        //             message: 'Warehouse updated successfully',
        //         })
        //     } catch (error) {
        //         this.convertValidationNotification(error)
        //     }
        // },
        async inactiveSelectedItems(checkWareItems) {
            this.$root.loader.start();
            const ids = this.checkWareItems.map((warehouse) => warehouse.id);
            axios
                .post(route("warehouses.inactive.selected"), { ids })
                .then((response) => {
                    this.checkWareItems = [];
                    this.reload();
                });
            this.$root.loader.finish();
        },
        async activeSelectedItems(checkWareItems) {
            this.$root.loader.start();
            const ids = this.checkWareItems.map((warehouse) => warehouse.id);
            axios
                .post(route("warehouses.active.selected"), { ids })
                .then((response) => {
                    this.checkWareItems = [];
                    this.reload();
                });
            this.$root.loader.finish();
        },
    },
};
</script>

<style lang="scss" scoped>
.breadcrumb-text {
    color: #6343e9 !important;
}
</style>
