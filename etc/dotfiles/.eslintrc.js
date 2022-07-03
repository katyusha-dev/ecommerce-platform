const path = require('path')

module.exports = {
  root: false,
  // parser: 'vue-eslint-parser',
  parserOptions: {
    parser: '@typescript-eslint/parser',
    ecmaVersion: 2020,
    sourceType: 'module',
    extraFileExtensions: ['.vue'],
    ecmaFeatures: {
      tsx: true,
      jsx: true
    }
  },
  // plugins: ['@typescript-eslint'],
  plugins: ['unused-imports', 'sort-class-members'],
  // extends: ['plugin:@typescript-eslint/recommended'],
  // extends: ['plugin:eslint-plugin-vue', 'plugin:@typescript-eslint/recommended'],
  extends: ['plugin:@typescript-eslint/recommended', 'plugin:vue/vue3-recommended'],
  rules: {
    'no-unused-vars': 'off',
    'unused-imports/no-unused-imports': 'error',
    'sort-imports': [
      'error',
      {
        'ignoreDeclarationSort': true
      }],
    camelcase: 0,
    semi: ['error', 'never'],
    semicolon: 'off',
    indent: 'off',
    quotes: 'off',
    eqeqeq: ['error', 'always'],
    'vue/no-deprecated-slot-attribute': 'off',
    'unused-imports/no-unused-vars': 'off',
    'vue/html-self-closing': 'off',
    'no-param-reassign': 'off',
    'max-len': 'off',
    'import/no-unused-modules': 0,
    'vue/max-attributes-per-line': 0,
    'no-angle-bracket-type-assertion': 0,
    'no-var-requires': 0,
    'no-return-await': 0,
    'vue/no-deprecated-v-on-native-modifier': 'off',
    'vue/v-on-style': 'off',
    'vue/no-use-v-if-with-v-for': 'off',
    'vue/no-v-for-template-key-on-child': 'off',
    '@typescript-eslint/ban-types': 0,
    '@typescript-eslint/no-var-requires': 0,
    '@typescript-eslint/no-angle-bracket-type-assertion': 0,
    '@typescript-eslint/no-namespace': 0,
    '@typescript-eslint/explicit-module-boundary-types': 0,
    'import/no-webpack-loader-syntax': 0,
    // eslint
    'one-var': 0,
    'arrow-parens': 0,
    'generator-star-spacing': 0,
    'no-debugger': 0,
    'no-console': 0,
    'no-extra-semi': 1,
    'space-before-function-paren': 0,
    'no-useless-escape': 1,
    'no-tabs': 1,
    'no-mixed-spaces-and-tabs': 1,
    'new-cap': 0,
    'no-new': 0,
    'prefer-const': 1,
    'vue/no-v-html': 0,
    'lines-between-class-members': 0,
    'no-unused-expressions': 1,
    'object-curly-spacing': ['error', 'always'],
    'vue/singleline-html-element-content-newline': 0,
    'no-trailing-spaces': 0,
    'spaced-comment': ['error'],
    'no-multi-spaces': ['error', { exceptions: { 'VariableDeclarator': true } }],
    'object-shorthand': ['error', 'always'],
    'no-multiple-empty-lines': [
      'error',
      {
        max: 1,
        maxEOF: 1,
        maxBOF: 0
      }
    ],
    'func-call-spacing': 'off',
    'brace-style': 'off',
    'comma-dangle': ['error', 'never'],
    'comma-spacing': 'off',
    '@typescript-eslint/quotes': ['error', 'single', { allowTemplateLiterals: true }],
    '@typescript-eslint/comma-spacing': ['error', { before: false, after: true }],
    '@typescript-eslint/comma-dangle': ['error', 'never'],
    '@typescript-eslint/brace-style': ['error', '1tbs'],
    '@typescript-eslint/func-call-spacing': ['error', 'never'],
    '@typescript-eslint/array-type': 'off',
    '@typescript-eslint/no-unused-vars': 'off',
    'eslint@typescript-eslint/ban-ts-comment': 0,
    '@typescript-eslint/ban-ts-comment': 0,
    '@typescript-eslint/no-explicit-any': 'off',
    '@typescript-eslint/no-this-alias': 0,
    '@typescript-eslint/no-inferrable-types': 0,
    '@typescript-eslint/semi': ['error', 'never'],
    '@typescript-eslint/indent': ['error', 2],
    '@typescript-eslint/member-delimiter-style': [
      'error',
      {
        multiline: {
          delimiter: 'semi',
          requireLast: true
        },
        singleline: {
          delimiter: 'semi',
          requireLast: false
        },
        multilineDetection: 'brackets'
      }
    ],
    '@typescript-eslint/explicit-member-accessibility': 0,
    '@typescript-eslint/explicit-function-return-type': 0,
    '@typescript-eslint/no-empty-function': 0,
    'sort-class-members/sort-class-members': [
      2,
      {
        'order': [
          '[properties]',
          '[conventional-private-properties]',
          '[static-properties]',
          'constructor',
          '[arrow-function-properties]',
          '[static-methods]',
          '[methods]',
          '[conventional-private-methods]'
        ],
        'accessorPairPositioning': 'getThenSet'
      }
    ],
    'vue/valid-template-root': 'off'
  }
}
