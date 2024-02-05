<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <Head title="Forgot Password" />
    <main class="main-content main-content-bg mt-0">
        <div
            class="page-header min-vh-100"
            style="
                background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/reset-basic.jpg');
            "
        >
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-7">
                        <div
                            class="card z-index-0 mb-7"
                            style="margin-top: 10rem"
                        >
                            <div class="card-header text-center pt-4 pb-1">
                                <h4 class="font-weight-bolder mb-1">
                                    Reset password
                                </h4>
                                <p class="mb-0">
                                    You will receive an e-mail in maximum 60
                                    seconds
                                </p>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="submit">
                                    <div class="mb-3">
                                        <input
                                            type="email"
                                            v-model="form.email"
                                            class="form-control"
                                            placeholder="Email"
                                            aria-label="Email"
                                        />
                                        <div class="mt-2">
                                            <InputError
                                                :message="form.errors.email"
                                            />
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button
                                            type="submit"
                                            class="btn text-white bg-gradient-dark btn-lg w-100 my-2 mb-2"
                                        >
                                            Send
                                        </button>
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
