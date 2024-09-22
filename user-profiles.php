<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('user-profiles.php');
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
          <h6 class="modal-title"><i class="bx bx-trash text-danger"></i> <strong>DELETE ACCOUNT</strong></h6>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6>Are you sure to delete this account? <strong>This process <i>cannot</i> be undone</strong>.</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-dark btn-delete" data-bs-dismiss="modal">Confirm</button>
        </div>
      </div>
    </div>
  </div><!-- End Delete Modal-->

  <div class="modal fade" id="modal_delete_role" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title"><i class="bx bx-trash text-danger"></i> <strong>DELETE RECORD</strong></h6>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6>Are you sure to delete this record? <strong>This process <i>cannot</i> be undone</strong>.</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-dark btn-delete" data-bs-dismiss="modal">Confirm</button>
        </div>
      </div>
    </div>
  </div><!-- End Delete Modal-->

  <div class="modal fade" id="modal_deactivate" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title"><i class="bx bx-power-off text-danger"></i> <strong>DEACTIVATE ACCOUNT</strong></h6>
          <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6>Are you sure to deactivate this account?</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-dark btn-deactivate-confirm" data-bs-dismiss="modal">Confirm</button>
        </div>
      </div>
    </div>
  </div><!-- End Deactivate Modal-->

  <div class="modal fade" id="modal_add"> <!-- Modal add -->
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bx bx-user-plus text-success"></i> <strong>CREATE ACCOUNT</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" enctype="multipart/form-data" action="controller.php?action=register" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="row mb-3 contact_message form">
              <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img src="assets/img/avatars/default.png" alt="system-logo" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                <div class="button-wrapper">
                  <label for="profile_image" class="bg-dark me-2 mb-0" style="cursor: pointer; font-size: inherit; padding: 12px 30px; color: #ffffff; border-radius: 4px">
                    <span class="d-none d-sm-block">Upload photo</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input type="file" id="profile_image" class="account-file-input" name="image" hidden accept="image/png, image/jpeg" />
                  </label>
                  <button type="reset" class="btn bg-danger account-image-reset me-2" style="font-size: inherit; padding: 0px 30px; color: #ffffff; border-radius: 4px">Reset</button>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Name</label>
              <div class="col-md-8 col-lg-9">
                <input name="name" type="text" class="form-control" placeholder="Enter name" required>
                <div class="invalid-feedback">Please enter name*</div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Phone number</label>
              <div class="col-md-8 col-lg-9">
                <input name="phone" type="tel" maxlength="11" class="form-control" placeholder="Enter phone number" required>
                <div class="invalid-feedback">Please enter phone no.*</div>
              </div>
            </div>
            <div class="row">
              <label class="col-md-4 col-lg-3 col-form-label">Role</label>
              <div class="col-md-8 col-lg-9">
              <select class="form-select pt-1 mb-3" style="border-radius: 0; border-color: none;" name="role">
                <?php
                $result_roles = $db->GR_roles();
                if (mysqli_num_rows($result_roles) > 0) {
                  while ($row_roles = mysqli_fetch_array($result_roles)) {
                ?>
                    <option><?php echo $row_roles['role']; ?></option>
                <?php
                  }
                }
                ?>
              </select>

              </div>
              <div class="col-12">
                <div class="alert alert-info mb-0">
                  <h6 class="alert-heading fw-bold mb-1">REMINDER:</h6>
                  <p class="mb-0">The default <i>username</i> and <i>password</i> for newly created accounts is; <strong>username: <i>name</i></strong>, <strong>password: <i>phone no.</i></strong></p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal" aria-label="Close" title="Cancel"><i class="bi bi-x-circle"></i> Cancel</button>
            <button type="submit" class="btn btn-dark" name="btn_register"><i class="bi bi-check-circle"></i> Create</button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- End Add Modal-->

  <div class="modal fade" id="modal_add_role"> <!-- Modal add -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bx bx-plus text-success"></i> <strong>ADD ROLE</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" enctype="multipart/form-data" action="controller.php?action=add_role" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="row mb-3">
              <label class="col-md-4 col-lg-3 col-form-label">Role</label>
              <div class="col-md-8 col-lg-9">
                <input name="role" type="text" class="form-control" placeholder="Enter role" required>
                <div class="invalid-feedback">Please enter role*</div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal" aria-label="Close" title="Cancel"><i class="bi bi-x-circle"></i> Cancel</button>
            <button type="submit" class="btn btn-dark" name="btn_add_role"><i class="bi bi-check-circle"></i> Add</button>
          </div>
        </form>
      </div>
    </div>
  </div><!-- End Add Modal-->

  <?php
  $result_roles = $db->GR_roles();
  if (mysqli_num_rows($result_roles) > 0) {
    while ($row_roles = mysqli_fetch_array($result_roles)) {
  ?>
      <div class="modal fade" id="modal_edit_<?php echo $row_roles['id']; ?>_role"> <!-- Modal edit -->
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="bx bx-info-circle text-info"></i> <strong>UPDATE ROLE</strong></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="controller.php?action=update_role" class="needs-validation" novalidate>
              <div class="modal-body">
                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label">Role</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="role" type="text" class="form-control" value="<?php echo $row_roles['role']; ?>" placeholder="Enter role" required>
                    <div class="invalid-feedback">Please enter role*</div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal" aria-label="Close" title="Cancel"><i class="bi bi-x-circle"></i> Cancel</button>
                <button type="submit" class="btn btn-dark" name="btn_update_role"><i class="bi bi-check-circle"></i> Add</button>
              </div>
            </form>
          </div>
        </div>
      </div><!-- End edit Modal-->
  <?php
    }
  }
  ?>

  <?php
  $ressult = $db->GR_user_accounts();
  if (mysqli_num_rows($ressult) > 0) {
    while ($row = mysqli_fetch_array($ressult)) {
  ?>
      <div class="modal fade" id="modal_manage_<?php echo $row['id']; ?>">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="bx bx-user text-info"></i> <strong>PROFILE DETAILS</strong></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="controller.php?action=update_user_profile&id=<?php echo $row['id']; ?>" class="needs-validation" novalidate>
              <div class="modal-body">
                <div class="col-12">
                  <div class="contact_message form">
                    <label class="form-label">Profile image</label>
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                      <img src="assets/img/avatars/<?php echo $row['img_dir']; ?>" alt="profile" class="d-block rounded" height="100" width="100" />
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-12 pb-3">
                        <label for="fullname" class="form-label">Name <small>(required *)</small></label>
                        <input type="text" id="fullname" name="name" value="<?php echo $row['name']; ?>">
                      </div>
                      <div class="col-6 pb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>" placeholder="john.doe@example.com" />
                      </div>
                      <div class="col-6 pb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="tel" id="phoneNumber" name="phone" maxlength="11" value="<?php echo $row['phone']; ?>" placeholder="09084524688" />
                      </div>
                      <div class="col-12 pb-2">
                        <label>Address</label>
                        <textarea class="mb-0" placeholder="Complete address *" name="address"><?php echo $row['address']; ?></textarea>
                      </div>
                      <div class="col-3 pb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select pt-1 mb-3" style="border-radius: 0; border-color: none;" name="role">
                          <?php
                          $result_roles = $db->GR_roles();
                          if (mysqli_num_rows($result_roles) > 0) {
                            while ($row_roles = mysqli_fetch_array($result_roles)) {
                          ?>
                              <option <?php if ($row_roles['role'] == "ADMIN") {
                                        echo 'disabled';
                                      } ?>><?php echo $row_roles['role']; ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>

                      </div>
                      <div class="col-3 pb-3">
                        <label class="form-label">Status</label>
                        <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
                        <span class="form-control" style="border: none; padding-left: 0"><?php if ($row['status'] == 'ACTIVE') {
                                                                                            echo '<span class="badge rounded-pill bg-success p-2">ACTIVE</span>';
                                                                                          } else {
                                                                                            echo '<span class="badge rounded-pill bg-danger">INACTIVE</span>';
                                                                                          } ?></span>
                      </div>
                    </div>
                    <p class="form-messege"></p>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal" aria-label="Close" title="Cancel"><i class="bi bi-x-circle"></i> Cancel</button>
                <button type="submit" class="btn btn-dark" name="btn_update_profile"><i class="bi bi-check-circle"></i> Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div><!-- End Add Modal-->
  <?php
    }
  }
  ?>

  <!--home product area start-->
  <section class="home_product_area mb-50">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="product_header">
            <div class="section_title mt-5">
              <h2><i class='bx bx-registered pb-1'></i> User Profiles</h2>
            </div>
            <div class="product_tab_button mt-5">
              <ul class="nav">
                <li class="me-4 mb-2"><a class="active" data-bs-toggle="modal" data-bs-target="#modal_add">
                    <i class="bx bx-user-plus"></i> Create account
                  </a>
                </li>
                <li style="display: flex;">
                  <span class="pe-2" style="align-self: center;">FILTER:</span>
                  <select class="form-select selector" style="border-radius: 0; border-color: none;">
                    <?php
                    $result_roles = $db->GR_roles();
                    if (mysqli_num_rows($result_roles) > 0) {
                      while ($row_roles = mysqli_fetch_array($result_roles)) {
                    ?>
                        <option><?php echo $row_roles['role']; ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </li>
              </ul>
            </div>
          </div>
          <div class="container-fluid">
            <div class="table-responsive">
              <table class="table text-center" id="table_account_list" width="100%">
                <thead>
                  <tr>
                    <th>Profile image</th>
                    <th>Name</th>
                    <th>Role</th>
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
        <div class="col-12 mt-50" hidden>
          <div class="product_header">
            <div class="section_title">
              <h2>Shop <span>Roles</span></h2>
            </div>
            <div class="product_tab_button">
              <ul class="nav">
                <li><a class="active" data-bs-toggle="modal" data-bs-target="#modal_add_role">
                    <i class="bx bx-plus"></i> Add role
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="container-fluid">
            <div class="table-responsive">
              <table class="table text-center" id="table_roles" width="100%">
                <thead>
                  <tr>
                    <th>Role</th>
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
  $get->preloader_js();
  $get->novalidate();
  $get->toastr_js();
  $get->dt_js();
  $get->photo_controls();
  $db->display_message();
  ?>
  <script src="assets/js/dt.user.profiles.js"></script>

</body>

</html>