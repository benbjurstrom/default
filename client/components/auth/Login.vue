<template>
  <div>
    <h1 class="title">
      Login
    </h1>
    <form @submit.prevent="login">
      <b-field
        label="Email"
        :type="{'is-danger': errors.has('email')}"
        :message="errors.first('email')"
      >
        <b-input v-model="email" v-validate="'required|email'" type="text" name="email" />
      </b-field>

      <b-field
        label="Password"
        :type="{'is-danger': errors.has('password')}"
        :message="errors.first('password')"
      >
        <b-input
          v-model="password"
          v-validate="'required|min:3'"
          type="password"
          name="password"
          password-reveal
        />
      </b-field>
      <div class="level">
        <div class="level-left">
          <button
            type="submit"
            class="button is-link"
          >
            Login
          </button>
        </div>
        <div class="level-right">
          <a
            href="#"
            class="is-size-7"
            @click.prevent="$router.push('/auth/reset')"
          >
            Forgot Password?
          </a>
        </div>
      </div>
    </form>
    <div class="has-text-centered" style="margin-top: 2rem">
      <a
        href="#"
        class="is-size-7"
        @click.prevent="$router.push('/auth/register')"
      >
        Don't have an account? Register Now!
      </a>
    </div>
  </div>
</template>
<script>
export default {
  components: {
    //
  },
  data () {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    async login () {
      try {
        await this.$auth.loginWith('local', { data: { email: this.email, password: this.password },
          container: this.$el,
          validator: this.$validator
        })
        this.$router.push('/')
      } catch (e) {
        console.error(e)
      }
    }
  }
}
</script>
