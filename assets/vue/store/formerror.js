import Vue from 'vue';
export default {
  namespaced: true,
  state: {
    fields: {}
  },
  getters: {
    getFieldViolation: (state) => (id) => {
      //console.log(id);
      return state['fields'][id];
    },
  },
  mutations: {
    ['SET_ERROR'](state, errorAll) {
      // Get ISBN Violations
      let error = errorAll['violations'];
      let propertyName = errorAll['propertyNameCheck'];
      if (typeof(state['fields'][propertyName]) === "undefined") {
        Vue.set(state['fields'], propertyName, null);
      }
      // console.log(errorAll)
      let propObj = error.filter(p => p.propertyPath == propertyName);
      if (propObj.length > 0) {
        state['fields'][propertyName] = propObj.map(a => a.message).join(' ');
      } else {
        state['fields'][propertyName] = null;
      }
    },
    ['CLEAR_ERROR'](state) {
      let setAll = (obj, val) => Object.keys(obj).forEach(k => obj[k] = val);
      // set all fields to null
      setAll(state['fields'], null)
    },
  },
  actions: {
    setViolation({commit}, payload) {
      commit('SET_ERROR', payload);
    },
    clearViolations({commit}) {
      commit('CLEAR_ERROR');
    },
  },
}