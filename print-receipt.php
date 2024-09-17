<?php
require_once('config/dbconfig.php');
require_once('config/file_controller.php');
$db = new Data_Operations();
$get = new File_Contents();

$result_system = $db->GR_system_info();
$system_info = mysqli_fetch_assoc($result_system);

$transaction_id = $_GET['transaction_id'];
$total = 0;
?>
<?php include('util/head.php'); ?>
<style>
  .receipt-content .logo a:hover {
    text-decoration: none;
    color: #7793C4;
  }

  .receipt-content .invoice-wrapper {
    margin-top: 20px;
  }

  .receipt-content .invoice-wrapper .payment-details span {
    color: #A9B0BB;
    display: block;
  }

  .receipt-content .invoice-wrapper .payment-details a {
    display: inline-block;
    margin-top: 5px;
  }

  .receipt-content .invoice-wrapper .line-items .print a {
    display: inline-block;
    border: 1px solid #9CB5D6;
    padding: 13px 13px;
    border-radius: 5px;
    color: #708DC0;
    font-size: 13px;
    -webkit-transition: all 0.2s linear;
    -moz-transition: all 0.2s linear;
    -ms-transition: all 0.2s linear;
    -o-transition: all 0.2s linear;
    transition: all 0.2s linear;
  }

  .receipt-content .invoice-wrapper .line-items .print a:hover {
    text-decoration: none;
    border-color: #333;
    color: #333;
  }

  .receipt-content .logo {
    text-align: center;
  }

  .receipt-content .logo a {
    font-family: Myriad Pro, Lato, Helvetica Neue, Arial;
    font-size: 36px;
    letter-spacing: .1px;
    color: #555;
    font-weight: 300;
    -webkit-transition: all 0.2s linear;
    -moz-transition: all 0.2s linear;
    -ms-transition: all 0.2s linear;
    -o-transition: all 0.2s linear;
    transition: all 0.2s linear;
  }

  .receipt-content .invoice-wrapper .intro {
    line-height: 25px;
    color: #444;
  }

  .receipt-content .invoice-wrapper .payment-info {
    margin-top: 25px;
    padding-top: 15px;
  }

  .receipt-content .invoice-wrapper .payment-info span {
    color: #A9B0BB;
  }

  .receipt-content .invoice-wrapper .payment-info strong {
    display: block;
    color: #444;
    margin-top: 3px;
  }

  @media (max-width: 767px) {
    .receipt-content .invoice-wrapper .payment-info .text-right {
      text-align: left;
      margin-top: 20px;
    }
  }

  .receipt-content .invoice-wrapper .payment-details {
    border-top: 2px solid #EBECEE;
    margin-top: 30px;
    padding-top: 20px;
    line-height: 22px;
  }


  @media (max-width: 767px) {
    .receipt-content .invoice-wrapper .payment-details .text-right {
      text-align: left;
      margin-top: 20px;
    }
  }

  .receipt-content .invoice-wrapper .line-items {
    margin-top: 40px;
  }

  .receipt-content .invoice-wrapper .line-items .headers {
    color: #A9B0BB;
    font-size: 13px;
    letter-spacing: .3px;
    border-bottom: 2px solid #EBECEE;
    padding-bottom: 4px;
  }

  .receipt-content .invoice-wrapper .line-items .items {
    margin-top: 8px;
    border-bottom: 2px solid #EBECEE;
    padding-bottom: 8px;
  }

  .receipt-content .invoice-wrapper .line-items .items .item {
    padding: 10px 0;
    color: #696969;
    font-size: 15px;
  }

  @media (max-width: 767px) {
    .receipt-content .invoice-wrapper .line-items .items .item {
      font-size: 13px;
    }
  }

  .receipt-content .invoice-wrapper .line-items .items .item .amount {
    letter-spacing: 0.1px;
    color: #84868A;
    font-size: 16px;
  }

  @media (max-width: 767px) {
    .receipt-content .invoice-wrapper .line-items .items .item .amount {
      font-size: 13px;
    }
  }

  .receipt-content .invoice-wrapper .line-items .total {
    margin-top: 30px;
  }

  .receipt-content .invoice-wrapper .line-items .total .extra-notes {
    float: left;
    width: 40%;
    text-align: left;
    font-size: 13px;
    color: #7A7A7A;
    line-height: 20px;
  }

  @media (max-width: 767px) {
    .receipt-content .invoice-wrapper .line-items .total .extra-notes {
      width: 100%;
      margin-bottom: 30px;
      float: none;
    }
  }

  .receipt-content .invoice-wrapper .line-items .total .extra-notes strong {
    display: block;
    margin-bottom: 5px;
    color: #454545;
  }

  .receipt-content .invoice-wrapper .line-items .total .field {
    margin-bottom: 7px;
    font-size: 14px;
    color: #555;
  }

  .receipt-content .invoice-wrapper .line-items .total .field.grand-total {
    margin-top: 10px;
    font-size: 16px;
    font-weight: 500;
  }

  .receipt-content .invoice-wrapper .line-items .total .field.grand-total span {
    color: #20A720;
    font-size: 16px;
  }

  .receipt-content .invoice-wrapper .line-items .total .field span {
    display: inline-block;
    margin-left: 20px;
    min-width: 85px;
    color: #84868A;
    font-size: 15px;
  }

  .receipt-content .invoice-wrapper .line-items .print {
    margin-top: 50px;
    text-align: center;
  }



  .receipt-content .invoice-wrapper .line-items .print a i {
    margin-right: 3px;
    font-size: 14px;
  }

  .receipt-content .footer {
    margin-top: 40px;
    margin-bottom: 110px;
    text-align: center;
    font-size: 12px;
    color: #969CAD;
  }

  .text-right {
    text-align: right !important;
  }
