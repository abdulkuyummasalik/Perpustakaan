const mix = require('laravel-mix');

// Compile file SASS (SCSS) ke dalam folder public/css
mix.sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false  // Jangan ubah URL di CSS
    });

// Compile JavaScript (opsional jika ingin meng-compile file JavaScript)
mix.js('resources/js/app.js', 'public/js');
