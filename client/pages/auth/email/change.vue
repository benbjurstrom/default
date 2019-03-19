<template>
  <div class="columns is-centered" />
</template>
<script>
export default {
  async fetch ({ app, query, error, redirect }) {
    try {
      const route = Buffer.from(query.route, 'base64')
      await app.$axios.patch(route)
      await app.$auth.fetchUser()
      redirect('/auth/settings')
    } catch (e) {
      return error({ statusCode: 403, message: e.message })
    }
  }
}
</script>
