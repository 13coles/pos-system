<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('shop.php');
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
<script type="text/javascript" src="assets/js/instascan.min.js"></script>

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
          <h6>Are you sure to delete this brand? <strong>This process <i>cannot</i> be undone</strong>.</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-dark btn-delete" data-bs-dismiss="modal">Confirm</button>
        </div>
      </div>
    </div>
  </div><!-- End Delete Modal-->

  <div class="modal fade" id="modal_add"> <!-- Modal add -->
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bx bx-plus-circle text-success"></i> <strong>ADD BRAND</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" enctype="multipart/form-data" action="controller.php?action=add_brand" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="row mb-3 contact_message">
              <div class="col-12 d-flex align-items-start align-items-sm-center gap-4">
                <img src="assets/img/brands/brand-image.png" alt="brand" class="img-fluid d-block rounded brand" height="100" width="100">
                <div class="button-wrapper">
                  <label class="btn btn-dark me-2 mb-2" tabindex="0" style="cursor: pointer; font-size: inherit; padding: 12px 30px; color: #ffffff; border-radius: 4px">
                    <i class="ti ti-upload d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Upload new photo</span>
                    <input type="file" class="file-input-image" input-id="brand" name="image" hidden accept="image/png, image/jpeg, .svg">
                    <input type="hidden" class="filename" name="filename" value="<?php echo $admin_info['img_dir']; ?>">
                  </label>
                  <button type="button" class="btn btn-danger mb-2 file-reset-image" style="background-color: #dc3545;" id="brand" page="ADD-BRAND" hidden>
                    <i class="ti ti-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Reset</span>
                  </button>
                  <p class="text-muted mb-0">Allowed formats (JPG,PNG,SVG). Max size of 2.5MB</p>
                  <span class="size-preview mb-2">Size: <i class="bx bx-check text-success"></i></span>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Brand</label>
              <div class="col-md-8 col-lg-9">
                <input name="brand" type="text" class="form-control" placeholder="Enter brand name" required>
                <div class="invalid-feedback">Please specify brand name.</div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal" aria-label="Close" title="Cancel"><i class="bi bi-x-circle"></i> Cancel</button>
            <button type="submit" class="btn btn-dark" name="btn_add_brand"><i class="bi bi-check-circle"></i> Add</button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- End Add Modal-->

  <?php
  $result_brands_edit = $db->GR_brands();
  if (mysqli_num_rows($result_brands_edit) > 0) {
    while ($row_info = mysqli_fetch_array($result_brands_edit)) {
  ?>
      <div class="modal fade" id="modal_edit_<?php echo $row_info['id']; ?>"> <!-- Modal edit -->
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="bx bx-info-circle text-info"></i> <strong>EDIT BRAND</strong></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="controller.php?action=update_brand&id=<?php echo $row_info['id']; ?>" class="needs-validation" novalidate>
              <div class="modal-body">
                <div class="row mb-3 contact_message">
                  <div class="col-12 d-flex align-items-start align-items-sm-center gap-4">
                    <img src="assets/img/brands/<?php echo $row_info['img_dir']; ?>" alt="brand" class="img-fluid d-block rounded <?php echo $row_info['id']; ?>" height="100" width="100">
                    <div class="button-wrapper">
                      <label class="btn btn-dark me-2 mb-2" tabindex="0" style="cursor: pointer; font-size: inherit; padding: 12px 30px; color: #ffffff; border-radius: 4px">
                        <i class="ti ti-upload d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <input type="file" class="file-input-image" input-id="<?php echo $row_info['id']; ?>" name="image" hidden accept="image/png, image/jpeg, .svg">
                        <input type="hidden" class="filename_brand_<?php echo $row_info['id']; ?>" name="filename" value="<?php echo $row_info['img_dir']; ?>">
                      </label>
                      <button type="button" class="btn btn-danger mb-2 file-reset-image" style="background-color: #dc3545;" id="<?php echo $row_info['id']; ?>" page="BRAND" hidden>
                        <i class="ti ti-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Reset</span>
                      </button>
                      <p class="text-muted mb-0">Allowed formats (JPG,PNG,SVG). Max size of 2.5MB</p>
                      <span class="size-preview mb-2">Size: <i class="bx bx-check text-success"></i></span>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label">Brand</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="brand" type="text" class="form-control" value="<?php echo $row_info['brand']; ?>" placeholder="Enter product name">
                    <div class="invalid-feedback">Please add brand name.</div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal" aria-label="Close" title="Cancel"><i class="bi bi-x-circle"></i> Cancel</button>
                <button type="submit" class="btn btn-dark" name="btn_update_brand"><i class="bi bi-arrow-repeat"></i> Update</button>
              </div>
            </form>
          </div>
        </div>
      </div><!-- End Edit Modal-->
  <?php
    }
  }
  ?>

  <!--slider area start-->
  <section class="slider_section mt-20 mb-50">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 mt-30">
          <div class="product_header">
            <div class="section_title ">
              <h2><i class='bx bx-badge-check pb-1' style="font-size: 24px;"></i> <?php echo $system_info['system_title']; ?> Brands </h2>
            </div>
              <div class="product_tab_button">
                <ul class="nav" role="tablist">
                  <li>
                    <a class="active" data-bs-toggle="modal" data-bs-target="#modal_add">
                      <i class="bx bx-plus"></i> Add brand
                    </a>
                  </li>
                  <li>
                    <!-- Print Button -->
                    <a href="print-brands.php" rel="noopener" target="_blank" class="btn sm mb-3">
                      <i class='bx bx-printer' style="font-size: 24px;"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
       
          </div>
        </div>
        <div class="col-lg-12">
          <div class="table-responsive">
            <table class="table text-center" id="table_brands" width="100%">
              <thead>
                <tr>
                  <th width="30%">Image</th>
                  <th>Brand name</th>
                  <th width="20%">Action</th>
                </tr>
              </thead>
            </table>
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
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/dt.data.brands.js"></script>
  <!-- Main JS -->
  <script src="assets/js/main.js"></script>


  <!-- Page JS -->
  <?php
  $get->jQuery();
  $get->dt_js();
  $get->photo_controls();
  $get->novalidate();
  $get->toastr_js();
  $db->display_message();
  ?>


</body>

</html>