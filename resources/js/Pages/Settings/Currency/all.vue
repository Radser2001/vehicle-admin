<template>
    <AppLayout title="Currency Management">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center mb-3 mt-3">
                            <div class="col-lg-8">
                                <h6 class="h2 text-dark d-inline-block mb-0">Currency</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-block">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item">
                                            <Link :href="route('dashboard')">
                                            <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                            Currency Registry
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-4 text-right" v-if="can('create_currencies')">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#newCurrencyModal"
                                    class="btn btn-sm btn-neutral float-end">
                                    <font-awesome-icon icon="fa-solid fa-circle-plus" />
                                    ADD NEW
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"></div>
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
                                <div class="col-lg-9">
                                    <div class="row mb-3 d-flex justify-content-end">
                                        <div for="category_id" class="col-md-3 text-right col-form-label">
                                            BASE CURRENCY
                                        </div>
                                        <div class="col-lg-4 text-right">
                                            <Multiselect v-model="this.select_base_currency" :options="currencies"
                                                :showLabels="false" :close-on-select="true" :clear-on-select="false"
                                                :searchable="true" placeholder="Select Base Currency" label="name"
                                                track-by="id" />
                                        </div>
                                    </div>
                                </div>
                                <div class="flex text-muted ml-auto mx-2">
                                    <div class="inline-block">
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
                                        <div class="p-2 border icon_item" v-if="can('active_currencies')">
                                            <a @click.prevent="activeSelectedItems(checkCurencyItems)">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-check"
                                                    color="#0bd018" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="can('inactive_currencies')">
                                            <a @click.prevent="
                                                inactiveSelectedItems(checkCurencyItems)
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-minus"
                                                    color="#eb0505" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="can('delete_currencies') && this.checkCurencyItems.length > 0">
                                            <a href="javascript:void(0)"
                                                @click.prevent="deleteSelectedItems(checkCurencyItems)">
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
                                                        v-if="this.currencies.length > 0"

                                                        v-model="checkAllItems" />
                                                </div>
                                            </th>
                                            <th class="text-center">Status</th>
                                            <th :class="textClassHead">Code</th>
                                            <th :class="textClassHead">Name</th>
                                            <th :class="valueClassHead">Rate</th>
                                            <th :class="iconClassHead"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="currency in currencies" :key="currency.id" :class="rowClass">
                                            <td>
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="checkCurencyItems" v-bind:value="currency"
                                                        v-bind:id="currency.id" />
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span v-if="currency.status == 1"
                                                    class="badge bg-success text-white fw-bold">Active</span>
                                                <span v-if="currency.status == 0"
                                                    class="badge bg-warning text-white fw-bold">Deactive</span>
                                            </td>
                                            <td :class="textClassBody">
                                                {{ currency.code }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ currency.name }}
                                            </td>
                                            <td :class="valueClassBody">
                                                {{ formatPrice(currency.rate) }}
                                            </td>
                                            <td :class="iconClassBody">
                                                <a href="javascript:void(0)" v-if="can('update_currencies')" @click.prevent="editCurrency(currency.id)"
                                                    class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-pen" class="text-ash" />
                                                </a>
                                                <a href="javascript:void(0)" v-if="can('delete_currencies')" @click.prevent="deleteCurrency(currency.id)"
                                                    class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-trash" class="text-ash" />
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
            <div class="modal fade" id="newCurrencyModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newCurrencyModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-text text-gradient" id="add_brandLabel">
                                New Currency
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
                                    <form role="form text-left" @submit.prevent="createCurrencies"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="code" class="col-md-3 col-form-label">CODE</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="currency.code" placeholder="Code" required />
                                                <small v-if="validationErrors.code" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.code }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="currency.name" placeholder="Name" required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="rate" class="col-md-3 col-form-label">
                                                EXCHANGE RATE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" v-model="currency.rate" step="any"
                                                    class="form-control form-control-sm" name="rate" id="rate"
                                                    placeholder="Exchange Rate" required />
                                                <small v-if="validationErrors.rate" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.rate }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2" v-if="can('create_currencies')">
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

            <div class="modal fade" id="editCurrencyModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editCurrencyModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-text text-gradient" id="add_brandLabel">
                                Edit Currency
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
                                    <form role="form text-left" @submit.prevent="updateCurrency"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="code" class="col-md-3 col-form-label">CODE</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="edit_currency.code" placeholder="Code" required />
                                                <small v-if="validationErrors.code" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.code }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="edit_currency.name" placeholder="Name" required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="rate" class="col-md-3 col-form-label">
                                                EXCHANGE RATE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" step="any" v-model="edit_currency.rate"
                                                    class="form-control form-control-sm" name="rate" id="rate"
                                                    placeholder="Exchange Rate" required />
                                                <small v-if="validationErrors.rate" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.rate }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2" v-if="can('update_currencies')">
                                            <button type="submit" class="btn btn-round btn-neutral btn-sm mb-0">
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
            textClassHead: "text-start text-uppercase",
            textClassBody: "text-start",
            valueClassBody: "text-right",
            valueClassHead: "text-right",
            iconClassHead: "text-right",
            iconClassBody: "text-right",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [25, 50, 100],
            pageCount: 25,
            pagination: {},
            currency: {},
            edit_currency: {},
            select_currency: null,
            base_currency: {},

            currencies: [],
            checkCurencyItems: [],
            checkAllItems: false,
            select_base_currency: null,
            old_currency: null,
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
        this.getCurrencies();
        this.getBaseCurrency();
    },
    watch: {
        "currency.code": function (val) {
            val ? (this.currency.code = val.toUpperCase()) : "";
        },
        "edit_currency.code": function (val) {
            val ? (this.edit_currency.code = val.toUpperCase()) : "";
        },
        select_base_currency: function (newVal) {
            // console.log(this.select_base_currency)
            // this.select_base_currency ? this.storeBaseCurrency() : '';
            if (newVal) {
                if (newVal != this.old_currency) {
                    this.storeBaseCurrency();
                }
            }
        },

        checkAllItems(value) {
            this.currencies.forEach((item, index) => {
                if (index !== 0) {
                    item.selected = value;
                }
            });
            if (this.checkCurencyItems.length == this.currencies.length) {
                this.checkCurencyItems = [];
            } else {
                this.checkCurencyItems = this.currencies;
            }
        },
        checkCurencyItems(value) {
            if (this.checkCurencyItems.length != this.currencies.length) {
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
                await axios.get(route("currency.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.currencies = tableData.data;
            this.pagination = tableData.meta;
            this.getBaseCurrency();
            this.$root.loader.finish();
        },

        async storeBaseCurrency() {
            this.resetValidationErrors();

            // console.log(this.base_currency.base_currency_id)
            try {
                // console.log(this.select_base_currency)
                if (this.select_base_currency ) {
                    this.base_currency.base_currency_id = this.select_base_currency.id;
                }
                await axios.post(route("currency.base.update"), this.base_currency);
                this.$root.notify.success({
                    title: "Success",
                    message: "Base currency stored successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async createCurrencies() {
            this.resetValidationErrors();
            try {
                await axios.post(route("currency.store"), this.currency);
                this.reload();
                $("#newCurrencyModal").modal("hide");
                this.currency = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Currency created successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async getCurrencies() {
            this.$nextTick(() => {
                this.$root.loader.start();
            });
            const tableData = (await axios.get(route("currency.all"))).data;
            this.currencies = tableData.data;
            this.pagination = tableData.meta;
            this.$nextTick(() => {
                this.$root.loader.finish();
            });
            console.log(this.currencies);
        },

        async getBaseCurrency() {
            // console.log('first')
            this.select_base_currency = (
                await axios.get(route("currency.base.get"))
            ).data;
            this.old_currency = this.select_base_currency;
        },

        async deleteCurrency(id) {
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
                        axios.delete(route("currency.delete", id)).then((response) => {
                            this.reload();
                        });
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async editCurrency(id) {
            this.resetValidationErrors();
            try {
                const currency = (await axios.get(route("currency.get", id))).data;
                this.edit_currency = currency.data;
                $("#editCurrencyModal").modal("show");
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async updateCurrency() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route("currency.update", this.edit_currency.id),
                    this.edit_currency
                );
                this.reload();
                $("#editCurrencyModal").modal("hide");
                this.edit_currency = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Currency updated successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },

        selectAll: function (event) {
            if (event.target.checked == false) {
                this.checkCurencyItems = [];
            } else {
                this.currencies.forEach((currency) => {
                    this.checkCurencyItems.push(currency.id);
                });
            }
        },

        formatPrice(value) {
            let val = (value / 1).toFixed(2).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        async deleteSelectedItems(checkCurencyItems) {
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
                        const ids = this.checkCurencyItems.map(
                            (currencies) => currencies.id
                        );
                        axios
                            .post(route("currency.delete.selected", checkCurencyItems), {
                                ids,
                            })
                            .then((response) => {
                                this.reload();
                                // console.log('Items deleted successfully.')
                                // Update the list of items to reflect the changes
                            });
                        // Swal.fire(
                        //     "Deleted!",
                        //     `Curency has been deleted.`,
                        //     "success"
                        // );
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async inactiveSelectedItems(checkCurencyItems) {
            const ids = this.checkCurencyItems.map((currency) => currency.id);
            axios
                .post(route("currency.inactive.selected"), { ids })
                .then((response) => {
                    this.checkCurencyItems = [];
                    this.base_currency = [];
                });
                this.getBaseCurrency();
                this.reload();
        },
        async activeSelectedItems(checkCurencyItems) {
            const ids = this.checkCurencyItems.map((currency) => currency.id);
            axios
                .post(route("currency.active.selected"), { ids })
                .then((response) => {
                    this.checkCurencyItems = [];
                });
                this.reload();
        },
    },
};
</script>

<style lang="scss" scoped>
.breadcrumb-text {
    color: #6343e9 !important;
}
</style>
