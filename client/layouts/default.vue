<template>
  <div class="site">
    <nav
      class="navbar header"
      role="navigation"
      aria-label="main navigation"
    >
      <div class="navbar-brand">
        <a
          class="navbar-item"
          href="/"
        >
          <img
            src="~/assets/viga.png"
            alt="Buefy"
            height="28"
          >
        </a>

        <div
          class="navbar-burger"
          :class="{ 'is-active' : showNav }"
          @click="showNav = !showNav"
        >
          <span />
          <span />
          <span />
        </div>
      </div>

      <div class="navbar-menu" :class="{ 'is-active' : showNav }">
        <div class="navbar-start" />
        <div class="navbar-end">
          <Menu />
        </div>
      </div>
    </nav>

    <div class="site-content">
      <section class="main-content columns">
        <div class="container column is-10">
          <section class="section">
            <nuxt />
          </section>
        </div>
      </section>
    </div>

    <footer class="footer">
      <div class="content has-text-centered">
        <p>
          <a href="">Terms of Use</a> &#183;
          <a href="">Privacy Policy</a> <br>
          &copy; {{ year }}
        </p>
      </div>
    </footer>
  </div>
</template>

<script>
import Menu from '~/components/Menu'
export default {
  components: { Menu },
  data () {
    return {
      showNav: false
    }
  },
  computed: {
    year () {
      return new Date().getFullYear()
    }
  }
}
</script>
