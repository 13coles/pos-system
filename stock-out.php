<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('stock-out.php');
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


  <!--home product area start-->
  <section class="home_product_area mb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_header">
                    <div class="section_title mt-5">
                        <h2><i class='bx bx-registered pb-1'></i> Stock Out</h2>
                    </div>
                    <div class="product_tab_button mt-5">
                      <ul class="nav" role="tablist">
                        <li>
                           <a href="inventory.php" class="btn">Back</a>
                        </li>
                        <li>
                           <a href="stock-in.php" class="btn">Stock In</a>
                        </li>
                        <li>
                          <a href="print-stock-out.php" rel="noopener" target="_blank" class="btn sm mb-3">
                            <i class='bx bx-printer' style="font-size: 24px;"></i>
                          </a>
                        </li>
                      </ul>
              
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table text-center" id="stock-out-table" width="100%">
                            <thead>
                                <tr>
                                    <th>Date Sold or Remove</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="stock-out-body">
                                <!-- Data will be populated here by JavaScript -->
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

  <script>
    function fetchStockOutData() {
      $.ajax({
        url: 'fetch_stock_out.php',
        type: 'GET',
        dataType: 'json', 
        success: function(data) {
          // Clear the table body first
          $('#stock-out-body').empty();

          // Loop through the data and append each row to the table
          if (data.length > 0) {
            data.forEach(function(item) {
              var formattedDate = new Date(item.date_sold);
              var row = '<tr>';
              row += '<td>' +formattedDate.toLocaleDateString() + '</td>';
              row += '<td>' + item.product_name + '</td>';
              row += '<td>' + item.quantity + '</td>';
              row += '<td>' + item.status + '</td>';
              row += '</tr>';
              $('#stock-out-body').append(row);
            });
            
            // Initialize DataTables after data is added
            $('#stock-out-table').DataTable({
              "paging": true,        
              "searching": true,     
              "ordering": true,      
              "info": true,           
              "lengthMenu": [5, 10, 25, 50], 
              "order": [[0, 'desc']],
            });
          } else {
            // If no data found, show a message
            $('#stock-out-body').append('<tr><td colspan="4">No stock-out data available</td></tr>');
          }
        },
        error: function(xhr, status, error) {
          // Handle any errors here
          $('#stock-out-body').append('<tr><td colspan="4">Error fetching data</td></tr>');
        }
      });
    }

    
    $(document).ready(function() {
      fetchStockOutData();
    });
  </script>
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