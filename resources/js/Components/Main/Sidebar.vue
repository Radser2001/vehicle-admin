<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <nav
        class="bg-white sidenav navbar navbar-vertical fixed-start navbar-expand-xs navbar-light"
        id="sidenav-main"
    >
        <div class="collapse navbar-collapse sidebar_menu">
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
                <ul class="navbar-nav p-3">
                    <li class="nav-item">
                        <Link
                            :class="{
                                active: route().current() == 'dashboard',
                            }"
                            class="nav-link active-preloader"
                            :href="route('dashboard')"
                        >
                            <i
                                class="fa-solid fa-computer text-warning text-sm opacity-10"
                            ></i>
                            <span class="ml-2 nav-link-text font-weight-400"
                                >Dashboard</span
                            >
                        </Link>
                    </li>
                    <li class="nav-item mt-4">
                        <Link
                            :class="{
                                active: route().current() == 'vehicles.index',
                            }"
                            class="nav-link active-preloader"
                            :href="route('vehicles.index')"
                        >
                            <i
                                class="fa-solid fa-car text-primary text-sm opacity-10"
                            ></i>
                            <span class="ml-2 nav-link-text font-weight-400"
                                >Vehicles</span
                            >
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
