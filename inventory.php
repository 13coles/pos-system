<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('inventory.php');
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
                        <h2><i class='bx bx-registered pb-1'></i> Inventory Management</h2>
                        <select class="form-select selector" style="border-radius: 0; border-color: none;">
                            <option value="">Select Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <div class="product_tab_button mt-5">
                        <ul class="nav" role="tablist">
                          <li>
                            <a href="stock-in.php" class="btn">View Stock In</a>
                          </li>
                          <li>
                            <a href="stock-out.php" class="btn">View Stock Out</a>
                          </li>
                          <li>
                            <a href="print-inventory.php" rel="noopener" target="_blank" class="btn sm mb-3">
                              <i class='bx bx-printer' style="font-size: 24px;"></i>
                            </a>
                          </li>
                        </ul>
                        
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table text-center" id="table_account_list" width="100%">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Total Qty</th>
                                    <th>Sold Qty</th>
                                    <th>Available Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5">Please select a month to view inventory data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
  <script src="assets/js/inventory.js"></script>


  <!-- Page JS -->
  <?php
  $get->jQuery();
  $get->preloader_js();
  $get->novalidate();
  $get->toastr_js();
  $get->dt_js();
  $get->photo_controls();
  $db->display_message();
  ?>


</body>

</html>