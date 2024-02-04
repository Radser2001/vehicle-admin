<template>
    <AppLayout title="Unit Conversion">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center mb-3 mt-3">
                            <div class="col-lg-8">
                                <h6 class="h2 text-dark d-inline-block mb-0">
                                    Unit Conversion Management
                                </h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-block">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item">
                                            <Link :href="route('dashboard')">
                                            <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                            Unit Conversion Management
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
                    <div class="card shadow">
                        <form @submit.prevent="createUnitConversion">
                            <div class="row py-4 px-3">
                                <div class="col-md-4 column__right___padding">
                                    <label class="label-head">FROM</label>
                                    <Multiselect v-model="this.select_unit_from" :options="this.units"
                                        :close-on-select="true" :clear-on-select="false" :searchable="true"
                                        placeholder="Select Unit" label="name" track-by="id" />
                                    <small v-if="validationErrors.from_unit_id" id="msg_from_unit_id"
                                        class="text-danger form-text text-error-msg error">{{
                                            validationErrors.from_unit_id
                                        }}</small>
                                </div>
                                <div class="col-md-4 column__left___padding column__right___padding">
                                    <label class="label-head">TO</label>
                                    <Multiselect v-model="this.select_unit_to" :options="this.units" :close-on-select="true"
                                        :clear-on-select="false" :searchable="true" placeholder="Select Unit" label="name"
                                        track-by="id" />
                                    <small v-if="validationErrors.to_unit_id" id="msg_to_unit_id"
                                        class="text-danger form-text text-error-msg error">{{
                                            validationErrors.to_unit_id
                                        }}</small>
                                </div>
                                <div class="col-md-2 column__left___padding column__right___padding">
                                    <label>Ratio</label>
                                    <div class="input-group">
                                        <input type="number" id="inp_measurements_ratio" name="ratio" step="any" min="0"
                                            v-model="conversion.ratio" class="form-control form-control-sm"
                                            placeholder="Ratio" required />
                                    </div>
                                    <small v-if="validationErrors.ratio" id="msg_conversion"
                                        class="text-danger form-text text-error-msg error">{{ validationErrors.ratio
                                        }}</small>
                                </div>
                                <div class="col-md-1 pt-1">
                                    <label for=""></label>
                                    <div class="input-group"  v-if="can('create_unit_conversions')">
                                        <button type="submit" class="btn btn-sm btn-outline--info mt-3">
                                            <i class="fa-solid fa-circle-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="column__left___padding pt-1 p_count_container ml-auto">
                                    <select class="form-control form-control-sm per-page-entry mt-4" :value="25"
                                        v-model="pageCount" @change="perPageChange">
                                        <option v-for="perPageCount in perPage" :key="perPageCount" :value="perPageCount"
                                            v-text="perPageCount" />
                                    </select>
                                </div>
                            </div>
                        </form>
                        <!-- <hr /> -->
                        <!-- <div class="py-3 text-sm card-body">
                            <div class="flex">
                                <div class="flex items-center text-muted">
                                    Search:
                                    <div class="inline-block ml-2">
                                        <input type="text" class="form-control form-control-sm" v-model="search"
                                            @keyup="getSearch" />
                                    </div>
                                </div>
                                <div class="flex text-muted ml-auto mx-3">
                                    <div class="inline-block">
                                        <select
                                            class="form-control form-control-sm per-page-entry"
                                            :value="25"
                                            v-model="pageCount"
                                            @change="perPageChange"
                                        >
                                            <option
                                                v-for="perPageCount in perPage"
                                                :key="perPageCount"
                                                :value="perPageCount"
                                                v-text="perPageCount"
                                            />
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="table-responsive">
                            <div class="d-flex flex-row mb-3 rounded">
                                <div class="left d-flex mx-2">
                                    <div class="p-2 border icon_item">
                                        <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-clone"
                                            color="#505050" />
                                    </div>
                                    <div class="p-2 border icon_item">
                                        <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-arrow-up-from-bracket"
                                            color="#505050" />
                                    </div>
                                    <div class="p-2 border icon_item">
                                        <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-cloud-arrow-down"
                                            color="#505050" />
                                    </div>
                                    <div class="p-2 border icon_item">
                                        <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-wrench" rotation="{270}"
                                            color="#505050" />
                                    </div>
                                    <div class="p-2 border icon_item" v-if="can('active_unit_conversions')">
                                        <a @click.prevent="
                                            activeSelectedItems(
                                                checkUcItems
                                            )
                                            ">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-check"
                                                color="#0bd018" />
                                        </a>
                                    </div>
                                    <div class="p-2 border icon_item" v-if="can('inactive_unit_conversions')">
                                        <a @click.prevent="
                                            inactiveSelectedItems(
                                                checkUcItems
                                            )
                                            ">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-minus"
                                                color="#eb0505" />
                                        </a>
                                    </div>
                                    <div class="p-2 border icon_item" v-if="can('delete_unit_conversions') && this.checkUcItems.length > 0">
                                        <a href="javascript:void(0)" @click.prevent="
                                            deleteSelectedItems(
                                                checkUcItems
                                            )
                                            ">
                                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-trash"
                                                color="#eb0505" />
                                        </a>
                                    </div>
                                </div>
                                <div class="right d-flex ml-auto mx-3">
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
                                                <input class="form-check-input" type="checkbox" @click="selectAll"
                                                v-if="this.conversions.length > 0" :checked="this.checkAllItems.length==this.checkUcItems.length"  v-model="checkAllItems" />
                                            </div>
                                        </th>
                                        <th :class="iconClassHead">Status</th>
                                        <th :class="textClassHead">From</th>
                                        <th :class="textClassHead">To</th>
                                        <th :class="textClassHead" class="text_align_end">Rate</th>
                                        <th :class="textClassHead"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="conversion in conversions" :key="conversion.id" :class="rowClass">
                                        <td>
                                            <div class="form-check mb-4">
                                                <input class="form-check-input" type="checkbox" v-model="checkUcItems"
                                                    v-bind:value="conversion" v-bind:id="conversion.id" />
                                            </div>
                                        </td>
                                        <td :class="iconClassBody">
                                            <span v-if="conversion.status == 1"
                                                class="badge bg-success text-white fw-bold">Active</span>
                                            <span v-if="conversion.status == 0"
                                                class="badge bg-warning text-white fw-bold">Deactive</span>
                                        </td>
                                        <td :class="textClassBody">
                                            {{ conversion.from_name }}
                                        </td>
                                        <td :class="textClassBody">
                                            {{ conversion.to_name }}
                                        </td>
                                        <td :class="textClassBody" class="text_align_end">
                                            {{ formatPrice(conversion.ratio) }}
                                        </td>
                                        <td :class="iconClassBody">
                                            <a href="javascript:void(0)" v-if="can('delete_unit_conversions')" @click.prevent="
                                                deleteConversion(
                                                    conversion.id
                                                )
                                                " class="p-2 float-end">
                                                <i class="fas fa-trash text-ash text-right" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex mt-1 card-footer table-footer align-items-center">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                    Showing {{ pagination.from }} to
                                    {{ pagination.to }} of
                                    {{ pagination.total }} entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
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
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import Multiselect from "vue-multiselect";
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
    faPenToSquare,
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
            iconClassHead: "text-center",
            iconClassBody: "text-center",
            rowClass: "cursor-pointer",
            textClassRight: "text-right",

            search: null,
            page: 1,
            perPage: [25, 50, 100],
            pageCount: 25,
            pagination: {},
            conversion: {},
            conversions: [],
            units: [],
            units: {},
            checkUcItems: [],
            checkAllItems: false,
            select_unit_from: null,
            select_unit_to: null,
        };
    },
    beforeMount() {
        this.getConversions();
        this.getUnits();
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
        library.add(faPenToSquare);
    },
    watch: {
        checkAllItems(value) {
            this.conversions.forEach((item, index) => {
                if (index !== 0) {
                    item.selected = value;
                }
            });
            if (this.checkUcItems.length == this.conversions.length) {
                this.checkUcItems = [];
            } else {
                this.checkUcItems = this.conversions;
            }
        },
        checkUcItems(value) {
            if (this.checkUcItems.length != this.conversions.length) {
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
                await axios.get(route("conversion.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.conversions = tableData.data;
            this.pagination = tableData.meta;
            this.$root.loader.finish();
        },
        async getUnits() {
            const units = (await axios.get(route("units.list"))).data;
            this.units = units;
        },
        async createUnitConversion() {
            this.resetValidationErrors();
            try {
                this.conversion.from_uom_id = this.select_unit_from.id;
                this.conversion.to_uom_id = this.select_unit_to.id;
                await axios.post(route("conversion.store"), this.conversion);
                this.conversion = {};
                this.reload();
                this.select_unit_from = null;
                this.select_unit_to = null;
                this.$root.notify.success({
                    title: "Success",
                    message: "Unit Conversion created successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async getConversions() {
            this.$nextTick(() => {
                this.$root.loader.start();
            });
            const tableData = (await axios.get(route("conversion.all"))).data;
            this.conversions = tableData.data;
            this.pagination = tableData.meta;
            this.$nextTick(() => {
                this.$root.loader.finish();
            });
        },
        async deleteConversion(id) {
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
                            .delete(route("conversion.delete", id))
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
                this.checkUcItems = [];
            } else {
                this.units.forEach((unit) => {
                    this.checkUcItems.push(unit.id);
                });
            }
        },

        formatPrice(value) {
            let val = (value / 1).toFixed(2).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        async deleteSelectedItems(checkUcItems) {
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
                        const ids = this.checkUcItems.map((units) => units.id);
                        axios
                            .post(
                                route(
                                    "conversion.delete.selected",
                                    checkUcItems
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
                        //     `Unit Convertion has been deleted.`,
                        //     "success"
                        // );
                    }
                });
                this.$root.loader.finish();
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async inactiveSelectedItems(checkUcItems) {
            this.$root.loader.start();
            const ids = this.checkUcItems.map((conversion) => conversion.id);
            axios
                .post(route("conversion.inactive.selected"), { ids })
                .then((response) => {
                    this.checkUcItems = [];
                    this.reload();
                });
            this.$root.loader.finish();
        },
        async activeSelectedItems(checkUcItems) {
            this.$root.loader.start();
            const ids = this.checkUcItems.map((conversion) => conversion.id);
            axios
                .post(route("conversion.active.selected"), { ids })
                .then((response) => {
                    this.checkUcItems = [];
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
