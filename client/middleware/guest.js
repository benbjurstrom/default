export default function ({ store, redirect }) {
  // Guest only middleware. Redirect home if user is logged in.
  if (store.state.auth.loggedIn) {
    return redirect('/')
  }
}
