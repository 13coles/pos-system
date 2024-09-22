<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
$db = new Data_Operations();
$get = new File_Contents();

$db->GR_accounts();

$result_info = $db->GR_system_info();
$system_info = mysqli_fetch_array($result_info);

?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<?php
include_once('util/head.php');
echo '<link href="assets/css/style2.css" rel="stylesheet">';
echo '<script src="assets/js/helpers.js"></script>';
$get->toastr_css_new();
?>


<body class="">
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100 contact_message form">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto ccs">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your provided credentials</p>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                      <label class="form-label" for="username">Username</label>
                      <input type="text" class="form-control" placeholder="Username" tabindex="1" autofocus id="username" aria-label="Email" name="username" required>
                      <div class="invalid-feedback">*Please enter username</div>
                    </div>
                    <div class="mb-3 form-password-toggle">
                      <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                        <!-- <a href="auth-forgot-password.php">
                          <small>Forgot Password?</small>
                        </a> -->
                      </div>
                      <div class="input-group input-group-merge">
                        <input style="border-radius: 0;" type="password" tabindex="2" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />

                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        <div class="invalid-feedback">*Please enter password</div>
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-dark w-100 mt-4 mb-0" tabindex="3" name="btn-login" style="color: #ffffff;">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="width: 100%; height: 100%;">
                  <!-- Video Background -->
                  <video autoplay muted loop playsinline class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover;">
                      <source src="assets/img/gallery/bg-video.mp4" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>
                 
                  <h3 class="mt-5  text-white font-weight-bolder position-relative" style="color: black;  ">"Nurture Your Natural Beauty, Inside and Out."</h3>
                  <h4 class=" text-white font-weight-bolder position-relative" style="color: black;  ">"Empowering your beauty journey with products that care for you, mind, body, and soul."<h4>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include('util/footer-admin.php'); ?>

  <!-- Plugins JS -->
  <script src="assets/js/plugins.js"></script>

  <!-- Main JS -->
  <script src="assets/js/main.js"></script>

  <div id="preloader"></div>

  <?php
  $get->jQuery();
  $get->novalidate();
  $get->preloader_js();
  $get->toastr_js();
  $db->display_message();
  ?>
  <script src="assets/js/n.js"></script>
</body>

</html>