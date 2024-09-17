<div class="off_canvars_overlay">

</div>
<div class="Offcanvas_menu pt-2">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="canvas_open">
          <span>MENU</span>
          <a href="javascript:void(0)"><i class="bx bx-menu pb-1"></i></a>
        </div>
        <div class="Offcanvas_menu_wrapper">
          <div class="canvas_close">
            <a href="javascript:void(0)"><i class="bx bx-x pb-1"></i></a>
          </div>
          <div class="welcome_text pb-2">
            <p>Welcome, <span><?php echo $admin_info['name']; ?></span> </p>
            <p><img class="rounded" src="assets/img/avatars/<?php echo $admin_info['img_dir']; ?>" width="60" height="60"></p>
          </div>

          <div id="menu" class="text-left ">
            <ul class="offcanvas_main_menu">
              <li class="menu-item-has-children <?php if ($page == 'dashboard') {
                                                  echo 'active';
                                                } else {
                                                  echo '';
                                                } ?>">
                <a href="dashboard.php"><i class='bx bx-tachometer pb-1'></i> Dashboard</a>
              </li>
              <li class="menu-item-has-children">
                <a href="#"><i class='bx bx-category-alt  pb-1'></i> Shop management </a>
                <ul class="sub-menu">
                  <li><a href="brand.php">Brands</a></li>
                  <li><a href="pos.php">Point-Of-Sale</a></li>
                  <li><a href="shop-product.php">Product Management</a></li>
                  <li><a href="generate-reports.php">Generate QR</a></li>
                  <li><a href="sales.php">Sales</a></li>
                </ul>
              </li>
              <li class="menu-item-has-children">
                <a href="#"><i class="bx bx-cog pb-1"></i> Settings </a>
                <ul class="sub-menu">
                  <li><a href="user-profiles.php">User Profiles</a></li>
                  <!-- <li><a href="back-up.php">Back-up &amp; Restore</a></li> -->
                  <li><a href="settings.php">Page Settings</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="Offcanvas_footer">
            <form method="POST" style="display: inline-flex">
              <button style="background: none; border: none; cursor: pointer" type="submit" name="logout">
                <i class="bx bx-log-out pb-1"></i> Log Out
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>