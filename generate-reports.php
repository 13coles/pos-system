<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('generate-reports.php');
$page = basename($path, '.php');

$result_account_info = $db->GR_account_info();
$admin_info = mysqli_fetch_assoc($result_account_info);

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);

$notification_ctr = $db->GR_notif_ctr();

$product_ctr = $db->GR_product_ctr();

?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<?php
include_once('util/head.php');
$get->toastr_css_new();
$get->dt_css();
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

  <section class="home_product_area mb-50">
    <div class="container">
      <div class="row">
        <div class="col-12">
         <div class="product_header">
            <div class="section_title mt-5">
              <h2><i class='bx bx-qr'style="font-size: 24px;" ></i> Products QR</h2>
            </div>
            <div class="product_tab_button mt-5">
              <ul class="nav" role="tablist">
                <li>
                    <!-- Print Button -->
                    <a href="print-catalog.php" rel="noopener" target="_blank" class="btn sm mb-3">
                       <i class='bx bx-printer' style="font-size: 24px;"></i>
                    </a>
                </li>
              </ul>
            </div>
          </div>
      
  
          <div class="table-responsive">
            <table class="table text-center" id="table_catalog" width="100%">
              <thead>
                <tr>
                  <th>QR code</th>
                  <th>Brand</th>
                  <th>Product Name</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
               <!-- dynamic -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
  
    </div>
  </section>


  <!--footer area start-->
  <footer class="footer_widgets"></footer>
  <!--footer area end-->

  <!--footer area start-->
  <?php include_once('util/footer-admin.php'); ?>
  <!--footer area end-->

  <!-- Plugins JS -->
  <script src="assets/js/plugins.js"></script>

  <!-- Main JS -->
  <script src="assets/js/main.js"></script>

  <!-- Page JS -->
  <?php
  $get->jQuery();
  $get->novalidate();
  $get->toastr_js();
  $get->dt_js();
  $get->photo_controls();
  $db->display_message();
  ?>
  <script src="assets/js/dt.data.catalog.js"></script>


</body>

</html>