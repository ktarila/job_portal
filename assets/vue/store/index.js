import Vue from 'vue';
import Vuex from 'vuex';
import SecurityModule from './security';
import GlobalModule from './global'
import FormErrorModule from './formerror'


Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    security: SecurityModule,
    global: GlobalModule,
    formerror: FormErrorModule,

  },
});