<template>
  <form ref="element" @submit.prevent="changePassword">
    <h2 class="title is-4">
      Change Password
    </h2>
    <h3 class="subtitle is-6">
      Password must be at least 15 characters or 8 characters with one number and one special character
    </h3>
    <b-field
      label="Current password"
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
    <b-field
      label="New Password"
      :type="{'is-danger': errors.has('password_new')}"
      :message="errors.first('password_new')"
    >
      <b-input
        v-model="password_new"
        v-validate="'required|min:3'"
        type="password"
        name="password_new"
        password-reveal
      />
    </b-field>
    <b-field
      label="Confirm New Password"
      :type="{'is-danger': errors.has('password_new_confirmation')}"
      :message="errors.first('password_new_confirmation')"
    >
      <b-input
        v-model="password_new_confirmation"
        v-validate="'required|min:3'"
        type="password"
        name="password_new_confirmation"
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
import { mapFields } from 'vuex-map-fields'
import { mapState } from 'vuex'
export default {
  data () {
    return {
      //
    }
  },
  computed: {
    ...mapFields('auth/password', [
      'form.password',
      'form.password_new',
      'form.password_new_confirmation'
    ]),
    ...mapState('auth', ['user'])
  },
  methods: {
    async changePassword () {
      try {
        await this.$store.dispatch('auth/password/change', {
          container: this.$el,
          validator: this.$validator
        })

        this.$toast.open({
          message: 'Success! Your password has been updated.',
          type: 'is-success'
        })
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>
