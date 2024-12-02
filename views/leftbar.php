<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
        <?php if ($_SESSION['user_details']['role'] != 4) { ?>

          <li class="nav-small-cap">
            <i class="mdi mdi-dots-horizontal"></i>
            <span class="hide-menu">Attendance</span>
          </li>
          
          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>attendance/view"
              aria-expanded="false"><i class="bi bi-calendar3-range"></i><span class="hide-menu">Log
                View</span></a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>attendance/slotview"
              aria-expanded="false"><i class="bi bi-calendar3-week"></i><span class="hide-menu">Slot
                View</span></a>
          </li>






          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>attendance/pdf"
              aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span class="hide-menu">Test
              </span></a>
          </li>



          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>attendance/generate_pdf"
              aria-expanded="false"><i class="bi bi-file-earmark-pdf"></i><span class="hide-menu">Generate PDF
              </span></a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>attendance/pdf3"
              aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span class="hide-menu">Test PDF
                Surat Amaran
              </span></a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>attendance/pdf4"
              aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span class="hide-menu">Test PDF
                JTP2
              </span></a>
          </li>
      


        <li class="nav-small-cap">
          <i class="mdi mdi-dots-horizontal"></i>
          <span class="hide-menu">Manage</span>
        </li>


        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>subjek/create"
            aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span
              class="hide-menu">Subjek</span></a>
        </li>


        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>course/create"
            aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span
              class="hide-menu">Course</span></a>
        </li>


        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>class/create"
            aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span
              class="hide-menu">Class</span></a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>class/enrollment"
            aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span
              class="hide-menu">Enrollment</span></a>
        </li>


        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>class/org"
            aria-expanded="false"><i class="bi bi-mortarboard"></i><span
              class="hide-menu">Student</span></a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>sem/create"
            aria-expanded="false"><i class="mdi mdi-comment-processing-outline"></i><span
              class="hide-menu">Semester</span></a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>cuti/create"
            aria-expanded="false"><i class="bi bi-person-x"></i><span
              class="hide-menu">Cuti</span></a>
        </li>


        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>fp/create"
            aria-expanded="false"><i class="bi bi-fingerprint"></i><span class="hide-menu">Fingerprint
              Device</span></a>
        </li>

        <?php } ?>

        <li class="nav-small-cap">
          <i class="mdi mdi-dots-horizontal"></i>
          <span class="hide-menu">User</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>profile"
            aria-expanded="false"><i class="bi bi-person"></i><span
              class="hide-menu">Profile</span></a>
        </li>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>