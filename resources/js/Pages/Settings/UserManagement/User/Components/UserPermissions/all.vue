<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>Permissions Settings</h5>
        </div>
        <div class="card-body pt-2 mt-3">
            <form role="form text-left" @submit.prevent="updateUserPermission">
                <div class="mb-1 row">
                    <div class="mb-2 col-md-6" v-for="group in groups" :key="group.group_name" :class="rowClass">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ group.group_name }}</h5>
                                <ul class="list-group" v-for="permission in permissions" :key="permission.id" :class="list">
                                    <li class="list-group-item mb-1" v-if="permission.group_name == group.group_name">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input mt-0" type="checkbox" v-model="user_permissions"
                                                :id="permission.name" :key="permission.name" :value="permission.name">
                                            <label class="form-check-label" :for="permission.name">
                                                {{ permission.name }}
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end" >
                            <button type="button" class="btn btn-sm btn-outline-success mr-1 mb-1" v-on:click="printPermission">
                                <font-awesome-icon :icon="['fas', 'print']" />
                                <span>PRINT</span>
                            </button>
                            <button type="submit" class="btn btn-sm btn-neutral mr-1 mb-1" >
                                <font-awesome-icon :icon="['fas', 'floppy-disk']" />
                                <span>SAVE</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import Multiselect from "vue-multiselect";
import { library } from '@fortawesome/fontawesome-svg-core';
import { faFloppyDisk, faTrash, faArrowRightRotate, faPrint } from '@fortawesome/free-solid-svg-icons'
import Swal from "sweetalert2";

export default {
    components: {
        Link,
        Multiselect,
        library,
    },
    props: {
        userId: {
            type: Number,
            required: true,
        },
    },
    setup() { },
    data() {
        return {
            user: {},
            edit_user: {},
            groups: [],
            permissions: [],
            user_permissions: [],
        };
    },
    beforeMount() {
        library.add(faTrash);
        library.add(faPrint);
        library.add(faFloppyDisk);
        library.add(faArrowRightRotate);
        this.initData();
    },
    watch: {
    },
    methods: {
        async initData() {
            this.getUser();
            this.userPermissions();
            this.getPermissions();
            this.getPermissionGroup();
        },
        async getUser() {
            const user = (
                await axios.get(route("user.get", this.userId))
            ).data;
            this.user = user.data;
        },
        async updateUserPermission() {
            this.$root.loader.start();
            this.resetValidationErrors();
            try {
                console.log(this.user_permissions);
                await axios.post(
                    route("permission.user.update", this.userId),
                    {
                        permissions: this.user_permissions,
                    }
                );
                this.$root.notify.success({
                    title: "Success",
                    message: "User Permission Updated Successfully",
                });
                this.initData();
            } catch (error) {
                this.convertValidationError(error);
            }
            this.$root.loader.finish();
        },
        async getPermissionGroup() {
            const groups = (
                await axios.get(
                    route("permission.group.all")
                )
            ).data;
            this.groups = groups;
        },
        async getPermissions() {
            const permissions = (
                await axios.get(
                    route("permission.list.all")
                )
            ).data;
            this.permissions = permissions;
        },
        async userPermissions() {
            const user_permissions = (
                await axios.get(
                    route("permission.user.all", this.userId)
                )
            ).data;
            this.user_permissions = user_permissions;
        },
        async deleteUser() {
            try {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to delete this user!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#C00202", // Green
                    cancelButtonColor: "#6CA925", // Secondary Color
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(route("user.delete", this.user.id)).then((response) => {
                            this.$inertia.visit(route('user.index'));
                        });
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async restoreUser() {
            try {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to restore this user!",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#6CA925", // Green
                    cancelButtonColor: "#C00202", // Secondary Color
                    confirmButtonText: "Yes, restore it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get(route("user.restore", this.user.id)).then((response) => {
                            this.$inertia.visit(route('user.index'));
                        });
                    }
                });
            } catch (error) {
                this.convertValidationNotification(error);
            }
        },
        async printPermission(){
            this.$root.loader.start();
            try {
                const print = await axios.post(route("permission.print"), this.user, {
                    responseType: 'blob'
                });
                const url = window.URL.createObjectURL(print.data);
                window.open(url, '_blank');

            } catch (error) {
                this.$root.loader.finish();
                this.convertValidationNotification(error);
            }
            this.$root.loader.finish();
        },
    },
};
</script>

<style lang="scss" scoped></style>
