<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import SideBar from "@/Components/Main/SideBar.vue";
import NavBar from "@/Components/Main/NavBar.vue";
import Footer from "@/Components/Main/Footer.vue";
import Notification from "@/Components/Basic/Notification.vue";
import Loader from "@/Components/Basic/LoadingBar.vue";

defineProps({
    title: String,
});
</script>

<template>
    <div>
        <Head :title="title ? title : 'IMake'">
            <link rel="icon" type="image/svg+xml" href="/img/logo/logoN.png" />
            <slot name="meta_head" />
        </Head>
        <SideBar />
        <div class="main-content" id="panel">
            <NavBar />
            <div>
                <slot name="header" />
                <div class="container-fluid">
                    <slot name="content" />
                </div>
            </div>
        </div>
        <slot name="modals" />
        <Footer />
        <Notification ref="notify" />
        <Loader ref="loader" />
    </div>
</template>

<style lang="scss">
body {
    background-image: url("@/../src/img/banner/bg.png");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    height: 100vh;
}

.bg-header {
    background-color: #55699f;
}

.table-responsive {
    overflow: auto;
}
</style>
