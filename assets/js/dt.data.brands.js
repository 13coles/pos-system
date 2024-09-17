$(function () {
  const brand = "BRAND";

  // Initialize the DataTable
  const brandTable = $("#table_brands").DataTable({
    ordering: true,
    autoWidth: true,
    ajax: {
      url: "config/ajaxProcess/fetch.php",
      method: "GET",
      data: { action: "GR_tbl_brands" },
      dataSrc: "",
    },
    columns: [
      {
        render: function (data, type, row) {
          var img = `<a href="assets/img/brands/${row.img_dir}" target="_blank"><img src="assets/img/brands/${row.img_dir}" width="50" alt="image"></a>`;
          return img;
        },
      },
      { data: "brand" },
      {
        render: function (data, type, row) {
          var btn = `<div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu" style="">
                        <button type="button" class="dropdown-item" id="${row.id}" data-bs-toggle="modal" data-bs-target="#modal_edit_${row.id}" title="Edit"><i class="bx bx-pencil"></i> Edit</button>
                        <button type="button" class="dropdown-item btn-cont" id="${row.id}" name="${brand}" data-bs-toggle="modal" data-bs-target="#modal_delete" title="Delete"><i class="bx bx-trash"></i> Delete</button>
                      </div>
                    </div>`;
          return btn;
        },
      },
    ],
  });

  // Reload the DataTable every 3 seconds
  setInterval(function () {
    brandTable.ajax.reload(null, false); // 'false' to prevent reordering/resetting pagination
  }, 3000);

  // Edit button click event
  $(document).on("click", ".btn-edit", function () {
    var id = $(this).attr("id");
    const typeOf = "success";
    UR_product(id, typeOf);
  });

  // Set the ID and name attributes for the delete button
  $(document).on("click", ".btn-cont", function () {
    var get_id = $(this).attr("id");
    $(".btn-delete").attr("id", get_id);
    $(".btn-delete").attr("name", $(this).attr("name"));
  });

  // Delete button click event
  $(document).on("click", ".btn-delete", function () {
    var id = $(this).attr("id");
    var ref = $(this).attr("name");
    if (ref == brand) {
      DR_brand(id);
    }
  });

  // Function to delete a brand
  function DR_brand(id) {
    $.ajax({
      url: "config/ajaxProcess/fetch.php",
      method: "POST",
      data: { action: "DR_brand", id: id },
      success: function (data) {
        brandTable.ajax.reload(); // Reload the DataTable to reflect the deletion
        if (data == "Failed to delete brand!") {
          toastr["error"](data, "ERROR");
        } else {
          toastr["success"](data, "SUCCESS");
        }
      },
    });
  }
});
