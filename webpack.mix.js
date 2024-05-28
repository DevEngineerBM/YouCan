/* const mix = require('laravel-mix');
const webpack = require('webpack');
const path = require('path'); // Add this line

mix.js('resources/js/app.js', 'public/js')
   .vue()
   .sass('resources/sass/app.scss', 'public/css')
   .webpackConfig({
       resolve: { // Add this block
           alias: {
               '@stores': path.resolve(__dirname, 'resources/stores'),
           }
       },
       plugins: [
           new webpack.DefinePlugin({
               __VUE_OPTIONS_API__: true,
               __VUE_PROD_DEVTOOLS__: false,
               __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
           }),
       ],
   });
 */

   const mix = require('laravel-mix');
const webpack = require('webpack');
const path = require('path'); 

mix.js('resources/js/app.js', 'public/js')
   .vue()
    .postCss('resources/css/app.css', 'public/css')
   .webpackConfig({
       plugins: [
           new webpack.DefinePlugin({
               __VUE_OPTIONS_API__: true,
               __VUE_PROD_DEVTOOLS__: false,
               __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
           }),
       ],
   })
  
