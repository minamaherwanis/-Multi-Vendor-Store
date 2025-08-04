const mix = require('laravel-mix');

mixz
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
   ])
   .version();
