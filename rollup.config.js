import resolve from 'rollup-plugin-node-resolve';


export default {
  input: 'assets/js/val-bm.js',
  output: {
    file: 'valbm.js',
    format: 'iife'
  },
  plugins: [
    resolve()
  ]
};