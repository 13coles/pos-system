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
    <h4 class="text-center">Inventory Report</h4>
    <hr>
    <div class="table-responsive">
        <table class="table text-center" id="table_account_list" width="100%" style="font-size: 12px; table-layout: fixed;">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Total Qty</th>
                    <th>Sold Qty</th>
                    <th>Available Qty</th>
                </tr>
            </thead>
            <tbody id="inventory-data">
                <!-- Data will be populated dynamically here -->
            </tbody>
        </table>
    </div>
</div>

<script>

window.addEventListener("load", function() {
    fetchInventoryData();
});

function fetchInventoryData() {
   
    const month = '<?php echo isset($_GET['month']) ? $_GET['month'] : ''; ?>';

    fetch('fetch_inventory.php?month=' + month)
        .then(response => response.json())
        .then(data => {
            populateTable(data);
            window.print(); 
        })
        .catch(error => console.error('Error fetching inventory data:', error));
}


function populateTable(data) {
    const tableBody = document.getElementById('inventory-data');
    tableBody.innerHTML = ''; 

    data.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.product_name}</td>
            <td>${item.total_quantity}</td>
            <td>${item.sold_qty}</td>
            <td>${item.available_qty}</td>
        `;
        tableBody.appendChild(row);
    });
}
</script>

</body>
</html>
