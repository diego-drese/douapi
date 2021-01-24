let mix = require('laravel-mix');

mix.setPublicPath('./')

mix.babel([
    'src/resources/assets/theme/nice-admin/libs/jquery/dist/jquery.min.js',
    'src/resources/assets/theme/nice-admin/libs/popper.js/dist/umd/popper.min.js',
    'src/resources/assets/theme/nice-admin/libs/bootstrap/dist/js/bootstrap.min.js',
    'src/resources/assets/theme/nice-admin/dist/js/app.min.js',
    'src/resources/assets/theme/nice-admin/dist/js/app.init.js',
    'src/resources/assets/theme/nice-admin/dist/js/custom.min.js',
    'src/resources/assets/theme/nice-admin/libs/toastr/build/toastr.min.js',
    'src/resources/assets/theme/nice-admin/libs/tooltip/tooltip.js',
    'src/resources/assets/theme/nice-admin/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js',
    'src/resources/assets/theme/nice-admin/extra-libs/sparkline/sparkline.js',
    'src/resources/assets/theme/nice-admin/dist/js/sidebarmenu.js',
    'src/resources/assets/theme/nice-admin/libs/moment/moment.js',
    'src/resources/assets/theme/nice-admin/libs/moment/locale/pt-br.js',
    'src/resources/assets/js/tutorial-help.js',
],'vendor/oka6/admin/js/basic.js').version();

mix.styles([
    'src/resources/assets/theme/nice-admin/dist/css/style.min.css',
    'src/resources/assets/theme/nice-admin/libs/tooltip/tooltip.css',
    'src/resources/assets/theme/nice-admin/libs/toastr/build/toastr.min.css',
    'src/resources/assets/theme/nice-admin/dist/css/oka6.css',
],'vendor/oka6/admin/css/basic.css').version();

mix.sass('src/resources/assets/theme/nice-admin/sass/theme-color.scss', 'vendor/oka6/admin/css/themes.css').version();

/** DataTable*/

mix.babel([
    'src/resources/assets/theme/nice-admin/extra-libs/DataTables/datatables.js',
],'vendor/oka6/admin/js/datatables.js').version();

mix.styles([
    'src/resources/assets/theme/nice-admin/extra-libs/DataTables/datatables.css',
],'vendor/oka6/admin/css/datatables.css').version();


/** DataTable Adds*/

mix.babel([
    'src/resources/assets/theme/nice-admin/extra-libs/DataTables/group/js/dataTables.rowGroup.js',
],'vendor/oka6/admin/js/datatables.rowgroup.js').version();

mix.styles([
    'src/resources/assets/theme/nice-admin/extra-libs/DataTables/group/css/rowGroup.dataTables.min.css',
],'vendor/oka6/admin/css/datatables.rowgroup.css').version();

mix.babel([
    'src/resources/assets/theme/nice-admin/extra-libs/DataTables/select/js/dataTables.select.js',
],'vendor/oka6/admin/js/datatables.select.js').version();


mix.styles([
    'src/resources/assets/theme/nice-admin/extra-libs/DataTables/select/css/select.dataTables.min.css',
],'vendor/oka6/admin/css/datatables.select.css').version();

/** Bootstrap Switch*/
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js',
],'vendor/oka6/admin/js/bootstrap-switch.js').version();

mix.styles([
    'src/resources/assets/theme/nice-admin/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
],'vendor/oka6/admin/css/bootstrap-switch.css').version();

/** Select2*/
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/select2/dist/js/select2.min.js',
    'src/resources/assets/theme/nice-admin/libs/select2/dist/js/i18n/pt-BR.js',
],'vendor/oka6/admin/js/select2.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/select2/dist/css/select2.min.css',
],'vendor/oka6/admin/css/select2.css').version();

/** Material-datetimepicker.*/
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-custom.js',
],'vendor/oka6/admin/js/datetimepicker.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',
],'vendor/oka6/admin/css/datetimepicker.css').version();

/** DataeRangePicker */
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/daterangepicker/daterangepicker.js',
],'vendor/oka6/admin/js/daterangepicker.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/daterangepicker/daterangepicker.css'
],'vendor/oka6/admin/css/daterangepicker.css').version();

