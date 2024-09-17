<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('privacy-and-policy.php');
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
              <h2>Privacy <span>Policy</span></h2>
            </div>
            <h4>1. Introduction</h4>
            <p>Welcome to <strong><?php echo $system_info['system_title']; ?></strong> ("we," "our," or "us"). We are committed to
              protecting the privacy and security of your personal information. This Privacy Policy outlines how
              we collect, use, disclose, and protect your information when you visit our website or use our services.</p>
            <h4>2. Information We Collect</h4>
            <p>2.1. <strong>Personal Information:</strong> We may collect personal information such as your name, email address,
              mailing address, phone number, and payment information when you register on our website, place an
              order, or communicate with us.</p>
            <p>2.2. <strong>Usage Information:</strong> We may collect information about your interactions with our website, including
              your IP address, browser type, and operating system, to improve our services and enhance your experience.</p>
            <h4>3. How We Use Your Information</h4>
            <p style="margin-bottom: 0;">3.1. We use your personal information for the following purposes:</p>
            <ul class="px-4">
              <li style="padding: 0; border: none; list-style: circle">To process and fulfill orders.</li>
              <li style="padding: 0; border: none; list-style: circle">To provide customer support and respond to inquiries.</li>
              <li style="padding: 0; border: none; list-style: circle">To send transactional emails and updates related to your orders.</li>
              <li style="padding: 0; border: none; list-style: circle">To improve our website and services.</li>
            </ul>
            <p>3.2. We do not sell or rent your personal information to third parties.</p>
            <h4>4. Cookies and Tracking Technologies</h4>
            <p>We may use cookies and similar tracking technologies to enhance your experience on our website. You can
              control cookies through your browser settings.</p>
            <h4>5. Data Security</h4>
            <p>We take reasonable steps to protect your personal information from unauthorized access, disclosure,
              alteration, or destruction.</p>
            <h4>6. Third-Party Links</h4>
            <p>Our website may contain links to third-party websites. We are not responsible for the privacy practices
              or content of these websites.</p>
            <h4>7. Changes to This Privacy Policy</h4>
            <p>We may update this Privacy Policy from time to time. Please review it periodically for changes.</p>
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