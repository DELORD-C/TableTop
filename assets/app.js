import './bootstrap.js';
import './styles/app.scss';

// Bootstrap Framework
import 'bootstrap/scss/bootstrap.scss';
import 'bootstrap-icons/font/bootstrap-icons.scss';
require('bootstrap');

// Theme
require('chart.js');
require('trix');

// Axios
require('axios');

// Custom Scripts
require('./js/all');
require('./js/script');
require('./js/dice');
require('./js/ajax');
require('./js/fight');
require('./js/map');

// Start the Stimulus application
import './bootstrap';