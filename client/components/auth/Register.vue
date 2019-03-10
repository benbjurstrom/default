<template>
  <div>
    <h1 class="title">
      Register New Account
    </h1>
    <form @submit.prevent="register">
      <b-field
        label="Name"
        :type="{'is-danger': errors.has('name')}"
        :message="errors.first('name')"
      >
        <b-input v-model="form.name" v-validate="'required'" type="text" name="name" />
      </b-field>
      <b-field
        label="Email"
        :type="{'is-danger': errors.has('email')}"
        :message="errors.first('email')"
      >
        <b-input v-model="form.email" v-validate="'required|email'" type="text" name="email" />
      </b-field>

      <b-field
        label="Password"
        :type="{'is-danger': errors.has('password')}"
        :message="errors.first('password')"
      >
        <b-input
          v-model="form.password"
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
            Register
          </button>
        </div>
      </div>
    </form>
    <div class="has-text-centered" style="margin-top: 2rem">
      <a
        href="#"
        class="is-size-7"
        @click.prevent="$router.push('/login')"
      >
        Already registered? Click here to login!
      </a>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      form: {
        name: null,
        email: null,
        password: null
      }
    }
  },
  methods: {
    async register () {
      try {
        await this.$axios.post('/v1/auth/register', this.form, {
          container: this.$el,
          validator: this.$validator
        })

        await this.$auth.loginWith('local', { data: this.form },
          {
            container: this.$el,
            validator: this.$validator
          })
        this.$router.push('/')
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>
