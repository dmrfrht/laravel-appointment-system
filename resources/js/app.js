/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueMask from 'v-mask'

window.Vue = require('vue');
Vue.use(VueMask)
Vue.use(require('vue-resource'))

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/*Vue.component('example-component', require('./components/ExampleComponent.vue').default);*/
Vue.component('admin-list-appointment', require('./components/admin/AdminListAppointment.vue').default);
Vue.component('randevu-form-component', require('./components/RandevuFormComponent.vue').default);
Vue.component('randevu-detail-component', require('./components/RandevuDetailComponent.vue').default);

Vue.component('admin-component', require('./components/admin/AdminComponent').default);
Vue.component('admin-appointment-component', require('./components/admin/AdminAppointmentComponent.vue').default);
Vue.component('admin-today-appointment-component', require('./components/admin/AdminTodayAppointmentComponent.vue').default);
Vue.component('admin-last-appointment-component', require('./components/admin/AdminLastAppointmentComponent.vue').default);
Vue.component('admin-waiting-appointment-component', require('./components/admin/AdminWaitingAppointmentComponent.vue').default);
Vue.component('admin-cancel-appointment-component', require('./components/admin/AdminCancelAppointmentComponent.vue').default);
Vue.component('admin-working-component', require('./components/admin/AdminWorkingComponent.vue').default);
Vue.component('admin-working-item-component', require('./components/admin/AdminWorkingItemComponent.vue').default);
Vue.component('admin-appointment-modal-component', require('./components/admin/AdminAppointmentModalComponent.vue').default);

Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
});
