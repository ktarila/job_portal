
export default {
  state: {
    notification: null,
    type: null
  },
  mutations: {
    addMessage(state, message) {
      state.notification = message.notification
      state.type = message.type
    },
    removeMessage(state) {
      state.notification = null
      state.type = null
    },
  },
  actions: {
    addNotification({ commit }, message) {
      console.log(message)
      commit('addMessage', message)
    },

    clearNotification({ commit }) {
      commit('removeMessage')
    },
  },
  getters: {
    getNotificationMessage(state) {
      return state.notification
    },
    getNotificationType(state) {
      return state.type
    },
  }
}