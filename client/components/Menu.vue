<template>
  <div v-if="$auth.loggedIn" class="navbar-item has-dropdown is-hoverable">
    <a class="navbar-link">
      <div class="media">
        <figure class="image is-24x24 media-left">
          <img class="is-rounded" :src="'https://www.gravatar.com/avatar/' + user.gravatar + '?d=mp'">
        </figure>
        <div class="media-content">
          {{ user.email }}
        </div>
      </div>
    </a>

    <div class="navbar-dropdown">
      <a class="navbar-item" @click.prevent="$router.push('/auth/settings')">
        <div class="media">
          <b-icon class="media-left" icon="settings" />
          <div class="media-content">
            Settings
          </div>
        </div>
      </a>
      <a class="navbar-item" @click.prevent="logout">
        <div class="media">
          <b-icon class="media-left" icon="logout" />
          <div class="media-content">
            Logout
          </div>
        </div>
      </a>
    </div>
  </div>
  <div v-else class="navbar-item">
    <a v-if="$route.path !== '/login'" class="navbar-item" @click.prevent="$router.push('/login')">
      Sign In
    </a>
  </div>
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
      await this.$auth.logout()
    }
  }
}
</script>
