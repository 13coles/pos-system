<?php
include './config/conn.php';

// SQL query to fetch stock-out data, including the status
$sql = "SELECT date_sold, product_name, quantity, status FROM out_stock ORDER BY date_sold DESC";

// Execute the query
$result = $conn->query($sql);

// Prepare an array to store the data
$data = [];

if ($result->num_rows > 0) {
    // Fetch the data and add it to the array
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'date_sold' => date('M d, Y', strtotime($row['date_sold'])),
            'product_name' => $row['product_name'],
            'quantity' => $row['quantity'],
            'status' => $row['status'] // Include the status in the response
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
