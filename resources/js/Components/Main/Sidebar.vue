
<template>
    <nav class="bg-white sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="mb-4 text-center sidenav-header">
                <Link class="navbar-brand text-black d-flex align-items-center justify-content-center"
                    :href="route('dashboard')">
                <img src="../../../../public/img/logo-ct-dark.png" alt="iMake" class="home-logo mt-1" width="50" />
                <h5 class="ml-2">Vehicle - Admin</h5>
                </Link>
            </div>
            <br />
            <div class="mt-5 navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse sidebar_menu" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="mb-3 navbar-nav">
                        <li class="nav-item">
                            <Link :class="{
                                active: route().current() == 'dashboard',
                            }" class="nav-link active-preloader" :href="route('dashboard')">
                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-desktop" />

                            <span class="ml-2 nav-link-text font-weight-400">Dashboard</span>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :class="{ active: currentUrl.includes('/vehicles') }" class="nav-link active-preloader"
                                :href="route('vehicles.index')">
                            <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-truck" />
                            <span class="ml-2 nav-link-text font-weight-400">Vehicles</span>
                            </Link>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#settingsMenu" data-toggle="collapse" aria-expanded="true">
                                <font-awesome-icon icon="fa-solid fa-gears" /><span class="ml-2">Settings</span>
                            </a>
                            <ul class="list-unstyled" id="settingsMenu">
                                <li class="nav-item">
                                    <Link :class="{
                                        active:
                                            route().current() == 'make.index',
                                    }" class="nav-link active-preloader ml-4" :href="route('make.index')">
                                    <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-gear" />
                                    <span class="ml-2 hide-menu">Make</span>
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link :class="{
                                        active:
                                            route().current() == 'model.index',
                                    }" class="nav-link active-preloader ml-4" :href="route('model.index')">
                                    <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-gear" />
                                    <span class="ml-2 hide-menu">Model</span>
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link :class="{
                                        active:
                                            route().current() == 'category.index',
                                    }" class="nav-link active-preloader ml-4" :href="route('category.index')">
                                    <font-awesome-icon class="icon_item-icon" icon="fa-solid fa-gear" />
                                    <span class="ml-2 hide-menu">Category</span>
                                    </Link>
                                </li>



                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

import { library } from "@fortawesome/fontawesome-svg-core";
import { faGear, faDesktop, faTruck, faCar, faGears, faBoxesStacked } from "@fortawesome/free-solid-svg-icons";

library.add(faTruck);
library.add(faDesktop);
library.add(faCar);
library.add(faGear);
library.add(faGears);
library.add(faBoxesStacked);


const currentUrl = window.location.pathname;

</script>

<style lang="css">
.navbar-vertical .navbar-brand-img,
.navbar-vertical .navbar-brand>img {
    max-width: 100%;
    max-height: none;
    margin-top: -60px;
    margin-left: -10px;
}

.navbar-vertical.navbar-expand-xs .navbar-collapse {
    margin-top: -50px;
}
</style>
