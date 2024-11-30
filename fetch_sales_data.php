<?php
include './config/conn.php';

// Get the selected filter from the AJAX request
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'day'; // Default 
$data = [];
// Modify the query based on the selected filter
switch ($filter) {
    case 'day':
        $query = "
            SELECT 
                product_name,
                SUM(product_qty) AS total_sales
            FROM 
                tbl_transaction_ref
            WHERE 
                DATE(date_purchased) = CURDATE()  -- Today's date
            GROUP BY 
                product_name
            ORDER BY 
                total_sales DESC;
        ";
        break;

    case 'week':
        $query = "
            SELECT 
                product_name,
                SUM(product_qty) AS total_sales
            FROM 
                tbl_transaction_ref
            WHERE 
                YEARWEEK(date_purchased, 1) = YEARWEEK(CURDATE(), 1)  -- Current week
            GROUP BY 
                product_name
            ORDER BY 
                total_sales DESC;
        ";
        break;

    case 'month':
        $query = "
            SELECT 
                product_name,
                SUM(product_qty) AS total_sales
            FROM 
                tbl_transaction_ref
            WHERE 
                YEAR(date_purchased) = YEAR(CURDATE()) AND MONTH(date_purchased) = MONTH(CURDATE())  -- Current month
            GROUP BY 
                product_name
            ORDER BY 
                total_sales DESC;
        ";
        break;

    case 'year':
    default:
        $query = "
            SELECT 
                product_name,
                SUM(product_qty) AS total_sales
            FROM 
                tbl_transaction_ref
            WHERE 
                YEAR(date_purchased) = YEAR(CURDATE())  -- Current year
            GROUP BY 
                product_name
            ORDER BY 
                total_sales DESC;
        ";
        break;
}

$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'product_name' => $row['product_name'],
        'total_sales' => $row['total_sales']
    ];
}

echo json_encode($data);

?>
