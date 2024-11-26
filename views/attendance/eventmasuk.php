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
              <form action="eventmasuk" method="POST">


                <button type="submit" name="eventmasuk">asdasd</button>
              </form>
              <p>
                <?php
                $weekRange = getWeekRangeOfMonth(11, 2024, 5);
                // debug_to_console($startDate);
                
                $startDate = $weekRange['start_date'];
                $endDate = $weekRange['end_date'];
                $students_attendance = [];

                $query =

                  "SELECT a.*, b.masa_mula, b.masa_tamat, c.nama, c.role, c.ndp
            FROM attendance_slot a
            INNER JOIN time_slot b ON a.slot = b.slot
            INNER JOIN user c ON c.id = a.user_id
            WHERE c.role = 4
            AND a.slot NOT IN ('rehat1', 'rehat2')
            AND a.tarikh BETWEEN '$startDate' AND '$endDate'
            ORDER BY a.slot ASC";
    $timeslot = ["1", "2", "3", "4", "5"];


                $results2 = mysqli_query($db, $query);

                while ($row = mysqli_fetch_assoc($results2)) {
                  $user_id = $row['user_id']; // Group by user_id
                
                  // Store student's information
                  $students_attendance[$user_id]['info'] = [
                    'nama' => strtoupper($row['nama']),
                    'ndp' => $row['ndp']
                  ];

                  if (!isset($students_attendance[$user_id]['attendance'][$row['tarikh']])) {
                    $students_attendance[$user_id]['attendance'][$row['tarikh']] = [];
                  }

                  // Append the attendance record grouped by date
                  $students_attendance[$user_id]['attendance'][$row['tarikh']][] = [
                    'slot' => $row['slot'],
                    'slot_status' => $row['slot_status']
                  ];
                }

                $dates = getDatesFromRange($startDate, $endDate);
                // echo $startDate;
                // echo $endDate;
                // $students_attendance = [];
                $dayslot = count(value: $dates);
                $slottotal = $dayslot * count($timeslot);
                // var_dump($students_attendance);
                
                $d = 0;

                foreach ($students_attendance as $student_id => $data) {

                  // echo "Processing student ID: $student_id\n";
                
                  $asd = $d + 1;



                  $slot_takhadir = 0;
                  foreach ($dates as $date) {

                    // echo $date;
                    var_dump($data['attendance']);
                    foreach ($timeslot as $slot) {
                      // $tableB->easyCell("yrst", ';align:C;valign:M');'
                      echo $date;
                      $attendance = $data['attendance'][$date] ?? null; // Get attendance for the specific date
                      // echo "Checking attendance for date $date, slot $slot\n";
                      $slot_found = false;
                      if ($attendance) {
                        foreach ($attendance as $att) {
                            // Check the slot status and add the correct symbol
                             switch ($att['slot_status']) {
                              case 0:
                              case 2:
                              case 3:
                              case 5:
                                echo "0";

                                // $tableB->easyCell("0", ';align:C;valign:M');
                                $slot_takhadir++;
                                break;
                              case 4:
                                echo "k";

                                // $tableB->easyCell("K", ';align:C;valign:M');
                                break;
                              case 7:
                                echo "z";

                                // $tableB->easyCell("Z", ';align:C;valign:M');
                                break;
                              default:
                                echo "/";

                              // $tableB->easyCell("/", ';align:C;valign:M');
                            
                            $slot_found = true;
                            break;
                          }
                        }
                      }
                      if (!$slot_found) {
                        // $tableB->easyCell("a", ';align:C;valign:M');
                        echo "a";
                        $slot_takhadir++;
                      }

                    }


                  }








                  $d = $d + 1;

                }


                ?>
              </p>
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