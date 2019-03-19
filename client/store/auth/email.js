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
      }, config)
    },
    async resendVerification ({ commit, state }, config) {
      await this.$axios.get('v1/auth/email/verify', config)
    },
    async requestChange ({ commit, state }, config) {
      await this.$axios.post('v1/auth/email/change', {
        ...state.form
      }, config)
    },
    async resendChangeVerification ({ commit, state }, config) {
      await this.$axios.get('v1/auth/email/change', config)
    },
    async verifyChange ({ commit, state, dispatch }, config) {
      await this.$axios.patch('v1/auth/email/change', {
        ...state.form
      }, config)
    },
    async cancelChange ({ commit, state, dispatch }, config) {
      await this.$axios.delete('v1/auth/email/change', {
        ...state.form
      }, config)
    }
  },
  mutations: {
    RESET_FORM (state) {
      Object.assign(state.form, initialState.form)
    },
    updateField
  }
}
