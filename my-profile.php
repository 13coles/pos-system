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
                  <input type="text" id="email" name="email" value="<?php echo $admin_info['email']; ?>" placeholder="james@example.com" />
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
                  <input type="text" id="email" name="role" value="<?php echo $admin_info['role']; ?>" readonly placeholder="Enter ROle" />
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
                  <input type="text" id="username" name="username"  value="<?php echo $admin_info['username']; ?>" placeholder="Enter Uername" />
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