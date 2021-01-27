<template>
  <div class="row">
    <div class="col-md-4 mb-4" v-for="item in data">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">Randevu #{{ item.id }}</h5>

          <div class="appointment-detail p-3 mb-1">
            <p class="card-text text-center"><b>Ad-Soyad: </b> {{ item.full_name }}</p>
            <p class="card-text text-center"><b>Telefon: </b> <a :href="`tel:${item.phone}`">{{ item.phone }}</a></p>
            <p class="card-text text-center"><b>E-posta: </b> <a :href="`mailto:${item.email}`">{{ item.email }}</a></p>
          </div>

          <div class="appointment-detail px-3 py-2 d-flex justify-content-between">
            <p class="card-text text-center m-0"><b>Saat: </b> {{ item.working }}</p>
            <p class="card-text text-center m-0"><b>Tarih: </b> {{ item.date }}</p>
          </div>

          <div class="appointment-properties px-3 pt-3 d-flex justify-content-between">
            <button class="btn btn-danger btn-sm">Sil</button>
            <button class="btn btn-success btn-sm">Onayla</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  created() {
    console.log('olustu')
  },
  props: ["data"]
}
</script>