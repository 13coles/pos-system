<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('pos.php');
$page = basename($path, '.php');

$result_account_info = $db->GR_account_info();
$admin_info = mysqli_fetch_assoc($result_account_info);

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);

$notification_ctr = $db->GR_notif_ctr();

$product_ctr = $db->GR_product_ctr();

$sales = $db->GR_sales();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<?php
include_once('util/head.php');
$get->toastr_css_new();
$get->dt_css();
?>
<script type="text/javascript" src="assets/js/instascan.min.js"></script>
<body>
  <?php
  if($role == 'ADMIN') {
    include_once('util/navbar.php');
    include_once('util/off-canvas.php');
  } else if($role == 'CASHIER') {
    include_once('util/navbar-cashier.php');
    include_once('util/off-canvas-cashier.php');
  } 
  ?>

  <div class="modal fade" id="modal_delete" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bx bx-info-circle text-danger"></i> <strong>DELETE?</strong></h5>
          <span class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
        </div>
        <div class="modal-body">
          <h6>Are you sure to delete this record? <strong>This process <i>cannot</i> be undone</strong>.</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-dark btn-delete" data-bs-dismiss="modal">Confirm</button>
        </div>
      </div>
    </div>
  </div><!-- End Delete Modal-->

    <!-- Complete Purchase Modal -->
    <div class="modal fade" id="modal_complete" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bx bx-check-circle text-danger"></i> <strong>COMPLETE PURCHASE?</strong></h5>
                    <span class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
                </div>
                <div class="modal-body">
                    <h6>Do you confirm to complete this transaction? <strong>Once this process is completed it <i>cannot</i> be undone</strong>.</h6>
                    <form class="needs-validation" novalidate>
                        <label>Enter customer name:</label>
                        <input type="text" class="form-control customer" autofocus tabindex="1" required>
                        <div class="invalid-feedback">Please enter customer name*</div>
                    </form>
                    <div class="container receipt"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-dark btn-complete" data-bs-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div><!-- End Complete Purchase Modal-->

  <!--home product area start-->
    <section class="home_product_area mb-50">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center"> 
            <div class="product_header">
              <div class="section_title mt-5 d-flex align-items-center justify-content-center">
              <i class='bx bx-desktop me-2 '></i>
                <h2>POINT OF SALE</h2>
              </div>
              <div class="product_tab_button mt-5">
                <ul class="nav justify-content-center" role="tablist"> 
                  <li>
                    <a class="active btn-modal-complete" data-bs-toggle="modal" data-bs-target="#modal_complete">
                    <i class='bx bx-money mb-1' ></i> PAY NOW 
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <h1 id="cart_ctr" hidden></h1>
            <!-- Scanner Box -->
            <div class="scanner-box mb-3 border border-success rounded p-3">
              <div class="section_title mb-3 text-center d-flex align-items-center justify-content-center">
              <i class='bx bx-qr-scan me-2' style="font-size: 24px;"></i>
                <h2>QR Code Scanner</h2>
              </div>
              <video id="preview" class="w-100 rounded border border-dark"></video>
              <input type="text" id="pre" class="form-control mt-3" readonly>
              <audio src="assets/sounds/beep.mp3" id="sound"></audio>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="table-responsive">
              <table class="table text-center" id="table_cart" width="100%">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Sub-total</th>
                    <th>Quantity</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tfoot>
                  <tr>
                    <th colspan="4" class="card-footer text-end">TOTAL:</th>
                    <th class="total_payment">₱0.00</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!--home product area end-->

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
  $get->dt_js();
  $get->toastr_js();
  $db->display_message();
  ?>
  <script src="assets/js/instascan.controls.js"></script>

</body>

</html>