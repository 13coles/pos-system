<?php
require_once('config/dbconfig.php');
$db = new Data_Operations();
$result_notif = $db->GR_notifications();
if (mysqli_num_rows($result_notif) > 0) {
  while ($row_notif = mysqli_fetch_array($result_notif)) {
    echo "<li style='border-bottom: 1px solid #e5e5e5;'>
            <div class='alert alert-warning'>
              <h6 class='alert-heading fw-bold mb-1 notif-title' style='letter-spacing: 1.5px'>".$row_notif['notif_name']."</h6>
              <p class='mb-0 notif-message'>". $row_notif['notif_desc']."</p>
            </div>
          </li>";
  }
}
?>