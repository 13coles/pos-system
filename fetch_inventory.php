<?php
include './config/conn.php';

// Get the selected month from the request (if any)
$month = isset($_GET['month']) ? $_GET['month'] : '';

// SQL query with month filtering
$sql = "
    SELECT 
        COALESCE(in_stock.product_name, out_stock.product_name) AS product_name,
        COALESCE(in_stock.total_quantity, 0) AS total_quantity,
        COALESCE(out_stock.total_quantity, 0) AS sold_qty,
        COALESCE(in_stock.total_quantity, 0) - COALESCE(out_stock.total_quantity, 0) AS available_qty
    FROM 
        (SELECT product_name, SUM(quantity) AS total_quantity
         FROM in_stock
         WHERE MONTHNAME(date_added) LIKE ?
         GROUP BY product_name) AS in_stock
    LEFT JOIN 
        (SELECT product_name, SUM(quantity) AS total_quantity
         FROM out_stock
         WHERE MONTHNAME(date_sold) LIKE ?
         GROUP BY product_name) AS out_stock
    ON in_stock.product_name = out_stock.product_name;
";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameter to the SQL query (filter by the selected month)
$month_param = '%' . $month . '%';
$stmt->bind_param('ss', $month_param, $month_param);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Prepare an array to store the data
$data = [];

if ($result->num_rows > 0) {
    // Fetch the data and add it to the array
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'product_name' => $row['product_name'],
            'total_quantity' => $row['total_quantity'],
            'sold_qty' => $row['sold_qty'],
            'available_qty' => $row['available_qty']
        ];
    }
} else {
    $data = []; // No data found
}

// Set the header for JSON response
header('Content-Type: application/json');

// Return the data as a JSON response
echo json_encode($data);

// Close the connection
$conn->close();
?>