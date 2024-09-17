<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('terms-and-conditions.php');
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
echo '<link rel="stylesheet" href="/assets/css/style2.css">';
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
            <div class="section_title">
              <h2>Terms &amp; <span>Conditions</span></h2>
            </div>
            <h4>1. Acceptance of Terms</h4>
            <p>By accessing or using <strong><?php echo $system_info['system_title']; ?></strong> website and services,
              you agree to be bound by these Terms and Conditions.</p>
            <h4>2. Ordering and Payment</h4>
            <p>2.1. By placing an order, you agree to pay for the ordered products and any applicable shipping fees.</p>
            <p>2.2. We reserve the right to refuse or cancel orders in our discretion.</p>
            <h4>3. Product Information</h4>
            <p>3.1. We make reasonable efforts to provide accurate product descriptions. However, we do not warrant
              that product descriptions or other content on our website are accurate, complete, or error-free.</p>
            <h4>4. Returns and Refunds</h4>
            <p>Our returns and refunds policy is available on our website.</p>
            <h4>5. Intellectual Property</h4>
            <p>5.1. All content on our website, including text, graphics, logos, and images, is the property of
              <strong><?php echo $system_info['system_title']; ?></strong> and protected by intellectual property laws.
            </p>
            <p>5.2. You may not use our content without our prior written consent.</p>
            <h4>6. Limitation of Liability</h4>
            <p>We are not liable for any direct, indirect, incidental, special, or consequential damages arising
              from your use of our website or products.</p>
            <h4>7. Governing Law</h4>
            <p>These Terms and Conditions are governed by the laws of [to be cited].</p>
            <h4>8. Contact Us</h4>
            <p>If you have any questions or concerns about this Privacy Policy, please contact us
              at <?php echo $system_info['phone']; ?> or email us at <?php echo $system_info['email']; ?>.</p>
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
  $get->toastr_js();
  $db->display_message();
  ?>
</body>

</html>