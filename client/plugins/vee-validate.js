import Vue from 'vue'
import VeeValidate from 'vee-validate'
import VeeValidateLaravel from 'vee-validate-laravel'

Vue.use(VeeValidateLaravel)
Vue.use(VeeValidate, {
  // https://baianat.github.io/vee-validate/configuration.html
  inject: true
})
