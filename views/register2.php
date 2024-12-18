<?php include(getcwd() . '/admin/server.php');
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
    <div class="
          auth-wrapper
          d-flex
          no-block
          justify-content-center
          align-items-center
        " style="
          background: url(<?php echo $site_url ?>assets/images/auth-bg.jpg) no-repeat center
            center;
        ">
      <div class="auth-box p-4 bg-white rounded">
        <div>
          <div class="logo text-center">
            <span class="db"><img src="<?php echo $site_url ?>assets/images/logo-b.png" alt="logo" /></span>
            <span class="db"><img src="<?php echo $site_url ?>assets/images/logo-b-text.png" alt="logo" /></span>
            <h5 class="font-weight-medium mb-3 mt-2">Sign Up Admin</h5>
          </div>
          <!-- Form -->
          <div class="row">
            <div class="col-12">
              <form method="POST" action="register_admin" enctype="multipart/form-data">
                <div class="form-group row mb-3 ">
                  <div class="col-12 ">
                    <input class="form-control <?php formvalidatelabel("fullname", $errors) ?>" type="text"
                      placeholder="Nama Penuh" name="fullname" required>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 ">
                    <input class="form-control  <?php formvalidatelabel("email", $errors) ?>" type="text"
                      placeholder="Email" name="email" required>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 ">
                    <input class="form-control   <?php formvalidatelabel("phone", $errors) ?>" type="number"
                      placeholder="Nombor Telefon" name="phone" required>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 ">
                    <input class="form-control <?php formvalidatelabel("kp", $errors) ?>" type="number"
                      placeholder="Nombor Kad Pengenalan" name="kp" required>
                  </div>
                </div>
                <div class="row">

                  <div class="col-6 ">
                    <div class="form-group row mb-3">
                      <label for="FS_Jantina">Bengkel</label>

                      <select class="form-control  <?php formvalidatelabel("bengkel", $errors) ?>" id="FS_Jantina"
                        aria-label="Floating label select example" name="bengkel" required>

                        <option selected disabled> Pilih Bengkel</option>
                        <?php
                        $query = "SELECT * FROM bengkel  ";
                        $results = mysqli_query($db, $query);
                        while ($row = $results->fetch_assoc()) {
                          $id = $row['id'];
                          $nama = $row['nama'];
                          ?>
                          <option value="<?php echo $id ?>"><?php echo ($nama) ?></option>

                        <?php } ?>
                      </select>

                    </div>
                  </div>
                  <div class="col-5 mx-2 ">
                    <div class="form-group row mb-3">
                      <label for="FS_Jantina">Role</label>

                      <select class="form-control  <?php formvalidatelabel("role", $errors) ?>" id="FS_Jantina"
                        aria-label="Floating label select example" name="role" required>

                        <option selected disabled> Pilih Role</option>
                        <?php
                        $query = "SELECT * FROM user_role  WHERE nama != 'STUDENT'";
                        $results = mysqli_query($db, $query);
                        while ($row = $results->fetch_assoc()) {
                          $id = $row['id'];
                          $nama = $row['nama'];
                          ?>
                          <option value="<?php echo $id ?>"><?php echo ($nama) ?></option>

                        <?php } ?>
                      </select>

                    </div>
                  </div>
                </div>

                <div class="col-12 ">
                  <div class="form-group row mb-3">
                    <label for="FS_Jantina">Jantina</label>

                    <select class="form-control  <?php formvalidatelabel("jantina", $errors) ?>" id="FS_Jantina"
                      aria-label="Floating label select example" name="jantina" required>

                      <option selected disabled> Pilih Jantina</option>
                      <option value="Lelaki">Lelaki</option>
                      <option value="Perempuan">Perempuan</option>
                    </select>

                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 ">
                    <label for="FS_Agama">Agama</label>

                    <select class="form-control <?php formvalidatelabel("agama", $errors) ?>" id="FS_Agama"
                      aria-label="Floating label select example" name="agama" required>

                      <option selected disabled> Pilih Agama</option>
                      <option value="Islam">Islam</option>
                      <option value="Hindu">Hindu</option>
                      <option value="Budha">Budha</option>
                      <option value="Kristian">Kristian</option>
                      <option value="Lain-lain">Lain-lain</option>
                    </select>

                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 ">
                    <label for="FS_Status_Perkahwinan">Status Perkahwinan</label>

                    <select class="form-control  <?php formvalidatelabel("statuskahwin", $errors) ?>"
                      id="FS_Status_Perkahwinan" aria-label="Floating label select example" name="statuskahwin"
                      required>

                      <option selected disabled> Pilih Status Perkahwinan</option>
                      <option value="Tidak Berkahwin">Tidak Berkahwin</option>
                      <option value="Berkahwin">Berkahwin</option>
                    </select>

                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 ">
                    <input class="form-control <?php formvalidatelabel("bangsa", $errors) ?>" type="text"
                      placeholder="Bangsa" name="bangsa" required>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 ">
                    <label for="test" class="form-label">Gambar</label>
                    <input class="form-control-file <?php formvalidatelabel("gambar", $errors) ?>" type="file" id="test"
                      name="gambar" required>
                    <div class="text-body-secondary small">Only JPG, JPEG & PNG files are allowed.
                    </div>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback"><?php formvalidateerr("gambar", $errors) ?></div>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 ">
                    <input class="form-control  <?php formvalidatelabel("password1", $errors) ?>" type="password"
                      placeholder="Password" name="password1" required>

                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 ">
                    <input class="form-control  <?php formvalidatelabel("password2", $errors) ?>" type="password"
                      placeholder="Repeat password" name="password2" required>
                  </div>
                </div>
                <div class="d-flex align-items-stretch">
                  <button type="submit" name="user_register2" class="btn btn-info d-block w-100">
                    Sign up
                  </button>
                </div>
                <div class="form-group m-b-0 m-t-10 ">
                  <div class="col-sm-12 text-center ">
                    Already have an account? <a href="<?php echo $site_url ?>login" class="text-info m-l-5 "><b>Sign
                        In</b></a>
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

</body>

</html>