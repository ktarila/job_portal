import SecurityAPI from '../api/security';
import router from "../router";

export default {
  state: {
    token: null,
    refresh_token: null,
    user: null,
    error: null,
  },
  mutations: {
    authUser(state, userData) {
      state.token = userData.token
      state.refresh_token = userData.refresh_token
      state.error = null
    },
    clearAuth(state) {
      state.token = null
      state.refresh_token = null
      state.error = null
    },
    authError(state, error){
      state.token = null
      state.refresh_token = null
      state.error = error
    }
    
  },
  actions: {


    login({ commit }, payload) {

      return SecurityAPI.login(payload.email, payload.password)
        .then(res => {
          // console.log(res)
          localStorage.setItem('token', res.data.token)
          localStorage.setItem('refresh_token', res.data.refresh_token)
          commit('authUser', {
            token: res.data.token,
            refresh_token: res.data.refresh_token
          })
        })
        .catch(err => {
          // console.log(err.response)
          commit('authError', err.response.data.error)
        })
    },
    logout({ commit }) {
      commit('clearAuth')
      localStorage.removeItem('token')
      localStorage.removeItem('refresh_token')
      router.replace('/login')
    },
    AutoLogin({ commit }) {
      const token = localStorage.getItem('token')
      if (!token) {
        return
      }
      const refresh_token = localStorage.getItem('refresh_token')
      commit('authUser', {
        token: token,
        refresh_token: refresh_token
      })
    }
  },
  getters: {
    user(state) {
      return state.user
    },
    isAuthenticated() {
      let tok = localStorage.getItem('token')
      return tok !== null
    },
    hasError (state) {
      return state.error !== null;
    },
    error (state) {
      return state.error
    },
  }
}