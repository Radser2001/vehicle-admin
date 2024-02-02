<script setup>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import Sidebar from "@/Components/Main/Sidebar.vue";
</script>

<template>
    <div class="min-height-100 bg-primary position-absolute w-100"></div>
    <Sidebar />
    <main class="main-content position-relative border-radius-lg">
        <Navbar />
        <slot name="header" />
        <slot name="content" />
        <slot name="modals" />
        <Footer />
    </main>

    <!-- <main>
        <slot />
    </main> -->
</template>

<!-- <SideBar />
        <div class="main-content" id="panel">
            <NavBar />
            <slot name="header" />
            <div class="container-fluid mt--6">
                <slot name="content" />
            </div>
        </div>
        <slot name="modals" />
        <Footer />
        <Notification ref="notification" />
        <Loader ref="loader" /> -->
