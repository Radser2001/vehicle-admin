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
library.add(faHouse);
library.add(faPlusCircle);
library.add(faTrash);

const { vehicle_id } = defineProps(["vehicle_id"]);
const image = ref(null);
const images = ref([]);

function clearImageField() {
    document.getElementById("formFile").value = "";
    image.value = null;
}
reload();
async function reload() {
    // this.$root.loader.start();
    const response = (await axios.get(route("vehicles.image.all", vehicle_id)))
        .data;
    images.value = response;

    // $root.value.loader.finish();
}

const deleteImage = async (id) => {
    try {
        const response = await axios.delete(
            route("vehicles.image.delete", vehicle_id)
        );
        console.log(response);
        reload();
    } catch (error) {
        console.log(error);
    }
};

const uploadImage = async () => {
    try {
        const formData = new FormData();
        formData.append("image", image.value);
        console.log(formData.get("image"));
        console.log(image.value);
        const response = await axios.post(
            route("vehicles.image.update", vehicle_id),
            formData,
            {
                headers: {
                    "Content-Type":
                        "multipart/form-data; boundary=" + formData._boundary,
                },
            }
        );
        console.log(response);
        clearImageField();
        reload();
    } catch (error) {
        console.log(error);
    }
};
</script>

<template>
    <div id="upload-images">
        <div class="card-header">
            <h5>Vehicle Images</h5>
        </div>
        <div class="mb-3">
            <form @submit.prevent="uploadImage" enctype="multipart/form-data">
                <p for="formFile" class="form-label mb-4">Upload an Image</p>
                <input
                    class="form-control"
                    type="file"
                    id="formFile"
                    @input="image = $event.target.files[0]"
                />

                <button
                    type="submit"
                    class="btn btn-sm btn-round btn-outline--info mb-2"
                >
                    <font-awesome-icon icon="fa-solid fa-circle-plus" />
                    ADD
                </button>

                <div class="row">
                    <div
                        v-for="image in images"
                        :key="image.id"
                        class="col-md-3"
                    >
                        <div class="card">
                            <img
                                width="100"
                                :src="image.name"
                                class="card-img-top"
                                alt="..."
                            />
                            <div class="card-body">
                                <button
                                    class="btn btn-sm btn-round btn-outline--danger"
                                    @click="deleteImage(image.id)"
                                >
                                    <font-awesome-icon
                                        icon="fa-solid fa-trash"
                                    />
                                    DELETE
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
