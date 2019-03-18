import Vue from 'vue'
import _ from 'lodash'
import axios from 'axios'
import { Toast } from 'buefy/dist/components/toast'

export default function ({ $axios }) {
  let loading = null

  $axios.onRequest(async config => {
    const validator = _.get(config, 'validator')

    if (validator && !await validator.validateAll()) {
      throw new axios.Cancel('Client validation failed.')
    }

    // show loader by default
    if (_.get(config, 'loader' === false)) {
      return
    }

    loading = Vue.prototype.$loading.open({
      container: _.get(config, 'container')
    })

    return config
  })

  $axios.interceptors.response.use(
    // Do something with response data
    response => {
      if (loading) {
        loading.close()
      }

      return response
    },

    // Do something with response error
    async e => {
      if (loading) {
        loading.close()
      }

      if (e.constructor.name === 'Cancel') {
        return Promise.reject(e)
      }

      // if this is a network issue
      if (e.response === undefined) {
        Toast.open({
          message: 'Could not connect to server',
          type: 'is-light',
          queue: false
        })

        return Promise.reject(e)
      }

      // handle error by default
      if (_.get(e.config, 'handleError' === false)) {
        return Promise.reject(e)
      }

      const status = _.get(e, 'response.status')
      const validator = _.get(e, 'config.validator')

      if (status === 422 && validator) {
        showValidationErrors(validator, e.response.data)
        return Promise.reject(e)
      }

      showErrorMessage(status, e.response)

      return Promise.reject(e)
    }
  )
}

function showErrorMessage (status, response) {
  const message = _.get(response, 'data.message') ? _.get(response, 'data.message') : _.get(response, 'data.exception')
  Toast.open({
    message: status + ': ' + message,
    type: 'is-danger'
  })
}

function showValidationErrors (validator, errorResponseData) {
  // clear errors
  validator.errors.clear()

  // check if errors exist
  if (!errorResponseData.hasOwnProperty('errors')) {
    return
  }

  const errorFields = Object.keys(errorResponseData.errors)

  // insert laravel errors
  for (let i = 0; i < errorFields.length; i++) {
    const field = errorFields[i]

    const errorString = errorResponseData.errors[field].join(', ')
    validator.errors.add({ field: field, msg: errorString })
  }
}
