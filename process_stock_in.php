<?php
session_start();  

include './config/conn.php';  


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $product_id = $conn->real_escape_string($_POST['product_id']);
    $product_qty = $conn->real_escape_string($_POST['quantity']);
    $status = '';

    $existing_product_query = "SELECT `product_name`, `product_qty`, `status` FROM `tbl_products` WHERE `product_id` = '$product_id'";
    $existing_product_result = $conn->query($existing_product_query);

    if ($existing_product_result->num_rows > 0) {
        $existing_product = $existing_product_result->fetch_assoc();
        $existing_qty = $existing_product['product_qty'];
        $product_name = $existing_product['product_name'];

        $new_qty_added = $product_qty + $existing_qty;

  
        if ($new_qty_added == 0) {
            $status = 'OUT OF STOCK';
        } elseif ($new_qty_added <= 10) {
            $status = 'LOW STOCK';

          
            $title = "PRODUCT LOW ON STOCKS!";
            $message = "The product {$product_name}, has only ({$new_qty_added} pcs) remaining. Please restock soon.";
            $query_notif = "INSERT INTO `tbl_notification`(`notif_name`, `notif_desc`) VALUES ('$title', '$message')";
            $conn->query($query_notif);
        } else {
            $status = 'IN STOCK';
        }

        
        $update_query = "UPDATE `tbl_products` SET `product_qty` = '$new_qty_added', `status` = '$status' WHERE `product_id` = '$product_id'";

        if ($conn->query($update_query)) {
          
            if ($product_qty > 0) {
                $batch_number = 'BATCH_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 8);  // Generate a random batch number
                $in_stock_query = "INSERT INTO `in_stock` (`date_added`, `batch_number`, `product_id`, `product_name`, `quantity`) 
                                   VALUES (CURRENT_TIMESTAMP, '$batch_number', '$product_id', '$product_name', '$product_qty')";
                if ($conn->query($in_stock_query)) {
                  
                    $_SESSION['success'] = "Product stock updated and logged successfully!";
                    header("Location: stock-in.php");
                    exit();
                } else {
                  
                    $_SESSION['error'] = "Failed to log the stock update.";
                    header("Location: stock-in.php");
                    exit();
                }
            } else {
               
                $_SESSION['success'] = "Product stock updated successfully!";
                header("Location: stock-in.php");
                exit();
            }
        } else {
           
            $_SESSION['error'] = "Failed to update the product stock.";
            header("Location: stock-in.php");
            exit();
        }
    } else {
       
        $_SESSION['error'] = "Product not found.";
        header("Location: stock-in.php");
        exit();
    }
}
?>
