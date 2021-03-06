import _ from 'lodash'
export default function ({ store, redirect, route }) {
  // if the user is  logged in they must be verified

  // return if the user is not logged in
  if (!store.state.auth.loggedIn) {
    return
  }

  // to avoid a loop return if the current route is /auth/unverified
  if (route.path === '/auth/email/unverified') {
    return
  }

  // bounce if the user is hitting the verification link
  if (route.path === '/auth/email/verify') {
    return
  }

  // redirect to /unverified if the user is not verified
  const verified = _.get(store.state.auth, 'user.verified')
  if (!verified) {
    return redirect('/auth/email/unverified')
  }
}
