
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-datepicker/js/bootstrap-datepicker');
require('popper.js/dist/popper.min');

import 'tinymce/icons/default';
import 'tinymce/themes/silver';
import 'tinymce/plugins/link';
import 'datatables.net'
import 'datatables.net-bs4'

let oldInputLabel = [];
// show selected file in file chooser
$('input[type=file]').change(function () {
    let label = $(this).parent().find('label');
    if (typeof oldInputLabel[label] === "undefined") {
        // save initial label text for later use
        oldInputLabel[label] = label.text();
    }
    if (typeof $(this)[0].files[0] === "undefined") {
        // use initial text if no file is selected
        label.text(oldInputLabel[label]);
    } else {
        let file = $(this)[0].files[0].name;
        label.text(file);
    }
});
