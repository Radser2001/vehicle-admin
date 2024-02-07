
<template>
    <AppLayout title="Vehicle Admin">
        <template #header>
            <div class="header">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="py-4 col align-items-center">
                            <h6 class="mb-0 h2 text-dark d-inline-block">
                                Dashboard
                            </h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-block">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item">
                                        <Link href="/">
                                        <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                        </Link>
                                    </li>
                                    <li class="breadcrumb-item active breadcrumb-text" aria-current="page">
                                        Dashboard
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #content>
            <div class="mt-3 row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="mb-4 card">
                                <div class="p-3 card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="mb-3 text-md text-uppercase font-weight-bold">
                                                    Total Vehicles
                                                </p>
                                                <h5 class="text-lg font-weight-bolder">
                                                    {{ total_vehicles }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="text-center icon icon-shape bg-gradient-red shadow-danger rounded-circle">
                                                <font-awesome-icon icon="fa-solid fa-truck" color="#ffffff" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="mb-4 card">
                                <div class="p-3 card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="mb-3 text-md text-uppercase font-weight-bold">
                                                    Total Models
                                                </p>
                                                <h5 class="text-lg font-weight-bolder">
                                                    {{ total_models }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="text-center icon icon-shape bg-gradient-green shadow-danger rounded-circle">
                                                <font-awesome-icon icon="fa-solid fa-truck" color="#ffffff" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="mb-4 card">
                                <div class="p-3 card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="mb-3 text-md text-uppercase font-weight-bold">
                                                    Total Makes
                                                </p>
                                                <h5 class="text-lg font-weight-bolder">
                                                    {{ total_makes }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="text-center icon icon-shape bg-gradient-primary shadow-danger rounded-circle">
                                                <font-awesome-icon icon="fa-solid fa-truck" color="#ffffff" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="mb-4 card">
                                <div class="p-3 card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="mb-3 text-md text-uppercase font-weight-bold">
                                                    Total Categories
                                                </p>
                                                <h5 class="text-lg font-weight-bolder">
                                                    {{ total_categories }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="text-center icon icon-shape bg-gradient-indigo shadow-danger rounded-circle">
                                                <font-awesome-icon icon="fa-solid fa-truck" color="#ffffff" />
                                            </div>
                                        </div>
                                    </div>
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
import { library } from "@fortawesome/fontawesome-svg-core";
import { faHouse, faTruck } from "@fortawesome/free-solid-svg-icons";
import { Head, Link } from "@inertiajs/vue3";
import { ref, onBeforeMount } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

library.add(faHouse);
library.add(faTruck);

const total_vehicles = ref(null);
const total_models = ref(null);
const total_makes = ref(null);
const total_categories = ref(null);

onBeforeMount(() => {
    fetchTotalVehicles();
    fetchTotalModels();
    fetchTotalMakes();
    fetchTotalCategories();
});

async function fetchTotalVehicles() {
    const response = await axios.get(route("vehicles.count"));
    total_vehicles.value = response.data;
}
async function fetchTotalModels() {
    const response = await axios.get(route("model.count"));
    total_models.value = response.data;
}

async function fetchTotalMakes() {
    const response = await axios.get(route("make.count"));
    total_makes.value = response.data;
}

async function fetchTotalCategories() {
    const response = await axios.get(route("category.count"));
    total_categories.value = response.data;
}
</script>


<style lang="scss" scoped>
.breadcrumb-text {
    color: #6343e9 !important;
}
</style>
