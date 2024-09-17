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
        <table class="table text-center" id="table_catalog" width="100%">
            <thead>
                <tr>
                    <th>QR code</th>
                    <th>Brand</th>
                    <th>Product</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
              <!-- dynamic -->
              <?php if($products): ?>
                  <?php foreach($products as $product): ?>
                      <tr>
                          <td style="text-align: center; vertical-align: middle;">
                              <?php
                              if (!empty($product['qr_code'])) {
                                  echo '<img src="assets/img/QR/' . htmlspecialchars($product['qr_code']) . '" alt="QR Code" style="width: 100px; height: 100px;">';
                              } else {
                                  echo 'No QR code available';
                              }
                              ?>
                          </td>
                          <td style="text-align: center; vertical-align: middle;"><?php echo htmlspecialchars($product['product_brand']); ?></td>
                          <td style="text-align: center; vertical-align: middle;"><?php echo htmlspecialchars($product['product_name']); ?></td>
                          <td style="text-align: center; vertical-align: middle;"><?php echo htmlspecialchars($product['product_price']); ?></td>
                      </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr>
                      <td colspan="4" style="text-align: center; vertical-align: middle;">No products found.</td>
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
