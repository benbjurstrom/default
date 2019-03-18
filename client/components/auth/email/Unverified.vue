<template>
  <article class="message is-primary">
    <div class="message-header">
      <p>
        Email Verification Required
      </p>
    </div>
    <div class="message-body content">
      <p>
        Before proceeding please check your email ({{ email }}) for a verification link.
      </p>
      <a class="button is-small" @click.prevent="resend">Resend Email</a>
    </div>
  </article>
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
        await this.$store.dispatch('auth/email/resendVerification', {
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
