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
            <h4 class="page-title">Create Holiday</h4>
          </div>
          <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="index.html#">Home</a>
                  </li>
                  <li class="breadcrumb-item ">
                    Holiday
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Create
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
                    id="buttoncreateholiday">Create holiday</button>
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
                    <table id="holiday_create" class="table table-hover  table-striped table-bordered text-nowrap">
                      <thead>
                        <!-- start row -->
                        <tr>
                          <th>Nama</th>
                          <th>Tarikh</th>
                          <th>Status</th>
                          <!-- <th>Tarikh Tamat</th> -->
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
      var dt1 = $('#holiday_create').DataTable({
        scrollY: 600,  // Adjust table height
        fixedHeader: {
          header: true,
          headerOffset: 150  // Adjust if there's a fixed navbar, change the offset accordingly
        },
        ajax: {
          type: "POST",
          url: "holiday_findall",
          data: function (d) {
            console.log(d);
            return {
              holiday_findall: {
                limit: d.length,
                offset: d.start,
                draw: d.draw,
                search: d.search.value,
                  order: d.order, // Add this line to include order parameters

              },
            };
          },
        },
        columns: [
          {
            data: "a", className: "text-center",
          },
          { data: "b", responsivePriority: 1 },
          { data: "c", responsivePriority: 1 },
          // {
          //   data: "id",
          //   className: "text-center",
          //   responsivePriority: 1,
          //   render: function (data, type, row, meta) {
          //     return '<button type="button" class="btn btn-primary edit-sem" data-id="' + row.id + '">Show Details</button>';
          //   }
          // },
        ],
        order: [[0, 'asc']],
        processing: true,
        serverSide: true,
        stateSave: true,
        responsive: true,
       });

      
      // $('#holiday_create tbody').on('change', '.select-row', function () {
      //   var rowData = dt1.row($(this).closest('tr')).data();
      //   if ($(this).is(':checked')) {
      //     console.log('Selected row data:', rowData);
      //   }
      //   else {
      //     console.log('Deselected row data:', rowData);
      //   }
      // });


      // Button to open "Create Class" modal
      document.getElementById('buttoncreateholiday').onclick = function () {
        var myModal = new bootstrap.Modal(document.getElementById('CreateHolidayModal'));
        myModal.show();
        console.log("Create class button clicked");
      };

      // Handle row button click to open "Edit Class" modal and populate with data
      $('#holiday_create').on('click', '.edit-holiday', function () {
        // var id = $(this).data('id');  // Get the ID from the button's data attribute
        // var myModal = new bootstrap.Modal(document.getElementById('EditSemModal'));
        // myModal.show();

        // // Get row data
        // var rowData = dt1.row($(this).closest('tr')).data();

        // var date1 = new Date(rowData.b);
        // var date2 = new Date(rowData.c);

        // var formattedDate1 = date1.toLocaleDateString('en-GB'); // en-GB format gives 'dd/mm/yyyy'
        // var formattedDate2 = date2.toLocaleDateString('en-GB'); // en-GB format gives 'dd/mm/yyyy'



        // // Populate modal fields with row data
        // $('#id').val(id);
        // $('#nama').val(rowData.a);
        // $('#mula').val(rowData.b);
        // $('#tamat').val(rowData.c);
        // console.log(rowData.b);


        // console.log("Row data:", rowData);
      });
    });

  </script>
</body>

</html>