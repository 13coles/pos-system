$(function () {
  const cart = "CART";
  GR_cart_ctr();
  generate_table();

  let scanner = new Instascan.Scanner({
    video: document.getElementById("preview"),
  });

  scanner.addListener("scan", function (content) {
    document.getElementById("pre").value = content;
    const product_id = content;

    $.ajax({
      url: "config/ajaxProcess/fetch.php",
      method: "POST",
      data: { action: "IR_cart", product_id: product_id },
      success: function (data) {
        if (data == "Product is out of stock!") {
          toastr["error"](data, "ERROR");
        } else {
          toastr["success"]("Scan success", "SUCCESS");
          $("#table_cart").DataTable().ajax.reload();
          $("#sound")[0].play();
          GR_cart_ctr();
        }
      },
    });
  });

  Instascan.Camera.getCameras()
    .then(function (cameras) {
      if (cameras.length > 0) {
        scanner.start(cameras[0]);
      } else {
        console.error("No cameras found.");
      }
    })
    .catch(function (e) {
      console.error(e);
    });

  function generate_table() {
    $("#table_cart").DataTable({
      ordering: false,
      autoWidth: true,
      destroy: true,
      ajax: {
        url: "config/ajaxProcess/fetch.php",
        method: "GET",
        data: { action: "GR_tbl_cart" },
        dataSrc: "",
      },
      columns: [
        { data: "product_name" },
        {
          data: "product_price",
          render: function (data, type, row) {
            if (row.in_sale && row.in_sale > 0) {
              return `<span style="text-decoration: line-through; color: gray;">₱${parseFloat(row.product_price).toLocaleString()}</span> 
                      <span style="color: red; font-weight: bold;">₱${parseFloat(row.in_sale).toLocaleString()}</span>`;
            } else {
              return `<span>₱${parseFloat(row.product_price).toLocaleString()}</span>`;
            }
          },
        },
        {
          data: "subtotal",
          render: $.fn.dataTable.render.number(",", ".", 2, "₱"),
        },
        {
          render: function (data, type, row) {
            var quantity = `<input type="number" min="1" class="form-control text-center quantity-selector" id="${row.id}" price="${row.product_price}" value="${row.product_qty}">`;
            return quantity;
          },
        },
        {
          render: function (data, type, row) {
            var btn = `<button type="button" class="btn btn-danger btn-sm btn-delete" id="${row.id}" name="${cart}" title="Delete"><i class="bx bx-trash"></i> Delete</button>`;
            return btn;
          },
        },
      ],
      footerCallback: function (row, data, start, end, display) {
        var api = this.api();
  
        // Helper function to parse and sum numeric values
        var intVal = function (i) {
          return typeof i === "string"
            ? i.replace(/[\₱,]/g, "") * 1
            : typeof i === "number"
            ? i
            : 0;
        };

        // Total for the current page
        var pageTotal = api
        .column(2, { page: "current" }) // Use the correct column index for subtotal
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

         // Update the footer with the total
        $(api.column(2).footer()).html(
          $.fn.dataTable.render.number(",", ".", 2, "₱").display(pageTotal)
        );
      },
    });
  }

  $(document).on("change", ".quantity-selector", function () {
    var id = $(this).attr("id");
    var price = $(this).attr("price");
    var quantity = $(this).val();
    $.ajax({
      url: "config/ajaxProcess/fetch.php",
      method: "POST",
      data: {
        action: "UR_tbl_cart_FOR_QUANTITY",
        id: id,
        price: price,
        quantity: quantity,
      },
      success: function (data) {
        $("#table_cart").DataTable().ajax.reload();
        var name = $(".customer").val();
        $(".receipt").load("receipt.php?name=".concat(name));
      },
    });
  });

  //if "btn-complete" click this script send a ajax request to a server
  // to insert the the ordered products to table transaction 
  $(document).on("click", ".btn-complete", function () {
    var customer = $(".customer").val();
    var transaction_id = $(".transaction_id").html();
    var date = $(".date").html();
    $.ajax({
      url: "config/ajaxProcess/fetch.php",
      method: "POST",
      data: {
        action: "IR_tbl_sales", 
        customer: customer,
        transaction_id: transaction_id,
        date: date,
      },
      success: function (data) {
        $("#table_cart").DataTable().ajax.reload();
        if (data == "An error has occured during the transaction!") {
          toastr["error"](data, "ERROR");
        } else {
          toastr["success"](data, "SUCCESS");
          $(".customer").val("");
          GR_cart_ctr();
          GR_notification();
        }
      },
    });
  });

  $(document).on("keyup", ".customer", function () {
    var name = $(this).val();
    $(".receipt").load("receipt.php?name=".concat(name));
  });

  $(function () {
    $(".customer").keyup(function () {
      this.value = this.value
        .replace(/[^a-z]/gi, "")
        .replace(/(\..*)\./g, "$1");
      if (this.value == '') {
        $(".btn-complete").attr("hidden", true);
        $(".needs-validation").addClass("was-validated");
      } else {
        $(".btn-complete").attr("hidden", false);
        $(".needs-validation").removeClass("was-validated");
      }
    });
  });

  $(document).on("click", ".btn-delete", function () {
    var id = $(this).attr("id");
    var ref = $(this).attr("name");
    if (ref == cart) {
      DR_cart(id);
    }
  });

  function DR_cart(id) {
    $.ajax({
      url: "config/ajaxProcess/fetch.php",
      method: "POST",
      data: { action: "DR_cart", id: id },
      success: function (data) {
        $("#table_cart").DataTable().ajax.reload();
        if (data == "Failed to delete item!") {
          toastr["error"](data, "ERROR");
        } else {
          toastr["success"](data, "SUCCESS");
          GR_cart_ctr();
        }
      },
    });
  }
});

function GR_cart_ctr() {
  $.ajax({
    url: "config/ajaxProcess/fetch.php",
    method: "GET",
    data: { action: "GR_cart_ctr" },
    success: function (data) {
      $("#cart_ctr").html(data);

      if ($("#cart_ctr").html() == 0) {
        $(".btn-modal-complete").attr("hidden", true);
      } else {
        $(".btn-modal-complete").attr("hidden", false);
      }
    },
  });
}

function GR_notification() {
  $(".notif").load("notif-count.php");
  $(".notif-body").load("notif-body.php");
  $(".notif-none").attr("hidden", true);
  $(".notif-btn").attr("hidden", false);
}
