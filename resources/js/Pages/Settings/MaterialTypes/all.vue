<template>
    <AppLayout title="Material Types">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center mb-3 mt-3">
                            <div class="col-lg-8">
                                <h6 class="h2 text-dark d-inline-block mb-0">Material Types</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-block">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item">
                                            <Link :href="route('dashboard')">
                                            <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                            Material Types Management
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-4 text-right" v-if="can('create_types')">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#newMaterialTypeModal"
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
                                <div class="flex text-muted ml-auto mx-2">
                                    <div class="inline-block mx-1">
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
                                        <div class="p-2 border icon_item" v-if="can('active_types')">
                                            <a @click.prevent="
                                                activeSelectedItems(checkMatirialTypeItems)
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-check"
                                                    color="#0bd018" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="can('inactive_types')">
                                            <a @click.prevent="
                                                inactiveSelectedItems(checkMatirialTypeItems)
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-minus"
                                                    color="#eb0505" />
                                            </a>
                                        </div>
                                        <div class="p-2 border icon_item" v-if="can('delete_types') && this.checkMatirialTypeItems.length > 0">
                                            <a href="javascript:void(0)" @click.prevent="
                                                deleteSelectedItems(checkMatirialTypeItems)
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
                                                    v-if="this.materialTypes.length > 0" :checked="this.checkAllItems.length==this.checkMatirialTypeItems.length"  v-model="checkAllItems" />
                                                </div>
                                            </th>
                                            <th class="text-center">STATUS</th>
                                            <th :class="textClassHead">Code</th>
                                            <th :class="textClassHead">Name</th>
                                            <th :class="textClassHead"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="materialType in materialTypes" :key="materialType.id" :class="rowClass">
                                            <td class="checkArea">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="checkMatirialTypeItems" v-bind:value="materialType"
                                                        v-bind:id="materialType.id" />
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <label v-if="materialType.status == 1"
                                                    class="badge bg-success text-white fw-bold">Active</label>
                                                <label v-if="materialType.status == 0"
                                                    class="badge bg-warning text-white fw-bold">Deactive</label>
                                            </td>
                                            <td :class="textClassBody">
                                                {{ materialType.code }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ materialType.name }}
                                            </td>
                                            <td :class="iconClassBody">
                                                <a href="javascript:void(0)" v-if="can('update_types')"
                                                    @click.prevent="editMaterialType(materialType.id)"
                                                    class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-pen" class="text-ash" />
                                                </a>
                                                <a href="javascript:void(0)" v-if="can('delete_types')"
                                                    @click.prevent="deleteMaterialType(materialType.id)"
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
            <div class="modal fade newmodal" id="newMaterialTypeModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newMaterialTypeModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-text text-gradient" id="add_brandLabel">
                                New Material Type
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
                                    <form role="form text-left" @submit.prevent="createMaterialType"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="code" class="col-md-3 col-form-label col-form-label">
                                                CODE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="materialType.code" placeholder="Code" required />
                                                <small v-if="validationErrors.code" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.code }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label col-form-label">
                                                NAME
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="materialType.name" placeholder="Name" required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2" v-if="can('create_types')">
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
            <div class="modal fade" id="editMaterialTypeModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editMaterialTypeModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-text text-gradient" id="add_brandLabel">
                                Edit Material Type
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
                                    <form role="form text-left" @submit.prevent="updateMaterialType"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="code" class="col-md-3 col-form-label col-form-label">
                                                CODE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="edit_material_Type.code" placeholder="Code"
                                                    required />
                                                <small v-if="validationErrors.code" id="msg_code"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.code }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label col-form-label">
                                                NAME
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="edit_material_Type.name" placeholder="Name"
                                                    required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2" v-if="can('update_types')">
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
    faPenToSquare,
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
            iconClassHead: "text-right",
            iconClassBody: "text-right",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [25, 50, 100],
            pageCount: 25,
            pagination: {},
            materialType: {},
            edit_material_Type: {},
            materialMainTypes: [],
            select_material_main_type: {},
            select_edit_material_main_type: {},

            materialTypes: [],
            checkMatirialTypeItems: [],
            checkAllItems: false,
        };
    },
    beforeMount() {
        this.getMaterialTypes();
        this.getMaterialMainTypes();
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
        library.add(faPen);
    },
    watch: {
        checkAllItems(value) {
            this.materialTypes.forEach((item, index) => {
                if (index !== 0) {
                    item.selected = value;
                }
            });
            if (this.checkMatirialTypeItems.length == this.materialTypes.length) {
                this.checkMatirialTypeItems = [];
            } else {
                this.checkMatirialTypeItems = this.materialTypes;
            }
        },
        checkMatirialTypeItems(value) {
            if (this.checkMatirialTypeItems.length != this.materialTypes.length) {
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
                await axios.get(route("materialType.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.materialTypes = tableData.data;
            this.pagination = tableData.meta;
            this.$root.loader.finish();
        },

        async getMaterialTypes() {
            this.$nextTick(() => {
                this.$root.loader.start();
            });
            const tableData = (await axios.get(route("materialType.all"))).data;
            this.materialTypes = tableData.data;
            this.pagination = tableData.meta;
            this.$nextTick(() => {
                this.$root.loader.finish();
            });
        },
        async getMaterialMainTypes() {
            const materialMainTypes = (
                await axios.get(route("materialType.main.all"))
            ).data;
            this.materialMainTypes = materialMainTypes;
        },
        async createMaterialType() {
            this.resetValidationErrors();
            try {
                if (this.select_material_main_type) {
                    this.materialType.type = this.select_material_main_type.slug;
                }
                if (this.materialType.name) {
                    this.materialType.slug = this.materialType.name;
                }
                await axios.post(route("materialType.store"), this.materialType);
                this.reload();
                $("#newMaterialTypeModal").modal("hide");
                this.materialType = {};
                this.select_material_main_type = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Material Type created successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async deleteMaterialType(id) {
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
                        axios.delete(route("materialType.delete", id)).then((response) => {
                            this.reload();
                        });
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async editMaterialType(id) {
            this.resetValidationErrors();
            try {
                const edit_material_Type = (
                    await axios.get(route("materialType.get", id))
                ).data;
                this.edit_material_Type = edit_material_Type.data;
                // this.select_edit_material_main_type = (await axios.get(route('materialType.main.get', this.edit_material_Type.type))).data
                $("#editMaterialTypeModal").modal("show");
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async editMaterialCategory(id) {
            this.resetValidationErrors();
            try {
                const edit_material_category = (
                    await axios.get(route("materialCategory.get", id))
                ).data;
                this.edit_material_category = edit_material_category.data;
                $("#editMaterialCategoryModal").modal("show");
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async updateMaterialType() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route("materialType.update", this.edit_material_Type.id),
                    this.edit_material_Type
                );
                this.reload();
                $("#editMaterialTypeModal").modal("hide");
                this.edit_material_Type = {};
                this.select_edit_material_main_type = {};
                this.$root.notify.success({
                    title: "Success",
                    message: "Material Type updated successfully",
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },

        selectAll: function (event) {
            if (event.target.checked == false) {
                this.checkMatirialTypeItems = [];
            } else {
                this.materialTypes.forEach((materialType) => {
                    this.checkMatirialTypeItems.push(materialType.id);
                });
            }
        },

        async deleteSelectedItems(checkMatirialTypeItems) {
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
                        const ids = this.checkMatirialTypeItems.map(
                            (materialTypes) => materialTypes.id
                        );
                        axios
                            .post(
                                route("materialType.delete.selected", checkMatirialTypeItems),
                                { ids }
                            )
                            .then((response) => {
                                this.reload();
                                // console.log('Items deleted successfully.')
                                // Update the list of items to reflect the changes
                            });
                        // Swal.fire(
                        //   "Deleted!",
                        //   `Material Types has been deleted.`,
                        //   "success"
                        // );
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async inactiveSelectedItems(checkMatirialTypeItems) {
            const ids = this.checkMatirialTypeItems.map(
                (materialType) => materialType.id
            );
            axios
                .post(route("materialType.inactive.selected"), { ids })
                .then((response) => {
                    this.checkMatirialTypeItems = [];
                    this.reload();
                });
        },
        async activeSelectedItems(checkMatirialTypeItems) {
            const ids = this.checkMatirialTypeItems.map(
                (materialType) => materialType.id
            );
            axios
                .post(route("materialType.active.selected"), { ids })
                .then((response) => {
                    this.checkMatirialTypeItems = [];
                    this.reload();
                });
        },
    },
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
