<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('shop-product.php');
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

  <div class="modal fade" id="modal_delete" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bx bx-info-circle text-danger"></i> <strong>DELETE?</strong></h5>
          <span class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
        </div>
        <div class="modal-body">
          <h6>Are you sure to delete this product? <strong>This process <i>cannot</i> be undone</strong>.</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-dark btn-delete" data-bs-dismiss="modal">Confirm</button>
        </div>
      </div>
    </div>
  </div><!-- End Delete Modal-->

  <?php
  $result_products = $db->GR_products();
  if (mysqli_num_rows($result_products) > 0) {
    while ($row_info = mysqli_fetch_array($result_products)) {
  ?>
      <div class="modal fade" id="modal_edit_<?php echo $row_info['id']; ?>_product"> <!-- Modal edit -->
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="bx bx-info-circle text-info"></i> <strong>EDIT PRODUCT</strong></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" enctype="multipart/form-data" action="controller.php?action=update_product&id=<?php echo $row_info['id']; ?>" class="needs-validation" novalidate>
              <div class="modal-body">
                <div class="row mb-3 contact_message">
                  <div class="col-12 d-flex align-items-start align-items-sm-center gap-4">
                    <img src="assets/img/products/<?php echo $row_info['product_img']; ?>" alt="product" class="img-fluid d-block rounded <?php echo $row_info['id']; ?>" height="100" width="100">
                    <div class="button-wrapper">
                      <label class="btn btn-dark me-2 mb-2" tabindex="0" style="cursor: pointer; font-size: inherit; padding: 12px 30px; color: #ffffff; border-radius: 4px">
                        <i class="ti ti-upload d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <input type="file" class="file-input-image" input-id="<?php echo $row_info['id']; ?>" name="image" hidden accept="image/png, image/jpeg, .svg">
                        <input type="hidden" class="filename_product_<?php echo $row_info['id']; ?>" name="filename" value="<?php echo $row_info['product_img']; ?>">
                      </label>
                      <button type="button" class="btn btn-danger mb-2 file-reset-image" style="background-color: #dc3545;" id="<?php echo $row_info['id']; ?>" page="SHOP-PRODUCT" hidden>
                        <i class="ti ti-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Reset</span>
                      </button>
                      <p class="text-muted mb-0">Allowed formats (JPG,PNG,SVG). Max size of 2.5MB</p>
                      <span class="size-preview mb-2">Size: <i class="bx bx-check text-success"></i></span>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label">Product Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="product_name" type="text" class="form-control" value="<?php echo $row_info['product_name']; ?>" placeholder="Enter product name">
                    <div class="invalid-feedback">Please add product name.</div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label">Brand</label>
                  <div class="col-md-8 col-lg-9">
                    <select class="form-select" style="border-radius: 0;" name="product_brand">
                      <?php
                      $result_brands = $db->GR_brands();
                      if (mysqli_num_rows($result_brands) > 0) {
                        while ($row_brands = mysqli_fetch_array($result_brands)) {

                      ?>
                          <option <?php if ($row_info['product_brand'] == $row_brands['brand']) {
                                    echo 'selected';
                                  } ?>><?php echo $row_brands['brand']; ?></option>
                      <?php

                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label">Expiration Date</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="exp_date" type="date" class="form-control" value="<?php echo $row_info['exp_date']; ?>" required>
                    <div class="invalid-feedback">Please add a valid expiration date.</div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label">Price</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="product_price" type="text" class="form-control" value="<?php echo $row_info['product_price']; ?>" placeholder="Enter price">
                    <div class="invalid-feedback">Please add product price.</div>
                  </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Sale Price</label>
                    <div class="col-md-8 col-lg-9">
                        <input name="in_sale" type="text" class="form-control" placeholder="Enter sale price" value="<?php echo $row_info['in_sale']; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label">Quantity</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="product_qty" type="number" class="form-control" min="0" value="<?php echo $row_info['product_qty']; ?>" style="width: auto">
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal" aria-label="Close" title="Cancel"><i class="bi bi-x-circle"></i> Cancel</button>
                <button type="submit" class="btn btn-dark" name="btn_update_product"><i class="bi bi-arrow-repeat"></i> Update</button>
              </div>
            </form>
          </div>
        </div>
      </div><!-- End Edit Modal-->
  <?php
    }
  }
  ?>

  <div class="modal fade" id="modal_add"> <!-- Modal add -->
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bx bx-plus-circle text-success"></i> <strong>ADD PRODUCT</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" enctype="multipart/form-data" action="controller.php?action=add_product" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="row mb-3 contact_message">
              <div class="col-12 d-flex align-items-start align-items-sm-center gap-4">
                <img src="assets/img/products/default.png" alt="profile" class="img-fluid d-block rounded product" height="100" width="100">
                <div class="button-wrapper">
                  <label class="btn btn-dark me-2 mb-2" tabindex="0" style="cursor: pointer; font-size: inherit; padding: 12px 30px; color: #ffffff; border-radius: 4px">
                    <i class="ti ti-upload d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Upload new photo</span>
                    <input type="file" class="file-input-image" input-id="product" name="image" hidden accept="image/png, image/jpeg, .svg">
                    <input type="hidden" class="filename" name="filename" value="<?php echo $admin_info['img_dir']; ?>">
                  </label>
                  <button type="button" class="btn btn-danger mb-2 file-reset-image" style="background-color: #dc3545;" id="product" page="ADD-PRODUCT" hidden>
                    <i class="ti ti-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Reset</span>
                  </button>
                  <p class="text-muted mb-0">Allowed formats (JPG,PNG,SVG). Max size of 2.5MB</p>
                  <span class="size-preview mb-2">Size: <i class="bx bx-check text-success"></i></span>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Product Name</label>
              <div class="col-md-8 col-lg-9">
                <input name="product_name" type="text" class="form-control" placeholder="Enter product name" required>
                <div class="invalid-feedback">Please add product name.</div>
                <i>Invalid characters: (/)</i>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Brand</label>
              <div class="col-md-8 col-lg-9">
                <select class="form-select" style="border-radius: 0;" name="product_brand">
                  <?php
                  $result_brands = $db->GR_brands();
                  if (mysqli_num_rows($result_brands) > 0) {
                    while ($row_brands = mysqli_fetch_array($result_brands)) {

                  ?>
                      <option><?php echo $row_brands['brand']; ?></option>
                  <?php

                    }
                  }
                  ?>
                </select>
              </div>
            </div>
           <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Price</label>
              <div class="col-md-8 col-lg-9">
                <input name="product_price" type="number" class="form-control" placeholder="Enter price" min="0" step="0.01" required oninput="validatePrice(this)">
                <div class="invalid-feedback">Please add a valid product price (positive number).</div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Expiration Date</label>
              <div class="col-md-8 col-lg-9">
                <input name="exp_date" type="date" class="form-control" required>
                <div class="invalid-feedback">Please add a valid expiration date.</div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Quantity</label>
              <div class="col-md-8 col-lg-9">
                <input name="product_qty" type="number" min="0" class="form-control" value="1" required style="width: auto">
                <div class="invalid-feedback">Please indicate quantity.</div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal" aria-label="Close" title="Cancel"><i class="bi bi-x-circle"></i> Cancel</button>
            <button type="submit" class="btn btn-dark" name="btn_add_product"><i class="bi bi-check-circle"></i> Add</button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- End Add Modal-->

  <!--home product area start-->
  <section class="home_product_area mb-50">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="product_header">
            <div class="section_title mt-5">
              <h2><i class='bx bx-detail pb-1' style="font-size: 24px;"></i> Product List </h2>
            </div>
            <div class="product_tab_button mt-5">
              <ul class="nav" role="tablist">
                <li>
                  <a class="active" data-bs-toggle="modal" data-bs-target="#modal_add">
                    <i class="bx bx-plus"></i> Add product
                  </a>
                </li>
                <li>
                    <!-- Print Button -->
                    <a href="print-products.php" rel="noopener" target="_blank" class="btn sm mb-3">
                       <i class='bx bx-printer' style="font-size: 24px;"></i>
                    </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="container-fluid">
            <div class="table-responsive">
              <table class="table text-center" id="table_products" width="100%">
                <thead>
                  <tr>
                    <th>Date Expiration</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Available Quantity</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
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
  $get->novalidate();
  $get->toastr_js();
  $get->dt_js();
  $get->photo_controls();
  $db->display_message();
  ?>
  <script src="assets/js/dt.data.products.js"></script>
  <script>
  function validatePrice(input) {
    if (input.value < 0) {
      input.setCustomValidity('Price cannot be negative');
      input.reportValidity();
    } else {
      input.setCustomValidity('');
    }
  }
</script>
</body>

</html>