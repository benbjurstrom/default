<template>
  <div>
    <h1 class="title">
      Change Password
    </h1>
    <form @submit.prevent="updatePassword">
      <b-field
        disabled
        label="Email"
        :type="{'is-danger': errors.has('email')}"
        :message="errors.first('email')"
      >
        <b-input v-model="form.email" v-validate="'required|email'" type="text" name="email" disabled />
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
            Save Password
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
  props: {
    email: {
      required: true,
      type: String
    },
    token: {
      required: true,
      type: String
    }
  },
  data () {
    return {
      form: {
        email: null,
        password: null,
        confirm: null
      }
    }
  },
  mounted () {
    this.form.email = this.email
  },
  methods: {
    async updatePassword () {
      try {
        await this.$axios.patch('/v1/auth/password/reset',
          {
            email: this.email,
            token: this.token,
            password: this.form.password
          },
          {
            container: this.$el,
            validator: this.$validator
          }
        )
        await this.$auth.loginWith('local', { data: this.form })
        this.$router.push('/')
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>
