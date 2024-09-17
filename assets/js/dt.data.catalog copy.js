$(function () {
  $("#table_catalog").DataTable({
    ordering: true,
    autoWidth: true,
    lengthMenu: [[-1, 10, 25, 50, 100], ["All", 10, 25, 50, 100]],
    ajax: {
      url: "config/ajaxProcess/fetch.php",
      method: "GET",
      data: { action: "GR_tbl_products" },
      dataSrc: "",
    },
    columns: [
      {
        render: function (data, type, row) {
          var qr = `<a href="assets/img/QR/${row.qr_code}" target="_blank"><img src="assets/img/QR/${row.qr_code}" width="50" alt="qr"></a>`;
          return qr;
        },
      },
      { data: "product_brand" },
      { data: "product_name" },
      {
        data: "product_price",
        render: $.fn.dataTable.render.number(",", ".", 2, "₱"),
      },
    ],
  });

  $(document).on("click", ".btn-print", function () {
    $(this).hide();
    $(".buttons").hide();
    print();
    $(this).show();
    $(".buttons").show();
  });
  $(document).on("click", ".btn-close-window", function () {
    window.close();
  });
});
