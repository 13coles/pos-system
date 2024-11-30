$(function () {
  // Initialize the DataTable
  var productTable = $("#table_products").DataTable({
    ordering: true,
    order: [0, 'desc'],
    autoWidth: true,
    ajax: {
      url: "config/ajaxProcess/fetch.php",
      method: "GET",
      data: { action: "GR_tbl_products" },
      dataSrc: "",
    },
    columns: [
      { data: "exp_date" },
      {
        render: function (data, type, row) {
          var img = `<a href="assets/img/products/${row.product_img}" target="_blank"><img src="assets/img/products/${row.product_img}" width="50" alt="image"></a>`;
          return img;
        },
      },
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
      { data: "product_qty" },
      {
        render: function (data, type, row) {
          var typeOf = `${row.status}`;
          var status = "";
          switch (typeOf) {
            case "IN STOCK":
              status = `<div class="badge bg-success">IN STOCK</div>`;
              break; 
            case "LOW STOCK":
              status = `<div class="badge bg-warning">LOW STOCK</div>`;
              break;
            case "OUT OF STOCK":
              status = `<div class="badge bg-danger">OUT OF STOCK</div>`;
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
                        <button type="button" class="dropdown-item" id="${row.id}" data-bs-toggle="modal" data-bs-target="#modal_edit_${row.id}_product" title="Edit"><i class="bx bx-pencil"></i> Edit</button>
                        <button type="button" class="dropdown-item btn-cont" id="${row.id}" name="PRODUCT" data-bs-toggle="modal" data-bs-target="#modal_delete" title="Delete"><i class="bx bx-trash"></i> Delete</button>
                      </div>
                    </div>`;
          return btn;
        },
      },
    ],
  });

  // Function to update the entire DataTable every 3 seconds
  setInterval(function () {
    // Reload the entire table's data
    productTable.ajax.reload(null, false); // Use false to keep the current page
  }, 3000);

  // Event listeners for edit and delete buttons
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
        productTable.ajax.reload();
        if (data == "Failed to delete product!") {
          toastr["error"](data, "ERROR");
        } else {
          toastr["success"](data, "SUCCESS");
        }
      },
    });
  }
});

// UN COMMENT ONLY IF YOU INTEND TO USE THIS FOR A  Function to update product quantities every 3 seconds
//  setInterval(function () {
//   $.ajax({
//     url: "config/ajaxProcess/fetch.php",
//     method: "GET",
//     data: { action: "GR_tbl_product_quantities" },
//     dataType: "json",
//     success: function (data) {
//       data.forEach(function (product) {
//         var row = $('#table_products').DataTable().row(function (idx, rowData, node) {
//           return rowData.id == product.id;
//         });
//         if (row) {
//           row.data().product_qty = product.product_qty;
//           row.invalidate(); 
//         }
//       });
//       $('#table_products').DataTable().draw(false);
//     }
//   });
// }, 3000);