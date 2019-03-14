<template>
  <div>
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
            src="https://buefy.org/static/img/buefy.1d65c18.png"
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

    <section class="main-content columns">
      <div class="container column is-10">
        <section class="section">
          <nuxt />
        </section>
      </div>
    </section>
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
  }
}
</script>
