<?php
#####################################################################################################################################################################
##                                                                                                                                                                 ##
##                  WARNING !!!!!!!!!!!                                                                                                                            ##
##                  DO NOT DELETE THIS PAGE & MODIFY OR WRITE ANAYTHING UNLESS YOU UNDERSTAND                                                                      ##
##                  DELETING OR EDITING THE SYNTAX WILL CAUSE  SERVER ERRORS WITHOUT CONSULTING THE DEVELOPER                                                      ##
##                  THIS PAGE CONTAINS SERVER SIDE SCRIPT OF THE SYSTEM THAT COMMUNICATE THE VIA AJAX REQUEST                                                      ##
##################################################################################################################################################################### 
#connection
$conn = mysqli_connect('localhost', 'root', '', 'inventory_db');

#check if action is coreect
if (isset($_POST['action'])) {
  #insert product to cart
  if ($_POST['action'] == 'IR_cart') {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    #search if the product id is "in stock"
    $query_search = "SELECT * FROM `tbl_products` WHERE `product_id`='$product_id' AND `status`='IN STOCK'";
    $result_search = mysqli_query($conn, $query_search);
    $row = mysqli_fetch_array($result_search);
    #if product is "in stock", insert the following data
    $product_img = $row['product_img'];
    $qr_code = $row['qr_code'];
    $product_id = $row['product_id'];
    $product_name = $row['product_name'];
    $product_brand = $row['product_brand'];
    $product_price = $row['product_price'];
    $product_qty = $row['product_qty'];
    #query to insert product data to cart table
    $query = "INSERT INTO `tbl_cart` (`id`, `qr_code`, `product_img`, `product_id`, `product_name`, `product_brand`, `product_price`, `subtotal`, `product_qty`) VALUES (NULL, '$qr_code', '$product_img', '$product_id', '$product_name', '$product_brand', '$product_price', '$product_price', 1)";
    $result = mysqli_query($conn, $query);
    #cobdition if the insert query is true
    if ($result) {
      echo $return = $product_qty; #output the prodfuct quantity
    } else {
      echo $return = 'Product is out of stock!'; #if not throw this message
    }
  }

  #= DELETION PROCESS START HERE
  
  if ($_POST['action'] == 'DR_tbl_accounts') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "DELETE FROM `tbl_accounts` WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
      echo $return = 'Account deleted successfully!';
    } else {
      echo $return = 'Failed to delete account!';
    }
  }

  if ($_POST['action'] == 'DR_cart') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "DELETE FROM `tbl_cart` WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
      echo $return = 'Removed from cart!';
    } else {
      echo $return = 'Failed to delete item!';
    }
  }

  if ($_POST['action'] == 'DR_tbl_roles') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "DELETE FROM `tbl_roles` WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
      echo $return = 'Role deleted!';
    } else {
      echo $return = 'Failed to delete role!';
    }
  }

  if ($_POST['action'] == 'DR_brand') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "DELETE FROM `tbl_brands` WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
      echo $return = 'Brand deleted!';
    } else {
      echo $return = 'Failed to delete brand!';
    }
  }

  #delete the products based on ID
  if ($_POST['action'] == 'DR_product') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "DELETE FROM `tbl_products` WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
      echo $return = 'Product deleted!';
    } else {
      echo $return = 'Failed to delete product!';
    }
  }

  #=DELETION PROCESSS END

  #insert record to table sales
  if ($_POST['action'] == 'IR_tbl_sales') {
    $customer = mysqli_real_escape_string($conn, $_POST['customer']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $regex = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; #generate random string as transaction ID
    $transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id']);
    $status = "COMPLETED";
    $total_s = 0;
    #insert record to tbale transaction
    $query = "INSERT INTO `tbl_transaction_ref` (`id`, `date_purchased`, `transaction_id`, `qr_code`, `product_img`, `product_id`, `product_name`, `product_brand`, `product_price`, `subtotal`, `product_qty`, `customer`, `status`) SELECT NULL, '$date', '$transaction_id', `qr_code`, `product_img`, `product_id`, `product_name`, `product_brand`, `product_price`, `subtotal`, `product_qty`, '$customer', '$status' FROM `tbl_cart`";
    $result = mysqli_query($conn, $query);
    #query the transaction ID
    $query_transaction = "SELECT * FROM `tbl_transaction_ref` WHERE `transaction_id`='$transaction_id'";
    $result_transaction = mysqli_query($conn, $query_transaction);
    #condition if table rows is less than zero
    if (mysqli_num_rows($result_transaction) > 0) {
      #use while loop and do the computation product * quantity = total
      while ($row = mysqli_fetch_array($result_transaction)) {
        $product_id = $row['product_id'];
        $qty = $row['product_qty'];
        $total_s = $total_s + $row['subtotal'];
        #query the product name and quantity from table products based on product ID
        $query_qty = "SELECT `product_name`, `product_qty` FROM `tbl_products` WHERE `product_id`='$product_id'";
        $result_qty = mysqli_query($conn, $query_qty);
        $db_row = mysqli_fetch_array($result_qty);#fetch the result
        $db_qty = $db_row['product_qty'];
        $new_product_qty = $db_qty - $qty;#subract the quantity from database
        #condition if quantity is less than or equal 11
        if ($db_row['product_qty'] <= 11) {
          $title = "PRODUCT LOW ON STOCKS!"; #set the title
          $message = "The product " . $db_row['product_name'] . ", has only (" . $new_product_qty . "pcs.) remaining,
          Please restock soon."; #set this message
          #insert the ttle and message to notif table
          $query_notif = "INSERT INTO `tbl_notification`(`id`, `notif_name`, `notif_desc`) VALUES (NULL, '$title', '$message')";
          $result_notif = mysqli_query($conn, $query_notif);
        }
        #after update the table products with the new quantity based on product ID
        $query4 = "UPDATE `tbl_products` SET `product_qty`='$new_product_qty' WHERE `product_id`='$product_id'";
        $result4 = mysqli_query($conn, $query4);
      }
    }
    #after the nested condition done , update the status"OUT OF STOCK" WHERE product_qty = " 0 "
    $query_product_status = "UPDATE `tbl_products` SET `status`='OUT OF STOCK' WHERE `product_qty`='0'";
    $result_product_status = mysqli_query($conn, $query_product_status);
    #then now insert the record to sales table
    $query_sale = "INSERT INTO `tbl_sales` (`id`, `date_purchased`, `transaction_id`, `customer`, `total`, `status`) VALUES (NULL, '$date', '$transaction_id', '$customer', '$total_s', '$status');";
    $result_sale = mysqli_query($conn, $query_sale);
    #then delete records from the cart
    $query_DEL = "DELETE FROM `tbl_cart`";
    $result_DEL = mysqli_query($conn, $query_DEL);
    #condtion befor end of process
    if ($result_sale) {
      echo $return = "$transaction_id has completed successfully!"; #throw this message if transaction is done
    } else {
      echo $return = 'An error has occured during the transaction!'; #throw this is something happened
    }
  }

  #=UPDATE RECORDS HERE

  if ($_POST['action'] == 'UR_tbl_accounts_STATUS') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $query = "UPDATE `tbl_accounts` SET `status`='$status' WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
      echo $return = 'Account is now ' . $status . '!';
    } else {
      echo $return = 'Failed to deactivate account!';
    }
  }

  if ($_POST['action'] == 'UR_tbl_system_info') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $isWho = mysqli_real_escape_string($conn, $_POST['isWho']);

    $result = '';

    if ($isWho == 'FACEBOOK') {
      $query = "UPDATE `tbl_system_info` SET `link_facebook`='$link' WHERE `id`='$id'";
      $result = mysqli_query($conn, $query);
    } else if ($isWho == 'TWITTER') {
      $query = "UPDATE `tbl_system_info` SET `link_twitter`='$link' WHERE `id`='$id'";
      $result = mysqli_query($conn, $query);
    } else if ($isWho == 'INSTAGRAM') {
      $query = "UPDATE `tbl_system_info` SET `link_instagram`='$link' WHERE `id`='$id'";
      $result = mysqli_query($conn, $query);
    }

    if ($result) {
      echo $return = 'Account linked successfully!';
    } else {
      echo $return = 'Failed to link account!';
    }
  }
  #update table cart for quantity condition
  if ($_POST['action'] == 'UR_tbl_cart_FOR_QUANTITY') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $subtotal = $price * $quantity;

    $query = "UPDATE `tbl_cart` SET `product_qty`='$quantity', `subtotal`='$subtotal' WHERE `id`='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      echo $return = 'Success!';
    } else {
      echo $return = 'Failed!';
    }
  }
  #=UPDATE RECORDS END
} #end of transaction post

