import jQuery from 'jquery'
window.$ = window.jQuery = jQuery

import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

// Import DataTables and DataTables Buttons
import 'datatables.net-dt' // Main DataTables library
import 'datatables.net-buttons-dt' // DataTables Buttons extension
import 'datatables.net-buttons/js/buttons.html5' // HTML5 export
import 'datatables.net-buttons/js/buttons.print' // Print button
import 'datatables.net-buttons/js/buttons.colVis' // Column visibility button
import 'jszip' // JSZip library (required for Excel and PDF)
import pdfMake from 'pdfmake/build/pdfmake' // Required for PDF export

pdfMake.vfs = pdfFonts.pdfMake.vfs

import DateTime from 'datatables.net-datetime'
import 'datatables.net-responsive-dt'
import 'datatables.net-searchbuilder-dt'
import 'datatables.net-searchpanes-dt'
import 'datatables.net-select-dt'
