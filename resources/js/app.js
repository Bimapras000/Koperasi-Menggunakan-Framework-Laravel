import './bootstrap';
import $ from 'jquery';
import 'select2';
import 'select2/dist/css/select2.min.css';

$(document).ready(function() {
    $('.js-select2').select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).parent()
    });
});