<template>
    <AppLayout title="Warehouse Management - Edit">
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
                                        <li class="breadcrumb-item active text-info" aria-current="page">
                                            <Link :href="`/warehouses`" class="text-purple">
                                            Warehouse Management
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active text-info" aria-current="page">
                                            {{ this.warehouse.name }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #content>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-dark text-xxs font-weight-bolder opacity-7 text-start">
                                                Warehouse -
                                                {{ this.warehouse.name }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2">
                                                    <div class="warehouse_tree" id="warehouse_tree">
                                                        <ul>
                                                            <li id="level-1">
                                                                {{ this.warehouse.name }}
                                                                <span class="tool-box">
                                                                    <span @click.prevent="
                                                                        newLocation(this.warehouse.id)
                                                                        " class="ms-2 ml-3">
                                                                        <i class="fa-solid fa-circle-plus text-ash">
                                                                        </i>
                                                                    </span>
                                                                    <span @click.prevent="
                                                                        editWarehouse(this.warehouse.id)
                                                                        " class="ms-2 ml-2">
                                                                        <i class="fa-solid fa-pencil text-ash"> </i>
                                                                    </span>
                                                                    <!-- <span
                                                                        @click.prevent="deleteLocation(location.id)"
                                                                        class="ms-2 ml-2">
                                                                        <i class="fa-solid fa-trash text-ash">
                                                                        </i>
                                                                    </span> -->
                                                                </span>
                                                                <ul v-if="warehouseData.locations" class="ml-4">
                                                                    <li v-for="location in warehouseData.locations"
                                                                        class="mb-3" :key="location.id">
                                                                        {{ location.name }}
                                                                        <span class="tool-box">
                                                                            <span @click.prevent="
                                                                                newBin(this.warehouse.id, location.id)
                                                                                " class="ms-2 ml-3">
                                                                                <i class="fa-solid fa-circle-plus text-ash">
                                                                                </i>
                                                                            </span>
                                                                            <span @click.prevent="
                                                                                editLocation(location.id)
                                                                                " class="ms-2 ml-2">
                                                                                <i class="fa-solid fa-pencil text-ash">
                                                                                </i>
                                                                            </span>
                                                                            <span @click.prevent="
                                                                                deleteLocation(location.id)
                                                                                " class="ms-2 ml-2">
                                                                                <i class="fa-solid fa-trash text-ash">
                                                                                </i>
                                                                            </span>
                                                                        </span>
                                                                        <ul v-if="location.bins" class="ml-4">
                                                                            <li v-for="bin in location.bins" class="mt-2"
                                                                                :key="bin.id">
                                                                                {{ bin.name }}
                                                                                <span class="tool-box">
                                                                                    <span @click.prevent="editBin(bin.id)"
                                                                                        class="ms-2 ml-3">
                                                                                        <i
                                                                                            class="fa-solid fa-pencil text-ash">
                                                                                        </i>
                                                                                    </span>
                                                                                    <span @click.prevent="deleteBin(bin.id)"
                                                                                        class="ms-2 ml-2">
                                                                                        <i
                                                                                            class="fa-solid fa-trash text-ash">
                                                                                        </i>
                                                                                    </span>
                                                                                </span>
                                                                                <div class="row ml-3 mb-2">
                                                                                    <div class="col-md-2">
                                                                                        <span>Stock Remove</span>
                                                                                        <span v-if="bin.stock_remove == 1"
                                                                                            class="ml-2 text-success"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-check" /></span>
                                                                                        <span v-if="bin.stock_remove == 0"
                                                                                            class="ml-2 text-danger"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-xmark" /></span>
                                                                                    </div>
                                                                                    <div class="col-md-2 ml-3">
                                                                                        <span>Stock Putaway</span>
                                                                                        <span v-if="bin.stock_putaway == 1"
                                                                                            class="ml-2 text-success"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-check" /></span>
                                                                                        <span v-if="bin.stock_putaway == 0"
                                                                                            class="ml-2 text-danger"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-xmark" /></span>
                                                                                    </div>
                                                                                    <div class="col-md-2 ml-3">
                                                                                        <span>Stock Transfer</span>
                                                                                        <span v-if="bin.stock_transfer == 1"
                                                                                            class="ml-2 text-success"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-check" /></span>
                                                                                        <span v-if="bin.stock_transfer == 0"
                                                                                            class="ml-2 text-danger"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-xmark" /></span>
                                                                                    </div>
                                                                                    <div class="col-md-2 ml-3">
                                                                                        <span>Invoice Enable</span>
                                                                                        <span v-if="bin.invoice_enable == 1"
                                                                                            class="ml-2 text-success"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-check" /></span>
                                                                                        <span v-if="bin.invoice_enable == 0"
                                                                                            class="ml-2 text-danger"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-xmark" /></span>
                                                                                    </div>
                                                                                    <div class="col-md-2 ml-3">
                                                                                        <span>Quarantine</span>
                                                                                        <span v-if="bin.quarantine == 1"
                                                                                            class="ml-2 text-success"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-check" /></span>
                                                                                        <span v-if="bin.quarantine == 0"
                                                                                            class="ml-2 text-danger"><font-awesome-icon
                                                                                                icon="fa-solid fa-circle-xmark" /></span>
                                                                                    </div>
                                                                                </div>
                                                                                <hr />
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #modals>
            <div class="modal fade" id="editWarehouseModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editWarehouseModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                Edit Warehouse
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
                                    <form role="form text-left" @submit.prevent="updateWarehouse"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="code" class="col-md-3 col-form-label">CODE</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="edit_warehouse.code" placeholder="Code" required />
                                                <small v-if="validationErrors.code" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.code }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="edit_warehouse.name" placeholder="Name" required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="address" class="col-md-3 col-form-label">
                                                ADDRESS
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" v-model="edit_warehouse.address"
                                                    class="form-control form-control-sm" name="address" id="address"
                                                    placeholder="Address" required />
                                                <small v-if="validationErrors.address" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.address }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="contact" class="col-md-3 col-form-label">
                                                CONTACT
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" v-model="edit_warehouse.contact"
                                                    class="form-control form-control-sm" name="contact" id="contact"
                                                    placeholder="Contact" required />
                                                <small v-if="validationErrors.contact" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.contact }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2" v-if="can('update_categories')">
                                            <button type="submit" class="btn btn-round btn-outline--info btn-sm mb-0">
                                                <font-awesome-icon icon="fa-solid fa-floppy-disk" />
                                                UPDATE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="newLocationModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newLocationModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                New Location
                            </h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0" id="new-location-content">
                            <div class="card-plain">
                                <div class="card-body m-3">
                                    <form>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" v-model="location.name"
                                                    class="form-control form-control-sm" name="name" id="name"
                                                    placeholder="Location Name" required />
                                            </div>
                                        </div>
                                        <div class="text-right mt-2">
                                            <button type="button" @click.prevent="createLocation"
                                                class="btn btn-sm btn-round btn-outline--info btn-md mb-0">
                                                <i class="fas fa-save"></i>
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
            <div class="modal fade" id="editLocationModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editLocationModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                Edit Location
                            </h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0" id="edit-location-content">
                            <div class="card-plain">
                                <div class="card-body m-3">
                                    <form>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" v-model="this.location_edit.name"
                                                    class="form-control form-control-sm" name="name" id="name"
                                                    placeholder="Location Name" required />
                                            </div>
                                        </div>
                                        <div class="text-right mt-2">
                                            <button type="button" @click.prevent="updateLocation"
                                                class="btn btn-sm btn-round btn-outline--info btn-md mb-0">
                                                <i class="fas fa-save"></i>
                                                UPDATE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="newBinModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newBinModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                New Bin
                            </h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0" id="new-location-content">
                            <div class="card-plain">
                                <div class="card-body m-3">
                                    <form>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">NAME</div>
                                            <div class="col-md-8">
                                                <input type="text" v-model="bin.name" class="form-control form-control-sm"
                                                    name="name" id="name" placeholder="Bin Name" required />
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                STOCK REMOVE
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin.stock_remove == 1"
                                                        v-model="bin.stock_remove" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                STOCK PUTAWAY
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin.stock_putaway == 1"
                                                        v-model="bin.stock_putaway" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                STOCK TRANSFER
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin.stock_transfer == 1"
                                                        v-model="bin.stock_transfer" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                INVOICE ENABLE
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin.invoice_enable == 1"
                                                        v-model="bin.invoice_enable" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                QUARANTINE
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin.quarantine == 1"
                                                        v-model="bin.quarantine" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2">
                                            <button type="button" @click.prevent="createBin"
                                                class="btn btn-sm btn-round btn-outline--info btn-md mb-0">
                                                <i class="fas fa-save"></i>
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
            <div class="modal fade" id="editBinModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editBinModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                Edit Bin
                            </h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0" id="new-location-content">
                            <div class="card-plain">
                                <div class="card-body m-3">
                                    <form>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" v-model="bin_edit.name"
                                                    class="form-control form-control-sm" name="name" id="name"
                                                    placeholder="Location Name" required />
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                STOCK REMOVE
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin_edit.stock_remove == 1"
                                                        v-model="bin_edit.stock_remove" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                STOCK PUTAWAY
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin_edit.stock_putaway == 1"
                                                        v-model="bin_edit.stock_putaway" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                STOCK TRANSFER
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin_edit.stock_transfer == 1"
                                                        v-model="bin_edit.stock_transfer" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                INVOICE ENABLE
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin_edit.invoice_enable == 1"
                                                        v-model="bin_edit.invoice_enable" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-4 col-form-label">
                                                QUARANTINE
                                            </div>
                                            <div class="col-md-8">
                                                <label class="switch">
                                                    <input type="checkbox" :checked="bin_edit.quarantine == 1"
                                                        v-model="bin_edit.quarantine" v-bind:id="bin.id" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2">
                                            <button type="button" @click.prevent="updateBin"
                                                class="btn btn-sm btn-round btn-outline--info btn-md mb-0">
                                                <i class="fas fa-save"></i>
                                                UPDATE
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
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import Swal from "sweetalert2";

