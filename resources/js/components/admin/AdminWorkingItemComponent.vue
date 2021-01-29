<template>

  <div class="col-md-12 mb-2">
    <div class="card">
      <div class="card-header" style="position: relative;">
        <div>{{ title }}</div>
        <div style="position:absolute; right:5px; top:5px;">
          <button class="btn btn-outline-info" @click="show">Göster/Gizle</button>
        </div>
      </div>
      <div class="card-body">
        <div class="input-group" v-if="isShow">
          <input type="text" class="form-control" placeholder="Çalışma saati giriniz.."
                 aria-label="Çalışma saati giriniz.."
                 aria-describedby="basic-addon2"
                 v-model="time"
          >
          <div class="input-group-append">
            <button class="btn btn-primary" type="button" @click="addTime">Kaydet</button>
          </div>
        </div>
        <ul class="list-unstyled pt-2 pl-1">
          <li v-for="item in data">{{ item }}</li>
        </ul>
      </div>
    </div>
  </div>

</template>

<script>
export default {
  props: ["title", "data", "day"],
  data() {
    return {
      isShow: false,
      time: ''
    }
  },
  methods: {
    show() {
      this.isShow = !this.isShow
    },
    addTime() {
      this.$emit('add', { text: this.time, day: this.day})
      this.time = ''
      this.isShow = false
    }
  }
}
</script>