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
              <form action="" method="POST" id="generatePDFForm">
                <label for="kursus">Kursus</label>
                <input type="hidden" name="get_pdf" value="1">
                <select name="kursus" id="kursus">



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


                <button type="button" id="generatePDFButton">Generate PDF</button>
              </form>




            </div>

          </div>


          <div class="col-12">
            <div class="card  d-none " style='height: 75vh ; overflow: hidden; '>
              <iframe src=" " width="100%" height="100%" id="test"></iframe>
            </div>
          </div>




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
  <script>

    $(document).ready(function () {
      $('#generatePDFButton').click(function () {
        // Serialize form data
        const formData = $('#generatePDFForm').serialize();  // Using serializeArray() instead of serialize()




        // Send AJAX request
        $.ajax({
          url: 'get_pdf', // Your PHP script to generate the PDF
          method: 'POST',
          data: formData,
          success: function (response) {
            console.log(response);
            const pdfFilePath = response;

            // Set the iframe's src to the generated PDF file path
            $('#test').attr('src', pdfFilePath);
            $('#test').parent().removeClass('d-none');  // Remove the 'd-none' class from the parent of #test

          },
          error: function (xhr, status, error) {
            // Handle errors
            console.error('Error generating PDF:', error);
            // alert('An error occurred while generating the PDF.');
          },
        });
      });
    });

  </script>
</body>

</html>