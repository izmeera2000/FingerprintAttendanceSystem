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
            <h4 class="page-title">Test PDF 2</h4>
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
              <form action="" method="POST">
                <label for="kursus">Kursus</label>

                <select name="kursus" id="kursus">
                  <!-- <option value="volvo">Volvo</option>
                  <option value="saab">Saab</option>
                  <option value="mercedes">Mercedes</option>
                  <option value="audi">Audi</option> -->


                  <?php

                  $query =

                    "SELECT * FROM course ";

                  $results2 = mysqli_query($db, $query);

                  while ($row = mysqli_fetch_assoc($results2)) {
                    $nama = $row['nama'];

                    echo "<option value='$nama'>$nama</option>";

                  }
                  ?>
                </select>


                <label for="sem">Semester</label>

                <select name="sem" id="sem">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>


                </select>


                <label for="year">Tahun</label>

                <select name="year" id="year">

                  <?php

                  $query =

                    "SELECT DISTINCT YEAR(tarikh) AS year FROM attendance_slot ORDER BY year DESC;";

                  $results2 = mysqli_query($db, $query);

                  while ($row = mysqli_fetch_assoc($results2)) {
                    $year = $row['year'];

                    echo "<option value='$year'>$year</option>";

                  }
                  ?>
                </select>



                <label for="month">Bulan</label>

                <select name="month" id="month">

                  <?php

                  $query =

                    "SELECT DISTINCT MONTH(tarikh) AS month FROM attendance_slot ORDER BY month DESC;";

                  $results2 = mysqli_query($db, $query);

                  while ($row = mysqli_fetch_assoc($results2)) {
                    $month = $row['month'];

                    echo "<option value='$month'>$month</option>";

                  }
                  ?>
                </select>


                <label for="week">Minggu</label>

                <select name="week" id="week">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>



                </select>


                <button type="submit" name="get_pdf">Generate PDF</button>
              </form>



              <div class="card">
                <iframe src="<?php echo $site_url ?>test.pdf" width="100%" height="600px"></iframe>
              </div>

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