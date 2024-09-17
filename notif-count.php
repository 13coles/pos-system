<?php
require_once('config/dbconfig.php');
$db = new Data_Operations();
echo $notification_ctr = $db->GR_notif_ctr();
?>