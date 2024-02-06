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

const image = ref({});
const images = ref([]);

async function reload() {
    // this.$root.loader.start();
    const response = (await axios.get(route("vehicles.images.all", vehicle_id)))
        .data;

    images.value = response.data;

    // $root.value.loader.finish();
}
library.add(faHouse);
library.add(faPlusCircle);
library.add(faTrash);

const { vehicle_id } = defineProps(["vehicle_id"]);
</script>

<template>
    <div id="upload-images">
        <div class="card-header">
            <h5>Vehicle Images</h5>
        </div>
        <div class="mb-3">
            <p for="formFile" class="form-label mb-4">Upload an Image</p>
            <input class="form-control" type="file" id="formFile" />
        </div>
    </div>
</template>
