<template>
  <span>
    <button
        class="button is-primary is-medium"
        @click="isComponentModalActive = true"
    >
      Launch component modal
  </button>
  <b-modal :active.sync="isComponentModalActive" has-modal-card>
    <modal-form v-bind="formProps"></modal-form>
  </b-modal>
  </span>
</template>
