<?php
// Include necessary files
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
include('config/validator.php');

// Instantiate the required classes
$db = new Data_Operations();
$get = new File_Contents();

// Fetch data from the database
$result_account_info = $db->GR_account_info();
$admin_info = mysqli_fetch_assoc($result_account_info);

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);

$notification_ctr = $db->GR_notif_ctr();
$sales = $db->GR_print_sales();
?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<?php
// Include the head section and necessary styles
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
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($sales): ?>
                        <?php $overall_sales = 0; // Initialize overall sales total ?>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($sale['date_purchased']); ?></td>
                                <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($sale['transaction_id']); ?></td>
                                <td style="text-align: center; vertical-align: middle; font-size:12px;"><?php echo htmlspecialchars($sale['total']); ?></td>
                            </tr>
                            <?php $overall_sales += floatval($sale['total']); // Add to the overall total ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No sales found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align:right">OVERALL SALES:</th>
                        <td><?php echo '₱' . number_format($overall_sales, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script>
        // Automatically trigger print dialog when the page loads
        window.addEventListener("load", function() {
            window.print();
        });
    </script>
</body>
</html>
