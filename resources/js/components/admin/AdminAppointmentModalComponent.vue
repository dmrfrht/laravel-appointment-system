<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header d-flex justify-content-between">
            <h3 slot="header">{{ data.full_name }}</h3>
            <button
                class="modal-default-button btn btn-info"
                @click="$emit('close')"
              >
                Kapat
              </button>
          </div>

          <div class="modal-body">
            <slot name="body">
              <div class="d-flex justify-content-between">
                <span><b>Telefon:</b>{{ data.phone }}</span>
                <span><b>E-posta:</b>{{ data.email }}</span>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                <span><b>Saat:</b>{{ data.working }}</span>
                <span><b>Tarih:</b>{{ data.date }}</span>
              </div>
              <hr />
              <div>
                <span><b>Bildirim Tipi:</b>{{ data.notification }}</span>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                <span><b>Not:</b>{{ data.text }}</span>
              </div>
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import axios from "axios";
export default {
  props: ["modalId"],
  data() {
    return {
      data: [],
    };
  },
  created() {
    axios
      .get(`http://127.0.0.1:8000/api/admin/detail/${this.modalId}`)
      .then((res) => (this.data = res.data.data));
  },
};
</script>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983 !important;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>