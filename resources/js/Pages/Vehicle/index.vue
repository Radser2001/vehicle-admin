<template>
    <AppLayout title="Vendor Management">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center mb-1 mt-1">
                            <div class="col-lg-8">
                                <h6 class="h2 text-dark d-inline-block mb-0">vehicle</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-block">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item">
                                            <Link href="/">
                                            <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                           vehicle Management
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <!-- <div class="col-lg-4 text-right py-4" v-if="can('create_vendor')"> -->
                                <div class="col-lg-4 text-right py-4" >
                                <a href="javascript:void(0)" @click.prevent="newvehicle"
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
                        <div class="row my-3 mx-2">
                            <div class="col-md-2 column__right___padding">
                                <div for="purchase_uom" class="col-form-label">CODE</div>
                                <input type="text" class="form-control form-control-sm" name="code" id="code"
                                    v-model="search_vehicle.code" placeholder="Code" @keyup="getSearch" />
                            </div>
                            <div class="col-md-2 column__right___padding column__left___padding">
                                <div for="purchase_uom" class="col-form-label">NAME</div>
                                <input type="text" class="form-control form-control-sm" name="name" id="name"
                                    v-model="search_vehicle.name" placeholder="vehicle's Name" @keyup="getSearch" />
                            </div>
                             <div class="col-md-2 column__right___padding column__left___padding">
                                <div for="purchase_uom" class="col-form-label">Contact</div>
                                <input type="text" class="form-control form-control-sm" name="contact" id="contact"
                                    v-model="search_vehicle.Contact" placeholder="vehicle's Name" @keyup="getSearch" />
                            </div>
                            <div class="col-md-2 mt-4 column__left___padding">
                                <a href="javascript:void(0)" @click.prevent="clearFilters"
                                    class="btn btn-sm btn-ash float-end mt-2 pt-2">
                                    CLEAR
                                </a>
                            </div>
                            <div class="text-muted ml-auto mx-4 mt-4">
                                <div class="inline-block">
                                    <select class="form-control form-control-sm per-page-entry mt-2" :value="100"
                                        v-model="pageCount" @change="perPageChange">
                                        <option v-for="perPageCount in perPage" :key="perPageCount" :value="perPageCount"
                                            v-text="perPageCount" />
                                    </select>
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
                                        <div class="p-2 border icon_item" v-if="can('active_vendor')">
                                            <a @click.prevent="activeSelectedItems(checkvehicleItems)">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-check"
                                                    color="#0bd018" />
                                            </a>
                                        </div>
                                        <!-- <div class="p-2 border icon_item" v-if="can('inactive_vendor')"> -->
                                            <div class="p-2 border icon_item" >
                                            <a @click.prevent="inactiveSelectedItems(checkvehicleItems)">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-minus"
                                                    color="#eb0505" />
                                            </a>
                                        </div>
                                        <!-- <div class="p-2 border icon_item" v-if="this.checkvehicleItems.length > 0 && can('delete_vendor')"> -->
                                            <div class="p-2 border icon_item" v-if="this.checkvehicleItems.length > 0 ">
                                            <a href="javascript:void(0)"
                                                @click.prevent="deleteSelectedItems(checkvehicleItems)">
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
                                                   v-if="this.vehicle.length > 0" :checked="this.checkAllItems.length==this.checkvehicleItems.length"  v-model="checkAllItems" />
                                                </div>
                                            </th>
                                            <th :class="iconClassHead">Condition</th>
                                            <th :class="iconClassHead">Make</th>
                                            <th :class="textClassHead">Model</th>
                                            <th :class="textClassHead">Year</th>
                                            <th :class="textClassHead">Color</th>
                                            <th :class="textClassHead">Mileage</th>
                                            <th :class="textClassHead">Fuel Type</th>
                                            <th :class="textClassHead">Price</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="vehicle in vehicles" :key="vehicle.id" :class="rowClass">
                                            <td class="checkArea">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="checkvehicleItems" v-bind:value="vehicle"
                                                        v-bind:id="vehicle.id" />
                                                </div>
                                            </td>
                                            <td :class="iconClassBody" class="pt-2">
                                                <label v-if="vehicle.condition > 1"
                                                    class="badge bg-success text-white fw-bold">Active</label>
                                                <label v-if="vehicle.condition == 0"
                                                    class="badge bg-warning text-white fw-bold">Inactive</label>
                                            </td>
                                            <td :class="textClassBody">
                                                {{ vehicle.make }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ vehicle.model }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ vehicle.year }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ vehicle.color }}
                                            </td>
                                             <td :class="textClassBody">
                                                {{ vehicle.mileage }}
                                            </td>
                                             <td :class="textClassBody">
                                                {{ vehicle.fuel_type }}
                                            </td>
                                             <td :class="textClassBody">
                                                {{ vehicle.price }}
                                            </td>
                                            <td :class="textClassBody" >
                                                <a href="javascript:void(0)" @click.prevent="editvehicle(vehicle.id)">
                                                    <font-awesome-icon icon="fa-solid fa-pen" class="text-ash" />
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex mt-1 px-3 mx-1 card-footer table-footer align-items-center">
                            <div class="col-sm-12 col-md-6 p-0">
                                <div class="dataTables_info column__left___padding" id="DataTables_Table_0_info"
                                    role="status" aria-live="polite">
                                    Showing {{ pagination.from }} to {{ pagination.to }} of
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
                                                <template v-if="page == 1 ||
                                                    page == pagination.last_page ||
                                                    Math.abs(page - pagination.current_page) < 5
                                                    ">
                                                    <li class="page-item" :key="index" :class="pagination.current_page == page ? 'active' : ''
                                                        ">
                                                        <a class="page-link" @click="setPage(page)">{{
                                                            page
                                                        }}</a>
                                                    </li>
                                                </template>
                                            </template>
                                            <li class="page-item" :class="pagination.current_page == pagination.last_page
                                                    ? 'disabled'
                                                    : ''
                                                ">
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
            <div class="modal fade" id="newvehicleModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newVendorModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-mb" role="document">
                    <div class="modal-content p-2">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-text text-gradient" id="add_brandLabel">
                                New vehicle
                            </h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="fa fa-times"></i>
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="card-plain">
                                <div class="card-body">
                                    <form role="form text-left" @submit.prevent="createvehicle"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="code" class="col-md-3 col-form-label">CODE</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="vehicle.code" placeholder="Code" required />
                                            </div>

                                            <small v-if="validationErrors.name" id="msg_code"
                                                class="text-danger form-text text-error-msg error">{{ validationErrors.code
                                                }}</small>
                                        </div>
                                             <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="vehicle.name" placeholder="Name" required />
                                            </div>

                                            <small v-if="validationErrors.name" id="msg_name"
                                                class="text-danger form-text text-error-msg error">{{ validationErrors.name
                                                }}</small>
                                        </div>
                                             <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">EMAIL</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="email"
                                                    id="email" v-model="vehicle.email" placeholder="Email" required />
                                            </div>

                                            <small v-if="validationErrors.email" id="msg_name"
                                                class="text-danger form-text text-error-msg error">{{ validationErrors.email
                                                }}</small>
                                        </div>
                                             <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">CONTACT</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="contact"
                                                    id="contact" v-model="vehicle.contact" placeholder="Contact" required />
                                            </div>

                                            <small v-if="validationErrors.contact" id="msg_name"
                                                class="text-danger form-text text-error-msg error">{{ validationErrors.contact
                                                }}</small>
                                        </div>
                                             <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">ADDRESS</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="address"
                                                    id="address" v-model="vehicle.address" placeholder="Address" required />
                                            </div>

                                            <small v-if="validationErrors.address" id="msg_name"
                                                class="text-danger form-text text-error-msg error">{{ validationErrors.address
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">CITY</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="city" v-model="vehicle.city" placeholder="city" required />
                                            </div>

                                            <small v-if="validationErrors.city" id="msg_name"
                                                class="text-danger form-text text-error-msg error">{{ validationErrors.city
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">STATE</div>
                                            <div class="col-md-9">
                                                <input type="state" class="form-control form-control-sm" name="state"
                                                    id="state" v-model="vehicle.state" placeholder="State" required />
                                            </div>

                                            <small v-if="validationErrors.state" id="msg_name"
                                                class="text-danger form-text text-error-msg error">{{ validationErrors.state
                                                }}</small>
                                        </div>

                                        <div class="text-right mt-2" >
                                            <button type="submit" class="btn btn-round custom-button btn-sm mb-0">
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

import Multiselect from "vue-multiselect";

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
        Multiselect,
    },
    data() {
        return {
            textClassBody: "text-start",
            iconClassHead: "text-center",
            iconClassBody: "text-center",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [25, 50, 100],
            pageCount: 25,
            pagination: {},

            vehicle: {},
            select_country: null,
            select_currency: null,
            vehicles: [],
            checkvehicleItems: [],
            checkAllItems: false,

            search_vehicle: {},

        };
    },
    beforeMount() {
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


        this.getvehicles()
    },

    watch: {

        checkAllItems(value) {
            this.vehicles.forEach((item, index) => {
                if (index !== 0) {
                    item.selected = value;
                }
            });
            if (this.checkvehicleItems.length == this. vehicles.length) {
                this.checkvehicleItems = [];
            } else {
                this.checkvehicleItems = this.vendors;
            }
        },
        checkvehicleItems(value) {
            if (this.checkvehicleItems.length != this.vehicles.length) {
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
                await axios.get(route("vehicles.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                        search_vehicle_code: this.search_vehicle.code,
                        search_vehicle_name: this.search_vehicle.name,
                        search_vehicle_Contact: this.search_vehicle.Contact,

                    },
                })
            ).data;

            this.vehicles = tableData.data;
            this.pagination = tableData.meta;

            this.$root.loader.finish();
            },

            async getvehicles() {
                this.$nextTick(() => {
                    this.$root.loader.start();
                });
                const vehicles = (await axios.get(route("vehicles.all"))).data;
                this.vehicles= vehicles.data;
                this.pagination = vehicles.meta;
                this.$nextTick(() => {
                    this.$root.loader.finish();
                });
            },

            async createvehicle() {
                this.resetValidationErrors();
                try {

                    const vehicle = (await axios.post(route("vehicles.store"), this.vehicle))
                        .data;
                    window.location.href = route("vehicles.edit", vehicle.id);
                    $("#newVendorModal").modal("hide");
                    this.vehicle= {};
                    this.$root.notify.success({
                        title: "Success",
                        message: "vehicle created successfully",
                    });
                } catch (error) {
                    this.convertValidationNotification(error);
                }
            },

            async editvehicle(vehicleId) {

            window.location.href = route("vehicles.edit", vehicleId);
        },

            async newvehicle() {
                this.$root.loader.start();
                this.vehicle= {};
                $("#newvehicleModal").modal("show");
                this.$root.loader.finish();
            },

            async clearFilters() {
                this.search_vendor = {};
                this.reload();
            },

            async inactiveSelectedItems(checkvehicleItems) {
            this.$root.loader.start();
            const ids = this.checkvehicleItems.map((checkvehicleItems) =>this.vehicle.id);
            axios.post(route("vehicles.inactive.selected"), { ids })
                .then((response) => {
                    this.checkVendorItems = [];
                    this.reload();
                });
            this.$root.loader.finish();
            },

            async activeSelectedItems(checkvehicleItems) {
                this.$root.loader.start();
                const ids = this.checkvehicleItems.map((vehicle) => vehicle.id);
                axios.post(route("vehicles.active.selected"), { ids }).then((response) => {
                    this.checkVendorItems = [];
                    this.reload();
                });
                this.$root.loader.finish();
            },

            selectAll: function (event) {
                if (event.target.checked == false) {
                    this.checkVendorItems = [];
                } else {
                    this.vehicle.forEach((vehicle) => {
                        this.checkVendorItems.push(vehicle.id);
                    });
                }
            },


            async deleteSelectedItems(checkvehicleItems) {
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
                            const ids = this.checkVendorItems.map((vehicle) => vehicle.id);
                            axios.post(route("vehicles.delete.selected"), { ids })
                                .then((response) => {
                                    this.reload();
                                });
                            // Swal.fire(
                            //     "Deleted!",
                            //     `Vendor has been deleted.`,
                            //     "success"
                            // );
                        }
                    });
                    this.$root.loader.finish();
                } catch (error) {
                    this.convertValidationNotification(error);
                }
        },


        }

};
</script>

<style lang="scss" scoped>
.breadcrumb-text {
    color: #6343e9 !important;
}

.custom-button {
    background-color: #ffffff;
    border-color: #6343e9;
    color: #6343e9 !important;
}

.custom-button:hover {
    background-color: #6343e9;
    color: #ffffff !important;
}


</style>
