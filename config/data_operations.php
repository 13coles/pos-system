<!-- #################################################################################################################################################################### -->
<!--                                                                                                                                                                      -->
<!--                   WARNING !!!!!!!!!!!                                                                                                                                -->
<!--                   DO NOT DELETE THIS PAGE                                                                                                                            -->
<!--                   THIS PAGE CONTAINS THE DATABASE OPERATIONS OF THE SYSTEM                                                                                           -->
<!-- ###################################################################################################################################################################  -->
<?php
session_start();
require_once('config/dbconfig.php');
$db = new dbconfig();
###############################################################################################################
## Legend: UI=user input, AI=admin input GR=get record, UR=update record, IR=insert record, DR=delete record ##
###############################################################################################################
class Data_Operations extends dbconfig
{
  ############################################################################################################ 
  ##                                     Account creation                                                   ##
  ############################################################################################################
public function IR_new_USER()
{
  global $db;
  if (isset($_POST['btn_register'])) {
    // Sanitize input
    $name = $db->check($_POST['name']);
    $phone = $db->check($_POST['phone']);
    $role = $db->check($_POST['role']);
    $username = $name;  // You might want a different logic for username
    $password = $phone;

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle image upload
    $image = $_FILES['image']['name'];
    $path = "assets/img/avatars/" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $path);

    // Use default image if no image is uploaded
    if ($image == '') {
      $image = "default.png";
    }

    // Insert query without non-existent columns
    $query = "INSERT INTO `tbl_accounts` (`id`, `date_time`, `name`, `username`, `password`, `address`, `phone`, `email`, `role`, `status`, `img_dir`) 
              VALUES (NULL, CURRENT_TIMESTAMP, '$name', '$username', '$hashed_password', '', '$phone', '', '$role', 'ACTIVE', '$image')";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }
}

