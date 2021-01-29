<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-2 d-flex justify-content-end">
        <button class="btn btn-outline-success" @click="store">
          <i class="fa fa-plus"></i> Kaydı Tamamla
        </button>
      </div>

      <admin-working-item-component
        day="monday"
        @add="add"
        title="Pazartesi"
        :data="monday"
      ></admin-working-item-component>

      <admin-working-item-component
        day="tuesday"
        @add="add"
        title="Salı"
        :data="tuesday"
      ></admin-working-item-component>

      <admin-working-item-component
        day="wednesday"
        @add="add"
        title="Çarşamba"
        :data="wednesday"
      ></admin-working-item-component>

      <admin-working-item-component
        day="thursday"
        @add="add"
        title="Perşembe"
        :data="thursday"
      ></admin-working-item-component>

      <admin-working-item-component
        day="friday"
        @add="add"
        title="Cuma"
        :data="friday"
      ></admin-working-item-component>

      <admin-working-item-component
        day="saturday"
        @add="add"
        title="Cumartesi"
        :data="saturday"
      ></admin-working-item-component>

      <admin-working-item-component
        day="sunday"
        @add="add"
        title="Pazar"
        :data="sunday"
      ></admin-working-item-component>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      monday: [],
      tuesday: [],
      wednesday: [],
      thursday: [],
      friday: [],
      saturday: [],
      sunday: [],
    };
  },
  created() {
    axios.get(`http://127.0.0.1:8000/api/working-list`).then((res) => {
      this.monday = typeof res.data.monday !== "undefined" ? res.data.monday : [];
      this.tuesday = typeof res.data.tuesday !== "undefined" ? res.data.tuesday : [];
      this.wednesday = typeof res.data.wednesday !== "undefined" ? res.data.wednesday : [];
      this.thursday = typeof res.data.thursday !== "undefined" ? res.data.thursday : [];
      this.friday = typeof res.data.friday !== "undefined" ? res.data.friday : [];
      this.saturday = typeof res.data.saturday !== "undefined" ? res.data.saturday : [];
      this.sunday = typeof res.data.sunday !== "undefined" ? res.data.sunday : [];
    });
  },
  methods: {
    add(data) {
      this[data.day].push(data.text);
    },
    store() {
      axios
        .post(`http://127.0.0.1:8000/api/working-store`, {
          monday: this.monday,
          tuesday: this.tuesday,
          wednesday: this.wednesday,
          thursday: this.thursday,
          friday: this.friday,
          saturday: this.saturday,
          sunday: this.sunday,
        })
        .then((res) => console.log(res));
    },
  },
};
</script>