// Load plugins
import helper from "./helper";
import axios from "axios";
import * as Popper from "@popperjs/core";
import dom from "@left4code/tw-starter/dist/js/dom";
import Inputmask from "inputmask";
import TomSelect from "tom-select";
import chart from "chart.js";
// Set plugins globally
window.helper = helper;
window.axios = axios;
window.Popper = Popper;
window.TomSelect = TomSelect;
window.Inputmask = Inputmask;
window.chart = require('chart.js');
//window.$ = dom;

window.$ = require('jquery');
window.jQuery = require('jquery');
require('bootstrap');
require('datatables.net-bs4');
require('datatables.net-buttons-bs4');

// CSRF token
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

window.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
        element.addEventListener('keyup', function(e) {
            let cursorPostion = this.selectionStart;
            let value = parseInt(this.value.replace(/[^,\d]/g, ''));
            let originalLenght = this.value.length;
            if (isNaN(value)) {
                this.value = 0;
            } else {
                this.value = value.toLocaleString('id-ID', {
                    currency: 'IDR',
                    style: 'currency',
                    minimumFractionDigits: 0
                });
                cursorPostion = this.value.length - originalLenght + cursorPostion;
                this.setSelectionRange(cursorPostion, cursorPostion);
            }
        });
    });
});

