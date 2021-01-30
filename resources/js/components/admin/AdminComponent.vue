<template>
  <div class="container">
    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
      <li class="nav-item">
        <a
          class="nav-link active"
          id="waiting-tab"
          data-toggle="tab"
          href="#waiting"
          role="tab"
          aria-controls="waiting"
          aria-selected="true"
          >Onay Bekleyen Randevular</a
        >
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          id="home-tab"
          data-toggle="tab"
          href="#home"
          role="tab"
          aria-controls="home"
          aria-selected="true"
          >Günü Gelen Randevular</a
        >
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          id="profile-tab"
          data-toggle="tab"
          href="#profile"
          role="tab"
          aria-controls="profile"
          aria-selected="false"
          >Gelecek Randevular</a
        >
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          id="contact-tab"
          data-toggle="tab"
          href="#contact"
          role="tab"
          aria-controls="contact"
          aria-selected="false"
          >Geçmiş Randevular</a
        >
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          id="cancel-tab"
          data-toggle="tab"
          href="#cancel"
          role="tab"
          aria-controls="cancel"
          aria-selected="false"
          >İptal Edilen Randevular</a
        >
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div
        class="tab-pane fade show active"
        id="waiting"
        role="tabpanel"
        aria-labelledby="waiting-tab"
      >
        <admin-list-appointment
          @updateOkey="updateOkey"
          @updateCancel="updateCancel"
          :data="waiting.data"
        ></admin-list-appointment>

        <div class="row d-flex justify-content-center">
          <pagination
            :data="waiting"
            @pagination-change-page="waitingData"
          ></pagination>
        </div>
      </div>

      <div
        class="tab-pane fade"
        id="home"
        role="tabpanel"
        aria-labelledby="home-tab"
      >
        <admin-list-appointment
          @updateOkey="updateOkey"
          @updateCancel="updateCancel"
          :data="today.data"
        ></admin-list-appointment>

        <div class="row d-flex justify-content-center">
          <pagination
            :data="today"
            @pagination-change-page="todayData"
          ></pagination>
        </div>
      </div>

      <div
        class="tab-pane fade"
        id="profile"
        role="tabpanel"
        aria-labelledby="profile-tab"
      >
        <admin-list-appointment
          @updateOkey="updateOkey"
          @updateCancel="updateCancel"
          :data="list.data"
        ></admin-list-appointment>

        <div class="row d-flex justify-content-center">
          <pagination
            :data="list"
            @pagination-change-page="listData"
          ></pagination>
        </div>
      </div>

      <div
        class="tab-pane fade"
        id="contact"
        role="tabpanel"
        aria-labelledby="contact-tab"
      >
        <admin-list-appointment
          @updateOkey="updateOkey"
          @updateCancel="updateCancel"
          :data="last.data"
        ></admin-list-appointment>

        <div class="row d-flex justify-content-center">
          <pagination
            :data="last"
            @pagination-change-page="lastData"
          ></pagination>
        </div>
      </div>

      <div
        class="tab-pane fade"
        id="cancel"
        role="tabpanel"
        aria-labelledby="cancel-tab"
      >
        <admin-list-appointment
          @updateOkey="updateOkey"
          @updateCancel="updateCancel"
          :data="cancel.data"
        ></admin-list-appointment>

        <div class="row d-flex justify-content-center">
          <pagination
            :data="cancel"
            @pagination-change-page="cancelData"
          ></pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import io from "socket.io-client";

let socket = io(`http://127.0.0.1:3000`);
export default {
  data() {
    return {
      waiting: { data: [] },
      today: { data: [] },
      list: { data: [] },
      last: { data: [] },
      cancel: { data: [] },
    };
  },
  created() {
    this.getData();

    socket.on("admin_appointment_list", () => {
      console.log("veri geldi");
      this.getData();
    });
  },
  methods: {
    getData(url = "http://127.0.0.1:8000/api/admin/all") {
      axios.get(url).then((res) => {
        this.waiting = res.data.waiting_list;
        this.today = res.data.today_list;
        this.list = res.data.list;
        this.last = res.data.last_list;
        this.cancel = res.data.cancel_list;
      });
    },
    waitingData(page) {
      this.getData(`http://127.0.0.1:8000/api/admin/all?waiting_page=${page}`);
    },
    listData(page) {
      this.getData(`http://127.0.0.1:8000/api/admin/all?list_page=${page}`);
    },
    todayData(page) {
      this.getData(`http://127.0.0.1:8000/api/admin/all?today_page=${page}`);
    },
    lastData(page) {
      this.getData(`http://127.0.0.1:8000/api/admin/all?last_page=${page}`);
    },
    cancelData(page) {
      this.getData(`http://127.0.0.1:8000/api/admin/all?cancel_page=${page}`);
    },
    updateOkey(id) {
      axios
        .post(`http://127.0.0.1:8000/api/admin/process`, { type: 1, id })
        .then((res) => this.getData());
    },
    updateCancel(id) {
      axios
        .post(`http://127.0.0.1:8000/api/admin/process`, { type: 2, id })
        .then((res) => this.getData());
    },
  },
};
</script>