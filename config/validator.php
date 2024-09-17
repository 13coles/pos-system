<?php
require_once('config/dbconfig.php');
$db = new Data_Operations();

if (isset($_SESSION['user_AUTH'])) {
  $role = $_SESSION['role'];
} else {
  session_destroy();
  header("location: index.php");
}

if (isset($_REQUEST['login'])) {
  $db->GR_accounts();
}

if (isset($_REQUEST['logout'])) {
  session_destroy();
  header("location: index.php");
}
?>