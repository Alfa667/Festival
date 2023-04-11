/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');
import * as bootstrap from 'bootstrap';

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');
import { Tooltip, Toast, Popover } from 'bootstrap';

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

// assets/app.js

// returns the final, public path to this file
// path is relative to this file - e.g. assets/images/logo.png
import logoPath from './images/festivals.jpg';
import logoPath1 from './images/festivalImage.jpeg';
import logoPath2 from './images/festivalBeau.jpg';
import logoPath3 from './images/festivalElec.png';
import logoPath4 from './images/festivalFoule.jpg';
import logoPath5 from './images/festivalLumiere.jpg';
import logoPath6 from './images/festivalAigle.jpg';
import logoPath7 from './images/chambreun.jpg';
import logoPath8 from './images/chambredeux.jpg';
import logoPath9 from './images/chambretrois.jpg';



let html = `<img src="${logoPath}" alt="ACME logo">`;


// require the JavaScript
