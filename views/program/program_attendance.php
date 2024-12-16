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
          <div class="col-md-12">
            <div class="card">
              <!-- <div class="border-bottom title-part-padding">
                  <h4 class="card-title mb-0">Create Class</h4>
                </div> -->
              <div class="card-body">
                <!-- <h6 class="card-subtitle mb-3">
                    DataTables has most features enabled by default, so all you
                    need to do to use it with your own tables is to call the
                    construction function:<code> $().DataTable();</code>. You
                    can refer full documentation from here
                    <a href="https://datatables.net/">Datatables</a>
                  </h6> -->
                <div class="d-flex flex-row-reverse p-2 ">
                  <button type="button" class="btn waves-effect waves-light btn-rounded btn-primary "
                    id="buttonscanqr">Scan</button>
                  <!-- <button type="button"
                    class="btn waves-effect waves-light btn-rounded btn-secondary">Secondary</button>
                  <button type="button" class="btn waves-effect waves-light btn-rounded btn-success">Success</button>
                  <button type="button" class="btn waves-effect waves-light btn-rounded btn-info">Info</button>
                  <button type="button" class="btn waves-effect waves-light btn-rounded btn-warning">Warning</button>
                  <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger">Danger</button>
                  <button type="button" class="btn waves-effect waves-light btn-rounded btn-light">Light</button>
                  <button type="button" class="btn waves-effect waves-light btn-rounded btn-dark">Dark</button> -->
                </div>

                <div class="row">

                  <div class="table-responsive">
                    <table id="program_create" class="table  table-bordered text-nowrap">
                      <thead>
                        <!-- start row -->
                        <tr>
                          <th>Nama</th>
                          <th>Student</th>
                          <th>Tarikh</th>
                          <th>Created By</th>
                          <th>Action</th>
                          <!-- <th>Start date</th>
                          <th>Salary</th> -->
                        </tr>
                        <!-- end row -->
                      </thead>
                      <tbody>

                      </tbody>

                    </table>
                  </div>

                </div>

              </div>
            </div>

          </div>
          <!-- BEGIN MODAL -->
          <?php include(getcwd() . '/views/modals.php'); ?>

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
  <script src="<?php echo $site_url ?>assets/vendor/jsQR/dist/jsQR.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {

      // Initialize DataTable
      var dt1 = $('#program_create').DataTable({
        scrollY: 600,  // Adjust table height
        fixedHeader: {
          header: true,
          headerOffset: 150  // Adjust if there's a fixed navbar, change the offset accordingly
        },
        ajax: {
          type: "POST",
          url: "program_findall",
          data: function (d) {
            console.log(d);
            return {
              program_findall: {
                limit: d.length,
                offset: d.start,
                draw: d.draw,
                search: d.search.value,
              },
            };
          },
        },
        "drawCallback": function (settings) {
          // Here the response
          var response = settings.json;
          console.log(response);
        },
        columns: [
          { data: "a", className: "text-center" },
          {
            data: "id",  // Assuming `id` is the unique identifier for the program
            className: "text-center",  // Align the content in the center
            responsivePriority: 1,     // Make this column more important for responsiveness
            render: function (data, type, row, meta) {
              // Check if courses_sems exists and is an object
              let courseHtml = '';

              if (row.courses_sems && typeof row.courses_sems === 'object') {
                // Loop through each course and its associated semesters
                for (let course in row.courses_sems) {
                  if (row.courses_sems.hasOwnProperty(course)) {
                    // Create a list of semesters for each course
                    let semesters = row.courses_sems[course].join(', '); // Join semesters with commas

                    // Append to the courseHtml
                    courseHtml += `
            <div class="d-flex no-block align-items-center mb-2">
              <div>
                <h5 class="m-b-0 font-16 font-medium">${course}</h5>  
                <span class="text-muted">Semester ${semesters}</span>
              </div>
            </div>
          `;
                  }
                }
              }

              // Return the constructed HTML
              return courseHtml;
            }
          },



          { data: "c", responsivePriority: 1 },
          { data: "d", responsivePriority: 1 },
          {
            data: "id",
            className: "text-center",
            responsivePriority: 1,
            render: function (data, type, row, meta) {
              return '<button type="button" class="btn btn-primary edit-program" data-id="' + row.id + '">Show Details</button>';
            }
          },
        ],
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
      });

      // Button to open "Create Class" modal
      document.getElementById('buttonscanqr').onclick = function () {
        var myModal = new bootstrap.Modal(document.getElementById('ProgramScan'));
        myModal.show(); // Show the modal
        console.log("Create class button clicked");

        const videoElement = document.getElementById('video');
        const qrResult = document.getElementById('qr-result');
        const nextButton = document.getElementById('next-btn');

        const imgel = document.getElementById('image');
        const namael = document.getElementById('nama');
        const ndpel = document.getElementById('ndp');
        const student_id = document.getElementById('student_id');
        const program_id = document.getElementById('program_id');
        const scan_by = document.getElementById('scan_by');

        let videoStream = null;
        let scanInterval = null;
        let scanningActive = false; // To track if scanning is already active

        videoElement.style.display = 'inline-block'; // Show the video element

        // Start scanning for QR codes
        async function startScanning() {
          if (scanningActive) return; // Prevent starting scanning if already active
          scanningActive = true;

          try {
            // Access the user's webcam
            videoStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
            videoElement.srcObject = videoStream;

            scanQRCode(); // Start scanning after video feed starts
          } catch (error) {
            console.error('Error accessing webcam:', error);
            qrResult.textContent = 'Unable to access webcam.';
          }
        }

        // Function to scan the QR code in the video feed
        function scanQRCode() {
          const canvas = document.createElement('canvas');
          const context = canvas.getContext('2d');
          imgel.style.display = 'none';
          namael.style.display = 'none';
          ndpel.style.display = 'none';
          videoElement.style.display = 'inline-block';

          // Continuously scan the video feed
          scanInterval = setInterval(function () {
            if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA) {
              canvas.height = videoElement.videoHeight;
              canvas.width = videoElement.videoWidth;
              context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

              const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
              const code = jsQR(imageData.data, canvas.width, canvas.height);

              if (code) {
                qrResult.textContent = 'QR Code Data: ' + code.data;

                // Split the string by the delimiter "//"
                let parts = code.data.split('//');
                let ndp = parts[1];  // The first value after the first "//"
                let id = parts[2];   // The second value after the second "//"
                let nama = parts[3]; // The third value after the third "//"
                let img = parts[4];  // The fourth value after the third "//"

                // Display extracted data
                ndpel.style.display = 'inline-block';
                ndpel.value = ndp;

                namael.style.display = 'inline-block';
                namael.value = nama;

                imgel.style.display = 'inline-block';
                student_id.value = id;

                // Set the image source based on the QR data
                let dataSrc = (imgel.getAttribute('data-src')) + id + "/" + img;
                imgel.setAttribute('src', dataSrc);  // Set the src attribute to the data-src value

                stopVideo();
                clearInterval(scanInterval); // Stop the scanning loop

                // Show the "Next" button
                nextButton.style.display = 'inline-block';
              }
            }
          }, 100); // Scan every 100ms
        }

        // Stop the video stream
        function stopVideo() {
          if (videoStream) {
            const tracks = videoStream.getTracks();
            tracks.forEach(track => track.stop());
          }
          videoElement.style.display = 'none';
          scanningActive = false;
        }

        // Restart scanning when the "Next" button is pressed
        nextButton.addEventListener('click', function () {
          qrResult.textContent = ''; // Clear the result
          nextButton.style.display = 'none'; // Hide the "Next" button

          // Reset inputs and image display
          ndpel.style.display = 'none';
          namael.style.display = 'none';
          imgel.style.display = 'none';



          // Send AJAX request to update attendance
          $.ajax({
            type: "POST",
            url: "updateattprogram",
            data: {
              updateattprogram: {
                student_id: student_id.value,
                program_id: program_id.value,
                scan_by: scan_by.value
              },
            },
            success: function (response) {
              console.log(response);
              student_id.value = '';
              // program_id.value = '';
              // scan_by.value = '';
            },
            error: function (xhr, status, error) {
              console.error("Error occurred:", error); // Handle errors
            }
          });

          // Restart the scanning process after sending the data
          startScanning();
        });

        // Start scanning when the modal is opened
        startScanning();

        // When the modal is hidden, stop the video stream
        var modalElement = document.getElementById('ProgramScan');
        modalElement.addEventListener('hidden.bs.modal', function () {
          stopVideo(); // Stop video when modal is closed
          qrResult.textContent = ''; // Clear the result
          nextButton.style.display = 'none'; // Hide the "Next" button

          // Reset inputs and image display
          ndpel.style.display = 'none';
          namael.style.display = 'none';
          imgel.style.display = 'none';
          student_id.value = '';
          program_id.value = '';
          scan_by.value = '';
        });
      };

    });

  </script>


</body>

</html>