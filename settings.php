<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('settings.php');
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
include('util/head.php');
$get->toastr_css_new();
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
          <h6 class="modal-title"><i class="bx bx-unlink text-danger"></i> <strong>UNLINK ACCOUNT</strong></h6>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="needs-validation" method="POST" action="controller.php?action=unlink&ref=SYSTEM" novalidate>
          <div class="modal-body">
            <h6>Are you sure to delete this linked account? <strong>This process <i>cannot</i> be undone</strong>.</h6>
            <label for="facebook">Linked account: <span class="platform-text"></span></label>
            <input type="text" class="form-control linked" id="facebook" placeholder="Enter link" required readonly>
            <input type="hidden" class="platform" name="platform">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-dark" name="btn_unlink">Unlink</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_link_facebook" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <i class="bx bx-link text-primary"></i> <strong>LINK ACCOUNT</strong>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="needs-validation" method="POST" action="controller.php?action=link&ref=SYSTEM&platform=FACEBOOK" novalidate>
          <div class="modal-body contact_message form">
            <h5>Link your facebook account.</h5>
            <label for="#facebook" class="mb-2">Facebook link</label>
            <input type="text" id="facebook" name="link" placeholder="Enter link" required>
            <div class="invalid-feedback">*Enter a valid link</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-dark" name="btn_link">Link</button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- End link Modal-->

  <div class="modal fade" id="modal_link_twitter" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <i class="bx bx-link text-primary"></i> <strong>LINK ACCOUNT</strong>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="needs-validation" method="POST" action="controller.php?action=link&ref=SYSTEM&platform=TWITTER" novalidate>
          <div class="modal-body contact_message form">
            <h5>Link your twitter account.</h5>
            <label for="#twitter" class="mb-2">Twitter link</label>
            <input type="text" id="twitter" name="link" placeholder="Enter link" required>
            <div class="invalid-feedback">*Enter a valid link</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-dark" name="btn_link">Link</button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- End link Modal-->

  <div class="modal fade" id="modal_link_instagram" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <i class="bx bx-link text-primary"></i> <strong>LINK ACCOUNT</strong>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="needs-validation" method="POST" action="controller.php?action=link&ref=SYSTEM&platform=INSTAGRAM" novalidate>
          <div class="modal-body contact_message form">
            <h5>Link your instagram account.</h5>
            <label for="#instagram" class="mb-2">Instagram link</label>
            <input type="text" id="instagram" name="link" placeholder="Enter link" required>
            <div class="invalid-feedback">*Enter a valid link</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-dark" name="btn_link">Link</button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- End link Modal-->

  <div class="modal fade" id="modal_link_tiktok" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <i class="bx bx-link text-primary"></i> <strong>LINK ACCOUNT</strong>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="needs-validation" method="POST" action="controller.php?action=link&ref=SYSTEM&platform=TIKTOK" novalidate>
          <div class="modal-body contact_message form">
            <h5>Link your tiktok account.</h5>
            <label for="#tiktok" class="mb-2">Tiktok link</label>
            <input type="text" id="tiktok" name="link" placeholder="Enter link" required>
            <div class="invalid-feedback">*Enter a valid link</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-dark" name="btn_link">Link</button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- End link Modal-->

  <div class="contact_area pt-3">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="contact_message form">
            <div class="section_title mt-5">
              <h2><i class='bx bx-cog pb-1'></i> System Details</h2>
            </div>
            <form id="form" class="needs-validation" enctype="multipart/form-data" method="POST" action="controller.php?action=update_settings" novalidate>
              <div class="row">
                <div class="col-lg-6 mb-3">
                  <label class="form-label">Page logo</label>
                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="assets/img/system/<?php echo $system_info['system_logo']; ?>" alt="logo" class="img-fluid d-block rounded <?php echo $system_info['id'] . '_logo'; ?>" height="100" width="100">
                    <div class="button-wrapper">
                      <label class="btn btn-dark me-2 mb-2" tabindex="0" style="cursor: pointer; font-size: inherit; padding: 12px 30px; color: #ffffff; border-radius: 4px">
                        <i class="ti ti-upload d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <input type="file" class="file-input-image" input-id="<?php echo $system_info['id'] . '_logo'; ?>" name="logo" hidden accept="image/png, image/jpeg, .svg">
                        <input type="hidden" class="filename_logo" name="filename_logo" value="<?php echo $system_info['system_logo']; ?>">
                      </label>
                      <button type="button" class="btn btn-danger mb-2 file-reset-image" style="background-color: #dc3545;" id="<?php echo $system_info['id'] . '_logo'; ?>" page="SETTINGS_LOGO" hidden>
                        <i class="ti ti-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Reset</span>
                      </button>
                      <p class="text-muted mb-0">Allowed formats (JPG,PNG,SVG). Max size of 2.5MB</p>
                      <span class="size-preview-logo mb-2">Size: <i class="bx bx-check text-success"></i></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-3">
                  <label class="form-label">Page icon</label>
                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="assets/img/system/<?php echo $system_info['system_icon']; ?>" alt="icon" class="img-fluid d-block rounded <?php echo $system_info['id'] . '_icon'; ?>" height="100" width="100">
                    <div class="button-wrapper">
                      <label class="btn btn-dark me-2 mb-2" tabindex="0" style="cursor: pointer; font-size: inherit; padding: 12px 30px; color: #ffffff; border-radius: 4px">
                        <i class="ti ti-upload d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <input type="file" class="file-input-image" input-id="<?php echo $system_info['id'] . '_icon'; ?>" name="icon" hidden accept="image/png, image/jpeg, .svg">
                        <input type="hidden" class="filename_icon" name="filename_icon" value="<?php echo $system_info['system_icon']; ?>">
                      </label>
                      <button type="button" class="btn btn-danger mb-2 file-reset-image" style="background-color: #dc3545;" id="<?php echo $system_info['id'] . '_icon'; ?>" page="SETTINGS_ICON" hidden>
                        <i class="ti ti-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Reset</span>
                      </button>
                      <p class="text-muted mb-0">Allowed formats (JPG,PNG,SVG). Max size of 2.5MB</p>
                      <span class="size-preview-icon mb-2">Size: <i class="bx bx-check text-success"></i></span>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <p>
                <label for="fullname" class="form-label">System name <small>(required *)</small></label>
                <input type="text" id="fullname" name="system_title" value="<?php echo $system_info['system_title']; ?>">
              </p>
              <div class="row">
                <div class="col-6 pb-3">
                  <label for="email" class="form-label">E-mail</label>
                  <input type="text" id="email" name="email" value="<?php echo $system_info['email']; ?>" placeholder="john.doe@example.com" />
                </div>
                <div class="col-6 pb-3">
                  <label for="email" class="form-label">Phone Number</label>
                  <input type="tel" id="phoneNumber" name="phone" maxlength="11" value="<?php echo $system_info['phone']; ?>" placeholder="09084524688" />
                </div>
                <div class="col-12 mb-0">
                  <label>Address</label>
                  <textarea placeholder="Complete address *" name="address"><?php echo $system_info['address']; ?></textarea>
                </div>
                <div class="col-12 mb-0">
                  <label>Shop Description</label>
                  <textarea placeholder="Write something about the system *" name="system_description"><?php echo $system_info['system_description']; ?></textarea>
                </div>
              </div>
              <button class="btn" type="submit" name="btn_update_settings">Save changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--footer area start-->
  <?php include_once('util/footer-admin.php'); ?>
  <!--footer area end-->

  <!--map js code here-->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdWLY_Y6FL7QGW5vcO3zajUEsrKfQPNzI"></script>
  <script src="https://www.google.com/jsapi"></script>
  <script src="assets/js/map.js"></script>

  <!-- Plugins JS -->
  <script src="assets/js/plugins.js"></script>

  <!-- Main JS -->
  <script src="assets/js/main.js"></script>

  <!-- Page JS -->
  <?php
  $get->jQuery();
  $get->preloader_js();
  $get->novalidate();
  $get->toastr_js();
  $get->photo_controls();
  $db->display_message();
  ?>
  <script src="assets/js/controls.settings.js"></script>
</body>

</html>