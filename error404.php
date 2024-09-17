<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('settings.php');
$page = basename($path, '.php');

$result_account_info = $db->GR_account_info();
$admin_info = mysqli_fetch_assoc($result_account_info);

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<?php
include_once('util/head.php');
$get->toastr_css_new();
?>

<body>

  <!--breadcrumbs area start-->
  <div class="mb-4 text-center">
    <div class="container">
      <div class="row">
        <div class="col-12 pt-2">
          <div class="breadcrumb_content">
            <ul>
              <li><i class="bx bx-home pb-1 text-dark"></i><a href="dashboard.php"> Home</a></li>
              <li><i class="bx bx-error-alt pb-1"></i> 404</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--breadcrumbs area end-->

  <div class="error_section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="error_form">
            <h1>404</h1>
            <h2>Opps! PAGE NOT BE FOUND</h2>
            <p>Sorry but the page you are looking for does not exist, have been<br> removed, name changed or is temporarity unavailable.</p>
            <a href="dashboard.php">Back to home page</a>
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

  <!-- Page JS -->
  <?php
  $get->jQuery();
  $get->novalidate();
  $get->toastr_js();
  $db->display_message();
  ?>
</body>

</html>