<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>Basic Info</h5>
        </div>
        <div class="card-body pt-0 mt-3">
            <form role="form text-left" @submit.prevent="updateVehicleData" enctype="multipart/form-data">
                <div class="row mb-1">
                    <div for="make" class="col-md-2 col-form-label">MAKE</div>
                    <div class="col-md-10">
                        <!-- <input type="text" class="form-control form-control-sm" name="make" id="make"
                            v-model="vehicle.make" /> -->
                        <!-- <select v-model="vehicle.make" class="form-control form-control-sm" name="make" id="make">
                            <option v-for="make in makes" :value="make.name">{{ make.name }}
                            </option>
                        </select> -->

                        <Multiselect v-model="select_make" :options="makes" :showLabels="false" :close-on-select="true"
                            :clear-on-select="false" :searchable="true" placeholder="Select Make" label="name"
                            track-by="id" />
                        <small v-if="validationErrors.make" id="msg_make"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.code }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="model" class="col-md-2 col-form-label">MODEL</div>
                    <div class="col-md-10">

                        <!-- <select v-model="vehicle.model" class="form-control form-control-sm" name="model" id="model">
                            <option v-for="model in models" :value="model.name">{{ model.name }}
                            </option>
                        </select> -->
                        <Multiselect v-model="select_model" :options="models" :showLabels="false" :close-on-select="true"
                            :clear-on-select="false" :searchable="true" placeholder="Select Model" label="name"
                            track-by="id" />
                        <!-- <input type="text" class="form-control form-control-sm" name="model" id="model"
                            v-model="vehicle.model" /> -->
                        <small v-if="validationErrors.model" id="msg_model"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.name }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="Category" class="col-md-2 col-form-label">CATEGORY</div>
                    <div class="col-md-10">
                        <!-- <input type="text" class="form-control form-control-sm" name="category" id="category"
                            v-model="vehicle.category" /> -->
                        <Multiselect v-model="select_category" :options="categories" :showLabels="false"
                            :close-on-select="true" :clear-on-select="false" :searchable="true"
                            placeholder="Select Category" label="name" track-by="id" />
                        <!-- <select v-model="vehicle.category" class="form-control form-control-sm" name="category"
                            id="category">
                            <option v-for="category in categories" :value="category.name">{{ category.name }}
                            </option>
                        </select> -->
                        <small v-if="validationErrors.category" id="msg_name"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.category }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="year" class="col-md-2 col-form-label">YEAR</div>
                    <div class="col-md-10">
                        <input type="year" class="form-control form-control-sm" name="year" id="year"
                            v-model="vehicle.year" />
                        <small v-if="validationErrors.year" id="msg_year"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.year }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="condition" class="col-md-2 col-form-label">
                        CONDITION
                    </div>

                    <div class="col-md-10">
                        <select name="condition" id="condition" class="form-control form-control-sm" aria-label="CONDITION"
                            v-model="vehicle.condition">
                            <option value="0">New</option>
                            <option value="1">Used</option>
                        </select>

                        <small v-if="validationErrors.condition" id="msg_name"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.condition }}</small>
                    </div>
                </div>

                <div class="row mb-1">
                    <div for="mileage" class="col-md-2 col-form-label">
                        MILEAGE
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-control-sm" name="mileage" id="mileage"
                            v-model="vehicle.mileage" />
                        <small v-if="validationErrors.mileage" id="msg_name"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.mileage }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="fuel_type" class="col-md-2 col-form-label">
                        FUEL TYPE
                    </div>
                    <div class="col-md-10">

                        <select class="form-control form-control-sm" v-model="vehicle.fuel_type" name="fuel_type"
                            id="fuel_type" required>

                            <option value="Petrol (Gasoline)">Petrol (Gasoline)</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Hybrid">Hybrid</option>
                            <option value="Natural Gas">Natural Gas</option>
                            <option value="Hydrogen">Hydrogen</option>
                        </select>
                        <!-- <input type="text" class="form-control form-control-sm" name="fuel_type" id="fuel_type"
                            v-model="vehicle.fuel_type" /> -->
                        <small v-if="validationErrors.fuel_type" id="msg_name"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.fuel_type }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="price" class="col-md-2 col-form-label">PRICE</div>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-control-sm" name="price" id="price"
                            v-model="vehicle.price" />
                        <small v-if="validationErrors.price" id="msg_name"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.price }}</small>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-sm btn-round btn-outline-danger mb-0"
                        @click.prevent="deleteVehicle">
                        <font-awesome-icon icon="fa-solid fa-trash" />
                        DELETE
                    </button>
                    <button type="submit" class="btn btn-round custom-button btn-sm mb-0">
                        <font-awesome-icon icon="fa-solid fa-floppy-disk" />
                        SAVE
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Multiselect from "vue-multiselect";
import { ref, onMounted } from "vue";
import Swal from "sweetalert2";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faHouse,
    faFloppyDisk,
    faTrash,
} from "@fortawesome/free-solid-svg-icons";

const { vehicle_id } = defineProps(["vehicle_id"]);

const vehicle = ref({});

const makes = ref([]);
const models = ref([]);
const categories = ref([]);

const validationMessage = ref(null);
const validationErrors = ref({});

const select_category = ref(null);
const select_make = ref(null);
const select_model = ref(null);

library.add(faHouse);
library.add(faFloppyDisk);
library.add(faTrash);

onMounted(() => {
    getMakes();
    getModels();
    getCategories();
    getVehicle();
});

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

async function getVehicle() {
    const response = (await axios.get(route("vehicles.get", vehicle_id))).data;
    vehicle.value = response.data;
    select_category.value = categories.value.find(
        (category) => category.name === vehicle.value.category
    );
    select_make.value = makes.value.find(
        (make) => make.name === vehicle.value.make
    );
    select_model.value = models.value.find(
        (model) => model.name === vehicle.value.model
    );
}

async function getMakes() {

    const response = (await axios.get(route("make.all"))).data;
    makes.value = response.data;


}
async function getModels() {

    const response = (await axios.get(route("model.all"))).data;
    models.value = response.data;


}
async function getCategories() {

    const response = (await axios.get(route("category.all"))).data;
    categories.value = response.data;


}

async function updateVehicleData() {
    resetValidationErrors();
    if (select_category.value) {
        vehicle.value.category = select_category.value.name;
    }
    if (select_make.value) {
        vehicle.value.make = select_make.value.name;
    }
    if (select_model.value) {
        vehicle.value.model = select_model.value.name;
    }
    try {
        await axios.post(route("vehicles.update", vehicle_id), vehicle.value);

        successMessage("Vehicle updated successfully");
    } catch (error) {
        convertValidationError(error);
    }
}

async function deleteVehicle() {
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
                axios
                    .delete(route("vehicles.delete", vehicle_id))
                    .then((response) => {
                        window.location.href = route("vehicles.index");
                    });
                successMessage("Vehicle deleted successfully");
            }
        });
    } catch (error) {
        convertValidationNotification(error);
    }
}
</script>


<style lang="scss" scoped>
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