#check if action is correct
if (isset($_GET['action'])) {
  #get record from table brands
  if ($_GET['action'] == 'GR_tbl_brands') {
    $query = "SELECT * FROM `tbl_brands`";
    $result = mysqli_query($conn, $query);
    $array = [];
    if (mysqli_num_rows($result) > 0) {
      foreach ($result as $row) {
        array_push($array, $row);
      }
    }
    echo json_encode($array);
  }

  
  #dashboard contents start
  if ($_GET['action'] == 'Count_tbl_brands') {
    #Query to count the total number of brands
    $query = "SELECT COUNT(*) AS total_brands FROM `tbl_brands`";
    $result = mysqli_query($conn, $query);

    #Fetch the count from the result
    $data = mysqli_fetch_assoc($result);
    $totalBrands = $data['total_brands'];

    #Return the result as JSON
    echo json_encode(['total_brands' => $totalBrands]);
  }

  #count the total number of products
  if ($_GET['action'] == 'Count_tbl_products') {
    $query = "SELECT COUNT(*) AS total_products FROM `tbl_products`";
    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_assoc($result);
    $totalProducts = $data['total_products'];

    echo json_encode(['total_products' => $totalProducts]);
  }

  if ($_GET['action'] == 'Count_total_sales') {
    # Query to calculate the total sales
    $query = "SELECT SUM(total) AS total_sales FROM `tbl_sales`";
    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_assoc($result);
    $totalSales = $data['total_sales'];

    echo json_encode(['total_sales' => $totalSales]);
  }

  if ($_GET['action'] == 'Count_total_sold') {
    #Query to calculate the total sold
    $query = "SELECT SUM(product_qty) AS total_sold FROM `tbl_transaction_ref`";
    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_assoc($result);
    $totalSold = $data['total_sold'];

    echo json_encode(['total_sold' => $totalSold]);
  }
  #dashboard contents end

  #= GET RECORD FROM TABLES 
  if ($_GET['action'] == 'GR_tbl_roles') {
    $query = "SELECT * FROM `tbl_roles`";
    $result = mysqli_query($conn, $query);
    $array = [];
    if (mysqli_num_rows($result) > 0) {
      foreach ($result as $row) {
        array_push($array, $row);
      }
    }
    echo json_encode($array);
  }

  #get all the records from table products
  if ($_GET['action'] == 'GR_tbl_products') {
    $query = "SELECT * FROM `tbl_products`";
    $result = mysqli_query($conn, $query);
    $array = [];
    if (mysqli_num_rows($result) > 0) {
      foreach ($result as $row) {
        array_push($array, $row);
      }
    }
    echo json_encode($array);
  }

  #Fetch product quantities for real-time update
  if($_GET['action'] == 'GR_tbl_product_quantities') {
    #Prepare the query to fetch product ID and quantity
    $query ="SELECT id , product_qty FROM `tbl_products`";
    $result = $conn->query($query);

    #Initialize an array to store the data
    $productQuantities = array();

    #check if the query was successfull
    if ($result->num_rows > 0) {
      #we will use while loop to get the results and add them to the array
      while ($row = $result->fetch_assoc()) {
        $productQuantities[] = $row;
      }
    }
    #return data as JSON array
    echo json_encode($productQuantities);
  }


  if ($_GET['action'] == 'GR_tbl_cart') {
    $query = "SELECT * FROM `tbl_cart`";
    $result = mysqli_query($conn, $query);
    $array = [];
    if (mysqli_num_rows($result) > 0) {
      foreach ($result as $row) {
        array_push($array, $row);
      }
    }
    echo json_encode($array);
  }

  if ($_GET['action'] == 'GR_tbl_accounts') {
    $role = mysqli_real_escape_string($conn, $_GET['role']);

    $query = "SELECT * FROM `tbl_accounts` WHERE `role`='$role'";
    $result = mysqli_query($conn, $query);
    $array = [];
    if (mysqli_num_rows($result) > 0) {
      foreach ($result as $row) {
        array_push($array, $row);
      }
    }
    echo json_encode($array);
  }
  #select all cart data
  if ($_GET['action'] == 'GR_cart_ctr') {
    $query = "SELECT * FROM `tbl_cart`";
    $result = mysqli_query($conn, $query);
    $ctr = mysqli_num_rows($result);
    echo json_encode($ctr);
  }


  #sales.js response script
  if ($_GET['action'] == 'GR_tbl_sales') {
    $query = "SELECT * FROM `tbl_sales`";
    $result = mysqli_query($conn, $query);
    $array = [];
    if (mysqli_num_rows($result) > 0) {
      foreach ($result as $row) {
        array_push($array, $row);
      }
    }
    echo json_encode($array);
  }

  if ($_GET['action'] == 'GR_tbl_sales_range') {
    $from = mysqli_real_escape_string($conn, $_GET['from']);
    $to = mysqli_real_escape_string($conn, $_GET['to']);

    $query = "SELECT * FROM `tbl_sales` WHERE `date_purchased`>'$from' AND `date_purchased`<'$to'";
    $result = mysqli_query($conn, $query);
    $array = [];
    if (mysqli_num_rows($result) > 0) {
      foreach ($result as $row) {
        array_push($array, $row);
      }
    }
    echo json_encode($array);
  }

  if ($_GET['action'] == 'GR_tbl_transaction_ref') {
    $transaction_id = mysqli_real_escape_string($conn, $_GET['transaction_id']);

    $query = "SELECT * FROM `tbl_transaction_ref` WHERE `transaction_id`='$transaction_id'";
    $result = mysqli_query($conn, $query);
    $array = [];
    if (mysqli_num_rows($result) > 0) {
      foreach ($result as $row) {
        array_push($array, $row);
      }
    }
    echo json_encode($array);
  }
  #= GET RECORDS END

}#end of checking action 2
