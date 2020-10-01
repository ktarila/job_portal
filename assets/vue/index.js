import Vue from "vue";
import App from "./App";
import router from "./router";
import store from './store';
import moment from 'moment';


import { extend } from 'vee-validate';
import { required, image, size } from 'vee-validate/dist/rules';

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.component('loading-overlay', Loading);
 
// Add the required rule
extend('required', {
  ...required,
  message: 'This field is required'
});

extend('image', {
  ...image,
  message: 'Please enter a valid image'
});

extend('size', {
  ...size,
  message: "Size must be less than {size}kb"
});



import VDatePicker from 'v-calendar';
Vue.use(VDatePicker, {});

Vue.mixin({
  methods: {
    dateFormat: date => moment(date).format("Do MMM, YYYY")
  }
})

new Vue({
  components: { App },
  template: "<App/>",
  router,
  store
}).$mount("#app");