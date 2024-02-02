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
    </AppLayout>
</template>
