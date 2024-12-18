<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('stock-in.php');
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
                            <h2><i class='bx bx-registered pb-1'></i> Stock In</h2>
                        </div>
            

                        <div class="product_tab_button mt-5">
                            <ul class="nav" role="tablist">
                                <li>
                                <a href="inventory.php" class="btn">Back</a>
                                </li>
                                <li>
                                <a href="stock-out.php" class="btn">Stock Out</a>
                                </li>
                                <li>
                                <a href="print-stock-in.php" rel="noopener" target="_blank" class="btn sm mb-3">
                                    <i class='bx bx-printer' style="font-size: 24px;"></i>
                                </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <form action="process_stock_in.php" method="POST" id="stock-in-form" class="mb-3">
                        <div class="row g-2 align-items-end">
                            <!-- Select Product -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Select Product</label>
                                    <select name="product_id" class="form-control" required>
                                        <option value="" disabled selected>Select a product</option>
                                        <?php
                                        // Assuming you have a function to get products from the database
                                        $products = $db->GR_products(); 
                                        while ($product = mysqli_fetch_assoc($products)) {
                                            echo "<option value='{$product['product_id']}'>{$product['product_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Input Quantity -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity" class="form-label">Input Quantity</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Enter Quantity" required>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-dark" style="height: 38px; margin-top: 32px;">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="container-fluid">
                        <?php include './util/session.php'?>
                        <div class="table-responsive">
                            <table class="table text-center" id="stock-in-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Date Added</th>
                                        <th>Batch Number</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="stock-in-body">
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
    // Function to fetch stock-in data
    function fetchStockInData() {
        $.ajax({
            url: 'fetch_stock_in.php', 
            type: 'GET',
            dataType: 'json', 
            success: function(data) {
                // Clear the table body first
                $('#stock-in-body').empty();

                // Loop through the data and append each row to the table
                if (data.length > 0) {
                    data.forEach(function(item) {
                        var formattedDate = new Date(item.date_added); // Convert to Date object
                        var row = '<tr>';
                        row += '<td>' + formattedDate.toLocaleDateString() + '</td>';
                        row += '<td>' + item.batch_number + '</td>';
                        row += '<td>' + item.product_name + '</td>';
                        row += '<td>' + item.quantity + '</td>';
                        row += '</tr>';
                        $('#stock-in-body').append(row);
                    });
                    
                    // Initialize DataTables after data is added
                    $('#stock-in-table').DataTable({
                        "paging": true,       
                        "searching": true,     
                        "ordering": true,     
                        "info": true,           
                        "lengthMenu": [5, 10, 25, 50],
                        "order": [[2, 'desc']],
                    });
                } else {
                    // If no data found, show a message
                    $('#stock-in-body').append('<tr><td colspan="4">No stock-in data available</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors here
                $('#stock-in-body').append('<tr><td colspan="4">Error fetching data</td></tr>');
            }
        });
    }

    // Call the function to fetch data when the page is loaded
    $(document).ready(function() {
        fetchStockInData();
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