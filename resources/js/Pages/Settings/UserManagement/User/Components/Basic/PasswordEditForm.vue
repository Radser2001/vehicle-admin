<template>
    <div id="basic-info">
        <div class="card-header">
            <h5>Basic Info</h5>
        </div>
        <div class="card-body pt-2 mt-3">
            <form role="form text-left" @submit.prevent="updatePAssword" enctype="multipart/form-data">
                <div class="row mb-1">
                    <label for="Password" class="col-md-3 col-form-label">NEW PASSWORD</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control form-control-sm" name="password" id="new_pass"
                            placeholder="New Password" v-model="user.password" required>
                        <small v-if="validationErrors.password" id="inp_new_password"
                            class="text-danger form-text text-error-msg error">{{ validationErrors.password }}</small>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="Password" class="col-md-3 col-form-label">CONFIRM PASSWORD</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control form-control-sm" name="password_confirmation"
                            placeholder="Confirm Password" id="confirm_pass" v-model="user.password_confirmation"
                            required>
                        <small v-if="validationErrors.password_confirmation" id="inp_new_password_confirmation"
                            class="text-danger form-text text-error-msg error">{{
                            validationErrors.password_confirmation
                            }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-right" v-if="can('update_users')">
                        <button class="btn btn-round btn-outline-primary btn-neutral btn-sm mb-0" id="submit-btn" type="submit">
                            <font-awesome-icon icon="fa-solid fa-floppy-disk" />
                            UPDATE
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

import { library } from '@fortawesome/fontawesome-svg-core'
import { faFloppyDisk } from '@fortawesome/free-solid-svg-icons'

export default {
    components: {
        Link,
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
        };
    },
    beforeMount() {
        library.add(faFloppyDisk);
    },
    watch: {
    },
    methods: {
        async updatePAssword() {
            this.resetValidationErrors();
            try {
                await axios.post(
                    route("user.password.update", this.userId),
                    this.user
                );
                this.user = {}
                this.$root.notify.success({
                    title: "Success",
                    message: "User updated successfully",
                });

            } catch (error) {
                this.convertValidationError(error);
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.form-control-label {
    font-size: .8rem !important;
    font-weight: 100 !important;
    margin-bottom: 0px !important;
    padding-top: .5rem;
}
</style>
