<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
 import Multiselect from 'vue-multiselect'
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
                                                <i
                                                    style="
                                                        color: rgb(
                                                            175,
                                                            174,
                                                            174
                                                        );
                                                    "
                                                    class="fa-solid fa-house"
                                                ></i>
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
                                    <i class="fa-solid fa-circle-plus"></i>
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
                                <div for="purchase_uom" class="col-form-label">
                                    CODE
                                </div>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    name="code"
                                    id="code"
                                    placeholder="Code"
                                    @keyup="getSearch"
                                />
                            </div>
                            <div
                                class="col-md-2 column__right___padding column__left___padding"
                            >
                                <div for="purchase_uom" class="col-form-label">
                                    NAME
                                </div>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    name="name"
                                    id="name"
                                    placeholder="Customer's Name"
                                    @keyup="getSearch"
                                />
                            </div>
                            <div
                                class="col-md-2 column__right___padding column__left___padding"
                            >
                                <div for="purchase_uom" class="col-form-label">
                                    Contact
                                </div>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    name="contact"
                                    id="contact"
                                    placeholder="Customer's Name"
                                    @keyup="getSearch"
                                />
                            </div>
                            <div class="col-md-2 mt-4 column__left___padding">
                                <a
                                    href="javascript:void(0)"
                                    @click.prevent="clearFilters"
                                    class="btn btn-sm btn-ash float-end mt-2 pt-2"
                                >
                                    CLEAR
                                </a>
                            </div>
                            <div class="text-muted ml-auto mx-4 mt-4">
                                <div class="inline-block">
                                    <Multiselect
                                        class="form-control form-control-sm per-page-entry mt-2"
                                        :value="100"
                                    >
                                        <option />
                                    </Multiselect>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-4">
                            <div class="table-responsive">
                                <div class="d-flex flex-row mb-3 rounded">
                                    <div class="left d-flex">
                                        <div class="p-2 border icon_item">
                                            <i
                                                class="fa-solid fa-clone icon_item-icon"
                                                style="color: #505050"
                                            ></i>
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <i
                                                class="fa-solid fa-arrow-up-from-bracket icon_item-icon"
                                                style="color: #505050"
                                            ></i>
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <i
                                                class="fa-solid fa-cloud-arrow-down icon_item-icon"
                                                style="color: #505050"
                                            ></i>
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <i
                                                class="fa-solid fa-wrench icon_item-icon"
                                                style="color: #505050"
                                            ></i>
                                        </div>
                                        <div class="p-2 border icon_item">
                                            <a
                                                @click.prevent="
                                                    activeSelectedItems(
                                                        checkCustomerItems
                                                    )
                                                "
                                            >
                                                <i
                                                    class="fa-solid fa-circle-check icon_item-icon"
                                                    style="color: #505050"
                                                ></i>
                                            </a>
                                        </div>
                                        <!-- <div class="p-2 border icon_item" v-if="can('inactive_vendor')"> -->
                                        <div class="p-2 border icon_item">
                                            <a
                                                @click.prevent="
                                                    inactiveSelectedItems(
                                                        checkCustomerItems
                                                    )
                                                "
                                            >
                                                <i
                                                    class="fa-solid fa-circle-minus icon_item-icon"
                                                    style="color: #505050"
                                                ></i>
                                                <font-awesome-icon
                                                    class="icon_item-icon"
                                                    icon="fa-solid "
                                                    color="#eb0505"
                                                />
                                            </a>
                                        </div>
                                        <!-- <div class="p-2 border icon_item" v-if="this.checkCustomerItems.length > 0 && can('delete_vendor')"> -->
                                        <div class="p-2 border icon_item">
                                            <a
                                                href="javascript:void(0)"
                                                @click.prevent="
                                                    deleteSelectedItems(
                                                        checkCustomerItems
                                                    )
                                                "
                                                ><i
                                                    class="fa-solid fa-trash icon_item-icon"
                                                    style="color: #505050"
                                                ></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="right d-flex ml-auto">
                                        <div class="p-2 border icon_item">
                                            <i
                                                class="fa-solid fa-wrench fa-print"
                                                style="color: #505050"
                                            ></i>
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="checkArea">
                                                <div class="form-check mb-4">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        @click="selectAll"
                                                    />
                                                </div>
                                            </th>
                                            <th :class="iconClassHead">
                                                Status
                                            </th>
                                            <th :class="textClassHead">Code</th>
                                            <th :class="textClassHead">Name</th>
                                            <th :class="textClassHead">
                                                Contact
                                            </th>
                                            <th :class="textClassHead">
                                                Address
                                            </th>
                                            <th :class="textClassHead">City</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="customer in customers"
                                            :key="customer.id"
                                            :class="rowClass"
                                        >
                                            <td class="checkArea">
                                                <div class="form-check mb-4">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        v-model="
                                                            checkCustomerItems
                                                        "
                                                        v-bind:value="customer"
                                                        v-bind:id="customer.id"
                                                    />
                                                </div>
                                            </td>
                                            <td
                                                :class="iconClassBody"
                                                class="pt-2"
                                            >
                                                <!-- <label v-if="customer.status == 1"
                                                    class="badge bg-success text-white fw-bold">Active</label> -->
                                                <label
                                                    class="badge bg-warning text-white fw-bold"
                                                    >Deactive</label
                                                >
                                            </td>
                                            <td :class="textClassBody">
                                                {{ customer.code }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ customer.name }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ customer.contact }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ customer.address }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ customer.city }}
                                            </td>
                                            <td :class="textClassBody">
                                                <a
                                                    href="javascript:void(0)"
                                                    @click.prevent="
                                                        editCustomer(
                                                            customer.id
                                                        )
                                                    "
                                                >
                                                    <font-awesome-icon
                                                        icon="fa-solid fa-pen"
                                                        class="text-ash"
                                                    />
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div></div
        ></template>

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
