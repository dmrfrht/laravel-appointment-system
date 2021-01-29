<template>
  <div class="row">
    <div class="col-md-4 mb-4" v-for="item in data">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">Randevu</h5>

          <div class="appointment-detail p-3 mb-1">
            <p class="card-text text-center">
              <b>Ad-Soyad: </b> {{ item.full_name }}
            </p>
            <p class="card-text text-center">
              <b>Telefon: </b>
              <a :href="`tel:${item.phone}`">{{ item.phone }}</a>
            </p>
            <p class="card-text text-center">
              <b>E-posta: </b>
              <a :href="`mailto:${item.email}`">{{ item.email }}</a>
            </p>
          </div>

          <div
            class="appointment-detail px-3 py-2 d-flex justify-content-between"
          >
            <p class="card-text text-center m-0">
              <b>Saat: </b> {{ item.working }}
            </p>
            <p class="card-text text-center m-0">
              <b>Tarih: </b> {{ item.date }}
            </p>
          </div>

          <div
            class="appointment-properties px-3 pt-3 d-flex justify-content-between"
            v-if="!item.isActive"
          >
            <button
              class="btn btn-danger btn-sm"
              @click="appointmentCancel(item.id)"
            >
              Reddet
            </button>
            <button
              class="btn btn-success btn-sm"
              @click="appointmentOkey(item.id)"
            >
              Onayla
            </button>
          </div>

          <span
            v-if="item.isActive == 1"
            class="bg-success"
            style="
              padding: 3px;
              border-radius: 5px;
              position: absolute;
              top: 5px;
              left: 5px;
              color: #fff;
            "
          >
            Onaylı
          </span>

          <span
            v-if="item.isActive == 2"
            class="bg-danger"
            style="
              padding: 3px;
              border-radius: 5px;
              position: absolute;
              top: 5px;
              left: 5px;
              color: #fff;
            "
          >
            İptal Edildi
          </span>

          <span
            v-if="!item.isActive"
            class="bg-info"
            style="
              padding: 3px;
              border-radius: 5px;
              position: absolute;
              top: 5px;
              right: 5px;
              color: #fff;
            "
          >
            Yeni
          </span>
        </div>
        <div class="card-footer d-flex justify-content-center">
          <button class="btn btn-primary" @click="openModal(item.id)">Detaylar</button>
        </div>
      </div>
    </div>

    <admin-appointment-modal-component
      v-if="showModal"
      @close="showModal = false"
      :modalId="showModalId"
    ></admin-appointment-modal-component>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      showModalId: 0,
      showModal: false,
    };
  },
  props: ["data"],
  methods: {
    appointmentOkey(id) {
      this.$emit("updateOkey", id)
    },
    appointmentCancel(id) {
      this.$emit("updateCancel", id)
    },
    openModal(id) {
      this.showModalId = id
      this.showModal = true
    },
  },
};
</script>