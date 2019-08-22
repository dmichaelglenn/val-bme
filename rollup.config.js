import resolve from 'rollup-plugin-node-resolve';


export default {
  input: 'assets/js/val-bm.js',
  output: {
    file: 'custom.js',
    format: 'iife'
  },
  plugins: [
    resolve()
  ]
};