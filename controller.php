<?php
  require_once('config/dbconfig.php');
  $db = new Data_Operations();

  if(isset($_GET['action'])) {
    if($_GET['action'] == 'add_product') {
      global $db;
      if($db->IR_product()) {
        $db->set_messsage("add_product_success");
        header("location: shop-product.php");
      } else {
        $db->set_messsage("add_product_fail");
        header("location: shop-product.php");
      }
    }

    if ($_GET['action'] == 'update_product') {
      global $db;
      $id = $_GET['id'];
      if ($db->UR_product($id)) {
        $db->set_messsage("update_product_success");
        header("location: shop-product.php");
      } else {
        $db->set_messsage("update_product_fail");
        header("location: shop-product.php");
      }
    }

    if($_GET['action'] == 'add_brand') {
      global $db;
      if($db->IR_brand()) {
        $db->set_messsage("add_brand_success");
        header("location: brand.php");
      } else {
        $db->set_messsage("add_brand_fail");
        header("location: brand.php");
      }
    }

    if($_GET['action'] == 'add_role') {
      global $db;
      if($db->IR_role()) {
        $db->set_messsage("add_role_success");
        header("location: user-profiles.php");
      } else {
        $db->set_messsage("add_role_fail");
        header("location: user-profiles.php");
      }
    }

    if ($_GET['action'] == 'update_brand') {
      global $db;
      $id = $_GET['id'];
      if ($db->UR_brand($id)) {
        $db->set_messsage("update_brand_success");
        header("location: brand.php");
      } else {
        $db->set_messsage("update_brand_fail");
        header("location: brand.php");
      }
    }
    
    if($_GET['action'] == 'link') {
      global $db;
      $ref = $_GET['ref'];
      $platform = $_GET['platform'];
      if($ref == 'ADMIN') {
        if($db->UR_admin_social_link_LINK($platform)) {
          $db->set_messsage("link_success");
          header("location: my-profile.php");
        } else {
          $db->set_messsage("link_fail");
          header("location: my-profile.php");
        }
      } else if($ref == 'SYSTEM') {
        if($db->UR_system_social_link_LINK($platform)) {
          $db->set_messsage("link_success");
          header("location: settings.php");
        } else {
          $db->set_messsage("link_fail");
          header("location: settings.php");
        }
      }
    }
    
    if($_GET['action'] == 'unlink') {
      global $db;
      $ref = $_GET['ref'];
      if($ref == 'ADMIN') {
        if($db->UR_admin_social_link_UNLINK()) {
          $db->set_messsage("unlink_success");
          header("location: my-profile.php");
        } else {
          $db->set_messsage("unlink_fail");
          header("location: my-profile.php");
        }
      } else if($ref == 'SYSTEM') {
        if($db->UR_system_social_link_UNLINK()) {
          $db->set_messsage("unlink_success");
          header("location: settings.php");
        } else {
          $db->set_messsage("unlink_fail");
          header("location: settings.php");
        }
      }
    }

    if($_GET['action'] == 'register') {
      global $db;
      if($db->IR_new_USER()) {
        $db->set_messsage("add_user_success");
        header("location: user-profiles.php");
      } else {
        $db->set_messsage("add_user_fail");
        header("location: user-profiles.php");
      }
    }

    if($_GET['action'] == 'update_admin_profile') {
      global $db;
      $id = $_GET['id'];
      if($db->UR_admin_profile($id)) {
        $db->set_messsage("update_admin_profile_success");
        header("location: my-profile.php");
      } else {
        $db->set_messsage("update_admin_profile_fail");
        header("location: my-profile.php");
      }
    }

    if($_GET['action'] == 'update_user_profile') {
      global $db;
      $id = $_GET['id'];
      if($db->UR_user_profile($id)) {
        $db->set_messsage("update_admin_profile_success");
        header("location: user-profiles.php");
      } else {
        $db->set_messsage("update_admin_profile_fail");
        header("location: user-profiles.php");
      }
    }
    
    if($_GET['action'] == 'update_settings') {
      global $db;
      if($db->UR_settings()) {
        $db->set_messsage("update_settings_success");
        header("location: settings.php");
      } else {
        $db->set_messsage("update_settings_fail");
        header("location: settings.php");
      }
    }  
    
    if($_GET['action'] == 'import_database') {
      global $db;
      if($re = $db->IR_database()) {
        $db->set_messsage("import_database_success");
        header("location: back-up.php");
      } else {
        $db->set_messsage("import_database_fail");
        header("location: back-up.php");
      }
    }

    if($_GET['action'] == 'clear_notification') {
      global $db;
      $ref = $_GET['ref'];
      if($db->DR_notif_all()) {
        $db->set_messsage("clear_success");
        header("location: $ref.php");
      } else {
        $db->set_messsage("clear_fail");
        header("location: $ref.php");
      }
    }
    
    if($_GET['action'] == 'submit_email') {
      global $db;
      if($result = $db->GR_accounts_FOR_PASSWORD()) {
        if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            $email = $row['email'];
          }
        }
        
        if($id == NULL && $email == NULL) {
          $db->set_messsage("select_email_fail");
          header("location: auth-forgot-password.php");
        } else {
          $db->set_messsage("select_email_success");
          header("location: auth-forgot-password.php");
        }        
      } else {
        $db->set_messsage("select_email_fail");
        header("location: auth-forgot-password.php?fail");
      }
    }
    
    if($_GET['action'] == 'loginToPage') {
      global $db;
      $user = $_GET['user'];
      $role = $_GET['role'];
      if($user == 'USER' && $role == 'ADMIN') {
        $db->set_messsage("login_success");
        header("location: dashboard.php");
      } else if($user == 'USER' && $role == 'CASHIER') {
        $db->set_messsage("login_success");
        header("location: pos.php");
      } else if($user == 'none') {
        $db->set_messsage("login_fail");
        header("location: index.php");
      }
    }
  }
