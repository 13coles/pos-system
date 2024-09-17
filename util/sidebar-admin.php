<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="index.php" class="app-brand-link">
      <img src="assets/img/system/<?php echo $system_info['system_logo']; ?>" width="60">
      <span class="app-brand-text demo menu-text fw-bolder ms-2"><?php echo $system_info['system_title']; ?></span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-3">
    <!-- Dashboard -->
    <li class="menu-item <?php if($page == 'admin-dashboard') {echo 'active';} else {echo '';} ?>">
      <a href="admin-dashboard.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <!-- Layouts -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Pages</span>
    </li>
    <li class="menu-item <?php if($page == 'pages-admin-records-profiles') {echo 'open';} else {echo '';} ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-archive"></i>
        <div data-i18n="Authentications">Records</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item <?php if($page == 'pages-admin-records-profiles') {echo 'active';} else {echo '';} ?>">
          <a href="pages-admin-records-profiles.php" class="menu-link">
            <div data-i18n="Basic">Patient profile</div>
          </a>
        </li>
      </ul>
    </li> 
    <!-- Accounts &amp; Security -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Accounts &amp; Security</span></li>
    <li class="menu-item <?php if($page == 'pages-admin-myProfile' || $page == 'pages-admin-account-connections') {echo 'open';} else {echo '';} ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons bx bxs-user-account'></i>
        <div data-i18n="Account Settings">My account</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item <?php if($page == 'pages-admin-myProfile') {echo 'active';} else {echo '';} ?>">
          <a href="pages-admin-myProfile.php" class="menu-link">
            <div data-i18n="Account">My profile</div>
          </a>
        </li>
        <li class="menu-item <?php if($page == 'pages-admin-account-connections') {echo 'active';} else {echo '';} ?>">
          <a href="pages-admin-account-connections.php" class="menu-link">
            <div data-i18n="Connections">Connections</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item <?php if($page == 'accounts-security-admin-accounts') {echo 'active';} else {echo '';} ?>">
      <a href="accounts-security-admin-accounts.php" class="menu-link">
        <i class='menu-icon tf-icons bx bx-lock'></i>
        <div data-i18n="Basic">User accounts</div>
      </a>
    </li>
    <!-- Misc -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
    <li class="menu-item">
      <a
        href="https://www.facebook.com/Kiryu.Haruka0"
        target="_blank"
        class="menu-link"
      >
        <i class="menu-icon tf-icons bx bx-support"></i>
        <div data-i18n="Support">Support</div>
      </a>
    </li>
    <li class="menu-item <?php if($page == 'misc-back-up') {echo 'active';} else {echo '';} ?>">
      <a href="misc-back-up.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-data"></i>
        <div data-i18n="Documentation">Back-up data</div>
      </a>
    </li>
    <li class="menu-item <?php if($page == 'admin-settings') {echo 'active';} else {echo '';} ?>">
      <a href="admin-settings.php" class="menu-link">
        <i class='menu-icon tf-icons bx bx-cog' ></i>
        <div data-i18n="Basic">Settings</div>
      </a>
    </li>
  </ul>
</aside>