<template>
    <div id="upload-images">
        <div class="card-header">
            <h5>Vehicle Images</h5>
        </div>
        <div class="mb-3 container">
            <form @submit.prevent="uploadImage" enctype="multipart/form-data">
                <p for="formFile" class="form-label mb-4">
                    Upload Images of the vehicle
                </p>
                <input class="form-control" type="file" id="formFile" @input="image = $event.target.files[0]" />

                <button type="submit" class="btn btn-round custom-button btn-sm mb-0">
                    <font-awesome-icon icon="fa-solid fa-circle-plus" />
                    Upload Image
                </button>
            </form>
            <hr class="mt-3" />
            <div class="mt-4">
                <div v-if="images && images.length > 0" class="row">
                    <div v-for="image in images" :key="image.id" class="col-md-3">
                        <div class="card">
                            <img width="100" :src="image.name" class="card-img-top" alt="..." />
                            <div class="card-body">
                                <button class="btn btn-sm btn-round btn-outline-danger mb-0" @click="deleteImage(image.id)">
                                    <font-awesome-icon icon="fa-solid fa-trash" />
                                    DELETE
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p class="text-danger lead text-capitalize">
                        No images uploaded yet...
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faHouse,
    faPlusCircle,
    faTrash,
} from "@fortawesome/free-solid-svg-icons";
import { ref } from "vue";
import { onMounted } from "vue";
library.add(faHouse);
library.add(faPlusCircle);
library.add(faTrash);

const { vehicle_id } = defineProps(["vehicle_id"]);
const image = ref(null);
const images = ref([]);

function convertValidationNotification(err) {
    resetValidationErrors();
    if (!(err.response && err.response.data)) return;
    const { message } = err.response.data;
    errorMessage(message);
}

const successMessage = (message) => {
    Swal.fire({
        title: "Success",
        text: message,
        icon: "success",
        toast: true,
        position: "top-end",
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
    });
};
const errorMessage = (message) => {
    Swal.fire({
        title: "Error",
        text: message,
        icon: "error",
        toast: true,
        position: "top-end",
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
    });
};

function clearImageField() {
    document.getElementById("formFile").value = "";
    image.value = null;
}

onMounted(() => {
    getImages();
});

async function reload() {
    const response = (await axios.get(route("vehicles.image.all", vehicle_id)))
        .data;
    images.value = response;
}

async function getImages() {
    const response = (await axios.get(route("vehicles.image.all", vehicle_id)))
        .data;
    images.value = response;
}

const deleteImage = async (image_id) => {
    try {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#C00202",
            cancelButtonColor: "#6CA925",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .delete(route("vehicles.image.delete", image_id))
                    .then((response) => {
                        reload();
                    });

                successMessage("Image Deleted Successfully");
            }
        });
    } catch (error) {
        convertValidationNotification(error);
    }
};

const uploadImage = async () => {
    try {
        const formData = new FormData();
        formData.append("image", image.value);
        await axios.post(route("vehicles.image.update", vehicle_id), formData, {
            headers: {
                "Content-Type": `multipart/form-data; boundary= ${formData._boundary}`,
            },
        });
        successMessage("Image Uploaded Successfully");
        clearImageField();
        reload();
    } catch (error) {
        console.log(error);
    }
};
</script>



<style lang="scss" scoped>
.custom-button {
    background-color: #ffffff;
    border-color: #6343e9;
    color: #6343e9 !important;
}

.custom-button:hover {
    background-color: #6343e9;
    color: #ffffff !important;
}
</style>
