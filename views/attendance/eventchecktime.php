<?php include(getcwd() . '/admin/server.php');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<?php include(getcwd() . '/views/head.php'); ?>


<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <?php include(getcwd() . '/views/preloader.php'); ?>

  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <?php include(getcwd() . '/views/topbar.php'); ?>

    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <?php include(getcwd() . '/views/leftbar.php'); ?>

    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-5 align-self-center">
            <h4 class="page-title">Dashboard</h4>
          </div>
          <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="index.html#">Home</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Dashboard
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- End Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Container fluid  -->
      <!-- ============================================================== -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">



              <p>function to check time (8:10)</p>
              <!-- <form action="eventchecktime" method="POST">


                <button type="submit" name="eventcheck">asdasd</button>
              </form> -->


              <?php


              $slot_statuses = [
                0 => "Unattended / Unexcused Absence",
                1 => "Present",
                2 => "Late",
                3 => "Pending Excuse of Absence",
                4 => "Excused Absence",
                5 => "Left Early",
                6 => "Break",
                7 => "Not Yet",

              ];

              // $start_timeb = microtime(true);
              
              $time_slots = []; // Initialize an empty array
              $time_limit = 50;
              $nowdate = date('Y-m-d');
              $now = new DateTime();
              $now2 = $now->format('Y-m-d H:i:s');

              $query = "SELECT * FROM time_slot ORDER BY id ASC";
              $results = mysqli_query($db, $query);
              while ($row = mysqli_fetch_assoc($results)) {
                $time_slots[] = $row;
              }



              $query = "SELECT a.*,b.role FROM attendance a INNER JOIN user b ON b.id = a.user_id WHERE DATE(masa_mula) = CURDATE()  AND `role`='4'";
              $results = mysqli_query($db, $query);

              while ($row = $results->fetch_assoc()) {
                $id = $row['user_id'];

                $masa_mula = new DateTime($row['masa_mula']);
                $masa_tamat = !empty($row['masa_tamat']) ? new DateTime($row['masa_tamat']) : new DateTime(); // Use current time if masa_tamat is empty
              
                // Loop through the time slots
                foreach ($time_slots as $time_slot) {
                  $start_time = new DateTime($nowdate . ' ' . $time_slot['masa_mula']);
                  $end_time = new DateTime($nowdate . ' ' . $time_slot['masa_tamat']);
                  $slot_name = $time_slot['slot'];


                  $late_time = clone $start_time; // Clone the start time to avoid modifying the original
                  $late_time->modify('+10 minutes'); // Add 10 minutes to the start time
              
                  // Check for overlap
                  if ($masa_mula < $end_time && $masa_tamat > $start_time) {
                    $overlap_start = max($masa_mula->getTimestamp(), $start_time->getTimestamp());
                    $overlap_end = min($masa_tamat->getTimestamp(), $end_time->getTimestamp());

                    // Calculate duration in minutes
                    $overlap_duration = ceil(($overlap_end - $overlap_start) / 60); // Convert seconds to minutes
              
                    $interval = $start_time->diff($end_time);

                    $supposed_time = ($interval->h * 60) + $interval->i;


                    // Switch case to determine slot status
                    switch (true) {
                      case ($masa_mula > $late_time):
                        // Attendance is more than 10 minutes past the start time
                        // echo "Attendance from {$row['masa_mula']} to {$masa_tamat->format('Y-m-d H:i:s')} .<br>";
              
                        $slot_status = 2; // Late
                        break;

                      case ($overlap_duration < ($supposed_time - 10)):
                        $slot_status = 5; // Left  Early
                        break;

                      // case ($masa_tamat < $end_time):
                      //   // Attendance ends before the time slot ends
                      //   $slot_status = 5; // Leave or another appropriate status
                      //   break;
              
                      case ($slot_name == "rehat1" || $slot_name == "rehat2"):
                        $slot_status = 6; // rehat
                        break;

                      default:
                        // Default case for on-time attendance
                        $slot_status = 1; // Present
                        break;
                    }



                  } else {
                    // No overlap case
              
                    if ($now < $start_time) {
                      $slot_status = 7; // rehat
              
                    } else {

                      $slot_status = 0; // Unattended
                    }

                    if ($slot_name == "rehat1" || $slot_name == "rehat2") {
                      $slot_status = 6; // rehat
              
                    }
                  }

                  $query2 = "INSERT INTO attendance_slot (user_id, slot, slot_status, tarikh)
                       VALUES ('$id', '$slot_name', '$slot_status', '$nowdate')
                       ON DUPLICATE KEY UPDATE
                           slot_status = CASE 
                               WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(slot_status)
                               ELSE slot_status
                           END,
                           tarikh = CASE 
                               WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(tarikh)
                               ELSE tarikh
                           END";
                  $results2 = mysqli_query($db, $query2);

                  // echo " $supposed_time min<br>";
                  if (!$results2) {
                    // Query failed, output the error message
                    die("Error in query: " . mysqli_error($db));
                  } else {
                    $start_time2 = $start_time->format('Y-m-d H:i:s');
                    $end_time2 = $end_time->format('Y-m-d H:i:s');
                    $masa_tamat2 = $masa_tamat->format('Y-m-d H:i:s');
                    $masa_mula2 = $masa_mula->format('Y-m-d H:i:s');
                    echo " $slot_status  $slot_name  ($masa_mula2 < $end_time2 && $masa_tamat2 > $start_time2 ) <br> ";
                  }


                }

              }

              $query = "SELECT s.id, s.role 
              FROM user s 
              LEFT JOIN attendance a 
              ON s.id = a.user_id 
              AND DATE(a.masa_mula) = CURDATE() 
              WHERE a.user_id IS NULL 
              AND s.role = '4'";

              $results = mysqli_query($db, $query);

              while ($row = $results->fetch_assoc()) {
                foreach ($time_slots as $time_slot) {
                  $start_time = new DateTime($nowdate . ' ' . $time_slot['masa_mula']);
                  $end_time = new DateTime($nowdate . ' ' . $time_slot['masa_tamat']);
                  $slot_name = $time_slot['slot'];

                  if ($now < $start_time) {
                    $slot_status = 7;  // Not yet
                  } else {
                    $slot_status = 0;  // Unattended
                  }

                  if ($slot_name == "rehat1" || $slot_name == "rehat2") {
                    $slot_status = 6;  // Break
                  }

                  $id = $row['id'];

                  $query2 = "INSERT INTO attendance_slot (user_id, slot, slot_status, tarikh)
                       VALUES ('$id', '$slot_name', '$slot_status', '$nowdate')
                       ON DUPLICATE KEY UPDATE
                           slot_status = CASE 
                               WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(slot_status)
                               ELSE slot_status
                           END,
                           tarikh = CASE 
                               WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(tarikh)
                               ELSE tarikh
                           END";

                  $results2 = mysqli_query($db, $query2);
                }
              }



              ?>
            
          </div>
            <!-- BEGIN MODAL -->
            <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">
                      Add / Edit Event
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="">
                          <label class="form-label">Event Title</label>
                          <input id="event-title" type="text" class="form-control" />
                        </div>
                      </div>
                      <div class="col-md-12 mt-4">
                        <div><label class="form-label">Event Color</label></div>
                        <div class="d-flex">
                          <div class="n-chk">
                            <div class="form-check form-check-primary form-check-inline">
                              <input class="form-check-input" type="radio" name="event-level" value="Danger"
                                id="modalDanger" />
                              <label class="form-check-label" for="modalDanger">Danger</label>
                            </div>
                          </div>
                          <div class="n-chk">
                            <div class="form-check form-check-warning form-check-inline">
                              <input class="form-check-input" type="radio" name="event-level" value="Success"
                                id="modalSuccess" />
                              <label class="form-check-label" for="modalSuccess">Success</label>
                            </div>
                          </div>
                          <div class="n-chk">
                            <div class="form-check form-check-success form-check-inline">
                              <input class="form-check-input" type="radio" name="event-level" value="Primary"
                                id="modalPrimary" />
                              <label class="form-check-label" for="modalPrimary">Primary</label>
                            </div>
                          </div>
                          <div class="n-chk">
                            <div class="form-check form-check-danger form-check-inline">
                              <input class="form-check-input" type="radio" name="event-level" value="Warning"
                                id="modalWarning" />
                              <label class="form-check-label" for="modalWarning">Warning</label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 d-none">
                        <div class="">
                          <label class="form-label">Enter Start Date</label>
                          <input id="event-start-date" type="text" class="form-control" />
                        </div>
                      </div>

                      <div class="col-md-12 d-none">
                        <div class="">
                          <label class="form-label">Enter End Date</label>
                          <input id="event-end-date" type="text" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                      Close
                    </button>
                    <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">
                      Update changes
                    </button>
                    <button type="button" class="btn btn-primary btn-add-event">
                      Add Event
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- END MODAL -->
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- End Container fluid  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- footer -->
      <!-- ============================================================== -->
      <?php include(getcwd() . '/views/footer.php'); ?>

      <!-- ============================================================== -->
      <!-- End footer -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- customizer Panel -->
  <!-- ============================================================== -->

  <div class="chat-windows"></div>
  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <?php include(getcwd() . '/views/script.php'); ?>

</body>

</html>