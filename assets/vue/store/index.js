import Vue from 'vue';
import Vuex from 'vuex';
import SecurityModule from './security';
import GlobalModule from './global'


Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    security: SecurityModule,
    global: GlobalModule,

  },
});