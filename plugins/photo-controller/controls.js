$(function () {
  var default_img = $(".filename").val();
  var default_img_logo = $(".filename_logo").val();
  var default_img_icon = $(".filename_icon").val();
  var default_img_product = '';
  var default_img_brand = '';

  $(document).on("change", ".file-input-image", function () {
    var ref = $(this).attr("input-id");
    var img = $(this).get(0).files[0];
    var path = (window.URL || window.webkitURL).createObjectURL(img);
    default_img_product = $(".filename_product_".concat(ref)).val();
    default_img_brand = $(".filename_brand_".concat(ref)).val();
    $(".".concat(ref)).attr("src", path);
    $("#".concat(ref)).attr("hidden", false);
    if (img.size > 2500000) {
      $(".size-preview, .size-preview-logo, size-preview-icon").html("Size: <i class='bx bx-x text-danger'></i>");
    } else {
      $(".size-preview, .size-preview-logo, size-preview-icon").html("Size: <i class='bx bx-check text-success'></i>");
    }
  });

  $(document).on("click", ".file-reset-image", function () {
    var ref = $(this).attr("id");
    var page = $(this).attr("page");
    switch (page) {
      case "ADMIN-PROFILE":
        $(".".concat(ref)).attr("src", "assets/img/avatars/".concat(default_img));
        $(".file-input-image").val("");
        $(this).attr("hidden", true);
        $(".size-preview").html("Size: <i class='bx bx-check text-success'></i>");
        break;
      case "SETTINGS_LOGO":
        $(".".concat(ref)).attr("src", "assets/img/system/".concat(default_img_logo));
        $(".file-input-image").val("");
        $(this).attr("hidden", true);
        $(".size-preview-logo").html("Size: <i class='bx bx-check text-success'></i>").append(default_img);
        break;
      case "SETTINGS_ICON":
        $(".".concat(ref)).attr("src", "assets/img/system/".concat(default_img_icon));
        $(".file-input-image").val("");
        $(this).attr("hidden", true);
        $(".size-preview-icon").html("Size: <i class='bx bx-check text-success'></i>");
        break;
      case "SHOP-PRODUCT":
        $(".".concat(ref)).attr("src", "assets/img/products/".concat(default_img_product));
        $(".file-input-image").val("");
        $(this).attr("hidden", true);
        $(".size-preview").html("Size: <i class='bx bx-check text-success'></i>");
        break;
      case "ADD-PRODUCT":
        $(".".concat(ref)).attr("src", "assets/img/products/default.png");
        $(".file-input-image").val("");
        $(this).attr("hidden", true);
        $(".size-preview").html("Size: <i class='bx bx-check text-success'></i>");
        break;
      case "BRAND":
        $(".".concat(ref)).attr("src", "assets/img/brands/".concat(default_img_brand));
        $(".file-input-image").val("");
        $(this).attr("hidden", true);
        $(".size-preview").html("Size: <i class='bx bx-check text-success'></i>");
        break;
      case "ADD-BRAND":
        $(".".concat(ref)).attr("src", "assets/img/brands/brand-image.png");
        $(".file-input-image").val("");
        $(this).attr("hidden", true);
        $(".size-preview").html("Size: <i class='bx bx-check text-success'></i>");
        break;
    }
  });
});
