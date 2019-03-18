import { getField, updateField } from 'vuex-map-fields'

const initialState = {
  form: {
    email: null,
    password: null,
    signature: null
  }
}

export default {
  namespaced: true,
  state: JSON.parse(JSON.stringify(initialState)),
  getters: {
    getField
  },
  actions: {
    async verify ({ commit, state, dispatch }, config) {
      await this.$axios.patch('v1/auth/email/verify', {
        ...state.form
      })
      await dispatch('get')
    },
    async resendVerification ({ commit, state }, config) {
      await this.$axios.get('v1/auth/email/verify', {
        ...state.form
      })
    },
    async requestChange ({ commit, state }, config) {
      const { data } = await this.$axios.post('v1/auth/email/change', {
        ...state.form
      })
      commit('SET', data)
    },
    async resendChangeVerification ({ commit, state }, config) {
      await this.$axios.get('v1/auth/email/change', {
        ...state.form
      })
    },
    async verifyChange ({ commit, state, dispatch }, config) {
      await this.$axios.delete('v1/auth/email/change', {
        ...state.form
      })
      await dispatch('get')
    },
    async cancelChange ({ commit, state, dispatch }, config) {
      await this.$axios.delete('v1/auth/email/change', {
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
