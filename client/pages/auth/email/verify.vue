<template>
  <div class="columns is-centered" />
</template>
<script>
export default {
  async fetch ({ app, params, query, error, redirect, store }) {
    try {
      const id = store.state.auth.user.id
      await app.$axios.patch('v1/auth/email/verify?id=' + id + '&signature=' + query.signature)
      await store.dispatch('auth/fetchUser')
      redirect('/')
    } catch (e) {
      return error({ statusCode: 403, message: e.message })
    }
  }
}
</script>
