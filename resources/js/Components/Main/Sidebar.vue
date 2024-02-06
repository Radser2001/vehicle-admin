<script setup>
import { Link } from "@inertiajs/vue3";

import { library } from "@fortawesome/fontawesome-svg-core";

import { faCartShopping, faDesktop } from "@fortawesome/free-solid-svg-icons";

library.add(faCartShopping);
library.add(faDesktop);


// if (!window.Laravel) {
//     window.location.reload();
// }

</script>
<template>
    <nav
        class="bg-white sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light"
        id="sidenav-main"
    >
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="mb-4 text-center sidenav-header">
                <Link
                    class="navbar-brand text-black d-flex align-items-center justify-content-center"
                    :href="route('dashboard')"
                >
                    <img
                        src="../../../../public/img/logo-ct-dark.png"
                        alt="iMake"
                        class="home-logo mt-1"
                        width="50"
                    />
                    <h5 class="ml-2">Vehicle - Admin</h5>
                </Link>
            </div>
            <br />
            <div class="mt-5 navbar-inner">
                <!-- Collapse -->
                <div
                    class="collapse navbar-collapse sidebar_menu"
                    id="sidenav-collapse-main"
                >
                    <!-- Nav items -->
                    <ul class="mb-3 navbar-nav">
                        <li class="nav-item">
                            <Link
                                :class="{
                                    active: route().current() == 'dashboard',
                                }"
                                class="nav-link active-preloader"
                                :href="route('dashboard')"
                            >
                                <font-awesome-icon
                                    class="icon_item-icon ml-4"
                                    icon="fa-solid fa-desktop"
                                    color="#f74848"
                                />

                                <span class="ml-4 nav-link-text font-weight-400"
                                    >Dashboard</span
                                >
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link
                                :class="{
                                    active:
                                        route().current() == 'vehicles.index',
                                }"
                                class="nav-link active-preloader"
                                :href="route('vehicles.index')"
                            >
                                <font-awesome-icon
                                    class="icon_item-icon ml-4"
                                    icon="fa-solid fa-cart-shopping"
                                    color="#594dff"
                                />
                                <span class="ml-4 nav-link-text font-weight-400"
                                    >Vehicles</span
                                >
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<style lang="css">
.navbar-vertical .navbar-brand-img,
.navbar-vertical .navbar-brand > img {
    max-width: 100%;
    max-height: none;
    margin-top: -60px;
    margin-left: -10px;
}

.navbar-vertical.navbar-expand-xs .navbar-collapse {
    margin-top: -50px;
}
</style>
