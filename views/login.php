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
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="
          background: url(<?php echo $site_url ?>assets/images/login-register.jpg)
            no-repeat center center;
          background-size: cover;
        ">
      <div class="auth-box p-4 bg-white rounded">
        <div id="loginform">
          <div class="logo  text-center">
          <span class="db"><img src="<?php echo $site_url ?>assets/images/logo-b.png" alt="logo" /></span>
          <span class="db"><img src="<?php echo $site_url ?>assets/images/logo-b-text.png" alt="logo" /></span>
            <h3 class="box-title mb-3 mt-3">Sign In</h3>
          </div>
          <!-- Form -->
          <div class="row">
            <div class="col-12">
              <form class="form-horizontal m-t-20" id="loginform" method="POST" action="login"
                enctype="multipart/form-data">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                  </div>
                  <input class="form-control <?php formvalidatelabel("login", $errors) ?>" type="text"
                    placeholder="NDP or Email" name="login" required>
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                  </div>
                  <input class="form-control <?php formvalidatelabel("login", $errors) ?>" type="password"
                    placeholder="Password" name="password" required>
                </div>
                <!-- <?php  var_dump($_POST); ?> -->
                <!-- <div class="form-group">
                  <div class="d-flex">
                    <div class="checkbox checkbox-info pt-0">
                      <input id="checkbox-signup" type="checkbox" class="material-inputs chk-col-indigo" />
                      <label for="checkbox-signup"> Remember me </label>
                    </div>
                    <div class="ms-auto">
                      <a href="javascript:void(0)" id="to-recover"
                        class="link font-weight-medium d-flex align-items-center"><i class="ri-lock-line fs-5 me-1"></i>
                        Forgot pwd?</a>
                    </div>
                  </div>
                </div> -->
                <div class="form-group text-center mt-4 mb-3">
                  <div class="col-xs-12">
                    <button class="btn btn-info d-block w-100 waves-effect waves-light" type="submit"  name="user_login">
                      Log In
                    </button>
                  </div>
                </div>
                <!-- <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 mt-2 text-center">
                    <div class="social mb-3">
                      <a href="javascript:void(0)" class="btn btn-facebook" data-bs-toggle="tooltip"
                        title="Login with Facebook">
                        <i aria-hidden="true" class="ri-facebook-box-fill fs-4"></i>
                      </a>
                      <a href="javascript:void(0)" class="btn btn-googleplus" data-bs-toggle="tooltip"
                        title="Login with Google">
                        <i aria-hidden="true" class="ri-google-fill fs-4"></i>
                      </a>
                    </div>
                  </div>
                </div> -->
                <div class="form-group mb-0 mt-4">
                  <div class="col-sm-12 justify-content-center d-flex">
                    <p>
                      Don't have an account?
                      <a href="<?php echo $site_url ?>register" class="text-info font-weight-medium ms-1">Sign Up</a>
                    </p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div id="recoverform">
          <div class="logo">
            <h3 class="font-weight-medium mb-3">Recover Password</h3>
            <span class="text-muted">Enter your Email and instructions will be sent to you!</span>
          </div>
          <div class="row mt-3 form-material">
            <!-- Form -->
            <form class="col-12" action="index.html">
              <!-- email -->
              <div class="form-group row">
                <div class="col-12">
                  <input class="form-control" type="email" required="" placeholder="Username" />
                </div>
              </div>
              <!-- pwd -->
              <div class="row mt-3">
                <div class="col-12">
                  <button class="btn d-block w-100 btn-primary text-uppercase" type="submit" name="action">
                    Reset
                  </button>
                </div>
              </div>
            </form>
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