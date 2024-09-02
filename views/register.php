<?php include(getcwd() . '/admin/server.php'); 

// var_dump($_SESSION['user_details'] );
?>

<!DOCTYPE html>
<html dir="ltr">

<?php include(getcwd() . '/views/head.php'); ?>


<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <?php include(getcwd() . '/views/preloader.php'); ?>

        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
            style="background:url(<?php echo $site_url ?>assets/images/big/auth-bg.jpg) no-repeat center center;">
            <div class="auth-box">
                <div>
                    <div class="logo">
                        <span class="db"><img src="<?php echo $site_url ?>assets/images/logo-icon.png"
                                alt="logo" /></span>
                        <h5 class="font-medium m-b-20">Sign Up to Admin</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="register" enctype="multipart/form-data">
                                <div class="form-group row ">
                                    <div class="col-12 ">
                                        <input class="form-control  <?php formvalidatelabel("ndp", $errors) ?>"
                                            type="number" placeholder="NDP" name="ndp" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control <?php formvalidatelabel("fullname", $errors) ?>"
                                            type="text" placeholder="Nama Penuh" name="fullname" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control  <?php formvalidatelabel("email", $errors) ?>"
                                            type="text" placeholder="Email" name="email" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control   <?php formvalidatelabel("phone", $errors) ?>"
                                            type="number" placeholder="Nombor Telefon" name="phone" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control <?php formvalidatelabel("kp", $errors) ?>"
                                            type="number" placeholder="Nombor Kad Pengenalan" name="kp" required>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <div class="form-group row">
                                        <label for="FS_Jantina">Jantina</label>

                                        <select class="form-control  <?php formvalidatelabel("jantina", $errors) ?>"
                                            id="FS_Jantina" aria-label="Floating label select example" name="jantina"
                                            required>

                                            <option selected disabled> Pilih Jantina</option>
                                            <option value="Lelaki">Lelaki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <label for="FS_Agama">Agama</label>

                                        <select class="form-control <?php formvalidatelabel("agama", $errors) ?>"
                                            id="FS_Agama" aria-label="Floating label select example" name="agama"
                                            required>

                                            <option selected disabled> Pilih Agama</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Budha">Budha</option>
                                            <option value="Kristian">Kristian</option>
                                            <option value="Lain-lain">Lain-lain</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <label for="FS_Status_Perkahwinan">Status Perkahwinan</label>

                                        <select
                                            class="form-control  <?php formvalidatelabel("statuskahwin", $errors) ?>"
                                            id="FS_Status_Perkahwinan" aria-label="Floating label select example"
                                            name="statuskahwin" required>

                                            <option selected disabled> Pilih Status Perkahwinan</option>
                                            <option value="Tidak Berkahwin">Tidak Berkahwin</option>
                                            <option value="Berkahwin">Berkahwin</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control <?php formvalidatelabel("bangsa", $errors) ?>"
                                            type="text" placeholder="Bangsa" name="bangsa" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <label for="test" class="form-label">Gambar</label>
                                        <input class="form-control-file <?php formvalidatelabel("gambar", $errors) ?>"
                                            type="file" id="test" name="gambar" required>
                                        <div class="text-body-secondary small">Only JPG, JPEG & PNG files are allowed.
                                        </div>
                                        <div class="valid-feedback">Looks good!</div>
                                        <div class="invalid-feedback"><?php formvalidateerr("gambar", $errors) ?></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control  <?php formvalidatelabel("password1", $errors) ?>"
                                            type="password" placeholder="Password" name="password1" required>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 ">
                                        <input class="form-control  <?php formvalidatelabel("password2", $errors) ?>"
                                            type="password" placeholder="Repeat password" name="password2" required>
                                    </div>
                                </div>
                                <div class="form-group text-center ">
                                    <div class="col-xs-12 p-b-20 ">
                                        <button class="btn btn-block btn-lg btn-info " type="submit"
                                            name="user_register">SIGN UP</button>
                                    </div>
                                </div>
                                <div class="form-group m-b-0 m-t-10 ">
                                    <div class="col-sm-12 text-center ">
                                        Already have an account? <a href="<?php echo $site_url ?>login"
                                            class="text-info m-l-5 "><b>Sign In</b></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <?php include(getcwd() . '/views/script.php'); ?>

    <script>
        $('[data-toggle="tooltip "]').tooltip();
        $(".preloader ").fadeOut();
    </script>
</body>

</html>