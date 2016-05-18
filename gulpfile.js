var elixir = require('laravel-elixir');
var bowerComponent = 'vendor/bower_components/';

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
});

//css
elixir(function(mix) {
	mix.styles('app.min.1.css');
	mix.styles('app.min.2.css');
});

//js
elixir(function(mix) {
	mix.scripts('functions.js');
});

//vendor css
elixir(function(mix) {
	mix.copy(bowerComponent + 'animate.css/animate.min.css', 'public/css/animate.min.css');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/css/material-design-iconic-font.min.css', 'public/css/material-design-iconic-font.min.css');
});

//vendor js
elixir(function(mix) {
	mix.copy(bowerComponent + 'jquery/dist/jquery.min.js', 'public/js/jquery.min.js');
	mix.copy(bowerComponent + 'bootstrap/dist/bootstrap.min.js', 'public/js/bootstrap.min.js');
	mix.copy(bowerComponent + 'Waves/dist/waves.min.js', 'public/js/waves.min.js');
});

//vendor font
elixir(function(mix) {
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.eot', 'public/fonts/Material-Design-Iconic-Font.eot');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.svg', 'public/fonts/Material-Design-Iconic-Font.svg');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.ttf', 'public/fonts/Material-Design-Iconic-Font.ttf');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.woff', 'public/fonts/Material-Design-Iconic-Font.woff');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.woff2', 'public/fonts/Material-Design-Iconic-Font.woff2');
});