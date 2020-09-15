import SecurityAPI from '../api/security';
// import router from "../router";

export default {
  state: {
    token: null,
    refresh_token: null,
    user: {fullname: null, email: null, roles: []},
    error: null,
  },
  mutations: {
    authUser(state, userData) {
      state.token = userData.token
      state.refresh_token = userData.refresh_token
      state.user = JSON.parse(userData.user)
      state.error = null
    },
    clearAuth(state) {
      state.token = null
      state.refresh_token = null
      state.user = {}
      state.error = null
    },
    authError(state, error){
      state.token = null
      state.refresh_token = null
      state.user = {}
      state.error = error
    }
    
  },
  actions: {


    login({ commit }, payload) {

      return SecurityAPI.login(payload.email, payload.password)
        .then(res => {
          let aUser = {fullname: '', email: '', roles: []};
          aUser.fullname = res.data.fullname
          aUser.email = res.data.email
          aUser.roles = res.data.roles
          // JSON.stringify({"fullname": res.data.fullname, "email": res.data.email, "roles": res.data.roles})
          localStorage.setItem('token', res.data.token)
          localStorage.setItem('refresh_token', res.data.refresh_token)
          localStorage.setItem('user', JSON.stringify(aUser))
          commit('authUser', {
            token: res.data.token,
            refresh_token: res.data.refresh_token,
            user: JSON.stringify(aUser)
          })
        })
        .catch(err => {
          // console.log(err.response)
          commit('authError', err.response.data.error)
        })
    },
    logout({ commit }) {
      localStorage.removeItem('token')
      localStorage.removeItem('refresh_token')
      localStorage.removeItem('user')
      commit('clearAuth')
    },
    AutoLogin({ commit }) {
      const token = localStorage.getItem('token')
      if (!token) {
        return
      }
      const refresh_token = localStorage.getItem('refresh_token')
      const user = localStorage.getItem('user')
      commit('authUser', {
        token: token,
        refresh_token: refresh_token,
        user: user
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