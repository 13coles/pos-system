$(function () {
  generate_table();

  function generate_table() {
    $("#table_sales").DataTable({
      ordering: true,
      autoWidth: true,
      order: [0, "desc"],
      ajax: {
        url: "config/ajaxProcess/fetch.php",
        method: "GET",
        data: { action: "GR_tbl_sales" },
        dataSrc: "",
      },
      columns: [
        { data: "date_purchased" },
        { data: "transaction_id" },
        { data: "customer" },
        {
          data: "total",
          render: $.fn.dataTable.render.number(",", ".", 2, "₱"),
        },
        {
          render: function (data, type, row) {
            var typeOf = `${row.status}`;
            var status = "";
            switch (typeOf) {
              case "COMPLETED":
                status = `<div class="badge bg-success">COMPLETED</div>`;
                break;
            }
            return status;
          },
        },
        {
          render: function (data, type, row) {
            var btn = `<div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu" style="">
                        <button type="button" class="dropdown-item btn-view" id="${row.transaction_id}" data-bs-toggle="modal" data-bs-target="#modal_view" title="View transaction"><i class="bx bx-search"></i> View transaction</button>
                      </div>
                    </div>`;
            return btn; 
            //<a target="_blank" href="print-receipt.php?transaction_id=${row.transaction_id}&name=${row.customer}&date=${row.date_purchased}" class="dropdown-item" style="color: #000000" id="${row.transaction_id}" title="Generate receipt"><i class="bx bx-receipt"></i> Generate receipt</a>
          },
        },
      ],
      footerCallback: function (row, data, start, end, display) {
        var api = this.api(),
          data;

        var intVal = function (i) {
          return typeof i === "string"
            ? i.replace(/[\₱,]/g, "") * 1
            : typeof i === "number"
            ? i
            : 0;
        };

        pageTotal = api
          .column(3, { page: "current" })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        $(api.column(3).footer()).html(
          $.fn.dataTable.render.number(",", ".", 2, "₱").display(pageTotal)
        );
      },
    });
  }

  $(document).on("click", ".btn-view", function () {
    var transaction_id = $(this).attr("id");
    $("#table_preview").DataTable().destroy();
    $("#table_preview").DataTable({
      ordering: false,
      autoWidth: true,
      ajax: {
        url: "config/ajaxProcess/fetch.php",
        method: "GET",
        data: {
          action: "GR_tbl_transaction_ref",
          transaction_id: transaction_id,
        },
        dataSrc: "",
      },
      columns: [
        { data: "date_purchased" },
        { data: "transaction_id" },
        {
          render: function (data, type, row) {
            var qr = `<a href="assets/img/QR/${row.qr_code}" target="_blank"><img src="assets/img/QR/${row.qr_code}" width="50" alt="qr"></a>`;
            return qr;
          },
        },
        {
          render: function (data, type, row) {
            var img = `<a href="assets/img/products/${row.product_img}" target="_blank"><img src="assets/img/products/${row.product_img}" width="50" alt="image"></a>`;
            return img;
          },
        },
        { data: "product_id" },
        { data: "product_brand" },
        { data: "product_name" },
        {
          data: "product_price",
          render: $.fn.dataTable.render.number(",", ".", 2, "₱"),
        },
        {
          data: "subtotal",
          render: $.fn.dataTable.render.number(",", ".", 2, "₱"),
        },
        { data: "product_qty" },
        { data: "customer" },
        {
          render: function (data, type, row) {
            var typeOf = `${row.status}`;
            var status = "";
            switch (typeOf) {
              case "COMPLETED":
                status = `<div class="badge bg-success">COMPLETED</div>`;
                break;
            }
            return status;
          },
        },
      ],
      footerCallback: function (row, data, start, end, display) {
        var api = this.api(),
          data;

        var intVal = function (i) {
          return typeof i === "string"
            ? i.replace(/[\₱,]/g, "") * 1
            : typeof i === "number"
            ? i
            : 0;
        };

        pageTotal = api
          .column(8, { page: "current" })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        $(api.column(8).footer()).html(
          $.fn.dataTable.render.number(",", ".", 2, "₱").display(pageTotal)
        );
      },
    });
  });

  $("#btn_refresh").on("click", function () {
    $("#table_sales").DataTable().destroy();
    generate_table();
  });
  $("#btn_search").on("click", function () {
    var from = $("#date_range_toSearch").val().substring(0, 11);
    var to = $("#date_range_toSearch").val().substring(13);
    GR_tbl_sales_range(from, to);
  });
  function GR_tbl_sales_range(from, to) {
    $("#table_sales").DataTable().destroy();
    $("#table_sales").DataTable({
      ordering: true,
      autoWidth: true,
      order: [0, "desc"],
      ajax: {
        url: "config/ajaxProcess/fetch.php",
        method: "GET",
        data: {
          action: "GR_tbl_sales_range",
          from: from,
          to: to,
        },
        dataSrc: "",
      },
      columns: [
        { data: "date_purchased" },
        { data: "transaction_id" },
        { data: "customer" },
        {
          data: "total",
          render: $.fn.dataTable.render.number(",", ".", 2, "₱"),
        },
        {
          render: function (data, type, row) {
            var typeOf = `${row.status}`;
            var status = "";
            switch (typeOf) {
              case "COMPLETED":
                status = `<div class="badge bg-success">COMPLETED</div>`;
                break;
            }
            return status;
          },
        },
        {
          render: function (data, type, row) {
            var btn = `<div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu" style="">
                        <button type="button" class="dropdown-item btn-view" id="${row.transaction_id}" data-bs-toggle="modal" data-bs-target="#modal_view" title="View"><i class="bx bx-search"></i> View</button>
                      </div>
                    </div>`;
            return btn;
          },
        },
      ],
      footerCallback: function (row, data, start, end, display) {
        var api = this.api(),
          data;

        var intVal = function (i) {
          return typeof i === "string"
            ? i.replace(/[\₱,]/g, "") * 1
            : typeof i === "number"
            ? i
            : 0;
        };

        pageTotal = api
          .column(3, { page: "current" })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        $(api.column(3).footer()).html(
          $.fn.dataTable.render.number(",", ".", 2, "₱").display(pageTotal)
        );
      },
    });
  }
});
