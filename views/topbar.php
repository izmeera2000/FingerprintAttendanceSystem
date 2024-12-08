<header class="topbar">
  <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header">
      <!-- This is for the sidebar toggle which is visible on mobile only -->
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
        <i class="ri-close-line fs-6 ri-menu-2-line"></i>
      </a>
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->
      <div class="navbar-brand">
        <a href="<?php echo $site_url ?>dashboard" class="logo">
          <!-- Logo icon -->
          <b class="logo-icon">
            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
            <!-- Dark Logo icon -->
            <!-- <img src=" <?php echo $site_url ?>assets/images/logo-icon.png" alt="homepage" class="dark-logo" /> -->
            <!-- Light Logo icon -->
            <img src="<?php echo $site_url ?>assets/images/logo-w.png" alt="homepage" class="light-logo" />
          </b>
          <!--End Logo icon -->
          <!-- Logo text -->
          <span class="logo-text">
            <!-- dark Logo text -->
            <!-- <img src=" <?php echo $site_url ?>assets/images/logo-text.png" alt="homepage" class="dark-logo" /> -->
            <!-- Light Logo text -->
            <img src="<?php echo $site_url ?>assets/images/logo-w-text.png" class="light-logo" alt="homepage" />
            <!-- <p class="text-white light-logo">FINGERPRINT <br>ATTENDANCE SYSTEM</p> -->
          </span>
        </a>
        <a class="sidebartoggler d-none d-md-block" href="javascript:void(0)" data-sidebartype="mini-sidebar">
          <i class="mdi mdi-toggle-switch mdi-toggle-switch-on fs-6"></i>
        </a>
      </div>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Toggle which is visible on mobile only -->
      <!-- ============================================================== -->
      <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
        data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <i data-feather="more-horizontal" class="feather-sm"></i>
      </a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse collapse" id="navbarSupportedContent">
      <!-- ============================================================== -->
      <!-- toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav me-auto">
        <!-- <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li> -->
        <!-- ============================================================== -->
        <!-- Search -->
        <!-- ============================================================== -->
        <!-- <li class="nav-item search-box">
          <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
            <div class="d-flex align-items-center">
              <i data-feather="search" class="feather-sm me-1"></i>
              <div class="ms-1 d-none d-sm-block">
                <span>Search</span>
              </div>
            </div>
          </a>
          <form class="app-search position-absolute">
            <input type="text" class="form-control" placeholder="Search &amp; enter" />
            <a class="srh-btn">
              <i data-feather="x" class="feather-sm"></i>
            </a>
          </form>
        </li> -->
      </ul>
      <!-- ============================================================== -->
      <!-- Right side toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav">
        <!-- ============================================================== -->
        <!-- Messages -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End Messages -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Comment -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown border-end">
          <a class="
                    nav-link
                    dropdown-toggle
                    waves-effect waves-dark
                    position-relative
                  " href="index.html" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i data-feather="bell"></i>
            <span class="badge rounded-pill bg-info noti">3</span>
          </a>
          <div class="
                    dropdown-menu dropdown-menu-end
                    mailbox
                    dropdown-menu-animate-up
                  ">
            <span class="with-arrow">
              <span class="bg-primary"></span>
            </span>
            <ul class="list-style-none">
              <li>
                <div class="drop-title bg-primary text-white">
                  <h4 class="mb-0 m-t-5">4 New</h4>
                  <span class="fw-light">Notifications</span>
                </div>
              </li>
              <li>
                <div class="message-center notifications position-relative" style="height: 230px">
                  <!-- Message -->
                  <a href="javascript:void(0)" class="
                            message-item
                            d-flex
                            align-items-center
                            border-bottom
                            px-3
                            py-2
                          ">
                    <span class="btn btn-light-danger text-danger btn-circle">
                      <i data-feather="link" class="feather-sm fill-white"></i>
                    </span>
                    <div class="w-75 d-inline-block v-middle ps-3">
                      <h5 class="
                                message-title
                                mb-0
                                mt-1
                                fs-3
                                font-weight-medium
                              ">
                        Luanch Admin
                      </h5>
                      <span class="
                                fs-2
                                text-nowrap
                                d-block
                                time
                                text-truncate
                                fw-normal
                                text-muted
                                mt-1
                              ">Just see the my new admin!</span>
                      <span class="
                                fs-2
                                text-nowrap
                                d-block
                                subtext
                                text-muted
                              ">9:30 AM</span>
                    </div>
                  </a>
                  <!-- Message -->
                  <a href="javascript:void(0)" class="
                            message-item
                            d-flex
                            align-items-center
                            border-bottom
                            px-3
                            py-2
                          ">
                    <span class="
                              btn btn-light-success
                              text-success
                              btn-circle
                            ">
                      <i data-feather="calendar" class="feather-sm fill-white"></i>
                    </span>
                    <div class="w-75 d-inline-block v-middle ps-3">
                      <h5 class="
                                message-title
                                mb-0
                                mt-1
                                fs-3
                                font-weight-medium
                              ">
                        Event today
                      </h5>
                      <span class="
                                fs-2
                                text-nowrap
                                d-block
                                time
                                text-truncate
                                fw-normal
                                text-muted
                                mt-1
                              ">Just a reminder that you have event</span>
                      <span class="
                                fs-2
                                text-nowrap
                                d-block
                                subtext
                                text-muted
                              ">9:10 AM</span>
                    </div>
                  </a>
                  <!-- Message -->
                  <a href="javascript:void(0)" class="
                            message-item
                            d-flex
                            align-items-center
                            border-bottom
                            px-3
                            py-2
                          ">
                    <span class="btn btn-light-info text-info btn-circle">
                      <i data-feather="settings" class="feather-sm fill-white"></i>
                    </span>
                    <div class="w-75 d-inline-block v-middle ps-3">
                      <h5 class="
                                message-title
                                mb-0
                                mt-1
                                fs-3
                                font-weight-medium
                              ">
                        Settings
                      </h5>
                      <span class="
                                fs-2
                                text-nowrap
                                d-block
                                time
                                text-truncate
                                fw-normal
                                text-muted
                                mt-1
                              ">You can customize this</span>
                      <span class="
                                fs-2
                                text-nowrap
                                d-block
                                subtext
                                text-muted
                              ">9:08 AM</span>
                    </div>
                  </a>
                  <!-- Message -->
                  <a href="javascript:void(0)" class="
                            message-item
                            d-flex
                            align-items-center
                            border-bottom
                            px-3
                            py-2
                          ">
                    <span class="
                              btn btn-light-primary
                              text-primary
                              btn-circle
                            ">
                      <i data-feather="users" class="feather-sm fill-white"></i>
                    </span>
                    <div class="w-75 d-inline-block v-middle ps-3">
                      <h5 class="
                                message-title
                                mb-0
                                mt-1
                                fs-3
                                font-weight-medium
                              ">
                        Pavan kumar
                      </h5>
                      <span class="
                                fs-2
                                text-nowrap
                                d-block
                                time
                                text-truncate
                                fw-normal
                                text-muted
                                mt-1
                              ">Just see the my admin!</span>
                      <span class="
                                fs-2
                                text-nowrap
                                d-block
                                subtext
                                text-muted
                              ">9:02 AM</span>
                    </div>
                  </a>
                </div>
              </li>
              <li>
                <a class="nav-link text-center mb-1 text-dark" href="javascript:void(0);">
                  <strong>Check all notifications</strong>
                  <i data-feather="chevron-right" class="feather-sm"></i>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <!-- ============================================================== -->
        <!-- End Comment -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown">
          <a class="
                    nav-link
                    dropdown-toggle
                    waves-effect waves-dark
                    pro-pic
                  " href="javascript:void(0)" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img
                  src="<?php echo $site_url ?>assets/images/user/<?php echo $_SESSION['user_details']['id'] ?>/<?php echo $_SESSION['user_details']['image_url']; ?>"
                  alt="user" class="rounded-circle object-fit-cover" width="40" height="40"
                  onerror="this.onerror=null; this.src='<?php echo $site_url; ?>assets/images/user/0.jpg';" />
            <span
              class="ms-1 font-weight-medium d-none d-sm-inline-block"><?php echo $_SESSION['user_details']['nama'] ?>
              <i data-feather="chevron-down" class="feather-sm"></i></span>
          </a>
          <div class="
                    dropdown-menu dropdown-menu-end
                    user-dd
                    animated
                    flipInY
                  ">
            <span class="with-arrow">
              <span class="bg-primary"></span>
            </span>
            <div class="
                      d-flex
                      no-block
                      align-items-center
                      p-3
                      bg-primary
                      text-white
                      mb-2
                    ">
              <div class="">
                <img
                  src="<?php echo $site_url ?>assets/images/user/<?php echo $_SESSION['user_details']['id'] ?>/<?php echo $_SESSION['user_details']['image_url']; ?>"
                  alt="user" class="rounded-circle object-fit-cover" width="100" height="100"
                  onerror="this.onerror=null; this.src='<?php echo $site_url; ?>assets/images/user/0.jpg';" />
              </div>
              <div class="ms-2">
                <h4 class="mb-0 text-white"><?php echo $_SESSION['user_details']['nama'] ?></h4>
                <p class="mb-0"><?php echo $_SESSION['user_details']['email'] ?></p>
              </div>
            </div>
            <a class="dropdown-item" href="<?php echo $site_url ?>profile"><i data-feather="user"
                class="feather-sm text-info me-1 ms-1"></i>
              My Profile</a>
            <!-- <a class="dropdown-item" href="index.html#"><i data-feather="credit-card"
                class="feather-sm text-info me-1 ms-1"></i>
              My Balance</a>
            <a class="dropdown-item" href="index.html#"><i data-feather="mail"
                class="feather-sm text-success me-1 ms-1"></i>
              Inbox</a> -->
            <!-- <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="index.html#"><i data-feather="settings"
                class="feather-sm text-warning me-1 ms-1"></i>
              Account Setting</a> -->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo $site_url ?>logout"><i data-feather="log-out"
                class="feather-sm text-danger me-1 ms-1"></i>
              Logout</a>
            <div class="dropdown-divider"></div>
            <!-- <div class="p-2">
              <a href="<?php echo $site_url ?>profile" class="btn d-block w-100 btn-primary rounded-pill">View
                Profile</a>
            </div> -->
          </div>
        </li>
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
      </ul>
    </div>
  </nav>
</header>