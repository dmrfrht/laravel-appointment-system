<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div>
          <div class="row">
            <ul class="list-unstyled ml-auto mr-auto">
              <li
                v-for="error in errors"
                class="py-2 px-4"
                style="
                  border: 1px solid #ccc;
                  margin-bottom: 5px;
                  border-radius: 5px;
                "
              >
                {{ error }}
              </li>
            </ul>
          </div>
          <div class="form-group">
            <button
              class="btn btn-outline-success"
              style="float: right"
              @click="store"
            >
              <i class="fa fa-search"></i>
              Randevu Ara
            </button>
          </div>

          <div class="clearfix"></div>

          <div class="form">
            <div class="form-group">
              <label>Kod</label>
              <input
                type="text"
                class="form-control"
                placeholder="Randevu kodu giriniz.."
                v-model="code"
              />
            </div>
          </div>
        </div>

        <div v-if="completeForm">
          <div
            class="col-md-6 ml-auto mr-auto d-flex flex-column justify-content-between p-4"
            style="border: 1px solid #ccc"
          >
            <div>
              <span><b>Ad-Soyad:</b> {{ info.full_name }}</span>
            </div>
            <hr />
            <div class="date-time d-flex justify-content-between">
              <span><b>Tarih:</b> {{ info.date }}</span>
              <span><b>Saat:</b> {{ info.working }}</span>
            </div>
            <hr />
            <div>
              <span><b>Bildirim Türü:</b> {{ info.notification }}</span>
            </div>
            <div class="mt-2">
              <h6 class="text-center">Notlar</h6>
              <ul>
                <li v-for="item in note">{{ item.text }}</li>
              </ul>
            </div>
          </div>
          <a href="/detail" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i>
            Yenile
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      completeForm: false,
      code: null,
      errors: [],
      info: [],
      notificationType: "",
      note: [],
    };
  },
  methods: {
    store() {
      if (this.code != null) {
        axios
          .post(`http://127.0.0.1:8000/api/appointment-detail`, {
            code: this.code,
          })
          .then((res) => {
            if (res.data.status == true) {
              this.info = res.data.info;
              this.note = res.data.note;
              this.completeForm = true;
            } else {
              this.errors = [];
              this.errors.push(res.data.message);
            }
            this.code = "";
          })
          .catch((err) => {
            console.log(err);
          });
      }

      this.errors = [];
      if (this.code == null) {
        this.errors.push("Randevu Kodu Boş Bırakılamaz");
      }
    },
  },
};
</script>