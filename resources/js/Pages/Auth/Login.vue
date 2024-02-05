<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Sign In" />
    <main class="main-content main-content-bg mt-0">
        <div
            class="page-header min-vh-100"
            style="
                background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-basic.jpg');
            "
        >
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-7">
                        <div class="card border-0 mb-0" style="margin-top: 5rem">
                            <div class="card-header bg-transparent">
                                <h5 class="text-dark text-center mt-2 mb-3">
                                    Sign in
                                </h5>
                            </div>
                            <div class="card-body px-lg-5 pt-0">
                                <form
                                    @submit.prevent="submit"
                                    class="text-start"
                                >
                                    <div class="mb-3">
                                        <input
                                            type="email"
                                            v-model="form.email"
                                            class="form-control"
                                            placeholder="Email"
                                            aria-label="Email"
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.email"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <input
                                            type="password"
                                            class="form-control"
                                            placeholder="Password"
                                            v-model="form.password"
                                            aria-label="Password"
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.password"
                                        />
                                    </div>
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="rememberMe"
                                            v-model="form.remember"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="rememberMe"
                                            >Remember me</label
                                        >
                                    </div>
                                    <div class="text-center">
                                        <button
                                            type="submit"
                                            class="btn bg-primary text-white w-100 my-4 mb-2"
                                        >
                                            Sign in
                                        </button>
                                        <div
                                            class="text-center mt-2 mb-2 text-sm"
                                        >
                                            <Link
                                                v-if="canResetPassword"
                                                :href="
                                                    route('password.request')
                                                "
                                                class="text-center"
                                            >
                                                Forgot your password?
                                            </Link>
                                        </div>
                                    </div>
                                    <div
                                        class="mb-2 position-relative text-center"
                                    >
                                        <p
                                            class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3"
                                        >
                                            or
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <Link
                                            :href="route('register')"
                                            type="button"
                                            class="btn bg-gradient-dark text-white w-100 mt-2 mb-4"
                                        >
                                            Sign up
                                        </Link>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
