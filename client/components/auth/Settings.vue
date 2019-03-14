<template>
  <div>
    <section class="section">
      <h1 class="title is-2">
        User Settings
      </h1>
    </section>
    <section class="section">
      <form action="">
        <h2 class="title is-4">
          Change Email Address
        </h2>
        <h3 class="subtitle is-6">
          Current email address:
          <i>
            {{ user.email }}
          </i>
        </h3>
        <b-field
          label="Email"
          :type="{'is-danger': errors.has('email')}"
          :message="errors.first('email')"
        >
          <b-input v-model="email" v-validate="'required|email'" type="text" name="email" />
        </b-field>
        <b-field
          label="Enter password to confirm change"
          :type="{'is-danger': errors.has('current_password')}"
          :message="errors.first('current_password')"
        >
          <b-input
            v-model="form.current"
            v-validate="'required|min:3'"
            type="password"
            name="current_password"
            password-reveal
          />
        </b-field>
        <br>
        <div class="field is-grouped">
          <div class="control">
            <button
              type="submit"
              class="button is-link"
            >
              Change email address
            </button>
          </div>
        </div>
      </form>
    </section>
    <section class="section">
      <form action="">
        <h2 class="title is-4">
          Change Password
        </h2>
        <h3 class="subtitle is-6">
          Password must be at least 15 characters or 8 characters with one number and one special character
        </h3>
        <b-field
          label="Old password"
          :type="{'is-danger': errors.has('current_password')}"
          :message="errors.first('current_password')"
        >
          <b-input
            v-model="form.current"
            v-validate="'required|min:3'"
            type="password"
            name="current_password"
            password-reveal
          />
        </b-field>
        <b-field
          label="New Password"
          :type="{'is-danger': errors.has('password')}"
          :message="errors.first('password')"
        >
          <b-input
            v-model="form.new"
            v-validate="'required|min:3'"
            type="password"
            name="password"
            password-reveal
          />
        </b-field>
        <b-field
          label="Confirm New Password"
          :type="{'is-danger': errors.has('password')}"
          :message="errors.first('password')"
        >
          <b-input
            v-model="form.confirm"
            v-validate="'required|min:3'"
            type="password"
            name="password"
            password-reveal
          />
        </b-field>
        <br>
        <div class="field is-grouped">
          <div class="control">
            <button
              type="submit"
              class="button is-link"
            >
              Update password
            </button>
          </div>
        </div>
      </form>
    </section>
  </div>
</template>
<script>
import { mapState } from 'vuex'
export default {
  data () {
    return {
      form: {
        current: null,
        new: null,
        confirm: null
      }
    }
  },
  computed: {
    ...mapState('auth', ['user']),
    primary () {
      return this.$vuetify.theme.primary
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