/** ColorSelector*/
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/bootstrap-colorselector/bootstrap-colorselector.min.js',
],'vendor/oka6/admin/js/bootstrap-colorselector.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/bootstrap-colorselector/bootstrap-colorselector.min.css'
],'vendor/oka6/admin/css/bootstrap-colorselector.css').version();

/** Sweet Alert 2.*/
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/sweetalert2/dist/sweetalert2.all.min.js',
],'vendor/oka6/admin/js/sweetalert2.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/sweetalert2/dist/sweetalert2.min.css',
],'vendor/oka6/admin/css/sweetalert2.css').version();

/** Forms*/
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/jquery-mask/jquery.mask.min.js',
    'src/resources/assets/theme/nice-admin/libs/bootstrap-toggle/dist/js/bootstrap-toggle.min.js',
],'vendor/oka6/admin/js/forms.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/bootstrap-toggle/dist/css/bootstrap-toggle.min.css',
],'vendor/oka6/admin/css/form.css').version();

/** C3*/
mix.babel([
    'src/resources/assets/theme/nice-admin/extra-libs/c3/c3.min.js',
    'src/resources/assets/theme/nice-admin/extra-libs/c3/d3.min.js',
],'vendor/oka6/admin/js/c3.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/extra-libs/c3/c3.min.css',
],'vendor/oka6/admin/css/c3.css').version();

/** DropZone*/
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/dropzone/dist/min/dropzone.min.js',
],'vendor/oka6/admin/js/dropzone.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/dropzone/dist/min/dropzone.min.css',
],'vendor/oka6/admin/css/dropzone.css').version();

/** wickedpicker */
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/wickedpicker/wickedpicker.js',
],'vendor/oka6/admin/js/wickedpicker.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/wickedpicker/wickedpicker.css',
],'vendor/oka6/admin/css/wickedpicker.css').version();

/** timepicker */
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/jquery-timepicker/jquery.timepicker.js',
],'vendor/oka6/admin/js/timepicker.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/jquery-timepicker/jquery.timepicker.css',
],'vendor/oka6/admin/css/timepicker.css').version();


mix.babel([
    'src/resources/assets/theme/nice-admin/libs/jquery-timepicker/jquery.datepair.min.js',
],'vendor/oka6/admin/js/datepair.js').version();

mix.babel([
    'src/resources/assets/theme/nice-admin/libs/jquery.repeater/jquery.repeater.min.js',
],'vendor/oka6/admin/js/jquery.repeater.min.js').version();

mix.babel([
    'src/resources/assets/theme/nice-admin/libs/typeahead.js/dist/typeahead.jquery.min.js',
],'vendor/oka6/admin/js/typeahead.js').version();

/** SummerNote */
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/summernote/dist/summernote-bs4.min.js',
],'vendor/oka6/admin/js/summernote.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/summernote/dist/summernote-bs4.css',
],'vendor/oka6/admin/css/summernote.css').version();

/** JquerySteps */
mix.babel([
    'src/resources/assets/theme/nice-admin/libs/jquery-steps/build/jquery.steps.min.js',
],'vendor/oka6/admin/js/jquerysteps.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/jquery-steps/jquery.steps.css',
    'src/resources/assets/theme/nice-admin/libs/jquery-steps/steps.css',
],'vendor/oka6/admin/css/jquerysteps.css').version();

mix.babel([
    'src/resources/assets/theme/nice-admin/libs/nouislider/distribute/nouislider.min.js',
],'vendor/oka6/admin/js/nouislider.js').version();
mix.styles([
    'src/resources/assets/theme/nice-admin/libs/nouislider/distribute/nouislider.min.css',
],'vendor/oka6/admin/css/nouislider.css').version();

mix.copyDirectory('src/resources/assets/theme/nice-admin/dist/css/icons', 'vendor/oka6/admin/css/icons');
mix.copyDirectory('src/resources/assets/theme/nice-admin/images', 'vendor/oka6/admin/assets/images');
mix.copyDirectory('src/resources/assets/fonts', 'vendor/oka6/admin/css/fonts');
mix.copyDirectory('src/resources/assets/templates', 'vendor/oka6/templates');

mix.autoload({
    'jquery': ['jQuery', '$','jquery'],
});

mix.webpackConfig({
    resolve: {
        alias: {
            jquery: "jquery/src/jquery/jQuery/$"
        }
    }
});
