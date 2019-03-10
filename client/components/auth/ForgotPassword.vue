<template>
  <div>
    <form v-if="!success" @submit.prevent="reset">
      <h1 class="title">
        Forgot Password
      </h1>
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
      <h3 class="title">
        Success!
      </h3>
      <p class="">
        If the email {{ email }} belongs to an active account a password reset link will be dispatched.
      </p>
      <br>
      <p>
        <a
          href="#"
          class="is-size-7"
          @click.prevent="$router.push('/login')"
        >
          Back to login
        </a>
      </p>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      email: '',
      success: false
    }
  },
  methods: {
    async reset () {
      try {
        await this.$axios.post('v1/auth/password/email', { email: this.email },
          {
            container: this.$el,
            validator: this.$validator
          })
        this.success = true
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>
