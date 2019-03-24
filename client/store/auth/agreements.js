const initialState = {
  data: {
    terms: {
      sha: null
    },
    privacy: {
      sha: null
    }
  }
}

export default {
  namespaced: true,
  state: JSON.parse(JSON.stringify(initialState)),
  actions: {
    async get ({ commit }, config) {
      const { data } = await this.$axios.get('v1/auth/agreements', config)
      console.log(data)
      commit('SET', data)
    }
  },
  mutations: {
    SET: (state, data) => {
      state.data.terms.sha = data.terms.sha
      state.data.privacy.sha = data.privacy.sha
    },
    RESET (state) {
      Object.assign(state, initialState)
    }
  }
}
