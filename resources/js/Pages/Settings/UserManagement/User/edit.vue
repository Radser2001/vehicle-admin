<template>
    <AppLayout title="User - Edit">
        <template #header>
            <div class="pb-6 header">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="py-4 row align-items-center">
                            <div class="col-lg-6">
                                <h6 class="mb-0 h2 text-dark d-inline-block">User Management</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-block ">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item">
                                            <Link href="/">
                                            <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <Link :href="`/users`" class="text-purple">
                                            User Management
                                            </Link>
                                        </li>
                                        <li class="breadcrumb-item active text-info" aria-current="page">
                                            #{{ this.user_data.name }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #content>
            <div class="mt-4 row">
                <div class="col-lg-2 col-md-2">
                    <div class="nav-wrapper-loc">
                        <ul class="nav nav-pills nav-fill flex-column" id="tabs-icons-text" role="tablist">
                            <li class="mb-2 nav-item">
                                <a class="nav-link active" id="user_data-details-tab" data-toggle="tab" href="#user_data-details"
                                    role="tab" aria-controls="user_data-details" aria-selected="true">
                                    User Details</a>
                            </li>
                            <li class="mb-2 nav-item">
                                <a class="nav-link " id="user_data-permissions-tab" data-toggle="tab" href="#user_data-permissions"
                                    role="tab" aria-controls="user_data-permissions" aria-selected="true">
                                    User Permissions</a>
                            </li>
                            <li hidden></li>
                        </ul>
                    </div>

                </div>
                <div class="col-lg-10 col-md-10">
                    <div class="shadow card ">
                        <div class="card-body ">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="user_data-details" role="tabpanel">
                                    <PersonalEditForm :userId="this.user_data.id" />
                                </div>
                                <div class="tab-pane fade show" id="user_data-permissions" role="tabpanel">
                                    <UserPermissionsAll :userId="this.user_data.id" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import Swal from "sweetalert2";

import { library } from '@fortawesome/fontawesome-svg-core'
import { faHouse, faCircleInfo, faCartPlus, faDiamond } from '@fortawesome/free-solid-svg-icons'

import PersonalEditForm from '@/Pages/Settings/UserManagement/User/Components/Basic/PersonalEditForm.vue';
import PasswordEditForm from '@/Pages/Settings/UserManagement/User/Components/Basic/PasswordEditForm.vue';
import UserPermissionsAll from '@/Pages/Settings/UserManagement/User/Components/UserPermissions/all.vue';

export default {
    components: {
        AppLayout,
        Link,
        PersonalEditForm,
        PasswordEditForm,
        library,
        UserPermissionsAll,
    },
    props: {
        user_data: Object,
    },
    // setup() {
    //     const user_data = computed(() => usePage().props.value.user_data)
    //     return { user_data }
    // },
    data() {
        return {
            login_user: null,
        };
    },
    beforeMount() {
        library.add(faCircleInfo)
        library.add(faCartPlus)
        library.add(faDiamond)
        library.add(faHouse)
        this.getLoginUser();
    },
    watch: {

    },
    methods: {
        async getLoginUser() {
            this.$nextTick(() => {
                this.$root.loader.start();
            });
            this.login_user = await (await axios.get(route("login.user.get"))).data.id
            this.$nextTick(() => {
                this.$root.loader.finish();
            });
            // console.log("login user_data  ------->",this.login_user)
        },
    },
}

</script>

<style lang="scss">

</style>
