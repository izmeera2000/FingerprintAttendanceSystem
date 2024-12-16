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
                    id="buttoncreateprogram">Create Program</button>
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
          { data: "href", responsivePriority: 1 },
          // {
          //   data: "id",
          //   className: "text-center",
          //   responsivePriority: 1,
          //   render: function (data, type, row, meta) {
          //     return '<a  class="btn btn-primary  " href="program/'+row.id +'" data-id="' + row.id + '">Show Details</a>';
          //   }
          // },
        ],
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
      });

      // Button to open "Create Class" modal
      document.getElementById('buttoncreateprogram').onclick = function () {
        var myModal = new bootstrap.Modal(document.getElementById('CreateProgramModal'));
        myModal.show();
        console.log("Create class button clicked");
      };

      
    });

  </script>
</body>

</html>