
export default {
  state: {
    csrf: null,
  },
  mutations: {
    addCsrf(state, csrfToken) {
      state.csrf = csrfToken
    },
  },
  actions: {
    addToken({ commit }, csrfToken) {
      commit('addCsrf', csrfToken)

    },
  },
  getters: {
    getCsrfToken(state) {
      return state.csrf
    },
  }
}