<?php
include './config/conn.php';

/// Query to fetch product data
$sql = "SELECT product_name, product_qty FROM tbl_products";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = array(
            'product_name' => $row['product_name'],
            'product_qty' => (int)$row['product_qty'] // Ensure quantity is an integer
        );
    }
} else {
    $data = array(); // Return an empty array if no results
}

$conn->close();

// Return JSON response
echo json_encode($data);
?>
