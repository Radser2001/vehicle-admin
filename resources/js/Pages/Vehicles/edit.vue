<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Multiselect from "vue-multiselect";
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
                            <!-- Button trigger modal -->

                            <div class="col-lg-4 text-right py-4">
                                <a
                                    data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop"
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
            <form @submit.prevent="createVehicle">
                <div>
                    <div class="mb-3">
                        <label for="make" class="form-label">Make</label>
                        <input
                            type="text"
                            class="form-control"
                            id="make"
                            name="make"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input
                            type="text"
                            class="form-control"
                            id="model"
                            name="model"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input
                            type="number"
                            class="form-control"
                            id="year"
                            name="year"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="condition" class="form-label"
                            >Condition</label
                        >
                        <input
                            type="number"
                            class="form-control"
                            id="condition"
                            name="condition"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input
                            type="text"
                            class="form-control"
                            id="color"
                            name="color"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="mileage" class="form-label">Mileage</label>
                        <input
                            type="number"
                            class="form-control"
                            id="mileage"
                            name="mileage"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="fuel_type" class="form-label"
                            >Fuel Type</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="fuel_type"
                            name="fuel_type"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input
                            type="number"
                            step="0.01"
                            class="form-control"
                            id="price"
                            name="price"
                        />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form></template
        >
    </AppLayout>
</template>
