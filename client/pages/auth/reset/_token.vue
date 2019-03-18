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
import Reset from '~/components/auth/password/Reset'
export default {
  components: {
    Reset
  },
  auth: false,
  middleware: 'guest',
  validate ({ params }) {
    // Must be 64 characters
    return /^[a-zA-Z0-9]{64}$/.test(params.token)
  },
  data () {
    return {
      //
    }
  },
  async fetch ({ app, params, query, error }) {
    try {
      await app.$axios.get('v1/auth/password/reset', { params: {
        email: query.email,
        token: params.token
      } })
    } catch (e) {
      return error({ statusCode: 404, message: e.message })
    }
  }
}
</script>
