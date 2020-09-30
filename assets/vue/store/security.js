import SecurityAPI from '../api/security';
// import router from "../router";

export default {
  state: {
    token: null,
    refresh_token: null,
    user: {fullname: null, email: null, roles: [], info: null},
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
    },
    setInfo(state, info){
      console.log(info)
      state.user.info = info
    }
    
  },
  actions: {


    login({ commit }, payload) {
      return SecurityAPI.login(payload.email, payload.password)
        .then(res => {
          let aUser = {fullname: '', email: '', roles: [], info: ''};
          aUser.fullname = res.data.fullname
          aUser.email = res.data.email
          aUser.roles = res.data.roles
          aUser.info = res.data.info
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
    },
    refresh({ commit }, payload) {
      let aUser = {fullname: '', email: '', roles: [], info: ''};
      aUser.fullname = payload.data.fullname
      aUser.email = payload.data.email
      aUser.roles = payload.data.roles
      aUser.info = payload.data.info
      // JSON.stringify({"fullname": res.data.fullname, "email": res.data.email, "roles": res.data.roles})
      localStorage.setItem('token', payload.data.token)
      localStorage.setItem('refresh_token', payload.data.refresh_token)
      localStorage.setItem('user', JSON.stringify(aUser))
      commit('authUser', {
        token: payload.data.token,
        refresh_token: payload.data.refresh_token,
        user: JSON.stringify(aUser)
      })
    },

    personalInfoId({ commit }, personalInfoId) {
      console.log(personalInfoId)
      let user = localStorage.getItem('user')
      let jsonUser = JSON.parse(user)
      jsonUser.info = personalInfoId 
      localStorage.setItem('user', JSON.stringify(jsonUser))
      commit('setInfo', personalInfoId)
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
    refreshToken (state) {
      return state.refresh_token
    },
    token(state){
      return state.token
    }
  }
}