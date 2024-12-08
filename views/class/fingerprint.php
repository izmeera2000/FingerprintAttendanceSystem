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

                            <div class="card-body">

                                <div class="row">
                                    <input type="hidden" id="select_bengkel"
                                        value="<?php echo $_SESSION['user_details']['bengkel_id'] ?>">

                                    <div class="table-responsive">
                                        <?php
                                        ?>



                                        <select class="form-control" id="select_kelas"
                                            aria-label="Floating label select example">

                                            <?php
                                            $bengkel_id = $_SESSION['user_details']['bengkel_id'];

                                            $query = "SELECT * FROM kelas WHERE bengkel_id = '$bengkel_id'";
                                            $results = mysqli_query($db, $query);
                                            while ($row = $results->fetch_assoc()) {
                                                $id = $row['id'];
                                                $nama = $row['nama_kelas'];
                                                ?>
                                                <option value="<?php echo $id ?>"><?php echo $nama ?></option>

                                            <?php } ?>

                                        </select>

                                        <table id="enrollment" class="table table-striped table-bordered text-nowrap">
                                            <thead>
                                                <!-- start row -->

                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Kursus<br>
                                                        <select class="form-control" id="select_course"
                                                            aria-label="Floating label select example">
                                                            <option value="">Semua</option>

                                                            <?php
                                                            $bengkel_id = $_SESSION['user_details']['bengkel_id'];
                                                            $query = "SELECT id, nama FROM course WHERE bengkel_id = '$bengkel_id'";
                                                            $results = mysqli_query($db, $query);
                                                            while ($row = $results->fetch_assoc()) {
                                                                $id = $row['id'];
                                                                $nama = $row['nama'];
                                                                ?>
                                                                <option value="<?php echo $id ?>"><?php echo $nama ?>
                                                                </option>

                                                            <?php } ?>

                                                        </select>
                                                    </th>

                                                    <th>Status</th>
                                                    <th></th>

                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- <td>
                          <div class="d-flex no-block align-items-center">
                            <div class="m-r-10"><img
                                src="<?php echo $site_url ?>assets/images/user/<?php echo $_SESSION['user_details']['id'] ?>/<?php echo $_SESSION['user_details']['image_url'] ?>"
                                alt="user" class="rounded-circle" width="45"></div>
                            <div class="">
                              <h5 class="m-b-0 font-16 font-medium">Nama</h5><span class="text-muted">NDP</span>
                            </div>
                          </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td> -->
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
            // Initialize the DataTable and handle dynamic updates for col2 and col3

            var dt1 = $('#enrollment').DataTable({
                scrollY: 600,  // Adjust table height
                fixedHeader: {
                    header: true,
                    headerOffset: 150  // Adjust if there's a fixed navbar, change the offset accordingly
                },
                ajax: {
                    type: "POST",
                    url: "kelas_findall",
                    data: function (d) {
                        // Get the current values of col2 and col3
                        var bengkel = $('#select_bengkel').val();

                        var kelas = $('#select_kelas').val();
                        var course = $('#select_course').val();


                        // Return additional data for the AJAX request
                        return {
                            kelas_findall: {
                                limit: d.length,
                                offset: d.start,
                                draw: d.draw,
                                bengkel: bengkel,
                                kelas: kelas,
                                course: course,
                            },
                        };
                    },
                },
                columns: [
                    { data: "a", className: "text-center" },
                    { data: "b", responsivePriority: 1 },
                    { data: "c", className: "text-center" },
                    { data: "id", className: "text-center" },

                    //  {
                    //     data: "id",
                    //     className: "text-center",
                    //     responsivePriority: 1,
                    //     render: function (data, type, row, meta) {
                    //         return '<button type="button" class="btn btn-primary edit-class" data-id="' + row.id + '"><i class="bi bi-pencil-square"></i></button>'
                    //          . 'asdas'
                    //         ;
                    //     }
                    // },
                ],
                ordering: false,
                searching: false,
                processing: true,
                serverSide: true,
                stateSave: true,
                responsive: true,
            });

            // Function to update DataTable on dropdown change

            // Refetch (reload) data
            function refreshData() {
                // console.log("asa");
                dt1.ajax.reload(null, false);  // The second parameter false ensures the pagination is preserved
            }

            // Attach event listeners to dropdowns to update table when values change
            document.getElementById("select_kelas").addEventListener("change", refreshData);
            document.getElementById("select_course").addEventListener("change", refreshData);

            $('#enrollment').on('click', '.insert-fp', function () {
                var id = $(this).data('id');  // Get the ID from the button's data attribute
                var kelas = $(this).data('kelas');

                $.ajax({
                    type: "POST",
                    url: "kelas_insertfp",
                    data: {
                        kelas_insertfp: {

                            user_id: id,
                            kelas_id: kelas,
                        },
                    },
                    success: function (response) {
                        console.log(id);

                        console.log(kelas);
                        refreshData();                        // console.log(info.startStr);
                        // successCallback(JSON.parse(response));
                    },
                });


                // console.log("Row data:", rowData);
            });
            $('#enrollment').on('click', '.delete-fp', function () {
                var id = $(this).data('id');  // Get the ID from the button's data attribute
                var kelas = $(this).data('kelas');

                $.ajax({
                    type: "POST",
                    url: "kelas_deletefp",
                    data: {
                        kelas_deletefp: {

                            user_id: id,
                            kelas_id: kelas,
                        },
                    },
                    success: function (response) {
                        // console.log(JSON.parse(response));
                        // console.log(info.startStr);
                        // successCallback(JSON.parse(response));
                        console.log(response);

                        console.log(kelas);
                        refreshData();
                    },
                });


                // console.log("Row data:", rowData);
            });
        });

    </script>
</body>

</html>