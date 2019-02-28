<template>
  <b-dropdown v-if="$auth.loggedIn" position="is-bottom-left">
    <template>
      <a slot="trigger" class="navbar-item">
        <figure class="image is-24x24">
          <img class="is-rounded" :src="'https://www.gravatar.com/avatar/' + user.gravatar + '?d=mp'">
        </figure>
      </a>

      <b-dropdown-item custom>
        {{ user.email }}
      </b-dropdown-item>
      <hr class="dropdown-divider">
      <b-dropdown-item value="settings">
        <b-icon icon="settings" />
        Settings
      </b-dropdown-item>
      <b-dropdown-item value="logout" @click="logout">
        <b-icon icon="logout" />
        Logout
      </b-dropdown-item>
    </template>
  </b-dropdown>
  <a v-else class="navbar-item" @click.prevent="$router.push('/login')">
    Sign In
  </a>
</template>
<script>
import { mapState } from 'vuex'
export default {
  data () {
    return {
      //
    }
  },
  computed: {
    ...mapState('auth', ['user']),
    primary () {
      return this.$vuetify.theme.primary
    }
  },
  methods: {
    async logout () {
      this.$emit('loading', true)
      await this.$auth.logout()
      this.$emit('loading', false)
    }
  }
}
</script>
