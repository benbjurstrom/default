<template>
  <div class="columns is-centered">
    <div class="column is-half">
      <ForgotPassword />
    </div>
  </div>
</template>
<script>
import ForgotPassword from '~/components/auth/password/Forgot'
export default {
  auth: false,
  middleware: 'guest',
  components: {
    ForgotPassword
  }
}
</script>
