<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('back-up.php');
$page = basename($path, '.php');

$result_account_info = $db->GR_account_info();
$admin_info = mysqli_fetch_assoc($result_account_info);

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);

$notification_ctr = $db->GR_notif_ctr();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<?php
include_once('util/head.php');
$get->toastr_css_new();
?>

<body>
  <?php
  if ($role == 'ADMIN') {
    include_once('util/navbar.php');
    include_once('util/off-canvas.php');
  } else if ($role == 'CASHIER') {
    include_once('util/navbar-cashier.php');
    include_once('util/off-canvas-cashier.php');
  }
  ?>

  <div class="contact_area pt-3">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="mb-5">
            <div class="section_title mt-5">
              <h2>Back-up / Restore <span>Database</span></h2>
            </div>
            <div class="mb-3 col-12">
              <div class="alert alert-warning">
                <h6 class="alert-heading fw-bold mb-1">Back-up your data to avoid data loss.</h6>
                <p class="mb-0">Pleas make sure to upload <i>.sql</i> files only to avoid errors when backing up.</p>
              </div>
            </div>
            <div class="row">
              <div class="mb-3 col-12">
                <label class="form-label">Download file <small>(database)</small></label>
                <div>
                  <a href="database/db-export.php" target="_blank" class="btn btn-dark btn-download">Download</a>
                </div>
              </div>
              <div class="mb-3 col-md-6">
                <form method="POST" class="needs-validation" accept="sql" enctype="multipart/form-data" action="controller.php?action=import_database" novalidate>
                  <label for="file" class="form-label">Upload file <small>( database)</small></label>
                  <div class="input-group">
                    <input type="file" id="file" class="form-control form" name="database" accept=".sql" required>
                    <button type="reset" class="btn btn-danger btn-clear-select" hidden>Clear</button>
                    <button class="btn btn-dark" type="submit" name="btn_upload">Upload</button>
                    <div class="invalid-feedback">*Please select a file</div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--footer area start-->
    <?php include_once('util/footer-admin.php'); ?>
    <!--footer area end-->

    <!--map js code here-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdWLY_Y6FL7QGW5vcO3zajUEsrKfQPNzI"></script>
    <script src="https://www.google.com/jsapi"></script>
    <script src="assets/js/map.js"></script>

    <!-- Plugins JS -->
    <script src="assets/js/plugins.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>
    <script src="database/db-controls.js"></script>

    <!-- Page JS -->
    <?php
    $get->jQuery();
    $get->preloader_js();
    $get->novalidate();
    $get->toastr_js();
    $get->photo_controls();
    $db->display_message();
    ?>
</body>

</html>