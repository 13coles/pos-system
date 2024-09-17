<?php
require_once('config/dbconfig.php');
$db = new Data_Operations();

$result = $db->GR_cart_info();
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    echo "
    <div class='row item'>
      <div class='col-4 desc'>
        " . $row['product_name'] . "
      </div>
      <div class='col-3 qty'>
        " . $row['product_name'] . "
      </div>
      <div class='col-5 amount text-right'>
        " . $row['product_name'] . "
      </div>
    </div>
    ";
  }
}
?>