<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('dashboard.php');
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
echo '<link href="assets/vendor/apex-charts/apex-charts.css">';
?>
<style>
  .card-icon {
    width: 50px;
    height: 50px;
    background-color: #f5f5f5;
    border-radius: 50%;
  }

  .chart-container {
    width: 100%;
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 10px 15px;
  }

  .card-title {
    font-size: 18px;
    margin: 0;
  }

  @media (max-width: 768px) {
    .row .col-lg-6, .row .col-md-6 {
      width: 100%;
      flex-basis: 100%;
    }
  }
</style>
<body>
  <?php
  include_once('util/navbar.php');
  include_once('util/off-canvas.php');
  ?>

<section class="dashboard_area mb-5">
  <div class="container">
    <!-- Dashboard Title -->
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="section_title mt-5">
          <h2>Andrei’s Beauty Dashboard</h2>
        </div>
      </div>
    </div>

    <!-- Dashboard Metrics (Sales, Products, Brands, etc.) -->
    <div class="row mt-5">
      <!-- Total Sales Card -->
      <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm">
          <div class="card-body text-center">
            <h4>Total Sales</h4>
            <div class="d-flex justify-content-center align-items-center mt-3">
              <a href="pages-sales.php">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                  <i class="bx bx-money text-success" style="font-size: 30px;"></i>
                </div>
              </a>
              <div class="ps-3">
                <!-- This is where the total sales will be updated -->
                <h3 class="total-sales">0</h3>
                <span class="text-muted small pt-2">Total sales gained</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Sold Card -->
      <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm">
          <div class="card-body text-center">
            <h4>Total Sold</h4>
            <div class="d-flex justify-content-center align-items-center mt-3">
              <a href="pages-sales.php">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                  <i class="bx bx-cart text-primary" style="font-size: 30px;"></i>
                </div>
              </a>
              <div class="ps-3">
                <!-- This is where the total sold will be updated -->
                <h3 class="total-sold">0</h3>
                <span class="text-muted small pt-2">Total items sold</span>
              </div>
            </div>
          </div>
        </div>
      </div>

 
      <!-- Number of Brands Card -->
      <div class="col-md-6 col-lg-3 mb-4">
          <div class="card shadow-sm">
              <div class="card-body text-center">
                  <h4>No. of Brands</h4>
                  <div class="d-flex justify-content-center align-items-center mt-3">
                      <a href="pages-brands.php">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                              <i class="bx bx-star text-warning" style="font-size: 30px;"></i>
                          </div>
                      </a>
                      <div class="ps-3">
                          <!-- This is where the number of brands will be updated -->
                          <h3 class="total-brands">0</h3>
                          <span class="text-muted small pt-2">Number of brands</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <!-- Number of Products Card -->
      <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm">
          <div class="card-body text-center">
            <h4>No. of Products</h4>
            <div class="d-flex justify-content-center align-items-center mt-3">
              <a href="pages-products.php">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                  <i class="bx bx-box text-danger" style="font-size: 30px;"></i>
                </div>
              </a>
              <div class="ps-3">
                 <!-- This is where the number of products will be updated -->
                <h3 class="total-products">0</h3>
                <span class="text-muted small pt-2">Number of products</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="row mt-4">
 
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
          <div class="card-header">
            <h5 class="card-title"><i class='bx bx-bar-chart pb-1'></i> Products Chart</h5>
            <div class="d-flex align-items-center">
            
            </div>
          </div>
          <div class="card-body">
            <div id="products_chart"  class="chart-container" style="height: 300px;"></div>
          </div>
        </div>
      </div>

      <!-- Products Trends Chart -->
      <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title"><i class='bx bx-line-chart pb-1'></i> Sales Chart</h5>
                <div class="d-flex align-items-center">
                    <span class="pe-2">Filter:</span>
                    <select class="form-select form-select-sm selector-sales w-auto">
                        <option value="day" selected>Current Day</option>
                        <option value="week">Current Week</option>
                        <option value="month">Current Month</option>
                        <option value="year">Current Year</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div id="chart_funnel" class="chart-container" style="height: 300px;"></div>
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
  <script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- Custom Js -->
  <script src="assets/js/count.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <!-- Main JS -->
  <script src="assets/js/main.js"></script>

  <!-- Page JS -->
  <?php
  $get->jQuery();
  $get->preloader_js();
  $get->novalidate();
  $get->toastr_js();
  $db->display_message();
  ?>

</body>

</html>
