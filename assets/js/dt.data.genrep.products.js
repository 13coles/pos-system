$(function () {
  $("#table_products").DataTable({
    ordering: true,
    order: [0, 'desc'],
    autoWidth: true,
    dom:
      "<'row'<'col-sm-12 col-md-9'l><'col-sm-12 col-md-3'f><'p-3 col-sm-12 col-md-6'B>>" +
      "<'row'<'col-12'tr>>" +
      "<'row'<'pt-3 col-sm-12 col-md-9'i><'pt-3 col-sm-12 col-md-3'p>>",
    buttons: ["copy", "csv", "excel", "pdf", "print"],
    ajax: {
      url: "config/ajaxProcess/fetch.php",
      method: "GET",
      data: { action: "GR_tbl_products" },
      dataSrc: "",
    },
    columns: [
      { data: "date_posted" },
      {
        render: function (data, type, row) {
          var img = `<a href="assets/img/products/${row.product_img}" target="_blank"><img src="assets/img/products/${row.product_img}" width="50" alt="image"></a>`;
          return img;
        },
      },
      {
        render: function (data, type, row) {
          var qr = `<a href="assets/img/QR/${row.qr_code}" target="_blank"><img src="assets/img/QR/${row.qr_code}" width="50" alt="qr"></a>`;
          return qr;
        },
      },
      { data: "product_brand" },
      { data: "product_name" },
      { data: "product_desc" },
      {
        data: "product_price",
        render: $.fn.dataTable.render.number(",", ".", 2, "₱"),
      },
      { data: "product_qty" },
      {
        render: function (data, type, row) {
          var typeOf = `${row.status}`;
          var status = "";
          switch (typeOf) {
            case "IN STOCK":
              status = `<div class="badge bg-success">IN STOCK</div>`;
              break;
            case "OUT OF STOCK":
              status = `<div class="badge bg-danger">OUT OF STOCK</div>`;
              break;
          }
          return status;
        },
      },
    ],
  });

  $(document).on("click", ".btn-edit", function () {
    var id = $(this).attr("id");
    const typeOf = "success";
    UR_product(id, typeOf);
  });
  $(document).on("click", ".btn-cont", function () {
    var get_id = $(this).attr("id");
    $(".btn-delete").attr("id", get_id);
    $(".btn-delete").attr("name", $(this).attr("name"));
  });
  $(document).on("click", ".btn-delete", function () {
    var id = $(this).attr("id");
    var ref = $(this).attr("name");
    if (ref == "PRODUCT") {
      DR_product(id);
    }
  });
  function DR_product(id) {
    $.ajax({
      url: "config/ajaxProcess/fetch.php",
      method: "POST",
      data: { action: "DR_product", id: id },
      success: function (data) {
        $("#table_products").DataTable().ajax.reload();
        if (data == "Failed to delete product!") {
          toastr["error"](data, "ERROR");
        } else {
          toastr["success"](data, "SUCCESS");
        }
      },
    });
  }
});
