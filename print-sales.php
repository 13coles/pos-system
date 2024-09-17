<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');
$db = new Data_Operations();
$get = new File_Contents();

$result_account_info = $db->GR_account_info();
$admin_info = mysqli_fetch_assoc($result_account_info);

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);

$notification_ctr = $db->GR_notif_ctr();
// Fetch sales from the database
$sales = $db->GR_print_sales();

?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<?php
include_once('util/head.php');
$get->toastr_css_new();
$get->dt_css();
?>
<style>
        @media print {
            .table-responsive {
                overflow: hidden;
            }

            table {
                width: 100%;
                table-layout: fixed; 
            }

            th, td {
                word-wrap: break-word;
                font-size: 10px; 
            }
            body {
                overflow: hidden;
            }
        }
    </style>
<body>
<div class="wrapper">
    <div class="heading">
    <?php include('util/header-print.php'); ?>
    </div>
    <hr>
    <div class="table-responsive">
    <table class="table text-center" id="table_sales" width="100%">
        <thead>
          <tr>
            <th>Date Purchased</th>
            <th>Transaction ID</th>
            <th>Sold To</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
            <?php if ($sales): ?>
                <?php $overall_sales = 0; // Initialize overall sales total ?>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($sale['date_purchased']); ?></td>
                        <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($sale['transaction_id']); ?></td>
                        <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($sale['customer']); ?></td>
                        <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($sale['total']); ?></td>
                        <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($sale['status']); ?></td>
                    </tr>
                    <?php $overall_sales += floatval($sale['total']); // Add to the overall total ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center-middle">No sales found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align:right">OVERALL SALES:</th>
                <th><?php echo '₱' . number_format($overall_sales, 2); ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    </div>
</div>
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
