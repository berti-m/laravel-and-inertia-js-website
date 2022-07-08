let mix = require('laravel-mix');

mix.js("resources/js/app.js", "public/js")
  .extract()
  .postCss("resources/css/app.css", "public/css", [require('tailwindcss'),])
  .vue(3)
  .version();