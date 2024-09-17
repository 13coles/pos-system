<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('my-profile.php');
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
        <form class="needs-validation" method="POST" action="controller.php?action=unlink&ref=ADMIN" novalidate>
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
        <form class="needs-validation" method="POST" action="controller.php?action=link&ref=ADMIN&platform=FACEBOOK" novalidate>
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
        <form class="needs-validation" method="POST" action="controller.php?action=link&ref=ADMIN&platform=TWITTER" novalidate>
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
        <form class="needs-validation" method="POST" action="controller.php?action=link&ref=ADMIN&platform=INSTAGRAM" novalidate>
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
        <form class="needs-validation" method="POST" action="controller.php?action=link&ref=ADMIN&platform=TIKTOK" novalidate>
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
              <h2><i class='bx bx-user-pin pb-1'></i> Profile Details</h2>
            </div>
            <form id="form" class="needs-validation" enctype="multipart/form-data" method="POST" action="controller.php?action=update_admin_profile&id=<?php echo $admin_info['id']; ?>" novalidate>
              <div class="row mb-3">
                <div class="col-12 d-flex align-items-start align-items-sm-center gap-4">
                  <img src="assets/img/avatars/<?php echo $admin_info['img_dir']; ?>" alt="profile" class="img-fluid d-block rounded <?php echo $admin_info['id']; ?>" height="100" width="100">
                  <div class="button-wrapper">
                    <label class="btn btn-dark me-2 mb-2" tabindex="0" style="cursor: pointer; font-size: inherit; padding: 12px 30px; color: #ffffff; border-radius: 4px">
                      <i class="ti ti-upload d-block d-sm-none"></i>
                      <span class="d-none d-sm-block">Upload new photo</span>
                      <input type="file" class="file-input-image" input-id="<?php echo $admin_info['id']; ?>" name="image" hidden accept="image/png, image/jpeg, .svg">
                      <input type="hidden" class="filename" name="filename" value="<?php echo $admin_info['img_dir']; ?>">
                    </label>
                    <button type="button" class="btn btn-danger mb-2 file-reset-image" style="background-color: #dc3545;" id="<?php echo $admin_info['id']; ?>" page="ADMIN-PROFILE" hidden>
                      <i class="ti ti-x d-block d-sm-none"></i>
                      <span class="d-none d-sm-block">Reset</span>
                    </button>
                    <p class="text-muted mb-0">Allowed formats (JPG,PNG,SVG). Max size of 2.5MB</p>
                    <span class="size-preview mb-2">Size: <i class="bx bx-check text-success"></i></span>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-12 pb-3">
                  <label for="fullname" class="form-label">Name <small>(required *)</small></label>
                  <input type="text" id="fullname" name="name" value="<?php echo $admin_info['name']; ?>">
                </div>
                <div class="col-6 pb-3">
                  <label for="email" class="form-label">E-mail</label>
                  <input type="text" id="email" name="email" value="<?php echo $admin_info['email']; ?>" placeholder="john.doe@example.com" />
                </div>
                <div class="col-6 pb-3">
                  <label for="phoneNumber" class="form-label">Phone Number</label>
                  <input type="tel" id="phoneNumber" name="phone" maxlength="11" value="<?php echo $admin_info['phone']; ?>" placeholder="09084524688" />
                </div>
                <div class="col-12 pb-2">
                  <label>Address</label>
                  <textarea class="mb-0" placeholder="Complete address *" name="address"><?php echo $admin_info['address']; ?></textarea>
                </div>
                <div class="col-3 pb-3">
                  <label class="form-label">Role</label>
                  <input type="text" id="email" name="role" value="<?php echo $admin_info['role']; ?>" readonly placeholder="john.doe@example.com" />
                </div>
                <div class="col-3 pb-3">
                  <label class="form-label">Status</label>
                  <input type="hidden" name="status" value="<?php echo $admin_info['status']; ?>">
                  <span class="form-control" style="border: none; padding-left: 0"><?php if ($admin_info['status'] == 'ACTIVE') {
                                                                                      echo '<span class="badge rounded-pill bg-success p-2">ACTIVE</span>';
                                                                                    } else {
                                                                                      echo '<span class="badge rounded-pill bg-danger">INACTIVE</span>';
                                                                                    } ?></span>
                </div>
                <div class="col-6 pb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="tel" id="username" name="username" maxlength="11" value="<?php echo $admin_info['username']; ?>" placeholder="09084524688" />
                </div>
                <div class="col-6 pb-3">
                  <label for="cur_password" class="form-label">Currrent password</label>
                  <input type="password" id="cur_password" value="<?php echo $admin_info['password']; ?>" readonly placeholder="09084524688" />
                  <input type="hidden" name="oldpassword" value="<?php echo $admin_info['password']; ?>">
                </div>
                <div class="col-6 pb-3">
                  <label for="password" class="form-label">New Password <small>(Leave blank if you don't want to change your password.)</small></label>
                  <input type="text" id="password" name="newpassword">
                </div>
              </div>
              <button class="btn" type="submit" name="btn_update_profile">Save changes</button>
              <p class="form-messege"></p>
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