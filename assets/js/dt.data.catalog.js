$(function () {
  $("#table_catalog").DataTable({
    ordering: true,
    autoWidth: true,
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
});
