<template>
  <div>
    <div v-if="completeForm">
      <div class="row">
        <ul class="list-unstyled ml-auto mr-auto">
          <li v-for="error in errors" class="py-2 px-4"
              style="border: 1px solid #ccc; margin-bottom: 5px; border-radius: 5px;">
            {{ error }}
          </li>
        </ul>
      </div>

      <div class="form-group">
        <button
          class="btn btn-outline-success"
          style="float: right;"
          @click="store"
        >
          <i class="fa fa-plus"></i>
          Randevu Oluştur
        </button>
      </div>

      <div class="clearfix"></div>

      <div class="form">
        <div class="form-group">
          <label>Ad-Soyad</label>
          <input
            type="text"
            class="form-control"
            placeholder="Ad-Soyad giriniz.."
            v-model="name"
          >
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>E-posta Adresi</label>
              <input
                type="email"
                class="form-control"
                placeholder="E-posta adresinizi giriniz.."
                v-model="email"
              >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Telefon Numarası</label>
              <input
                type="tel"
                class="form-control"
                placeholder="Telefon numaranızı giriniz.."
                v-model="phone"
                v-mask="'+90-###-###-####'"
              >
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Tarih</label>
          <input
            type="date"
            class="form-control"
            v-model="date"
            @change="selectDate"
            :min="minDate"
          >
        </div>

        <div class="form-group">
          <label>Bildirim Türü</label>
          <div class="radio-buttons d-flex justify-content-between">
            <div class="form-check">
              <input class="form-check-input" type="radio" v-model="notificationType" value="1">
              <label class="form-check-label">
                SMS
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" v-model="notificationType" value="0">
              <label class="form-check-label">
                E-posta
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Notunuz</label>
          <textarea
            class="form-control"
            rows="2"
            placeholder="Notunuzu giriniz.."
            v-model="text"
          ></textarea>
        </div>

        <div class="form-group">
          <label>Saat</label>
          <ul class="list-group">
            <li
              class="list-group-item mb-1"
              v-for="(item, index) in workingHours"
            >
              <div class="px-2" v-if="item.isActive">
                <input
                  class="form-check-input"
                  type="radio"
                  v-model="workingHour"
                  :value="item.id"
                >
              </div>
              <div class="ml-2">{{ item.hours }}</div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div v-else>
      <div
        class="col-md-4 ml-auto mr-auto d-flex flex-column justify-content-between text-center text-success"
        style="padding: 15px; border: 1px solid #ccc; border-radius: 5px;"
      >
        <i class="fa fa-check fa-3x mb-3"></i>
        Randevunuz başarılı bir şekilde eklenmiştir
      </div>
      <a href="/" class="btn btn-outline-primary">
        <i class="fas fa-arrow-left"></i>
        anasayfaya dön
      </a>
    </div>

  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      name: null,
      email: null,
      phone: null,
      date: new Date().toISOString().slice(0, 10),
      text: null,
      workingHours: [],
      workingHour: 0,
      errors: [],
      notificationType: null,
      completeForm: true,
      minDate: new Date().toISOString().slice(0, 10),
    }
  },
  methods: {
    store() {
      if (this.name && this.email && this.validEmail(this.email) && this.workingHour && this.notificationType) {
        axios.post(`http://127.0.0.1:8000/api/appointment-store`, {
          full_name: this.name,
          email: this.email,
          phone: this.phone,
          date: this.date,
          workingHour: this.workingHour,
          notificationType: this.notificationType
        })
          .then(res => {
            if (res.status) this.completeForm = false
          })
      }

      this.errors = [];

      if (!this.name) this.errors.push("Ad-Soyad girilmelidir.")
      if (!this.email) this.errors.push("E-posta adresi girilmelidir.")
      if (!this.validEmail(this.email)) this.errors.push("E-posta adresiniz doğru formatta değildir.")
      if (!this.phone) this.errors.push("Telefon numarası girilmelidir.")
      if (!this.workingHour) this.errors.push("Çalışma saati seçilmelidir.")
      if (!this.notificationType) this.errors.push("Bildirim türü seçilmelidir.")


    },
    selectDate() {
      axios.get(`http://127.0.0.1:8000/api/working-hours/${this.date}`)
        .then(res => {
          console.log(res.data)
          this.workingHours = res.data
        })
    },
    validEmail(email) {
      let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }
  },
  mounted() {
    axios.get('http://127.0.0.1:8000/api/working-hours')
      .then(res => {
        this.workingHours = res.data
      })
  }
}
</script>