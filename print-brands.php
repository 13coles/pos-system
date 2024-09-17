<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$result_account_info = $db->GR_account_info();
$admin_info = mysqli_fetch_assoc($result_account_info);

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);

$notification_ctr = $db->GR_notif_ctr();
// Fetch brands from the database
$brands = $db->GR_brands(); 

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
        <table class="table text-center" id="table_brands" width="100%">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Brand Name</th>
                </tr>
            </thead>
            <tbody>
              <!-- dynamic -->
              <?php if($brands): ?>
                  <?php foreach($brands as $brand): ?>
                      <tr>
                          <td style="text-align: center; vertical-align: middle;">
                              <?php
                              if (!empty($brand['img_dir'])) {
                                  echo '<img src="assets/img/brands/' . htmlspecialchars($brand['img_dir']) . '" alt="Brand Image" style="width: 100px; height: 100px;">';
                              } else {
                                  echo 'No image available';
                              }
                              ?>
                          </td>
                          <td style="text-align: center; vertical-align: middle;"><?php echo htmlspecialchars($brand['brand']); ?></td>
                      </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr>
                      <td colspan="2" style="text-align: center; vertical-align: middle;">No brands found.</td>
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
