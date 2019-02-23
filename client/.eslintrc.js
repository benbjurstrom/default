module.exports = {
  root: true,
  parserOptions: {
    parser: "babel-eslint"
  },
  env: {
    browser: true,
    node: true
  },
  extends: [
    '@vue/standard',
    'plugin:vue/recommended'
  ],
  // required to lint *.vue files
  plugins: [
    'vue'
  ],
  // add your custom rules here
  rules: {
    'quotes': ['error', 'single'],
    'vue/max-attributes-per-line': ['error', {
      'singleline': 100,
      'multiline': {
        'max': 1,
        'allowFirstLine': false
      }
    }]
  },
  globals: {}
}
