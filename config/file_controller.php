<?php
/*
  * File Controller v1.7stable
  * Developed by Ken Deanon, Web Developer
  * Created: 3/18/2023, Updated: 10/29/2023
  * Current version: v1.5
  * Licensed under developer name "KEN P. DEANON" 
      (https://www.facebook.com/Kiryu.Haruka0)

  #Index:
  1. jQuery
  2. DataTables & Plugins
  3. Toastr
  4. Bootstrap Select2
  5. Purecounter/preloader
  6. Database cloud controls
  7. PHP form validation
  8. Photo controller
  9. Datepicker
  10. Bootstrap Datepicker
  11. Daterangepicker
  12. Magnific Popup
  13. 
*/

class File_Contents
{
  #1. jQuery
  public function jQuery()
  {
    echo '
      <!-- jQuery -->
      <script src="plugins/jquery/jquery.min.js"></script>
    ';
  }

  #2. DataTables & Plugins
  public function dt_css()
  {
    echo '
      <!-- DataTables & Plugins --> 
      <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    ';
  }

  public function dt_js()
  {
    echo '
      <!-- DataTables & Plugins --> 
      <script src="plugins/datatables/new.js"></script>
      <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
      <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
      <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
      <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
      <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
      <script src="plugins/jszip/jszip.min.js"></script>
      <script src="plugins/pdfmake/pdfmake.min.js"></script>
      <script src="plugins/pdfmake/vfs_fonts.js"></script>
      <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
      <script src="plugins/datatables-buttons/js/buttons.print.js"></script>
      <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    ';
  }

  #3. Toastr
  public function toastr_css()
  {
    echo '
      <!-- Toastr -->
      <link rel="stylesheet" href="plugins/toastrv1/build/toastr.css">
    ';
  }

  public function toastr_css_new()
  {
    echo '
      <!-- Toastr -->
      <link rel="stylesheet" href="plugins/toastrv1/build/toastr.new.css">
    ';
  }

  public function toastr_js()
  {
    echo '
      <!-- Toastr -->
      <script src="plugins/toastrv1/build/toastr.min.js"></script>
      <script src="plugins/toastrv1/build/toastr.set.js"></script>
    ';
  }

  #4. Bootstrap Select2
  public function select2_css()
  {
    echo '
      <!-- Select2 -->
      <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
      <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.css">
    ';
  }

  public function select2_js()
  {
    echo '
      <!-- Select2 -->
      <script src="plugins/select2/js/select2.full.min.js"></script>
    ';
  }

  #5. Purecounter/preloader
  public function preloader_css()
  {
    echo '
      <!-- Preloader -->
      <link rel="stylesheet" href="plugins/preloader/preloader.css">
    ';
  }

  public function preloader_js()
  {
    echo '
      <!-- Purecounter & preloader -->
      <script src="plugins/purecounter/purecounter_vanilla.js"></script>
      <script src="plugins/purecounter/purecounter_vanilla.set.js"></script>
    ';
  }

  #6. Database cloud controls
  public function cloud()
  {
    echo '
      <!-- Database cloud controls -->
      <script src="plugins/database-uploader/db-controls.js"></script>
    ';
  }

  #7. PHP form validation
  public function novalidate()
  {
    echo '
      <!-- PHP form validation -->
      <script src="plugins/php-email-form/validate.js"></script>
    ';
  }

  #8. Photo controller
  public function photo_controls()
  {
    echo '
      <!-- Photo controller -->
      <script src="plugins/photo-controller/controls.js"></script>
    ';
  }

  #9. Datepicker
  public function datepicker_css()
  {
    echo '
      <!-- Datepicker -->
      <link rel="stylesheet" href="plugins/datepicker/datepicker.css">
    ';
  }

  public function datepicker_js()
  {
    echo '
      <!-- Datepicker -->
      <script src="plugins/moment/moment.min.js"></script>
      <script src="plugins/datepicker/datepicker.js"></script>
      <script src="plugins/datepicker/datepicker.set.js"></script>
    ';
  }

  #10. Bootstrap Datepicker
  public function datepicker_bootstrap_css()
  {
    echo '
      <!-- Datepicker -->
      <link rel="stylesheet" href="plugins/bootstrap-datepicker/bootstrap-datepicker.css">
    ';
  }

  public function datepicker_bootstrap_js()
  {
    echo '
      <!-- Datepicker -->
      <script src="plugins/moment/moment.min.js"></script>
      <script src="plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
      <script src="plugins/bootstrap-datepicker/controls.js"></script>
    ';
  }

  #11. Daterangepicker
  public function daterangepicker_css()
  {
    echo '
      <!-- Daterangepicker -->
      <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    ';
  }

  public function daterangepicker_js()
  {
    echo '
      <!-- Daterangepicker -->
      <script src="plugins/moment/moment.min.js"></script>
      <script src="plugins/daterangepicker/daterangepicker.js"></script>
      <script src="plugins/daterangepicker/daterangepicker.set.js"></script>
    ';
  }

  #12. Magnific Popup
  public function magnific_css()
  {
    echo '
      <!-- Magnific Popup -->
      <link rel="stylesheet" href="plugins/magnific-popup/css/magnific.css">
    ';
  }

  public function magnific_js()
  {
    echo '
      <!-- Magnific Popup -->
      <script src="plugins/magnific-popup/js/magnific.js"></script>
      <script src="plugins/magnific-popup/js/controls.js"></script>
    ';
  }
}
