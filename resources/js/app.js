import './bootstrap';

import jQuery from 'jquery';

window.$ = jQuery;

import pdfmake from 'pdfmake';

import DataTable from 'datatables.net-dt';

import 'datatables.net-buttons-dt';

import 'datatables.net-buttons/js/buttons.html5.mjs';

import 'datatables.net-fixedheader-dt';

import 'datatables.net-responsive-dt';

import 'datatables.net-searchbuilder-dt';

import 'datatables.net-searchpanes-dt';

let table = new DataTable('#myTable', {
    // config options...
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

