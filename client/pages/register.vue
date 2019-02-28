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
  }
}
</script>
