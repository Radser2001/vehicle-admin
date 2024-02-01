<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <main class="main-content main-content-bg mt-0">
            <div
                class="page-header min-vh-100"
                style="
                    background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-basic.jpg');
                "
            >
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-7">
                            <div class="card z-index-0">
                                <div class="card-header text-center pt-4">
                                    <h5>Sign Up</h5>
                                </div>

                                <div class="card-body">
                                    <form @submit.prevent="submit">
                                        <div class="mb-3">
                                            <input
                                                type="name"
                                                v-model="form.name"
                                                class="form-control"
                                                placeholder="Name"
                                                aria-label="Name"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.name"
                                            />
                                        </div>
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
                                                v-model="form.password"
                                                class="form-control"
                                                placeholder="Password"
                                                aria-label="Password"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.password"
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <input
                                                type="password"
                                                v-model="
                                                    form.password_confirmation
                                                "
                                                class="form-control"
                                                placeholder="Confirm Password"
                                                aria-label="Confirm Password"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors
                                                        .password_confirmation
                                                "
                                            />
                                        </div>

                                        <div class="text-center">
                                            <button
                                                type="submit"
                                                class="btn bg-gradient-dark w-100 my-4 mb-2"
                                            >
                                                Sign Up
                                            </button>
                                        </div>
                                        <div class="text-center text-sm mt-2">
                                            Already registered?
                                            <Link
                                                :href="route('login')"
                                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                >Login
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
    </GuestLayout>
</template>
