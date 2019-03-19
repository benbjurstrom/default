import { getField, updateField } from 'vuex-map-fields'

const initialState = {
  form: {
    password: null,
    password_new: null,
    password_new_confirmation: null
  }
}

export default {
  namespaced: true,
  state: JSON.parse(JSON.stringify(initialState)),
  getters: {
    getField
  },
  actions: {
    async change ({ commit, state }, config) {
      await this.$axios.patch('v1/auth/password/change', {
        ...state.form
      }, config)
      commit('RESET_FORM')
    }
  },
  mutations: {
    RESET_FORM (state) {
      Object.assign(state.form, initialState.form)
    },
    updateField
  }
}
