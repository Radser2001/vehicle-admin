
<template>
    <AppLayout title="Vehicle Management">
        <template #loader>
            <Loader ref="loading_bar" />
        </template>
        <template #header>
            <div class="header">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center mb-1 mt-1">
                            <div class="col-lg-8">
                                <h6 class="h2 text-dark d-inline-block mb-0">
                                    Vehicle Make
                                </h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-block">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item">
                                            <Link href="/">
                                            <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                            Vehicle Make Management
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <!-- <div class="col-lg-4 text-right py-4" v-if="can('create_Vehicle')"> -->
                            <div class="col-lg-4 text-right py-4">
                                <a href="javascript:void(0)" @click.prevent="newMake"
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
                                Search:
                                <div class="inline-block ml-2">
                                    <input type="text" class="form-control form-control-sm" v-model="search"
                                        @keyup="getSearch" />
                                </div>
                            </div>

                            <div class="col-md-2 mt-3 column__left___padding">
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
                                        <div class="p-2 border icon_item">
                                            <a @click.prevent="
                                                activeSelectedItems(
                                                    checkMakeItems.value
                                                )
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-check"
                                                    color="#0bd018" />
                                            </a>
                                        </div>
                                        <!-- <div class="p-2 border icon_item" v-if="can('inactive_Vehicle')"> -->
                                        <div class="p-2 border icon_item">
                                            <a @click.prevent="
                                                inactiveSelectedItems(
                                                    checkMakeItems.value
                                                )
                                                ">
                                                <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-circle-minus"
                                                    color="#eb0505" />
                                            </a>
                                        </div>
                                        <!-- <div class="p-2 border icon_item" v-if="checkMakeItems.value.length > 0 && can('delete_Vehicle')"> -->
                                        <div class="p-2 border icon_item" v-if="checkMakeItems.length > 0">
                                            <a href="javascript:void(0)" @click.prevent="
                                                deleteSelectedItems(
                                                    checkMakeItems.value
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
                                                    <input class="form-check-input" type="checkbox" @click="selectAll" v-if="makes &&
                                                        makes.length > 0
                                                        " :checked="checkAllItems" v-model="checkAllItems" />
                                                </div>
                                            </th>
                                            <th :class="iconClassHead">
                                                Status
                                            </th>
                                            <th :class="iconClassHead">Make</th>
                                            <th :class="textClassHead">
                                                Code
                                            </th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="make in makes" :key="make.id" :class="rowClass">
                                            <td class="checkArea">
                                                <div class="form-check mb-4">
                                                    <input class="form-check-input" type="checkbox" v-model="checkMakeItems
                                                        " v-bind:value="make" v-bind:id="make.id" />
                                                </div>
                                            </td>
                                            <td :class="iconClassBody" class="pt-2">
                                                <label v-if="make.status == 1
                                                    " class="badge bg-success text-white fw-bold">Active</label>
                                                <label v-if="make.status == 0
                                                    " class="badge bg-warning text-white fw-bold">Inactive</label>
                                            </td>
                                            <td :class="textClassBody">
                                                {{ make.name }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ make.code }}
                                            </td>

                                            <td :class="iconClassBody">
                                                <a href="javascript:void(0)" @click.prevent="
                                                    editMake(make.id)
                                                    " class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-pen" class="text-ash" />
                                                </a>
                                                <a href="javascript:void(0)" @click.prevent="deleteMake(make.id)"
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
            <div class="modal fade" id="newMakeModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newMakeModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-mb" role="document">
                    <div class="modal-content p-2">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-text text-gradient" id="add_brandLabel">
                                New Vehicle Make
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
                                    <form role="form text-left" @submit.prevent="createMake" enctype="multipart/form-data">

                                        <div class="row mb-1">
                                            <div for="make" class="col-md-3 col-form-label">
                                                MAKE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="make"
                                                    id="make" v-model="make.name" placeholder="make" required /><small
                                                    v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.make
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="condition" class="col-md-3 col-form-label">
                                                STATUS
                                            </div>
                                            <div class="col-md-9">
                                                <select name="status" id="status" class="form-select" aria-label="status"
                                                    required v-model="make.status">
                                                    <option selected value="0">Inactive</option>
                                                    <option value="1">Active</option>
                                                </select>
                                                <small v-if="validationErrors.condition
                                                    " id="msg_condition"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.condition
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2">
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


            <!-- vehicle make edit modal -->
            <div class="modal fade" id="editMakeModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editMakeModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-text text-gradient" id="add_brandLabel">
                                Edit Make
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
                                    <form role="form text-left" @submit.prevent="updateMake" enctype="multipart/form-data">

                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="edit_make.name" placeholder="Name" required />
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="condition" class="col-md-3 col-form-label">
                                                STATUS
                                            </div>
                                            <div class="col-md-9">
                                                <select name="status" id="status" class="form-select" aria-label="status"
                                                    required v-model="edit_make.status">
                                                    <option value="0">Inactive</option>
                                                    <option value="1">Active</option>
                                                </select>
                                                <small v-if="validationErrors.condition
                                                    " id="msg_condition"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.condition
                                                    }}</small>
                                            </div>
                                        </div>
                                        <div class="text-right mt-2">
                                            <button type=" submit" class="btn btn-round btn-outline--info btn-sm mb-0">
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

<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import Swal from "sweetalert2";
import Multiselect from "vue-multiselect";
import AppLayout from "@/Layouts/AppLayout.vue";
import Loader from "@/Components/Basic/LoadingBar.vue";
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

