<template>
  <div class="columns is-centered">
    <div class="column is-half">
      <Reset
        :email="$route.query.email"
        :token="$route.params.token"
      />
    </div>
  </div>
</template>
<script>
export default {
  async fetch ({ app, params, query, error, redirect }) {
    try {
      await app.$axios.get('v1/auth/password/reset', { params: { signature: query.signature } })
      await this.$auth.fetchUser()
      redirect('/')
    } catch (e) {
      return error({ statusCode: 403, message: e.message })
    }
  }
}
</script>
