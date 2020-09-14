import Vue from "vue";
import App from "./App";
import router from "./router";
import store from './store';

import { extend } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';
 
// Add the required rule
extend('required', {
  ...required,
  message: 'This field is required'
});

new Vue({
  components: { App },
  template: "<App/>",
  router,
  store
}).$mount("#app");