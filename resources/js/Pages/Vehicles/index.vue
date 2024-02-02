<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
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
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
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

function newCustomer() {
    $("#newCustomerModal").modal("show");
}
</script>

<template>
    <AppLayout>
        <template #header>
            <div class="header pb-6 pt-5">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center mb-1 mt-1">
                            <div class="col-lg-8">
                                <h6 class="h2 text-dark d-inline-block mb-0">
                                    Vehicles
                                </h6>
                                <nav
                                    aria-label="breadcrumb"
                                    class="d-none d-md-block"
                                >
                                    <ol
                                        class="breadcrumb breadcrumb-links breadcrumb-dark"
                                    >
                                        <li class="ml-5 breadcrumb-item">
                                            <Link :href="route('dashboard')">
                                                <font-awesome-icon
                                                    style="
                                                        color: rgb(
                                                            175,
                                                            174,
                                                            174
                                                        );
                                                    "
                                                    icon="fa-solid fa-house"
                                                />
                                            </Link>
                                        </li>
                                        <li
                                            class="breadcrumb-item active breadcrumb-text"
                                            aria-current="page"
                                        >
                                            Vehicle Management
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-4 text-right py-4">
                                <a
                                    href="javascript:void(0)"
                                    @click.prevent="newCustomer"
                                    class="btn btn-sm btn-neutral float-end"
                                >
                                    <font-awesome-icon
                                        icon="fa-solid fa-circle-plus"
                                    />
                                    ADD NEW
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #content> </template>
        <template #modals>
            <div
                class="modal fade"
                id="newCustomerModal"
                data-bs-backdrop="static"
                tabindex="-1"
                role="dialog"
                aria-labelledby="newVendorModal"
                aria-hidden="true"
            >
                <div
                    class="modal-dialog modal-dialog-centered modal-mb"
                    role="document"
                >
                    <div class="modal-content p-2">
                        <div class="modal-header">
                            <h5
                                class="modal-title font-weight-bolder breadcrumb-text text-gradient"
                                id="add_brandLabel"
                            >
                                New Customer
                            </h5>

                            <button
                                type="button"
                                class="btn-close close btn"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">
                                    <i class="fa fa-times"></i>
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="card-plain">
                                <div class="card-body">
                                    <form
                                        role="form text-left"
                                        enctype="multipart/form-data"
                                    >
                                        <div class="row mb-1">
                                            <div
                                                for="code"
                                                class="col-md-3 col-form-label"
                                            >
                                                CODE
                                            </div>
                                            <div class="col-md-9">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    name="code"
                                                    id="code"
                                                    placeholder="Code"
                                                    required
                                                />
                                            </div>

                                            <small
                                                id="msg_code"
                                                class="text-danger form-text text-error-msg error"
                                            ></small>
                                        </div>
                                        <div class="row mb-1">
                                            <div
                                                for="name"
                                                class="col-md-3 col-form-label"
                                            >
                                                NAME
                                            </div>
                                            <div class="col-md-9">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    name="name"
                                                    id="name"
                                                    placeholder="Name"
                                                    required
                                                />
                                            </div>

                                            <small
                                                id="msg_name"
                                                class="text-danger form-text text-error-msg error"
                                            ></small>
                                        </div>
                                        <div class="row mb-1">
                                            <div
                                                for="name"
                                                class="col-md-3 col-form-label"
                                            >
                                                EMAIL
                                            </div>
                                            <div class="col-md-9">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    name="email"
                                                    id="email"
                                                    placeholder="Email"
                                                    required
                                                />
                                            </div>

                                            <small
                                                id="msg_name"
                                                class="text-danger form-text text-error-msg error"
                                            ></small>
                                        </div>
                                        <div class="row mb-1">
                                            <div
                                                for="name"
                                                class="col-md-3 col-form-label"
                                            >
                                                CONTACT
                                            </div>
                                            <div class="col-md-9">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    name="contact"
                                                    id="contact"
                                                    placeholder="Contact"
                                                    required
                                                />
                                            </div>

                                            <small
                                                id="msg_name"
                                                class="text-danger form-text text-error-msg error"
                                            ></small>
                                        </div>
                                        <div class="row mb-1">
                                            <div
                                                for="name"
                                                class="col-md-3 col-form-label"
                                            >
                                                ADDRESS
                                            </div>
                                            <div class="col-md-9">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    name="address"
                                                    id="address"
                                                    placeholder="Address"
                                                    required
                                                />
                                            </div>

                                            <small
                                                id="msg_name"
                                                class="text-danger form-text text-error-msg error"
                                            ></small>
                                        </div>
                                        <div class="row mb-1">
                                            <div
                                                for="name"
                                                class="col-md-3 col-form-label"
                                            >
                                                CITY
                                            </div>
                                            <div class="col-md-9">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm"
                                                    name="name"
                                                    id="city"
                                                    placeholder="city"
                                                    required
                                                />
                                            </div>

                                            <small
                                                id="msg_name"
                                                class="text-danger form-text text-error-msg error"
                                            ></small>
                                        </div>
                                        <div class="row mb-1">
                                            <div
                                                for="name"
                                                class="col-md-3 col-form-label"
                                            >
                                                STATE
                                            </div>
                                            <div class="col-md-9">
                                                <input
                                                    type="state"
                                                    class="form-control form-control-sm"
                                                    name="state"
                                                    id="state"
                                                    placeholder="State"
                                                    required
                                                />
                                            </div>

                                            <small
                                                id="msg_name"
                                                class="text-danger form-text text-error-msg error"
                                            ></small>
                                        </div>

                                        <div class="text-right mt-2">
                                            <button
                                                type="submit"
                                                class="btn btn-round custom-button btn-sm mb-0"
                                            >
                                                <font-awesome-icon
                                                    icon="fa-solid fa-floppy-disk"
                                                />
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
        </template></AppLayout
    >
</template>