</style>

<div class="receipt-content">
  <div class="container bootstrap snippets bootdey">
    <div class="row">
      <div class="col-12">
        <div class="invoice-wrapper">
          <?php
          include('util/header-print.php');
          ?>
           <div class="intro">
              Hello <strong><?php echo htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8'); ?></strong>,
              <br>
              Thank you for shopping with us! Below is the receipt for your recent order.<br>
          </div>


          <div class="line-items">
            <div class="headers clearfix">
              <div class="row">
                <div class="col-5">Product Name</div>
                <div class="col-4">Brand</div>
                <div class="col-1">Quantity</div>
                <div class="col-2 text-right">Amount</div>
              </div>
            </div>
            <div class="items">
              <?php
              $result = $db->GR_transaction_ref_FOR_RECEIPT($transaction_id);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                  echo "
                  <div class='row item'>
                    <div class='col-5 desc'>
                      " . $row['product_name'] . "
                    </div>
                    <div class='col-4 desc'>
                      " . $row['product_brand'] . "
                    </div>
                    <div class='col-1 qty'>
                      " . $row['product_qty'] . "
                    </div>
                    <div class='col-2 amount text-right'>
                      ₱" . number_format($row['subtotal'], 2) . "
                    </div>
                  </div>
                  ";
                  $total = $total + $row['subtotal'];
                }
              }
              ?>
            </div>
            <div class="total text-right">
              <div class="field">
                Discount <span><?php echo $discount = 0; ?>%</span>
              </div>
              <div class="field">
                VAT <span><?php echo $vat = 0; ?>%</span>
              </div>
              <div class="field grand-total">
                Total <span><?php echo "₱" . number_format($total, 2); ?></span>
              </div>
            </div>
          </div>

          <div class="kepp mt-5 text-center">
              <i>*Please keep this receipt for your records and any future reference.</i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/plugins.js"></script>
<script>
  $(function() {
    window.print();
    window.onafterprint = function() {
      window.close();
    }
  });
</script>