<template>
  <div id="basic-info">
    <div class="card-header">
      <h5>Basic Info</h5>
    </div>
    <div class="card-body pt-0 mt-3">
      <form
        role="form text-left"
        @submit.prevent="updateVehicleData"
        enctype="multipart/form-data"
      >
        <div class="row mb-1">
          <div for="code" class="col-md-2 col-form-label">CODE</div>
          <div class="col-md-10">
            <input
              type="text"
              class="form-control form-control-sm"
              name="code"
              id="code"
              v-model="vehicle.code"
            />
            <small
              v-if="validationErrors.code"
              id="msg_code"
              class="text-danger form-text text-error-msg error"
              >{{ validationErrors.code }}</small
            >
          </div>
        </div>
        <div class="row mb-1">
          <div for="name" class="col-md-2 col-form-label">NAME</div>
          <div class="col-md-10">
            <input
              type="text"
              class="form-control form-control-sm"
              name="name"
              id="name"
              v-model="vehicle.name"
            />
            <small
              v-if="validationErrors.name"
              id="msg_name"
              class="text-danger form-text text-error-msg error"
              >{{ validationErrors.name }}</small
            >
          </div>
        </div>
        <div class="row mb-1">
          <div for="name" class="col-md-2 col-form-label">EMAIL</div>
          <div class="col-md-10">
            <input
              type="email"
              class="form-control form-control-sm"
              name="email"
              id="email"
              v-model="vehicle.email"
            />
            <small
              v-if="validationErrors.name"
              id="msg_name"
              class="text-danger form-text text-error-msg error"
              >{{ validationErrors.email }}</small
            >
          </div>
        </div>
        <div class="row mb-1">
          <div for="name" class="col-md-2 col-form-label">CONTACT</div>
          <div class="col-md-10">
            <input
              type="text"
              class="form-control form-control-sm"
              name="contact"
              id="contact"
              v-model="vehicle.contact"
            />
            <small
              v-if="validationErrors.contact"
              id="msg_name"
              class="text-danger form-text text-error-msg error"
              >{{ validationErrors.contact }}</small
            >
          </div>
        </div>
        <div class="row mb-1">
          <div for="name" class="col-md-2 col-form-label">ADDRESS</div>
          <div class="col-md-10">
            <input
              type="text"
              class="form-control form-control-sm"
              name="address"
              id="address"
              v-model="vehicle.address"
            />
            <small
              v-if="validationErrors.address"
              id="msg_name"
              class="text-danger form-text text-error-msg error"
              >{{ validationErrors.address }}</small
            >
          </div>
        </div>
        <div class="row mb-1">
          <div for="name" class="col-md-2 col-form-label">CITY</div>
          <div class="col-md-10">
            <input
              type="text"
              class="form-control form-control-sm"
              name="city"
              id="city"
              v-model="vehicle.city"
            />
            <small
              v-if="validationErrors.city"
              id="msg_name"
              class="text-danger form-text text-error-msg error"
              >{{ validationErrors.city }}</small
            >
          </div>
        </div>
        <div class="text-right">
          <button
            type="button"
            class="btn btn-sm btn-round btn-outline-danger mb-0"
            @click.prevent="deleteVehicle"
          >
            <font-awesome-icon icon="fa-solid fa-trash" />
            DELETE
          </button>
          <button type="submit" class="btn btn-round custom-button btn-sm mb-0">
            <font-awesome-icon icon="fa-solid fa-floppy-disk" />
            SAVE
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import Multiselect from "vue-multiselect";
import Swal from "sweetalert2";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faHouse,
  faFloppyDisk,
  faTrash,
} from "@fortawesome/free-solid-svg-icons";

export default {
  components: {
    Link,
    Multiselect,
    library,
  },
  props: {
    vehicleId: {
      type: Number,
      required: true,
    },
  },
  setup() {},
  data() {
    return {
      vehicle: {},
    };
  },
  beforeMount() {
    library.add(faHouse);
    library.add(faFloppyDisk);
    library.add(faTrash);
    this.getVehicle();
  },
  watch: {},
  methods: {
    async getVehicle() {
      this.$nextTick(() => {
        this.$root.loader.start();
      });
      const vehicle = (
        await axios.get(route("vehicles.get", this.vehicleId))
      ).data;
      this.vehicle = vehicle.data;
      this.$root.loader.finish();
    },

    async updateVehicleData() {
      this.resetValidationErrors();
      try {
        await axios.post(
          route("vehicle.update", this.vehicleId),
          this.vendor
        );
        this.$root.notify.success({
          title: "Success",
          message: "vehicle updated successfully",
        });
      } catch (error) {
        this.convertValidationError(error);
      }
    },

    async deleteVehicle() {
      try {
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#C00202", // Green
          cancelButtonColor: "#6CA925", // Secondary Color
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (result.isConfirmed) {
            axios
              .delete(route("vehicles.delete", this.vehicle.id))
              .then((response) => {
                this.$inertia.visit(route("vehicles.index"));
              });
            // Swal.fire("Deleted!", `Vender has been deleted.`, "success");
          }
        });
      } catch (error) {
        this.convertValidationNotification(error);
      }
    },
  },
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