import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faHouse,
    faFloppyDisk,
    faCircleXmark,
    faCircleCheck,
    faXmark,
    faPlusCircle,
    faTrash,
    faPen,
} from "@fortawesome/free-solid-svg-icons";

export default {
    components: {
        AppLayout,
        Link,
        library,
    },
    props: {
        warehouse: Object,
    },
    // setup() {
    //     const warehouse = computed(() => usePage().props.value.warehouse)

    //     return {
    //         warehouse,
    //     }
    // },
    computed: {},
    data() {
        return {
            location: {},
            location_edit: {},
            bin: {},
            bin_edit: {},
            locations: [],
            warehouseData: {},
            edit_warehouse: {},
        };
    },
    beforeMount() {
        library.add(faHouse);
        library.add(faPen);
        library.add(faFloppyDisk);
        library.add(faPlusCircle);
        library.add(faXmark);
        library.add(faTrash);
        library.add(faCircleCheck);
        library.add(faCircleXmark);
        this.getWarehouse();
        this.treeInitialize();
    },
    watch: {
        stock_remove: function (val) {
            val ? console.log(val) : "";
        },
    },
    methods: {
        async treeInitialize() {
            // $('#warehouse_tree').jstree({
            //     'core': {
            //         'themes': {
            //             'responsive': false
            //         }
            //     },
            //     'types': {
            //         'default': {
            //             'icon': 'fa fa-folder'
            //         }
            //     },
            //     'plugins': ['types', 'dnd'],
            // });
            // $("#warehouse_tree").jstree('open_all');
        },
        async getWarehouse() {
            const warehouse = (
                await axios.get(route("warehouses.get.relations", this.warehouse.id))
            ).data;
            this.warehouseData = warehouse.data;
            this.treeInitialize();
        },

        async editWarehouse(id) {
            this.resetValidationErrors();
            try {
                const warehouse = (await axios.get(route("warehouses.get", id))).data;
                this.edit_warehouse = warehouse.data;
                $("#editWarehouseModal").modal("show");
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async updateWarehouse() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route("warehouses.update", this.edit_warehouse.id),
                    this.edit_warehouse
                );
                $("#editWarehouseModal").modal("hide");
                this.edit_warehouse = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Warehouse updated successfully",
                });
                this.getWarehouse();
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },

        async newLocation(warehouse_id) {
            this.resetValidationErrors();
            this.location = {};
            this.location.warehouse_id = warehouse_id;
            $("#newLocationModal").modal("show");
        },
        async newBin(warehouse_id, location_id) {
            this.resetValidationErrors();
            this.bin = {};
            this.bin.quarantine = 1;
            this.bin.stock_remove = 1;
            this.bin.stock_putaway = 1;
            this.bin.stock_transfer = 1;
            this.bin.invoice_enable = 1;
            this.bin.warehouse_id = warehouse_id;
            this.bin.location_id = location_id;
            $("#newBinModal").modal("show");
        },
        async createLocation() {
            this.resetValidationErrors();
            try {
                await axios.post(route("warehouse.location.store"), this.location);
                $("#newLocationModal").modal("hide");
                this.location = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Location created successfully",
                });
                this.getWarehouse();
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async createBin() {
            this.resetValidationErrors();
            try {
                // console.log(this.bin);
                await axios.post(route("warehouse.location.bin.store"), this.bin);
                $("#newBinModal").modal("hide");
                this.bin = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Bin created successfully",
                });
                this.getWarehouse();
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },

        async editLocation(location_id) {
            this.resetValidationErrors();
            try {
                const data = await axios.get(
                    route("warehouse.location.get", location_id)
                );
                this.location_edit = data.data;
                $("#editLocationModal").modal("show");
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async updateLocation() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route("warehouse.location.update", this.location_edit.id),
                    this.location_edit
                );
                $("#editLocationModal").modal("hide");
                this.location_edit = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Location updated successfully",
                });
                this.getWarehouse();
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async deleteLocation(id) {
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
                            .delete(route("warehouse.location.delete", id))
                            .then((response) => {
                                this.getWarehouse();
                            });
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },

        async editBin(bin_id) {
            this.resetValidationErrors();
            try {
                const data = await axios.get(
                    route("warehouse.location.bin.get", bin_id)
                );
                this.bin_edit = data.data;
                $("#editBinModal").modal("show");
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async updateBin() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route("warehouse.location.bin.update", this.bin_edit.id),
                    this.bin_edit
                );
                $("#editBinModal").modal("hide");
                this.bin_edit = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Bin updated successfully",
                });
                this.getWarehouse();
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async deleteBin(id) {
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
                            .delete(route("warehouse.location.bin.delete", id))
                            .then((response) => {
                                this.getWarehouse();
                            });
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
    },
};
</script>

<style lang="scss">
/* The switch - the box around the slider */
.switch {
    position: relative;
    display: inline-block;
    width: 45px;
    height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 2px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
}

input:checked+.slider {
    background-color: #2196f3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196f3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
