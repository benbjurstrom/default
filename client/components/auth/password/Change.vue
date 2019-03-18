<template>
  <form @submit.prevent="changePassword">
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
    ...mapState('auth', ['user'])
  },
  methods: {
    async changePassword () {
      try {
        await this.$store.dispatch('user/updatePassword', {
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
