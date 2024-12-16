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
          <?php if ($_SESSION['user_details']['role'] == 1) { ?>

            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>attendance/view"
                aria-expanded="false"><i class="bi bi-calendar3-range"></i><span class="hide-menu">Log
                  View</span></a>
            </li>
          <?php } ?>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>attendance/slotview"
              aria-expanded="false"><i class="bi bi-calendar3-week"></i><span class="hide-menu">Slot
                View</span></a>
          </li>








          <?php if ($_SESSION['user_details']['role'] <= 2) { ?>

            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link"
                href="<?php echo $site_url ?>attendance/generate_pdf" aria-expanded="false"><i
                  class="bi bi-file-earmark-pdf"></i><span class="hide-menu">Generate PDF
                </span></a>
            </li>
          <?php } ?>

          <?php if ($_SESSION['user_details']['role'] == 1) { ?>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>attendance/pdf"
              aria-expanded="false"><i class="bi bi-clipboard-check"></i><span class="hide-menu">Test
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

          <?php } ?>

          <?php if ($_SESSION['user_details']['role'] == 1) { ?>

          <li class="nav-small-cap">
            <i class="mdi mdi-dots-horizontal"></i>
            <span class="hide-menu">Manage</span>
          </li>


 

            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
              <i class="bi bi-book"></i>
                <span class="hide-menu">Subjek </span>
              </a>
              <ul aria-expanded="false" class="collapse  first-level">

                <li class="sidebar-item">
                  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>subjek/create"
                    aria-expanded="false"><span class="hide-menu">Create</span></a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>subjek/assignlist"
                    aria-expanded="false"><span class="hide-menu">Assign List</span></a>
                </li>
              </ul>
            </li>



 


            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
              <i class="bi bi-mortarboard"></i>
                <span class="hide-menu">Course </span>
              </a>
              <ul aria-expanded="false" class="collapse  first-level">

                <li class="sidebar-item">
                  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>course/create"
                    aria-expanded="false"><span class="hide-menu">Create</span></a>
                </li>

              </ul>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
              <i class="bi bi-clipboard"></i>
                <span class="hide-menu">Program </span>
              </a>
              <ul aria-expanded="false" class="collapse  first-level">

                <li class="sidebar-item">
                  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>program/create"
                    aria-expanded="false"><span class="hide-menu">Create</span></a>
                </li>

              </ul>
            </li>


            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
              <i class="ti-blackboard"></i>
                <span class="hide-menu">Class </span>
              </a>
              <ul aria-expanded="false" class="collapse  first-level">

                <li class="sidebar-item">
                  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>class/create"
                    aria-expanded="false"><span class="hide-menu">Create</span></a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="<?php echo $site_url ?>class/fingerprint" aria-expanded="false"><span
                      class="hide-menu">Fingerprint</span></a>
                </li>
              </ul>
            </li>


            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="bi bi-person"></i>
                <span class="hide-menu">Student </span>
              </a>
              <ul aria-expanded="false" class="collapse  first-level">
                <li class="sidebar-item">
                  <a href="<?php echo $site_url ?>student/enrollment" class="sidebar-link">
                    <!-- <i class="mdi mdi-book-multiple"></i> -->
                    <span class="hide-menu"> Enrollment </span>
                  </a>
                </li>
 
              </ul>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>sem/create"
                aria-expanded="false"><i class="bi bi-archive"></i><span class="hide-menu">Semester</span></a>
            </li>



          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>cuti/create"
              aria-expanded="false"><i class="bi bi-person-x"></i><span class="hide-menu">Cuti</span></a>
          </li>

          <?php } ?>

          <?php if ($_SESSION['user_details']['role'] == 1) { ?>

 

            
            <li class="sidebar-item">
              <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
              <i class="bi bi-fingerprint"></i>
                <span class="hide-menu">Fingerprint Device </span>
              </a>
              <ul aria-expanded="false" class="collapse  first-level">

                <li class="sidebar-item">
                  <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>fp/create"
                    aria-expanded="false"><span class="hide-menu">Create</span></a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="<?php echo $site_url ?>fp/settings" aria-expanded="false"><span
                      class="hide-menu">Settings</span></a>
                </li>
              </ul>
            </li>
          <?php } ?>

        <?php } ?>

        <li class="nav-small-cap">
          <i class="mdi mdi-dots-horizontal"></i>
          <span class="hide-menu">User</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo $site_url ?>profile"
            aria-expanded="false"><i class="bi bi-person"></i><span class="hide-menu">Profile</span></a>
        </li>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>