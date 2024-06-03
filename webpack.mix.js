const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
.sass('resources/sass/app.scss', 'public/css');


mix
  .js(["resources/js/admin/admin.js"], "public/js")
  .sass("resources/sass/admin/admin.scss", "public/css")
  .vue();

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
