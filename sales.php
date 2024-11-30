<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('sales.php');
$page = basename($path, '.php');

$result_account_info = $db->GR_account_info();
$admin_info = mysqli_fetch_assoc($result_account_info);

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);

$notification_ctr = $db->GR_notif_ctr();

$employee_ctr = $db->GR_employee_ctr();

$product_ctr = $db->GR_product_ctr();

$sales = $db->GR_sales();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<?php
include_once('util/head.php');
$get->toastr_css_new();
$get->dt_css();
$get->daterangepicker_css();
?>

<body>
  <?php
  if ($role == 'ADMIN') {
    include_once('util/navbar.php');
    include_once('util/off-canvas.php');
  } else if ($role == 'CASHIER') {
    include_once('util/navbar-cashier.php');;
    include_once('util/off-canvas-cashier.php');
  } 
  ?>


  <div class="modal fade" id="modal_view"> <!-- Modal edit -->
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bx bx-info-circle text-info"></i> <strong>TRANSACTION DETAILS</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table text-center" id="table_preview" width="100%">
              <thead>
                <tr>
                  <th>Date purchased</th>
                  <th>Transaction ID</th>
                  <th>QR code</th>
                  <th>Image</th>
                  <th>Product ID</th>
                  <th>Brand</th>
                  <th>Product Name</th>
                  <th>Price</th>
                  <th>Subtotal</th>
                  <th>Quantity</th>
                  <th>Customer</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th colspan="8" class="card-footer" style="text-align:right">TOTAL:</th>
                  <th class="total_payment">₱0.00</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal" aria-label="Close" title="Close"><i class="bi bi-x-circle"></i> Close</button>
        </div>
      </div>
    </div>
  </div><!-- End view Modal-->

  <section class="home_product_area mb-50">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="product_header">
            <div class="section_title mt-5">
              <h2> <i class='bx bx-dollar-circle pb-1' style="font-size: 24px;"></i> Sales Reports</h2>
            </div>
            <div class="product_tab_button mt-5">
              <ul class="nav" role="tablist">
                <li>
                    <!-- Print Button -->
                    <a href="print-sales.php" rel="noopener" target="_blank" class="btn sm mb-3">
                       <i class='bx bx-printer' style="font-size: 24px;"></i>
                    </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="container">
            <div class="form-group col-6 mb-3">
              <label>Search by date range:</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="bx bx-calendar"></i>
                </span>
                <input type="text" class="form-control" id="date_range_toSearch">
                <span class="input-group-text btn btn-danger pt-2" id="btn_refresh">
                  <i class="bx bx-refresh"></i> Refresh
                </span>
                <span class="input-group-text btn btn-dark pt-2" id="btn_search">
                  <i class="bx bx-search" style="font-size: 24px;"></i> Search
                </span>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table text-center" id="table_sales" width="100%">
                <thead>
                  <tr>
                    <th>Date purchased</th>
                    <th>Transaction ID</th>
                    <th>Total Sales</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th colspan="2" class="card-footer" style="text-align:right">OVERALL SALES:</th>
                    <th class="total_payment">₱0.00</th>
                  </tr>
                </tfoot>
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

  <!-- Page JS -->
  <?php
  $get->jQuery();
  $get->toastr_js();
  $get->dt_js();
  $get->daterangepicker_js();
  $get->photo_controls();
  $db->display_message();
  ?>
  <script src="assets/js/dt.data.sales.js"></script>

</body>

</html>