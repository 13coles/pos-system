<header class="header_area">
  <div class="header_top sticky-header">
    <div class="container">
      <div class="row align-items-center p-2">
        <div class="col-lg-4">
          <div class="welcome_text top_right">
            <ul>
              <li class="top_links">
                <span><i class="bx bx-bell pb-1"></i> <span class="badge bg-danger notif" style="position: absolute; top: -7px; left: 9px;"><?php echo $notification_ctr; ?></span></span>
                  <ul class="dropdown_links text-center" style="right: unset; left: 0; width: 23rem; max-height: 300px; overflow: hidden;">
                    <!-- Wrapper for scrollable notifications -->
                    <div class="notif-wrapper" style="overflow-y: auto; max-height: 250px;">
                      <span class="notif-body"></span>
                      <?php
                      $result_notif = $db->GR_notifications();
                      if (mysqli_num_rows($result_notif) > 0) {
                        while ($row_notif = mysqli_fetch_array($result_notif)) {
                      ?>
                          <li>
                            <div class="alert alert-warning">
                              <h6 class="alert-heading fw-bold mb-1 notif-title" style="letter-spacing: 1.5px;"><?php echo $row_notif['notif_name']; ?></h6>
                              <p class="mb-0 notif-message"><?php echo $row_notif['notif_desc']; ?></p>
                            </div>
                          </li>
                      <?php
                        }
                      }
                      ?>
                      <li class="notif-none" style="border-bottom: none;" <?php if ($notification_ctr == 0) {
                                                                          echo '';
                                                                        } else {
                                                                          echo 'hidden';
                                                                        } ?>>
                        <div class="alert alert-info">
                          <p class="mb-0">No new notifications.</p>
                        </div>
                      </li>
                    </div> <!-- End of notif-wrapper -->

                    <li class="notif-btn" <?php if ($notification_ctr == 0) {
                                              echo 'hidden';
                                            } ?>>
                      <a>
                        <form method="POST" action="controller.php?action=clear_notification&ref=<?php echo $page; ?>" style="display: inline-flex">
                          <button style="background: none; border: none; cursor: pointer" type="submit" name="logout">Clear notifications</button>
                        </form>
                      </a>
                    </li>
                  </ul>

              </li>
              <li class="top_links p-0">
                <img src="assets/img/avatars/<?php echo $admin_info['img_dir']; ?>" alt="system-logo" class="rounded" width="40" height="40">
              </li>
              <li class="top_links">Welcome,
                <span style="color: #ea0094"><?php echo $admin_info['name']; ?></span><i class="bx bx-caret-down zmdi"></i>
                <ul class="dropdown_links text-center">
                  <li class="<?php if ($page == 'my-profile') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="my-profile.php">My Profile</a></li>
                  <li>
                    <a href="logout">
                      <form method="POST" style="display: inline-flex">
                        <button style="background: none; border: none; cursor: pointer" type="submit" name="logout">Log Out</button>
                      </form>
                    </a>
                  </li>
                </ul>
              </li>

            </ul>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="top_right text-right">
            <ul>
              <li class="<?php if ($page == 'dashboard') {
                            echo 'active';
                          } else {
                            echo '';
                          } ?>">
                <a href="dashboard.php"><i class='bx bx-tachometer pb-1'></i> Dashboard</a>
              </li>
              <li class="top_links <?php if ($page == 'shop' || $page == 'pos' || $page == 'shop-product' || $page == 'generate-reports' || $page == 'sales') {
                                      echo 'active';
                                    } else {
                                      echo '';
                                    } ?>">
                <span><i class='bx bx-category-alt  pb-1'></i> Shop &amp; Management</span><i class="bx bx-caret-down zmdi"></i>
                <ul class="dropdown_links text-center">
                  <li class="<?php if ($page == 'shop') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="brand.php">Brands</a></li>
                  <li class="<?php if ($page == 'pos') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="pos.php">Point-Of-Sale</a></li>
                  <li class="<?php if ($page == 'shop-product') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="shop-product.php">Product management</a></li>
                  <li class="<?php if ($page == 'generate-reports') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="generate-reports.php">Generate QR</a></li>
                  <li class="<?php if ($page == 'sales') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="sales.php">Sales</a></li>
                  <li class="<?php if ($page == 'inventory') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="inventory.php">Inventory</a></li>
                </ul>
              </li>
              <li class="top_links <?php if ($page == 'user-profiles' || $page == 'settings' || $page == 'back-up') {
                                      echo 'active';
                                    } else {
                                      echo '';
                                    } ?>">
                <span><i class="bx bx-cog pb-1"></i> Settings</span><i class="bx bx-caret-down zmdi"></i>
                <ul class="dropdown_links text-center">
                  <li class="<?php if ($page == 'user-profiles') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="user-profiles.php">User profiles</a></li>
                  <!-- <li class="<?php if ($page == 'back-up') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="back-up.php">Back-up &amp; Restore</a></li> -->
                  <li class="<?php if ($page == 'settings') {
                                echo 'active';
                              } else {
                                echo '';
                              } ?>"><a href="settings.php">Page settings</a></li>
                </ul>
              </li>
              <li>
                <a>
                  <form method="POST" style="display: inline-flex">
                    <button style="background: none; border: none; cursor: pointer" type="submit" name="logout">
                      <i class="bx bx-log-out pb-1"></i> Log Out
                    </button>
                  </form>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>