const textClassHead = ref("text-start text-uppercase");
const textClassBody = ref("text-start");
const iconClassHead = ref("text-center");
const iconClassBody = ref("text-center");
const rowClass = ref("cursor-pointer");

const search = ref(null);
const page = ref(1);
const perPage = ref([25, 50, 100]);
const pageCount = ref(25);
const pagination = ref({});
const make = ref({});
const makes = ref([]);
const checkMakeItems = ref([]);
const checkAllItems = ref(false);
const searchMake = ref({});
const edit_make = ref({});

const validationMessage = ref(null);
const validationErrors = ref({});
const loading_bar = ref(null);

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

function resetValidationErrors() {
    validationErrors.value = {};
    validationMessage.value = null;
}
function convertValidationNotification(err) {
    resetValidationErrors();
    if (!(err.response && err.response.data)) return;
    const { message } = err.response.data;
    errorMessage(message);
}
function convertValidationError(err) {
    resetValidationErrors();
    if (!(err.response && err.response.data)) return;
    const { message, errors } = err.response.data;
    validationMessage.value = message;

    if (errors) {
        for (const error in errors) {
            validationErrors.value[error] = errors[error][0];
        }
    }
}

const successMessage = (message) => {
    Swal.fire({
        title: "Success",
        text: message,
        icon: "success",
        toast: true,
        position: "top-end",
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
    });
};
const errorMessage = (message) => {
    Swal.fire({
        title: "Error",
        text: message,
        icon: "error",
        toast: true,
        position: "top-end",
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
    });
};

onMounted(() => {
    getMakes();
});

function setPage(newPage) {
    page.value = newPage;
    reload();
}

function getSearch() {
    page.value = 1;
    reload();
}

function perPageChange() {
    reload();
}

async function reload() {
    loading_bar.value.start();
    const tableData = (
        await axios.get(route("make.all"), {
            params: {
                page: page.value,
                per_page: pageCount.value,
                "filter[search]": search.value,

            },
        })
    ).data;

    makes.value = tableData.data;
    pagination.value = tableData.meta;

    loading_bar.value.finish();
}

async function getMakes() {
    loading_bar.value.start();
    const response = (await axios.get(route("make.all"))).data;
    makes.value = response.data;
    pagination.value = response.meta;
    loading_bar.value.finish();
}

async function createMake() {
    resetValidationErrors();
    try {

        await axios.post(route("make.store"), make.value);
        make.value = {};
        $("#newMakeModal").modal("hide");
        successMessage("Vehicle Make created successfully");
        reload();
    } catch (error) {
        convertValidationError(error);

    }
}


async function editMake(makeId) {
    resetValidationErrors();
    try {
        const response = (await axios.get(route("make.get", makeId))).data;
        edit_make.value = response.data;
        $("#editMakeModal").modal("show");
    } catch (error) {
        convertValidationError(error);
    }
}

async function updateMake() {
    resetValidationErrors();
    try {
        await axios.post(
            route("make.update", edit_make.value.id),
            edit_make.value
        );
        reload();
        $("#editMakeModal").modal("hide");
        edit_make.value = {};
        successMessage("Vehicle Make updated successfully");
    } catch (error) {
        convertValidationNotification(error);
    }
}

async function deleteMake(makeId) {
    try {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#C00202",
            cancelButtonColor: "#6CA925",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(route("make.delete", makeId)).then((response) => {
                    reload();
                });
            }
            successMessage("Vehicle Make deleted successfully");
        });
    } catch (error) {
        convertValidationNotification(error);
    }
}

async function newMake() {
    loading_bar.value.start();
    make.value = {};
    $("#newMakeModal").modal("show");
    loading_bar.value.finish();
}

function clearFilters() {
    search.value = null;
    reload();
}

async function inactiveSelectedItems() {
    loading_bar.value.start();
    const ids = checkMakeItems.value.map((item) => item.id);
    await axios
        .post(route("make.inactive.selected"), { ids })
        .then((response) => {
            checkMakeItems.value = [];
            reload();
        });
    loading_bar.value.finish();
}

async function activeSelectedItems() {
    loading_bar.value.start();
    const ids = checkMakeItems.value.map((item) => item.id);
    await axios
        .post(route("make.active.selected"), { ids })
        .then((response) => {
            checkMakeItems.value = [];
            reload();
        });
    loading_bar.value.finish();
}

function selectAll(event) {
    loading_bar.value.start();
    if (event.target.checked === false) {
        checkMakeItems.value = [];
    } else {
        checkMakeItems.value = make.value.map((make) => make.id);
    }
    loading_bar.value.finish();
}

async function deleteSelectedItems() {
    try {
        if (checkMakeItems.value && checkMakeItems.value.length > 0) {
            const result = await Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#C00202",
                cancelButtonColor: "#6CA925",
                confirmButtonText: "Yes, delete it!",
            });

            if (result.isConfirmed) {
                loading_bar.value.start();
                const ids = checkMakeItems.value.map((item) => item.id);
                await axios
                    .post(route("make.delete.selected"), { ids })
                    .then((response) => {
                        reload();
                        checkMakeItems.value = [];
                    });
                successMessage("Vehicle Make deleted successfully");
            }
        }
    } catch (error) {
        convertValidationNotification(error);
    } finally {
        loading_bar.value.finish();
    }
}
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
