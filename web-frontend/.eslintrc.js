module.exports = {
  'env': {
    'browser': true,
    'es6': true,
  },
  'extends': [
    'plugin:vue/essential',
    'google',
  ],
  'parserOptions': {
    'ecmaVersion': 12,
    'sourceType': 'module',
  },
  'plugins': [
    'vue',
  ],
  'rules': {
    "max-len": ["warn", 120],
    "dot-notation": ["off"],
    "no-unused-vars": ["warn"],
    "no-console": ["off"],
    "arrow-body-style": ["off"],
    "no-empty-pattern": ["off"],
    "no-param-reassign": ["off"],
    "comma-dangle": ["error", "only-multiline"],
    "import/extensions": 0,
    // TODO: setup webpack imports linting later
    "import/no-unresolved": [2, { ignore: ['^@/'] }],
    "no-plusplus": ["off"],
    "no-trailing-spaces": ["off"],
    "object-shorthand": ["off"],
    "object-curly-spacing": ["off"],
    "camelcase": ["off"],
    "quotes": ["off"],
    "vue/multi-word-component-names": ["off"],
    "import/no-unresolved": ["off"],
    "brace-style": ["off"],
    "block-spacing": ["warn"],
    "no-var": ["off"],
    "arrow-parens": ["warn"]
  },
};
