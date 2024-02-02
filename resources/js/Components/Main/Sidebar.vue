<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
        id="sidenav-main"
    >
        <div class="sidenav-header">
            <i
                class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true"
                id="iconSidenav"
            ></i>
            <p class="navbar-brand m-0">
                <img
                    src="img/logo-ct-dark.png"
                    class="navbar-brand-img h-100"
                    alt="main_logo"
                />
                <span class="ms-1 font-weight-bold">Vehicle Admin</span>
            </p>
        </div>
        <hr class="horizontal dark mt-0" />
        <div
            class="collapse navbar-collapse w-auto h-auto"
            id="sidenav-collapse-main"
        >
            <ul class="navbar-nav">
                <li class="nav-item">
                    <Link :href="route('dashboard')" class="nav-link">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="ni ni-ungroup text-warning text-sm opacity-10"
                            ></i>
                        </div>
                        <p class="nav-link-text ms-1">Dashboard</p>
                    </Link>
                </li>
                <li class="nav-item">
                    <Link class="nav-link" :href="route('vehicles.index')">
                        <div
                            class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="ni ni-ui-04 text-info text-sm opacity-10"
                            ></i>
                        </div>
                        <p class="nav-link-text ms-1">Vehicles</p>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>
