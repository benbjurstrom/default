<template>
  <div class="columns is-centered">
    <div class="column is-half">
      <section class="section">
        <ChangeEmail />
      </section>
      <section class="section">
        <!--<ChangePassword />-->
      </section>
    </div>
  </div>
</template>
<script>
import ChangeEmail from '~/components/auth/email/Change'
// import ChangePassword from '~/components/auth/ChangePassword'
export default {
  components: {
    ChangeEmail
    // ChangePassword
  },
  async fetch ({ store }) {
    await store.dispatch('user/get')
  }
}
</script>
