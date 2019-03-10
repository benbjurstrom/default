<template>
  <div>
    <h1 class="title">
      Email Verification Required
    </h1>
    <p>
      Before proceeding please check your email ({{ email }}) for a verification link. If you did not receive the email
      <a href="#" @click.prevent="resend()">click here to request another</a>.
    </p>
  </div>
</template>
<script>
export default {
  computed: {
    email () {
      return this.$store.state.auth.user.email
    }
  },
  methods: {
    async resend () {
      try {
        await this.$axios.post('v1/auth/password/email', {
          email: this.email
        }, {
          container: this.$el,
          validator: this.$validator
        })

        this.$toast.open({
          message: 'Success! A new email has been sent.',
          type: 'is-success'
        })
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>
