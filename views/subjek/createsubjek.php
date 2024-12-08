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
                    id="buttoncreatesubjek">Create Device</button>
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
                    <table id="subjek_create" class="table table-striped table-bordered text-nowrap">
                      <thead>
                        <!-- start row -->
                        <tr>
                          <th>Nama</th>
                          <th>Kod</th>
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
      var dt1 = $('#subjek_create').DataTable({
        scrollY: 600,  // Adjust table height
        fixedHeader: {
          header: true,
          headerOffset: 150  // Adjust if there's a fixed navbar, change the offset accordingly
        },
        ajax: {
          type: "POST",
          url: "subjek_findall",
          data: function (d) {
            console.log(d);
            return {
              subjek_findall: {
                limit: d.length,
                offset: d.start,
                draw: d.draw,
                search: d.search.value,
              },
            };
          },
        },
        columns: [
          { data: "a", className: "text-center" },
          { data: "b", responsivePriority: 1 },
          {
            data: "id",
            className: "text-center",
            responsivePriority: 1,
            render: function (data, type, row, meta) {
              return '<button type="button" class="btn btn-primary assign-subjek m-2" data-id="' + row.id + '">Assign</button><button type="button" class="btn btn-primary edit-subjek m-2" data-id="' + row.id + '">Show Details</button>';
            }
          },
        ],
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
      });

      // Button to open "Create Class" modal
      document.getElementById('buttoncreatesubjek').onclick = function () {
        var myModal = new bootstrap.Modal(document.getElementById('CreateSubjekModal'));
        myModal.show();
        console.log("Create class button clicked");
      };

      // Handle row button click to open "Edit Class" modal and populate with data
      $('#subjek_create').on('click', '.edit-subjek', function () {
        var id = $(this).data('id');  // Get the ID from the button's data attribute
        var myModal = new bootstrap.Modal(document.getElementById('EditSubjekModal'));
        myModal.show();

        // Get row data
        var rowData = dt1.row($(this).closest('tr')).data();

 
 

        // Populate modal fields with row data
        $('#id').val(id);
        $('#nama').val(rowData.a);
        $('#kod').val(rowData.b);
        console.log(rowData.b);


        // console.log("Row data:", rowData);
      });

      $('#subjek_create').on('click', '.assign-subjek', function () {
        var id = $(this).data('id');  // Get the ID from the button's data attribute
        var myModal = new bootstrap.Modal(document.getElementById('AssignSubjekModal'));
        myModal.show();

        // Get row data
        var rowData = dt1.row($(this).closest('tr')).data();

 
 

        // Populate modal fields with row data
        $('#id2').val(id);
        $('#nama2').val(rowData.a);
        $('#kod2').val(rowData.b);
        console.log(rowData.b);


        // console.log("Row data:", rowData);
      });
    });

  </script>
</body>

</html>