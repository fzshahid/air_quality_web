const mix = require('laravel-mix');

// Entry points and output paths
mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .vue(); // Include Vue support

// Enable source maps in development
if (!mix.inProduction()) {
    mix.sourceMaps();
}

// Versioning for production
if (mix.inProduction()) {
    mix.version();
}

// Explicitly handle .vue files
mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }
        ]
    }
});

// Ensure vue-loader plugin is used
const VueLoaderPlugin = require('vue-loader/lib/plugin');
mix.webpackConfig({
    plugins: [
        new VueLoaderPlugin()
    ]
});
