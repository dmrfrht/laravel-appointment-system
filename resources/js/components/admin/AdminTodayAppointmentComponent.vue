<template>
  <div class="container">

    <admin-list-appointment
      :data="items.data"
    ></admin-list-appointment>


    <div class="row d-flex justify-content-center">
      <pagination :data="items" @pagination-change-page="getData"></pagination>
    </div>

  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      items: {
        data: []
      }
    }
  },
  created() {
    this.getData();
  },
  mounted() {

  },
  methods: {
    getData(page) {
      if (typeof page === 'undefined') page = 1

      axios.get(`http://127.0.0.1:8000/api/admin/today-list/?page=${page}`)
        .then(res => {
          this.items = res.data
        })
    }
  }
}
</script>