<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>User Info</h5>
        </div>
        <div class="card-body pt-2 mt-3">
            <form role="form text-left" @submit.prevent="updateBasicData" enctype="multipart/form-data">
                <div class="row mb-1">
                    <div for="name" class="col-md-2 col-form-label">NAME</div>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Name"
                            v-model="this.user.name" required :disabled="user.deleted_at != null" />
                        <small v-if="validationErrors.name" class="mt-1 text-sm text-danger form-text text-error-msg error">
                            {{ validationErrors.name }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <div for="email" class="col-md-2 col-form-label">EMAIL</div>
                    <div class="col-md-10">
                        <input type="text" class="form-control form-control-sm" name="email" id="email"
                            v-model="this.user.email" placeholder="Email" required :disabled="user.deleted_at != null" />
                        <small v-if="validationErrors.email"
                            class="mt-1 text-sm text-danger form-text text-error-msg error">
                            {{ validationErrors.email }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="Password" class="col-md-2 col-form-label">NEW PASSWORD</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control form-control-sm" name="password" id="new_pass"
                            placeholder="New Password" v-model="edit_user.password" :disabled="user.deleted_at != null" />
                        <small v-if="validationErrors.password" id="inp_new_password"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.password }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="Password" class="col-md-2 col-form-label">CONFIRM PASSWORD</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control form-control-sm" name="password_confirmation"
                            placeholder="Confirm Password" id="confirm_pass" v-model="edit_user.password_confirmation"
                            :required="edit_user.password != null" :disabled="user.deleted_at != null" />
                        <small v-if="validationErrors.password_confirmation" id="inp_new_password_confirmation"
                            class="text-danger form-text text-error-msg error">{{
                                validationErrors.password_confirmation
                            }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <div class="">
                            <button type="submit" v-if="user.deleted_at == null && can('update_users')" class="btn btn-round btn-neutral btn-sm mb-0">
                                <font-awesome-icon icon="fa-solid fa-floppy-disk" />
                                UPDATE
                            </button>
                            <button type="button" v-if="can('restore_users') && user.deleted_at != null" class="btn btn-round btn-outline-warning btn-sm mb-0"
                                @click="restoreUser">
                                <font-awesome-icon icon="fa-solid fa-arrow-right-rotate" />
                                RESTORE
                            </button>
                            <button type="button" v-else-if="can('delete_users')" class="btn btn-round btn-outline-danger btn-sm mb-0" @click="deleteUser">
                                <font-awesome-icon icon="fa-solid fa-trash" />
                                DELETE
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
import { faFloppyDisk, faTrash, faArrowRightRotate } from '@fortawesome/free-solid-svg-icons'
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
    data() {
        return {
            user: {},
            edit_user: {},
        };
    },
    beforeMount() {
        library.add(faTrash);
        library.add(faFloppyDisk);
        library.add(faArrowRightRotate);
        this.getUser();
    },
    watch: {
    },
    methods: {
        async getUser() {
            const user = (
                await axios.get(route("user.get", this.userId))
            ).data;
            this.user = user.data;
        },
        async updateBasicData() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route("user.basic.update", this.userId),
                    this.user
                );
                if (this.edit_user.password == null) {
                    this.$root.notify.success({
                        title: "Success",
                        message: "User updated successfully",
                    });
                } else {
                    this.updatePassword();
                }
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async updatePassword() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route("user.password.update", this.userId),
                    this.edit_user
                );
                this.edit_user = {}
                this.$root.notify.success({
                    title: "Success",
                    message: "User updated successfully",
                });

            } catch (error) {
                this.convertValidationError(error);
            }
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
    },
};
</script>

<style lang="scss" scoped></style>
