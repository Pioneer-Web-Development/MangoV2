var elixir = require('laravel-elixir');

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
elixir.config.assetsDir = 'resources/assets/'; //trailing slash required.
elixir(function(mix) {
 mix.scripts([
         '../../../bower_components/jquery/dist/jquery.min.js',
         '../jqueryui/jquery-ui.min.js',
         '../../../bower_components/bootstrap/dist/js/bootstrap.min.js',
         '../../../bower_components/moment/min/moment.min.js',
         '../../../bower_components/fullcalendar/dist/fullcalendar.min.js',
         '../smartadmin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js',
         '../DataTables/DataTables-1.10.8/js/jquery.dataTables.min.js',
         '../DataTables/DataTables-1.10.8/js/dataTables.bootstrap.min.js',
         '../DataTables/Buttons-1.0.0/js/dataTables.buttons.min.js',
         '../DataTables/Buttons-1.0.0/js/buttons.bootstrap.min.js',
         '../DataTables/Buttons-1.0.0/js/buttons.colVis.min.js',
         '../DataTables/Buttons-1.0.0/js/buttons.flash.min.js',
         '../DataTables/Buttons-1.0.0/js/buttons.print.min.js',
         '../DataTables/ColReorder-1.2.0/js/dataTables.colReorder.min.js',
         '../bootstrap-modal/js/bootstrap-modalmanager.js',
         '../bootstrap-modal/js/bootstrap-modal.js',
         '../twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js',
         '../qTip2/src/jquery.qtip.min.js',
         '../malsup-form/jquery.form.min.js',
         '../pioneer/contextMenu.js',
         '../pioneer/userInteraction.js',
         '../smartadmin/js/notification/SmartNotification.min.js',
         '../smartadmin/js/plugin/cssemotions/jquery.cssemoticons.min.js',
         '../smartadmin/js/smart-chat-ui/smart.chat.ui.js',
         '../smartadmin/js/smart-chat-ui/smart.chat.manager.js',
         '../smartadmin/js/smartwidgets/jarvis.widget.min.js',
         '../../../bower_components/summernote/dist/summernote.min.js',
         '../../../bower_components/jquery.maskedinput/dist/jquery.maskedinput.min.js',
         '../../../bower_components/select2/dist/js/select2.full.min.js',
         '../../../bower_components/bootstrap-validator/dist/validator.min.js',
         '../../../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
         '../../../bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
         '../../../bower_components/slider/js/bootstrap-slider.js',
         '../../../bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
         '../../../bower_components/typeahead.js/dist/typeahead.bundle.min.js',
         '../../../bower_components/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js',
         '../../../bower_components/chained/jquery.chained.min.js',
         '../../../bower_components/chained/jquery.chained.remote.min.js',
         '../smartadmin/js/app.js',
         '../smartadmin/js/app.config.js'
    ])
     .styles([
      '../../../bower_components/bootstrap/dist/css/bootstrap.min.css',
      '../../../bower_components/fullcalendar/dist/fullcalendar.min.css',
      '../../../bower_components/fullcalendar/dist/fullcalendar.print.css',
      '../../../bower_components/summernote/dist/summernote.css',
      '../../../bower_components/summernote/dist/summernote-bs3.css',
      '../DataTables/DataTables-1.10.8/css/dataTables.bootstrap.min.css',
      '../DataTables/Buttons-1.0.0/css/buttons.bootstrap.min.css',
      '../DataTables/ColReorder-1.2.0/css/colReorder.bootstrap.min.css',
      '../../../bower_components/select2/dist/css/select2.min.css',
      '../../../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
      '../../../bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
      '../../../bower_components/slider/css/slider.css',
      '../../../bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css',
      '../../../bower_components/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css',
      '../bootstrap-modal/css/bootstrap-modal-bs3patch.css',
      '../bootstrap-modal/css/bootstrap-modal.css',
      '../qTip2/src/jquery.qtip.min.css'
     ])
     .sass([
         '../../../bower_components/font-awesome/scss/font-awesome.scss',
         'smartadmin-production-plugins.scss',
         'smartadmin-production.scss',
         'smartadmin-skins.scss',
         'app.scss'
     ]);
});