  #= Account creation end
  ############################################################################################################
  ############################################################################################################
  ##                                                                                                        ##
  ##                                       GENERATE RECORDS                                                 ##
  ##                                                                                                        ##
  ############################################################################################################ 
  public function GR_brands()#Get all records for brands
  { 
    global $db;
    $query = "SELECT * FROM `tbl_brands`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function GR_products()#Get all records for products
  { 
    global $db;
    $query = "SELECT * FROM `tbl_products`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function GR_products_by_latest()#Get the latest 3 added products
  { 
    global $db;
    $query = "SELECT * FROM `tbl_products` ORDER BY `date_posted` DESC LIMIT 3";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function GR_products_by_BRAND($brand)#Get the products by brand
  { 
    global $db;
    $query = "SELECT * FROM `tbl_products` WHERE `product_brand`='$brand'";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }
  ############################################################################################################
  ##                                                                                                        ##
  ##                                   PRODUCT CREATION MANAGEMENT                                          ##
  ##                                                                                                        ##
  ############################################################################################################
  public function IR_product() #Insert product
  {
      global $db;
      if (isset($_POST['btn_add_product'])) {
          require_once('plugins/phpqrcode/qrlib.php');

          $regex = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
          $product_id = 'PRODUCT_' . substr(str_shuffle($regex), 0, 12); # Generate random product ID
          $product_brand = $db->check($_POST['product_brand']);
          $product_name = $db->check($_POST['product_name']);
          $exp_date = $db->check($_POST['exp_date']);
          $product_price = $db->check($_POST['product_price']);
          $product_qty = $db->check($_POST['product_qty']);
          $status = $product_qty == 0 ? 'OUT OF STOCK' : 'IN STOCK';

          $image = $_FILES['image']['name'];
          $path = "assets/img/products/" . basename($_FILES['image']['name']);
          move_uploaded_file($_FILES['image']['tmp_name'], $path);

          if ($image == '') {
              $image = 'default.png';
          }

          $path = 'assets/img/QR/';
          $qr = $path . $product_name . ".png";
          $qr_img = $product_name . ".png";

          // Generate QR code with product id
          QRcode::png($product_id, $qr, 'H', 5, 5);

          // Insert product details into the tbl_products table
          $query = "INSERT INTO `tbl_products` (`id`, `date_posted`, `product_id`, `product_img`, `product_brand`, `product_name`, `exp_date`, `product_price`, `product_qty`, `status`, `qr_code`) 
          VALUES (NULL, CURRENT_TIMESTAMP, '$product_id', '$image', '$product_brand', '$product_name', '$exp_date', '$product_price', '$product_qty', '$status', '$qr_img')";
          $result = mysqli_query($db->connection, $query);

          if ($result) {
            // Insert product details into the in_stock table
            $batch_number = 'BATCH_' . substr(str_shuffle($regex), 0, 8);  // Generate a random batch number
            $in_stock_query = "INSERT INTO `in_stock` (`date_added`, `batch_number`, `product_name`, `quantity`) 
                              VALUES (CURRENT_TIMESTAMP, '$batch_number', '$product_name', '$product_qty')";
            $in_stock_result = mysqli_query($db->connection, $in_stock_query);
            return $in_stock_result;  // Return result of inserting into in_stock table
          } else {
            return false;  // Return false if the product insert failed
          }
      }
  }
  public function UR_product($id) {
    global $db;
  
    if (isset($_POST['btn_update_product'])) {
        $product_brand = $db->check($_POST['product_brand']);
        $product_name = $db->check($_POST['product_name']);
        $exp_date = $db->check($_POST['exp_date']);
        $product_price = $db->check($_POST['product_price']);
        $in_sale = $db->check($_POST['in_sale']);
        $product_qty = $db->check($_POST['product_qty']);
        $filename = $db->check($_POST['filename']); // using the hidden filename field
        $status = '';

        // Get the existing product quantity from the database
        $existing_product_query = "SELECT `product_qty` FROM `tbl_products` WHERE `id` = '$id'";
        $existing_product_result = mysqli_query($db->connection, $existing_product_query);
        $existing_product = mysqli_fetch_assoc($existing_product_result);
        $existing_qty = $existing_product['product_qty'];

        // Calculate the newly added quantity
        $new_qty_added = $product_qty - $existing_qty;

         // Calculate the difference in quantity
         $qty_diff = $existing_qty - $product_qty; 

         // Handle out of stock scenario: Insert into out_stock if quantity decreased
         if ($qty_diff > 0) {
             $out_stock_query = "INSERT INTO `out_stock` (`product_name`, `quantity`, `status`, `date_sold`) 
                                 VALUES ('$product_name', '$qty_diff', 'expired', CURRENT_TIMESTAMP)";
             mysqli_query($db->connection, $out_stock_query);
         }

        // Determine stock status based on quantity
        if ($product_qty == 0) {
            $status = 'OUT OF STOCK';
        } elseif ($product_qty <= 10) {
            $status = 'LOW STOCK';
            
            // Notification for low stock
            $title = "PRODUCT LOW ON STOCKS!";
            $message = "The product " . $product_name . ", has only (" . $product_qty . "pcs.) remaining.
                Please restock soon.";
            $query_notif = "INSERT INTO `tbl_notification`(`id`, `notif_name`, `notif_desc`) VALUES (NULL, '$title', '$message')";
            mysqli_query($db->connection, $query_notif);
        } else {
            $status = 'IN STOCK';
        }

        // Handle image upload (only if a new image is uploaded)
        if ($_FILES['image']['name'] != '') {
            $image = $_FILES['image']['name'];
            $path = "assets/img/products/" . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $path);
        } else {
            // Keep the existing image if no new image is uploaded
            $image = $filename; // filename comes from the hidden input field in the form
        }

        // Prepare the update query, only updating changed fields
        $update_fields = [];
        if ($product_name !== $existing_product['product_name']) {
            $update_fields[] = "`product_name` = '$product_name'";
        }
        if ($product_price !== $existing_product['product_price']) {
            $update_fields[] = "`product_price` = '$product_price'";
        }
        if ($in_sale !== $existing_product['in_sale']) {
            $update_fields[] = "`in_sale` = '$in_sale'";
        }
        if ($product_qty !== $existing_product['product_qty']) {
            $update_fields[] = "`product_qty` = '$product_qty'";
        }
        if ($image !== $existing_product['product_img']) {
            $update_fields[] = "`product_img` = '$image'";
        }
        if ($product_brand !== $existing_product['product_brand']) {
            $update_fields[] = "`product_brand` = '$product_brand'";
        }
        if ($exp_date !== $existing_product['exp_date']) {
            $update_fields[] = "`exp_date` = '$exp_date'";
        }
        if ($status !== $existing_product['status']) {
            $update_fields[] = "`status` = '$status'";
        }

        // Only update if there are fields to update
        if (count($update_fields) > 0) {
            $update_query = "UPDATE `tbl_products` SET " . implode(', ', $update_fields) . " WHERE `id` = '$id'";
            $result = mysqli_query($db->connection, $update_query);

            if ($result) {
                // Insert the newly added quantity into the in_stock table
                if ($new_qty_added > 0) {
                    $batch_number = 'BATCH_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 8);  // Generate a random batch number
                    $in_stock_query = "INSERT INTO `in_stock` (`date_added`, `batch_number`, `product_name`, `quantity`) 
                                       VALUES (CURRENT_TIMESTAMP, '$batch_number', '$product_name', '$new_qty_added')";
                    mysqli_query($db->connection, $in_stock_query);
                }

                return true;  // Return true if the product update was successful
            } else {
                return false;  // Return false if the product update failed
            }
        } else {
            return true;  // Return true if no changes were made
        }
    }
}


  
  ###################################################################################################################
  ##                                                                                                               ##
  ##                                          BRAND CRUD OPEARTION                                                 ##
  ##                                                                                                               ##
  ###################################################################################################################
  public function IR_brand()#Insert brand
  { 
    global $db;
    if (isset($_POST['btn_add_brand'])) {
      $brand = $db->check($_POST['brand']);

      $image = $_FILES['image']['name'];
      $path = "assets/img/brands/" . basename($_FILES['image']['name']);
      move_uploaded_file($_FILES['image']['tmp_name'], $path);

      if ($image == '') {
        $image = 'brand-image.png';
      }

      $query = "INSERT INTO `tbl_brands` (`id`, `brand`, `img_dir`) VALUES (NULL, '$brand', '$image')";
      $result = mysqli_query($db->connection, $query);

      return $result;
    }
  }

  public function UR_brand($id) #Update brand
  {
    global $db;
    if (isset($_POST['btn_update_brand'])) {
      $brand = $db->check($_POST['brand']);
      $filename = $db->check($_POST['filename']);

      $image = $_FILES['image']['name'];
      $path = "assets/img/brands/" . basename($_FILES['image']['name']);
      move_uploaded_file($_FILES['image']['tmp_name'], $path);

      if ($image == '') {
        $image = $filename;
      }

      $query = "UPDATE `tbl_brands` SET `brand`='$brand', `img_dir`='$image' WHERE `id`='$id'";
      $result = mysqli_query($db->connection, $query);

      return $result;
    }
  }

  ######################################## Product management end #######################################################

  ##########################################      Roles          #########################################################
  public function GR_roles()
  { #Get roles
    global $db;
    $query = "SELECT * FROM `tbl_roles`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function IR_role()
  { #Insert role
    global $db;
    if (isset($_POST['btn_add_role'])) {
      $role = $db->check($_POST['role']);

      $query = "INSERT INTO `tbl_roles` (`id`, `role`) VALUES (NULL, '$role')";
      $result = mysqli_query($db->connection, $query);

      return $result;
    }
  }

  public function UR_role($id)
  { #Update role
    global $db;
    if (isset($_POST['btn_update_role'])) {
      $role = $db->check($_POST['role']);

      $query = "UPDATE `tbl_roles` SET `role`='$role' WHERE `id`='$id'";
      $result = mysqli_query($db->connection, $query);

      return $result;
    }
  }

  #####################################################= Admin profile =############################################
  public function UR_admin_profile($id)
  { #Update the admin details
    global $db;
    if (isset($_POST['btn_update_profile'])) {
      $name = $db->check($_POST['name']);
      $username = $db->check($_POST['username']);
      $oldpassword = $db->check($_POST['oldpassword']);
      $newpassword = $db->check($_POST['newpassword']);
      $address = $db->check($_POST['address']);
      $phone = $db->check($_POST['phone']);
      $email = $db->check($_POST['email']);
      $role = $db->check($_POST['role']);
      $status = $db->check($_POST['status']);
      $filename = $db->check($_POST['filename']);

      $image = $_FILES['image']['name'];
      $password = '';

      if ($image == '') { #Check if the image is not new
        $image = $filename;
      } else { #Uploads the new selected image
        $path = "assets/img/avatars/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
      }

      if ($newpassword == '') {
        $password = $oldpassword;
      } else {
        $password = password_hash($newpassword, PASSWORD_DEFAULT);
      }

      $query = "UPDATE `tbl_accounts` SET `name` = '$name', `username` = '$username', `password` = '$password', `address` = '$address', `phone` = '$phone', `email` = '$email', `role` = '$role', `status` = '$status', `img_dir` = '$image' WHERE `id`='$id'";
      $result = mysqli_query($db->connection, $query);

      return $result;
    }
  }

  public function UR_admin_social_link_LINK($platform)
  { #Link social accounts
    global $db;
    if (isset($_POST['btn_link'])) {
      $link = $db->check($_POST['link']);

      if ($platform == 'FACEBOOK') {
        $query = "UPDATE `tbl_accounts` SET `link_facebook`='$link' WHERE `role`='ADMIN'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TWITTER') {
        $query = "UPDATE `tbl_accounts` SET `link_twitter`='$link' WHERE `role`='ADMIN'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'INSTAGRAM') {
        $query = "UPDATE `tbl_accounts` SET `link_instagram`='$link' WHERE `role`='ADMIN'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TIKTOK') {
        $query = "UPDATE `tbl_accounts` SET `link_tiktok`='$link' WHERE `role`='ADMIN'";
        $result = mysqli_query($db->connection, $query);
      }

      return $result;
    }
  }

  public function UR_admin_social_link_UNLINK()
  { #Unlink social accounts
    global $db;
    if (isset($_POST['btn_unlink'])) {
      $platform = $db->check($_POST['platform']);

      if ($platform == 'FACEBOOK') {
        $query = "UPDATE `tbl_accounts` SET `link_facebook`='' WHERE `role`='ADMIN'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TWITTER') {
        $query = "UPDATE `tbl_accounts` SET `link_twitter`='' WHERE `role`='ADMIN'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'INSTAGRAM') {
        $query = "UPDATE `tbl_accounts` SET `link_instagram`='' WHERE `role`='ADMIN'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TIKTOK') {
        $query = "UPDATE `tbl_accounts` SET `link_tiktok`='' WHERE `role`='ADMIN'";
        $result = mysqli_query($db->connection, $query);
      }

      return $result;
    }
  }
  #=########################################################### Admin profile END  ############################################

  #=########################################################### User profiles ##################################################
  public function GR_user_accounts()
  { #Get all info about the system 
    global $db;
    $query = "SELECT * FROM `tbl_accounts`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function UR_user_profile($id)
  { #Update the admin details
    global $db;
    if (isset($_POST['btn_update_profile'])) {
      $name = $db->check($_POST['name']);
      $username = $db->check($_POST['username']);
      $address = $db->check($_POST['address']);
      $phone = $db->check($_POST['phone']);
      $email = $db->check($_POST['email']);
      $role = $db->check($_POST['role']);
      $status = $db->check($_POST['status']);
      $filename = $db->check($_POST['filename']);

      $image = $_FILES['image']['name'];
      $password = '';

      if ($image == '') { #Check if the image is not new
        $image = $filename;
      } else { #Uploads the new selected image
        $path = "assets/img/avatars/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
      }

      $query = "UPDATE `tbl_accounts` SET `name` = '$name', `username` = '$username', `address` = '$address', `phone` = '$phone', `email` = '$email', `role` = '$role', `status` = '$status', `img_dir` = '$image' WHERE `id`='$id'";
      $result = mysqli_query($db->connection, $query);

      return $result;
    }
  }

  public function UR_user_social_link_LINK($platform)
  { #Link social accounts
    global $db;
    if (isset($_POST['btn_link'])) {
      $link = $db->check($_POST['link']);

      if ($platform == 'FACEBOOK') {
        $query = "UPDATE `tbl_accounts` SET `link_facebook`='$link' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TWITTER') {
        $query = "UPDATE `tbl_accounts` SET `link_twitter`='$link' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'INSTAGRAM') {
        $query = "UPDATE `tbl_accounts` SET `link_instagram`='$link' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TIKTOK') {
        $query = "UPDATE `tbl_accounts` SET `link_tiktok`='$link' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      }

      return $result;
    }
  }

  public function UR_user_social_link_UNLINK()
  { #Unlink social accounts
    global $db;
    if (isset($_POST['btn_unlink'])) {
      $platform = $db->check($_POST['platform']);

      if ($platform == 'FACEBOOK') {
        $query = "UPDATE `tbl_accounts` SET `link_facebook`='' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TWITTER') {
        $query = "UPDATE `tbl_accounts` SET `link_twitter`='' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'INSTAGRAM') {
        $query = "UPDATE `tbl_accounts` SET `link_instagram`='' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TIKTOK') {
        $query = "UPDATE `tbl_accounts` SET `link_tiktok`='' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      }

      return $result;
    }
  }
  #= #####################################################  User profiles END ###################################################

  #= #####################################################  System settings  #####################################################
  public function GR_system_info()
  { #Get all info about the system
    global $db;
    $query = "SELECT * FROM `tbl_system_info`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function UR_settings()
  { #Update the system details
    global $db;
    if (isset($_POST['btn_update_settings'])) {
      $system_title = $db->check($_POST['system_title']);
      $system_description = $db->check($_POST['system_description']);
      $address = $db->check($_POST['address']);
      $phone = $db->check($_POST['phone']);
      $email = $db->check($_POST['email']);
      $filename_logo = $db->check($_POST['filename_logo']);
      $filename_icon = $db->check($_POST['filename_icon']);

      $logo = $_FILES['logo']['name'];
      $icon = $_FILES['icon']['name'];

      if ($logo == '') { #Check if the image is not new
        $logo = $filename_logo;
      } else { #Uploads the new selected image
        $path = "assets/img/system/" . basename($_FILES['logo']['name']);
        move_uploaded_file($_FILES['logo']['tmp_name'], $path);
      }

      if ($icon == '') { #Check if the image is not new
        $icon = $filename_icon;
      } else { #Uploads the new selected image
        $path = "assets/img/system/" . basename($_FILES['icon']['name']);
        move_uploaded_file($_FILES['icon']['tmp_name'], $path);
      }

      $query = "UPDATE `tbl_system_info` SET `system_title`='$system_title', `system_description`='$system_description',`address`='$address', `phone`='$phone', `email`='$email', `system_icon`='$icon', `system_logo`='$logo'";
      $result = mysqli_query($db->connection, $query);

      return $result;
    }
  }

  public function UR_system_social_link_LINK($platform)
  { #Link social accounts
    global $db;
    if (isset($_POST['btn_link'])) {
      $link = $db->check($_POST['link']);

      if ($platform == 'FACEBOOK') {
        $query = "UPDATE `tbl_system_info` SET `link_facebook`='$link' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TWITTER') {
        $query = "UPDATE `tbl_system_info` SET `link_twitter`='$link' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'INSTAGRAM') {
        $query = "UPDATE `tbl_system_info` SET `link_instagram`='$link' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TIKTOK') {
        $query = "UPDATE `tbl_system_info` SET `link_tiktok`='$link' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      }

      return $result;
    }
  }

  public function UR_system_social_link_UNLINK()
  { #Unlink social accounts
    global $db;
    if (isset($_POST['btn_unlink'])) {
      $platform = $db->check($_POST['platform']);

      if ($platform == 'FACEBOOK') {
        $query = "UPDATE `tbl_system_info` SET `link_facebook`='' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TWITTER') {
        $query = "UPDATE `tbl_system_info` SET `link_twitter`='' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'INSTAGRAM') {
        $query = "UPDATE `tbl_system_info` SET `link_instagram`='' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      } else if ($platform == 'TIKTOK') {
        $query = "UPDATE `tbl_system_info` SET `link_tiktok`='' WHERE `id`='1'";
        $result = mysqli_query($db->connection, $query);
      }

      return $result;
    }
  }
  #= ##########################################################  System settings END  #############################################

  public function GR_sales()
  { #Get all records and count them from all tbl sales
    global $db;
    $query = "SELECT `total` FROM `tbl_sales`";
    $result = mysqli_query($db->connection, $query);
    $order_sale = 0;
    while ($row_s = mysqli_fetch_assoc($result)) {
      $order_sale = $order_sale + $row_s['total'];
    }

    return $order_sale;
  }

  public function GR_print_sales() {
    global $db;
    $query = "SELECT `date_purchased`, `transaction_id`, `customer`, `total`, `status` FROM `tbl_sales`";
    $result = mysqli_query($db->connection, $query);
    $sales = [];

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch each sale record as an associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $sales[] = $row;
        }
    }

    return $sales; // Return an array of sales records
}


  #= ##############################################################  Charts ###################################################
  public function GR_date()
  { #Get all dates from the table and display on the chart
    global $db;
    $query = "SELECT `date_processed` FROM `tbl_transaction_ref` WHERE `status`='PAID'";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function GR_quantity()
  { #Get all the quantity from table and display on the chart
    global $db;
    $query = "SELECT `quantity` FROM `tbl_transaction_ref` WHERE `status`='PAID'";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }
  #= ################################################################### Charts end ############################################

  #= Database import/export
  public function IR_database()
  { #Import database
    global $db;
    if (isset($_POST['btn_upload'])) {
      $database_file = $_FILES['database']['tmp_name'];
      $database_type = $_FILES['database']['type'];

      if ($database_type == 'application/octet-stream') {
        $handle = fopen($database_file, "r+");
        $contents = fread($handle, filesize($database_file));

        $sql = explode(';', $contents);
        foreach ($sql as $query) {
          $result = mysqli_query($db->connection, $query);
          //    if($result) {
          //      echo '<tr><td><br></td></tr>';
          //      echo '<tr><td>'.$query.'<b>SUCCESS</b></td></tr>';
          //      echo '<tr><td><br></td></tr>';
          //    }
        }
        fclose($handle);
        return true;
      } else {
        return false;
      }
    }
  }
  #= Database import/export

  #=################################# Dashboard #######################################################################################################
  public function GR_sales_YEAR()
  {
    global $db;
    $query = "SELECT `year` FROM `tbl_sales_chart`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

 
  #=################################# Dashboard END ######################################################################################################

  public function GR_employee_ctr()
  { #Get all employee count
    global $db;
    $query = "SELECT * FROM `tbl_accounts` WHERE `role`='CASHIER'";
    $result = mysqli_query($db->connection, $query);
    $customer_ctr = mysqli_num_rows($result);

    return $customer_ctr;
  }

  public function GR_product_ctr()
  { #Get all user count
    global $db;
    $query = "SELECT * FROM `tbl_products`";
    $result = mysqli_query($db->connection, $query);
    $product_ctr = mysqli_num_rows($result);

    return $product_ctr;
  }

  #= ##########################################################  Notifications  #############################################################################
  public function GR_notifications()
  { #Get all records for notifications
    global $db;
    $query = "SELECT * FROM `tbl_notification`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function GR_notif_ctr()
  { #Get all notification count
    global $db;
    $query = "SELECT * FROM `tbl_notification`";
    $result = mysqli_query($db->connection, $query);
    $notif_ctr = mysqli_num_rows($result);

    return $notif_ctr;
  }

  public function DR_notif_all()
  { #Remove all notifications
    global $db;
    $query = "DELETE FROM `tbl_notification`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }
  #=############################################################## Notifications END  #####################################################################33

  ####################################################################  Cart  ###############################################################################
  public function GR_cart_info()
  {
      global $db;
      // Update the query to join tbl_cart and tbl_products
      $query = "
          SELECT 
              cart.id,
              cart.product_name AS cart_product_name,
              cart.product_brand AS cart_product_brand,
              cart.product_price AS cart_product_price,
              cart.subtotal,
              cart.product_qty,
              products.product_price AS original_price,
              products.in_sale AS sale_price,
              products.product_name AS product_name,
              products.product_brand AS product_brand
          FROM 
              tbl_cart AS cart
          JOIN 
              tbl_products AS products 
          ON 
              cart.product_id = products.product_id;
      ";
      $result = mysqli_query($db->connection, $query);
  
      return $result;
  }
  

  public function GR_cart_ctr()
  { #Get cart count
    global $db;
    $id = $_SESSION['user_AUTH'];
    $query = "SELECT * FROM `tbl_cart` WHERE `user_id`='$id'";
    $result = mysqli_query($db->connection, $query);
    $count = mysqli_num_rows($result);

    return $count;
  }

  public function GR_cart_total()
  { #Get cart total
    global $db;
    $id = $_SESSION['user_AUTH'];
    $query = "SELECT SUM(`sub_total`) AS total FROM `tbl_cart` WHERE `user_id`='$id'";
    $result = mysqli_query($db->connection, $query);
    $row = mysqli_fetch_array($result);
    $total = $row['total'];

    return $total;
  }
  # ############################################################  Cart END ####################################################################################

  public function GR_product_img($product)
  { #Get a certain product image
    global $db;
    $query = "SELECT `product_img` FROM `tbl_products` WHERE `product_name`='$product'";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function GR_transaction_ref_FOR_RECEIPT($transaction_id)
  { #Get all cart records
    global $db;
    $query = "SELECT * FROM `tbl_cart`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  public function GR_transaction_ref() #Get all transactions records
  {
    global $db;
    $query = "SELECT * FROM `tbl_transaction_ref`";
    $result = mysqli_query($db->connection, $query);

    return $result;
  }

  #================================================================= Authentication login ========================================================================#
  public function GR_accounts()
  { #Get particular record for logging in and verify user input
    global $db;
    if (isset($_POST['btn-login'])) {
      $username = $db->check($_POST['username']);
      $password = $db->check($_POST['password']);

      $query = "SELECT * FROM `tbl_accounts` WHERE `status`='ACTIVE'";
      $result = mysqli_query($db->connection, $query);

      while ($row = mysqli_fetch_array($result)) {
        $verify = password_verify($password, $row['password']);
        if ($username == $row['username'] && $verify == 1) {
          $_SESSION['user_AUTH'] = $row['id'];
          $_SESSION['role'] = $row['role'];
          $role = $row['role'];
          header("location: controller.php?action=loginToPage&user=USER&role=$role");
        }
      }

      if ($_SESSION['user_AUTH'] == '') {
        header("location: controller.php?action=loginToPage&user=none");
      }
    }
  }
  #====================================================================================== Authentication login END ===================================================#

  #======================================================================================= Account info ==============================================================#
  public function GR_account_info()
  { #Get all info for the current user
    global $db;
    if (isset($_SESSION['user_AUTH'])) {
      $id = $_SESSION['user_AUTH'];
      $query = "SELECT * FROM `tbl_accounts` WHERE `id`='$id'";
      $result = mysqli_query($db->connection, $query);
    }

    return $result;
  }
  #======================================================================================= Account info END =========================================================#

  public function GR_accounts_FOR_PASSWORD()
  { #Get particular record for changing password
    global $db;
    if (isset($_POST['btn_send_link'])) {
      $email = $db->check($_POST['email']);

      $query = "SELECT * FROM `tbl_accounts` WHERE `email`='$email'";
      $result = mysqli_query($db->connection, $query);

      return $result;
    }
  }

  public function set_messsage($msg)
  { #Set Session Message
    if (!empty($msg)) {
      $_SESSION['MSG'] = $msg;
    } else {
      $msg = "";
    }
  }


  ########################################################################################################################################################################
  ##                                                                                                                                                                    ##
  ##                                                   DISPLAY MESSAGES                                                                                                 ##
  ########################################################################################################################################################################
  public function display_message()
  { #Display Session Message
    if (isset($_SESSION['MSG'])) {
      if ($_SESSION['MSG'] == "add_user_success") {
        echo "<script>toastr.success('Account created successfully!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "add_user_fail") {
        echo "<script>toastr.error('Failed to create account!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "login_success") {
        echo "<script>toastr.success('Welcome back!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "login_fail") {
        echo "<script>toastr.error('Login failed! Incorrect username or password.', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_admin_profile_success") {
        echo "<script>toastr.info('Profile updated!', 'INFO');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_admin_profile_fail") {
        echo "<script>toastr.error('Failed to update profile!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_admin_account_success") {
        echo "<script>toastr.info('Account updated!', 'INFO');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_admin_account_fail") {
        echo "<script>toastr.error('Updating account failed!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_settings_success") {
        echo "<script>toastr.info('System settings updated!', 'INFO');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_settings_fail") {
        echo "<script>toastr.error('Can't update system settings!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_profile_success") {
        echo "<script>toastr.info('Profile updated!', 'INFO');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_profile_fail") {
        echo "<script>toastr.error('Failed to update profile!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "add_rating_and_review_success") { #rating
        echo "<script>toastr.success('Rating and review posted!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "add_rating_and_review_fail") {
        echo "<script>toastr.error('Failed to post review!');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_rating_and_review_success") {
        echo "<script>toastr.info('Post updated!');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_rating_and_review_fail") {
        echo "<script>toastr.error('Failed to update post!');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "delete_rating_and_review_success") {
        echo "<script>toastr.success('Post deleted successfully!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "delete_rating_and_review_fail") { #rating
        echo "<script>toastr.error('Failed to delete post!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "select_email_success") {
        echo "<script>toastr.info('Email found. An OTP code has been sent successfully!', 'INFO');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "select_email_fail") {
        echo "<script>toastr.error('Your email address does not appear in our database!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_password_success") {
        echo "<script>toastr.success('Password has been changed successfully!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_password_fail") {
        echo "<script>toastr.error('Password change failed!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "add_product_success") { #PRODUCTS
        echo "<script>toastr.success('Product successfully added!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "add_product_fail") {
        echo "<script>toastr.error('Failed to add product!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_product_success") {
        echo "<script>toastr.info('Product updated!', 'INFO');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_product_fail") {
        echo "<script>toastr.error('Failed to update product!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "add_brand_success") { #BRANDS
        echo "<script>toastr.success('Brand added to category!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "add_brand_fail") {
        echo "<script>toastr.error('Failed to add brand!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_brand_success") {
        echo "<script>toastr.info('Brand updated!', 'INFO');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_brand_fail") {
        echo "<script>toastr.error('Failed to update brand!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "add_role_success") { #ROLES
        echo "<script>toastr.success('Role added!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "add_role_fail") {
        echo "<script>toastr.error('Failed to add role!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_role_success") {
        echo "<script>toastr.info('Role updated!', 'INFO');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "update_role_fail") {
        echo "<script>toastr.error('Failed to update role!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "clear_success") {
        echo "<script>toastr.success('Notifications cleared!');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "clear_fail") {
        echo "<script>toastr.error('Failed to clear notifications!');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "import_database_success") {
        echo "<script>toastr.success('File upload success, data restored!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "import_database_fail") {
        echo "<script>toastr.error('Failed uploading database to server!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "link_success") {
        echo "<script>toastr.success('Account linked successfully!', 'SUCCESS');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "link_fail") {
        echo "<script>toastr.error('Can't link account!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "unlink_success") {
        echo "<script>toastr.info('Account unlinked!', 'INFO');</script>";
        unset($_SESSION['MSG']);
      } else if ($_SESSION['MSG'] == "unlink_fail") {
        echo "<script>toastr.error('Can't unlink account!', 'ERROR');</script>";
        unset($_SESSION['MSG']);
      }
    }
  }
}
################################################################################# END ###################################################################################################################################
