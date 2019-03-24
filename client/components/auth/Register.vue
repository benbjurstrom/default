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
      <b-field
        label=""
        :type="{'is-danger': errors.has('terms')}"
        :message="{'Please check this box to proceed' : errors.firstByRule('terms', 'required')}"
      >
        <b-checkbox
          v-model="form.terms"
          v-validate="'required:false'"
          name="terms"
          size="is-small"
        >
          I accept the <a href="#" @click.prevent="">privacy policy</a> and <a href="#" @click.prevent="">terms of use</a>
        </b-checkbox>
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
import { mapState } from 'vuex'
export default {
  data () {
    return {
      form: {
        name: null,
        email: null,
        password: null,
        terms: true,
        agreements: {
          privacy: null,
          terms: null
        }
      }
    }
  },
  computed: {
    ...mapState('auth/agreements', {
      agreements: 'data'
    })
  },
  methods: {
    async register () {
      try {
        this.form.agreements.privacy = this.agreements.privacy.sha
        this.form.agreements.terms = this.agreements.terms.sha
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
