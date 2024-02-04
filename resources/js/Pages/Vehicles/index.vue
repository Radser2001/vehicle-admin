<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Multiselect from "vue-multiselect";
import axios from "axios";

const vehicle = {
    make: "",
    model: "",
    year: "",
    condition: "",
    color: "",
    mileage: "",
    fuel_type: "",
    price: "",
};

async function createVehicle() {
    // resetValidationErrors();

    try {
        const response = await axios.post(route("vehicles.store"), vehicle);

        if (response.data.id) {
            window.location.href = route("vehicles.edit", response.data.id);
        }

        notify.success({
            title: "Success",
            message: "Vehicle created successfully",
        });
    } catch (error) {
        // convertValidationNotification(error);
        console.log(error);
    }
}

function newVehicle() {
    $("#staticBackdrop").modal("show");
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
                                    @click.prevent="newvehicle"
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
            <div class="card">
                <div class="card-body">
                    <table class="table p-5">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td colspan="2">Larry the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div></template
        >

        <template #modals>
            <!-- Modal -->
            <div
                class="modal fade"
                id="staticBackdrop"
                data-bs-backdrop="static"
                data-bs-keyboard="false"
                tabindex="-1"
                aria-labelledby="staticBackdropLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1
                                class="modal-title fs-5"
                                id="staticBackdropLabel"
                            >
                                Modal title
                            </h1>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <form @submit.prevent="createVehicle">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="make" class="form-label"
                                        >Make</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="make"
                                        v-model="vehicle.make"
                                        name="make"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="model" class="form-label"
                                        >Model</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="model"
                                        v-model="vehicle.model"
                                        name="model"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="year" class="form-label"
                                        >Year</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="year"
                                        v-model="vehicle.year"
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
                                        v-model="vehicle.condition"
                                        name="condition"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="color" class="form-label"
                                        >Color</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="color"
                                        v-model="vehicle.color"
                                        name="color"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="mileage" class="form-label"
                                        >Mileage</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="mileage"
                                        v-model="vehicle.mileage"
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
                                        v-model="vehicle.fuel_type"
                                        name="fuel_type"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label"
                                        >Price</label
                                    >
                                    <input
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        id="price"
                                        v-model="vehicle.price"
                                        name="price"
                                    />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                >
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div></template
        ></AppLayout
    >
</template>
