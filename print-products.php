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

// Fetch products from tbl_products
$products = $db->GR_products(); 
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<?php
include_once('util/head.php');
$get->toastr_css_new();
$get->dt_css();
?>
<body>
<div class="wrapper">
    <div class="heading">
    <?php include('util/header-print.php'); ?>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table text-center" id="table_products" width="100%" style="font-size: 12px; table-layout: fixed;">
            <thead>
                <tr>
                    <th>Date Expiration</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Available Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              <!-- dynamic -->
              <?php if($products): ?>
                  <?php foreach($products as $product): ?>
                      <tr>
                          <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($product['exp_date']); ?></td>
                          <td style="text-align: center; vertical-align: middle;" class="img-fluid">
                              <?php
                              // Display the product image
                              if (!empty($product['product_img'])) {
                                  echo '<img src="assets/img/products/' . htmlspecialchars($product['product_img']) . '" alt="Product Image" style="width: 100px; height: 100px;">';
                              } else {
                                  echo 'No image available';
                              }
                              ?>
                          </td>
                          <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($product['product_name']); ?></td>
                          <td style="text-align: center; vertical-align: middle; font-size:12px;">
                              <?php 
                              // Check if the product is on sale and render the price accordingly
                              if (isset($product['in_sale']) && $product['in_sale'] > 0) {
                                  echo '<span style="text-decoration: line-through; color: gray;">₱' . number_format($product['product_price'], 2) . '</span>';
                                  echo ' <span style="color: red; font-weight: bold;">₱' . number_format($product['in_sale'], 2) . '</span>';
                              } else {
                                  echo '₱' . number_format($product['product_price'], 2);
                              }
                              ?>
                          </td>
                          <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($product['product_qty']); ?></td>
                          <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($product['status']); ?></td>
                      </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr>
                      <td colspan="6" class="text-center-middle">No products found.</td>
                  </tr>
              <?php endif; ?>
          </tbody>
        </table>
    </div>
</div>
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
