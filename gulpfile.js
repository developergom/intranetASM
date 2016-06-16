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
	mix.scripts('demo.js');
	mix.scripts('charts.js');
	mix.scripts('flot-charts/curved-line-chart.js');
	mix.scripts('flot-charts/line-chart.js');
});

//vendor css
elixir(function(mix) {
	mix.copy(bowerComponent + 'animate.css/animate.min.css', 'public/css/animate.min.css');
	mix.copy(bowerComponent + 'fullcalendar/dist/fullcalendar.min.css', 'public/css/fullcalendar.min.css');
	mix.copy(bowerComponent + 'bootstrap-sweetalert/lib/sweet-alert.css', 'public/css/sweet-alert.min.css');
	mix.copy(bowerComponent + 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css', 'public/css/jquery.mCustomScrollbar.min.css');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/css/material-design-iconic-font.min.css', 'public/css/material-design-iconic-font.min.css');
	mix.copy(bowerComponent + 'jquery.bootgrid/dist/jquery.bootgrid.min.css', 'public/css/jquery.bootgrid.min.css');
	mix.copy(bowerComponent + 'chosen/chosen.css', 'public/css/chosen.css');
});

//vendor js
elixir(function(mix) {
	mix.copy(bowerComponent + 'jquery/dist/jquery.min.js', 'public/js/jquery.min.js');
	mix.copy(bowerComponent + 'bootstrap/dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js');
	mix.copy(bowerComponent + 'Waves/dist/waves.min.js', 'public/js/waves.min.js');
	mix.copy(bowerComponent + 'flot/jquery.flot.js', 'public/js/jquery.flot.js');
	mix.copy(bowerComponent + 'flot/jquery.flot.resize.js', 'public/js/jquery.flot.resize.js');
	mix.copy(bowerComponent + 'flot.curvedlines/curvedLines.js', 'public/js/curvedlines.js');
	mix.copy(bowerComponent + 'moment/min/moment.min.js', 'public/js/moment.min.js');
	mix.copy(bowerComponent + 'fullcalendar/dist/fullcalendar.min.js', 'public/js/fullcalendar.min.js');
	mix.copy(bowerComponent + 'simpleWeather/jquery.simpleWeather.min.js', 'public/js/jquery.simpleWeather.min.js');
	mix.copy(bowerComponent + 'bootstrap-sweetalert/lib/sweet-alert.min.js', 'public/js/sweet-alert.min.js');
	mix.copy(bowerComponent + 'remarkable-bootstrap-notify/dist/bootstrap-notify.min.js', 'public/js/bootstrap-notify.min.js');
	mix.copy(bowerComponent + 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js', 'public/js/jquery.mCustomScrollbar.concat.min.js');
	mix.copy(bowerComponent + 'jquery.bootgrid/dist/jquery.bootgrid.min.js', 'public/js/jquery.bootgrid.min.js');
	mix.copy(bowerComponent + 'input-mask/input-mask.min.js', 'public/js/input-mask.min.js');
	mix.copy(bowerComponent + 'chosen/chosen.jquery.js', 'public/js/chosen.jquery.js');
	mix.copy(bowerComponent + 'jquery.price_format/jquery.price_format.min.js', 'public/js/jquery.price_format.min.js');
});

//vendor font
elixir(function(mix) {
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.eot', 'public/fonts/Material-Design-Iconic-Font.eot');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.svg', 'public/fonts/Material-Design-Iconic-Font.svg');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.ttf', 'public/fonts/Material-Design-Iconic-Font.ttf');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.woff', 'public/fonts/Material-Design-Iconic-Font.woff');
	mix.copy(bowerComponent + 'material-design-iconic-font/dist/fonts/Material-Design-Iconic-Font.woff2', 'public/fonts/Material-Design-Iconic-Font.woff2');

	mix.copy('resources/assets/fonts/**','public/fonts');
});