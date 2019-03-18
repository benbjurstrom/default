import { getField, updateField } from 'vuex-map-fields'

const initialState = {
  data: {
    id: null,
    name: null,
    email: null,
    emailPending: null,
    gravatar: null
  },
  form: {
    email: null,
    password: null,
    password_old: null,
    password_new: null,
    password_new_confirm: null
  }
}

export default {
  namespaced: true,
  state: JSON.parse(JSON.stringify(initialState)),
  getters: {
    getField
  },
  actions: {
    async get ({ commit }, config) {
      const { data } = await this.$axios.get('v1/auth/user', config)
      commit('SET', data)
    },
    async changePassword ({ commit, state }, config) {
      await this.$axios.patch('v1/auth/user/password', {
        ...state.form
      })
    },
    async emailChangeResend ({ commit, state }, config) {
      await this.$axios.get('v1/auth/user/email', {
        ...state.form
      })
    },
    async changeEmail ({ commit, state }, config) {
      const { data } = await this.$axios.post('v1/auth/user/email', {
        ...state.form
      })
      commit('SET', data)
    },
    async emailChangeCancel ({ commit, state, dispatch }, config) {
      await this.$axios.delete('v1/auth/user/email', {
        ...state.form
      })
      await dispatch('get')
    }
  },
  mutations: {
    SET: (state, data) => {
      state.data.id = data.data.id
      state.data.name = data.data.name
      state.data.email = data.data.email
      state.data.emailPending = data.data.email_pending
      state.data.gravatar = data.data.gravatar
    },
    RESET (state) {
      Object.assign(state, JSON.parse(JSON.stringify(initialState)))
    },
    RESET_FORM (state) {
      Object.assign(state.form, initialState.form)
    },
    updateField
  }
}
