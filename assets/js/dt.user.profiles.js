$(function () {
  const admin_role = "ADMIN";
  const cashier_role = "CASHIER";
  const role = "ROLE";

  generate_dt_ACCOUNTS(admin_role);

  function generate_dt_ACCOUNTS(role) {
    $("#table_account_list").DataTable({
      ordering: false,
      autoWidth: false,
      ajax: {
        url: "config/ajaxProcess/fetch.php",
        method: "GET",
        data: { action: "GR_tbl_accounts", role: role },
        dataSrc: "",
      },
      columns: [
        {
          render: function (data, type, row) {
            var photo = `<img src="assets/img/avatars/${row.img_dir}" alt="Photo" width="50px">`;
            return photo;
          },
        },
        { data: "name" },
        {
          render: function (data, type, row) {
            var role = `<div class="badge bg-info" style="font-size: 10px">${row.role}</div>`;
            return role;
          },
        },
        {
          render: function (data, type, row) {
            var typeOf = `${row.status}`;
            var status = "";
            switch (typeOf) {
              case "ACTIVE":
                status = `<div class="badge bg-success" style="font-size: 10px">ACTIVE</div>`;
                break;
              case "INACTIVE":
                status = `<div class="badge bg-danger" style="font-size: 10px">INACTIVE</div>`;
                break;
            }
            return status;
          },
        },
        {
          render: function (data, type, row) {
            var acc_status = row.status,
              btn = "",
              role = row.role;
            if (acc_status == "ACTIVE") {
              switch (role) {
                case "ADMIN":
                  btn = `<div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="my-profile.php" style="color: #000000"><i class='bx bxs-user-account pb-1'></i> View profile</a>
                            <button class="dropdown-item btn-deactivate" data-bs-toggle="modal" data-bs-target="#modal_deactivate" name="ADMIN" id="${row.id}"><i class='bx bx-power-off pb-1'></i> Deactivate account</button>
                          </div>
                        </div>`;
                  break;
                case "CASHIER":
                  btn = `<div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu" style="">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal_manage_${row.id}" style="color: #000000"><i class='bx bxs-user-account pb-1'></i> View profile</button>
                            <button class="dropdown-item btn-deactivate" data-bs-toggle="modal" data-bs-target="#modal_deactivate" name="CASHIER" id="${row.id}"><i class='bx bx-power-off pb-1'></i> Deactivate account</button>
                            <button class="dropdown-item btn-cont" data-bs-toggle="modal" data-bs-target="#modal_delete" name="CASHIER" id="${row.id}"><i class='bx bx-trash pb-1'></i> Delete account</button>
                          </div>
                        </div>`;
                  break;
              }
            } else {
              switch (role) {
                case "ADMIN":
                  btn = `<div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="my-profile.php" style="color: #000000"><i class='bx bxs-user-account pb-1'></i> View profile</a>
                            <button class="dropdown-item btn-activate" data-bs-toggle="modal" data-bs-target="#modal_activate" name="ADMIN" id="${row.id}"><i class='bx bx-power-off pb-1'></i> Activate account</button>
                          </div>
                        </div>`;
                  break;
                case "CASHIER":
                  btn = `<div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu" style="">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal_manage_${row.id}" style="color: #000000"><i class='bx bxs-user-account pb-1'></i> View profile</button>
                            <button class="dropdown-item btn-activate" data-bs-toggle="modal" data-bs-target="#modal_activate" name="CASHIER" id="${row.id}"><i class='bx bx-power-off pb-1'></i> Activate account</button>
                            <button class="dropdown-item btn-cont" data-bs-toggle="modal" data-bs-target="#modal_delete" name="CASHIER" id="${row.id}"><i class='bx bx-trash pb-1'></i> Delete account</button>
                          </div>
                        </div>`;
                  break;
              }
            }
            return btn;
          },
        },
      ],
    });
  }

  $("#table_roles").DataTable({
    ordering: true,
    autoWidth: true,
    ajax: {
      url: "config/ajaxProcess/fetch.php",
      method: "GET",
      data: { action: "GR_tbl_roles" },
      dataSrc: "",
    },
    columns: [
      {
        render: function (data, type, row) {
          var status = `<div class="badge bg-info">${row.role}<div>`;
          return status;
        },
      },
      {
        render: function (data, type, row) {
          var role = row.role;
          var btn;
          if (role == "ADMIN") {
            btn = '';
          } else {
            btn = `<div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu" style="">
                        <button type="button" class="dropdown-item" id="${row.id}" data-bs-toggle="modal" data-bs-target="#modal_edit_${row.id}_role" title="Edit"><i class="bx bx-pencil"></i> Edit</button>
                        <button type="button" class="dropdown-item btn-cont" id="${row.id}" name="${role}" data-bs-toggle="modal" data-bs-target="#modal_delete_role" title="Delete"><i class="bx bx-trash"></i> Delete</button>
                      </div>
                    </div>`;
          }
          return btn;
        },
      },
    ],
  });

  //Button controls
  $(document).on("click", ".btn-cont", function () {
    var get_id = $(this).attr("id");
    $(".btn-delete").attr("id", get_id);
    $(".btn-delete").attr("name", $(this).attr("name"));
  });

  $(document).on("click", ".btn-delete", function () {
    var id = $(this).attr("id");
    var selected = $(this).attr("name");
    switch (selected) {
      case "ADMIN":
        DR_tbl_accounts(id);
        break;
      case "CASHIER":
        DR_tbl_accounts(id);
        break;
      case role:
        DR_tbl_roles(id);
        break;
    }
  });

  $(document).on("change", ".selector", function () {
    $("#table_account_list").DataTable().destroy();
    var selected = $(this).val();
    switch (selected) {
      case "ADMIN":
        generate_dt_ACCOUNTS(admin_role);
        break;
      case "CASHIER":
        generate_dt_ACCOUNTS(cashier_role);
        break;
    }
  });

  $(document).on("click", ".btn-activate", function () {
    var id = $(this).attr("id");
    var selected = $(this).attr("name");
    const status = "ACTIVE";
    switch (selected) {
      case "ADMIN":
        UR_tbl_accounts_STATUS(id, status);
        break;
      case "CASHIER":
        UR_tbl_accounts_STATUS(id, status);
        break;
    }
  });

  $(document).on("click", ".btn-deactivate", function () {
    var id = $(this).attr("id");
    var selected = $(this).attr("name");
    $(".btn-deactivate-confirm").attr("id", id);
    $(".btn-deactivate-confirm").attr("name", selected);
  });

  $(document).on("click", ".btn-deactivate-confirm", function () {
    var id = $(this).attr("id");
    var selected = $(this).attr("name");
    const status = "INACTIVE";
    switch (selected) {
      case "ADMIN":
        UR_tbl_accounts_STATUS(id, status);
        break;
      case "CASHIER":
        UR_tbl_accounts_STATUS(id, status);
        break;
    }
  });
  //Button controls

  //Delete function
  function DR_tbl_accounts(id) {
    $.ajax({
      url: "config/ajaxProcess/fetch.php",
      method: "POST",
      data: { action: "DR_tbl_accounts", id: id },
      success: function (data) {
        $("#table_account_list").DataTable().ajax.reload();

        if (data == "Failed to delete account!") {
          toastr["error"](data, "ERROR");
        } else {
          toastr["success"](data, "SUCCESS");
        }
      },
    });
  }

  function DR_tbl_roles(id) {
    $.ajax({
      url: "config/ajaxProcess/fetch.php",
      method: "POST",
      data: { action: "DR_tbl_roles", id: id },
      success: function (data) {
        $("#table_roles").DataTable().ajax.reload();

        if (data == "Failed to delete role!") {
          toastr["error"](data, "ERROR");
        } else {
          toastr["success"](data, "SUCCESS");
        }
      },
    });
  }
  //Delete function

  //Update function
  function UR_tbl_accounts_STATUS(id, status) {
    $.ajax({
      url: "config/ajaxProcess/fetch.php",
      method: "POST",
      data: {
        action: "UR_tbl_accounts_STATUS",
        id: id,
        status: status,
      },
      success: function (data) {
        $("#table_account_list").DataTable().ajax.reload();

        if (data == "Failed to deactivate account!") {
          toastr["error"](data, "ERROR");
        } else {
          if (status == "ACTIVE") {
            toastr["info"](data, "INFO");
          } else {
            toastr["info"](data, "INFO");
          }
        }
      },
    });
  }
  //Update function
});
