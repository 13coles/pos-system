<?php
include './config/conn.php';
// SQL query to fetch stock-in data
$sql = "SELECT date_added, batch_number, product_name, quantity FROM in_stock ORDER BY date_added DESC";

// Execute the query
$result = $conn->query($sql);

// Prepare an array to store the data
$data = [];

if ($result->num_rows > 0) {
    // Fetch the data and add it to the array
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'date_added' => date('M d, Y', strtotime($row['date_added'])),
            'batch_number' => $row['batch_number'],
            'product_name' => $row['product_name'],
            'quantity' => $row['quantity']
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
