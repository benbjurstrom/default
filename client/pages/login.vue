<template>
  <div class="columns is-centered">
    <div class="column is-half">
      <Login />
    </div>
  </div>
</template>
<script>
import Login from '~/components/auth/Login'
export default {
  auth: false,
  middleware: 'guest',
  components: {
    Login
  }
}
</script>
