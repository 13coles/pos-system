<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$path = realpath('print-inventory.php');
$page = basename($path, '.php');

$result_account_info = $db->GR_account_info();
$admin_info = mysqli_fetch_assoc($result_account_info);

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);

$notification_ctr = $db->GR_notif_ctr();

?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<?php
include_once('util/head.php');
$get->toastr_css_new();
$get->dt_css();
?>
<body>
<div class="wrapper">
    <div class="heading">
    <?php include('util/header-print.php'); ?>
    </div>
    <h4 class="text-center">Stock Out Report</h4>
    <hr>
   
    <div class="table-responsive">
        <table class="table text-center" id="stock-out-table" width="100%" style="font-size: 12px; table-layout: fixed;">
            <thead>
                <tr>
                    <th>Date Sold or Remove</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="stock-in-body">
                <!-- Data will be populated dynamically here -->
            </tbody>
        </table>
    </div>
</div>

<script>
// Trigger the data fetching and page printing once the page loads
window.addEventListener("load", function() {
    fetchStockOutData();
});

function fetchStockOutData() {
    fetch('fetch_stock_out.php')  // Replace with your PHP endpoint
        .then(response => response.json())
        .then(data => {
            populateStockOutTable(data);
            window.print();  // Automatically trigger the print dialog after the data is populated
        })
        .catch(error => console.error('Error fetching stock-in data:', error));
}

function populateStockOutTable(data) {
    const tableBody = document.getElementById('stock-in-body');
    tableBody.innerHTML = '';  // Clear any existing rows

    data.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.date_sold}</td>
            <td>${item.product_name}</td>
            <td>${item.quantity}</td>
            <td>${item.status}</td>
        `;
        tableBody.appendChild(row);
    });
}
</script>

</body>
</html>