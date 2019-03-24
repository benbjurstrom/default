<template>
  <div class="columns is-centered">
    <div class="column is-half">
      <Register />
    </div>
  </div>
</template>
<script>
import Register from '~/components/auth/Register'
export default {
  auth: false,
  middleware: 'guest',
  components: {
    Register
  },
  async fetch ({ app, params, query, error, redirect, store }) {
    try {
      await store.dispatch('auth/agreements/get')
    } catch (e) {
      return error({ statusCode: 403, message: e.message })
    }
  }
}

</script>
