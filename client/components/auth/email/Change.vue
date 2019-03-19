<template>
  <div>
    <h2 class="title is-4">
      Change Email Address
    </h2>
    <h3 class="subtitle is-6">
      Current email address:
      <i>
        {{ user.email }}
      </i>
    </h3>
    <article v-if="user.email_pending" class="message is-primary">
      <div class="message-header">
        <p>
          Email Change Pending
        </p>
      </div>
      <div class="message-body content">
        <p>
          A verification email has been sent to <i>{{ user.email_pending }}</i>. To complete the requested email change please follow the link in the email.
        </p>
        <a class="button is-small" @click.prevent="resendChangeVerification">Resend Email</a>
        <a class="button is-small" @click.prevent="cancelChange">Cancel Request</a>
      </div>
    </article>
    <form v-else @submit.prevent="requestChange">
      <b-field
        label="New Email"
        :type="{'is-danger': errors.has('email')}"
        :message="errors.first('email')"
      >
        <b-input v-model="email" v-validate="'required|email'" type="text" name="email" />
      </b-field>
      <b-field
        label="Enter password to confirm change"
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
  </div>
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
    ...mapState('auth', {
      user: state => state.user
    }),
    ...mapFields('auth/email', [
      'form.email',
      'form.password'
    ])
  },
  methods: {
    async requestChange () {
      try {
        await this.$store.dispatch('auth/email/requestChange', {
          container: this.$el,
          validator: this.$validator
        })

        await this.$auth.fetchUser()
      } catch (e) {
        console.log(e)
      }
    },
    async resendChangeVerification () {
      try {
        await this.$store.dispatch('auth/email/resendChangeVerification', {
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
    },
    async cancelChange () {
      try {
        await this.$store.dispatch('auth/email/cancelChange', {
          container: this.$el,
          validator: this.$validator
        })

        await this.$auth.fetchUser()
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>
