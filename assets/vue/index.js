import Vue from "vue";
import App from "./App";
import router from "./router";
import store from './store';


import { extend } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.component('loading-overlay', Loading);
 
// Add the required rule
extend('required', {
  ...required,
  message: 'This field is required'
});



import VDatePicker from 'v-calendar';
Vue.use(VDatePicker, {});

new Vue({
  components: { App },
  template: "<App/>",
  router,
  store
}).$mount("#app");