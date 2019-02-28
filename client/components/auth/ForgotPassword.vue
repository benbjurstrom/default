<template>
  <div>
    <form v-if="!success" @submit.prevent="reset">
      <h3 class="title is-3">
        Forgot Password
      </h3>
      <b-field
        label="Email"
        :type="{'is-danger': errors.has('email')}"
        :message="errors.first('email')"
      >
        <b-input v-model="email" v-validate="'required|email'" type="text" name="email" />
      </b-field>
      <div class="level">
        <div class="level-left">
          <button
            type="submit"
            class="button is-link"
          >
            Send Reset Link
          </button>
        </div>
        <div class="level-right">
          <a
            href="#"
            class="is-size-7"
            @click.prevent="$router.push('/login')"
          >
            Back to login
          </a>
        </div>
      </div>
    </form>
    <div v-else>
      <h3 class="title is-3">
        Success!
      </h3>
      <p class="title is-7">
        If the email {{ email }} belongs to an active account a password reset link will be dispatched.
      </p>
      <a
        href="#"
        class="is-size-7"
        @click.prevent="$router.push('/login')"
      >
        Back to login
      </a>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      email: '',
      loading: false,
      success: false
    }
  },
  methods: {
    async reset () {
      const isValid = await this.$validator.validateAll()
      if (isValid) {
        try {
          this.loading = true
          await this.$axios.post('v1/auth/password/email', { email: this.email })
          this.success = true
        } catch (e) {
          this.$setLaravelValidationErrorsFromResponse(e.response.data)
        } finally {
          this.loading = false
        }
      }
    }
  }
}
</script>
