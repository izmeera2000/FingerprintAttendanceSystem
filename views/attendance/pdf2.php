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
      <?php
      renderBreadcrumb($pagetitle, $breadcrumbs); // Use the global breadcrumbs variable
      ?>
      <!-- ============================================================== -->
      <!-- End Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Container fluid  -->
      <!-- ============================================================== -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
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

                    "SELECT b.id, b.nama FROM user_enroll a
                    INNER JOIN course b ON b.id = a.course_id
                    WHERE user_status = 1
                    GROUP BY b.nama;";

                  $results2 = mysqli_query($db, $query);

                  while ($row = mysqli_fetch_assoc($results2)) {
                    $nama = $row['nama'];
                    $id = $row['id'];

                    echo "<option value='$id'>$nama</option>";

                  }
                  ?>
                </select>


                <label for="sem">Semester</label>

                <select name="sem" id="sem">
                  <!-- <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option> -->
                  <?php

                  $query =

                    "SELECT b1.nama AS sem_start2, b2.nama AS sem_now2 FROM user_enroll a 
                    INNER JOIN sem b1 ON b1.id = a.sem_start 
                    INNER JOIN sem b2 ON b2.id = a.sem_now 
                    WHERE user_status = 1
                    GROUP BY b1.nama, b2.nama;";

                  $results2 = mysqli_query($db, $query);

                  while ($row = mysqli_fetch_assoc($results2)) {
                    // $nama = $row['nama'];
                  
                    $currentIndex = calculateSemesterIndex($row['sem_start2'], $row['sem_now2']);
                    $sem_start = $row['sem_start2'];
                    echo "<option value='$sem_start'>$currentIndex</option>";

                  }


                  ?>


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
                <?php
                var_dump(getWeekRangeOfMonth(12, 2024, 2));
                echo json_encode($events);

                ?>

                <button type="submit" name="get_pdf">Generate PDF</button>
              </form>




            </div>

          </div>
          <!-- <div class="card">
              </div> -->
          <?php if (isset($_POST['get_pdf'])) { ?>

            <div class="col-12 ">
              <div class="card " style='height: 75vh ; overflow: hidden; '>
                <iframe src="<?php echo $site_url ?>test.pdf" width="100%" height="100%"></iframe>
              </div>
            </div>
          <?php } ?>


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