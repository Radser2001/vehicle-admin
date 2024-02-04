<template>
    <AppLayout title="Tax Management">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center mb-3 mt-3">
                            <div class="col-lg-8">
                                <h6 class="h2 text-dark d-inline-block mb-0">Tax</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-block">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item">
                                            <Link :href="route('dashboard')">
                                            <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                            Tax
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-4 text-right" v-if="can('create_tax')">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#newTaxModal"
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
                                        <div class="p-2 border icon_item" v-if="can('active_tax')">
                                            <a @click.prevent="activeSelectedItems">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-check"
                                                    color="#0bd018" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="can('inactive_tax')">
                                            <a @click.prevent="inactiveSelectedItems">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-minus"
                                                    color="#eb0505" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="this.checkTaxItems.length > 0 && can('delete_tax')">
                                            <a href="javascript:void(0)"
                                                @click.prevent="deleteSelectedItems(checkTaxItems)">
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
                                        <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#newMaterialModal">
                                            <div class="p-2 border icon_item">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-square-plus"
                                                    color="#306ed9" />
                                            </div>
                                        </a> -->
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="checkArea">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox"
                                                    v-if="this.taxes.length > 0"  :checked="this.checkAllItems.length==this.checkTaxItems.length" v-model="checkAllItems" />
                                                </div>
                                            </th>
                                            <th class="text-center">STATUS</th>
                                            <th :class="textClassHead">Name</th>
                                            <th :class="textClassHead">Type</th>
                                            <th :class="textClassHead" class="text_align_end">
                                                Value
                                            </th>
                                            <th :class="textClassHead"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="tax in taxes" :key="tax.id" :class="rowClass">
                                            <td class="checkArea">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox" v-model="checkTaxItems"
                                                        v-bind:value="tax" v-bind:id="tax.id" />
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span v-if="tax.status == 1"
                                                    class="badge bg-success text-white fw-bold">Active</span>
                                                <span v-if="tax.status == 0"
                                                    class="badge bg-warning text-white fw-bold">Deactive</span>
                                            </td>
                                            <td :class="textClassBody">
                                                {{ tax.name }}
                                            </td>
                                            <td :class="textClassBody">
                                                <span v-if="tax.value_type == 0">Value</span>
                                                <span v-if="tax.value_type == 1">Percentage</span>
                                            </td>
                                            <td :class="textClassBody" class="text_align_end">
                                                {{ formatPrice(tax.value) }}
                                            </td>
                                            <td :class="iconClassBody">
                                                <a href="javascript:void(0)" v-if="can('update_tax')" @click.prevent="editTax(tax.id)"
                                                    class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-pen" class="text-ash" />
                                                </a>
                                                <a href="javascript:void(0)" v-if="can('delete_tax')" @click.prevent="deleteTax(tax.id)"
                                                    class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-trash" class="text-ash" />
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
            <div class="modal fade" id="newTaxModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newTaxModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                New Tax
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
                                    <form role="form text-left" @submit.prevent="createTax" enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="tax.name" placeholder="Name" required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="value" class="col-md-3 col-form-label">
                                                VALUE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" step="any" class="form-control form-control-sm"
                                                    name="value" id="value" v-model="tax.value" placeholder="Value"
                                                    required />
                                                <small v-if="validationErrors.value" id="msg_value"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.value }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="value" class="col-md-3 col-form-label">
                                                VALUE TYPE
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control form-control-sm" v-model="tax.value_type"
                                                    name="value_types" id="value_types">
                                                    <option value="1" selected>Percentage</option>
                                                    <option value="0">Value</option>
                                                </select>
                                                <small v-if="validationErrors.value_type" id="msg_value"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.value_type }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2" v-if="can('create_tax')">
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

            <div class="modal fade" id="editTaxModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editTaxModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder text-info text-gradient" id="add_brandLabel">
                                Edit Tax
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
                                    <form role="form text-left" @submit.prevent="updateTax" enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="this.edit_tax.name" placeholder="Name" required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="value" class="col-md-3 col-form-label">
                                                VALUE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="value"
                                                    id="value" v-model="this.edit_tax.value" placeholder="Value" required />
                                                <small v-if="validationErrors.value" id="msg_value"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.value }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="value" class="col-md-3 col-form-label">
                                                VALUE TYPE
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control form-control-sm"
                                                    v-model="this.edit_tax.value_type" name="value_types" id="value_types">
                                                    <option value="1">Percentage</option>
                                                    <option value="0">Value</option>
                                                </select>
                                                <small v-if="validationErrors.value_type" id="msg_value"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.value_type }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2" v-if="can('update_tax')">
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
            iconClassHead: "text-right",
            iconClassBody: "text-right",
            rowClass: "cursor-pointer",
            textClassRight: "text-right",

            search: null,
            page: 1,
            perPage: [25, 50, 100],
            pageCount: 25,
            pagination: {},
            tax: {},
            taxes: [],
            edit_tax: {},
            checkTaxItems: [],
            checkAllItems: false,
        };
    },
    beforeMount() {
        this.getTaxes();
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
            this.taxes.forEach((item, index) => {
                if (index !== 0) {
                    item.selected = value;
                }
            });
            if (this.checkTaxItems.length == this.taxes.length) {
                this.checkTaxItems = [];
            } else {
                this.checkTaxItems = this.taxes;
            }
        },
        checkTaxItems(value) {
            if (this.checkTaxItems.length !== this.taxes.length) {
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
                await axios.get(route("tax.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.taxes = tableData.data;
            this.pagination = tableData.meta;
            this.$root.loader.finish();
        },

        formatPrice(value) {
            let val = (value / 1).toFixed(2).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        async createTax() {
            this.resetValidationErrors();
            try {
                this.tax.slug = this.tax.name;
                await axios.post(route("tax.store"), this.tax);
                this.reload();
                $("#newTaxModal").modal("hide");
                this.tax = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "tax created successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async getTaxes() {
            this.$nextTick(() => {
                this.$root.loader.start();
            });
            const tableData = (await axios.get(route("tax.all"))).data;
            this.taxes = tableData.data;
            this.pagination = tableData.meta;
            this.$nextTick(() => {
                this.$root.loader.finish();
            });
        },
        async deleteTax(id) {
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
                        axios.delete(route("tax.delete", id)).then((response) => {
                            this.reload();
                        });
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },

        async deleteSelectedItems(checkTaxItems) {
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
                        const ids = this.checkTaxItems.map((tax) => tax.id);
                        axios
                            .post(route("tax.delete.selected", checkTaxItems), {
                                ids,
                            })
                            .then((response) => {
                                this.reload();
                            });
                        this.checkAllItems = false;
                        // Swal.fire(
                        //     "Deleted!",
                        //     `Tax has been deleted.`,
                        //     "success"
                        // );
                    }
                });
                this.$root.loader.finish();
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async editTax(id) {
            this.resetValidationErrors();
            try {
                const tax = (await axios.get(route("tax.get", id))).data;
                this.edit_tax = tax;
                $("#editTaxModal").modal("show");
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async updateTax() {
            this.resetValidationErrors();
            try {
                this.edit_tax.slug = this.edit_tax.name;
                await axios.post(route("tax.update", this.edit_tax.id), this.edit_tax);
                this.reload();
                $("#editTaxModal").modal("hide");
                this.edit_tax = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "tax updated successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async inactiveSelectedItems() {
            this.$root.loader.start();
            const ids = this.checkTaxItems.map((tax) => tax.id);
            axios.post(route("tax.inactive.selected"), { ids }).then((response) => {
                this.reload();
            });
            this.checkTaxItems = [];
            this.checkAllItems = false;
            this.$root.loader.finish();
        },
        async activeSelectedItems() {
            this.$root.loader.start();
            const ids = this.checkTaxItems.map((tax) => tax.id);
            axios.post(route("tax.active.selected"), { ids }).then((response) => {
                this.reload();
            });
            this.checkTaxItems = [];
            this.checkAllItems = false;
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
