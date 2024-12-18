<?php include(getcwd() . '/admin/server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords"
    content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, nice admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, material design, material dashboard bootstrap 5 dashboard template" />
  <meta name="description"
    content="Nice is powerful and clean admin dashboard template, inpired from Google's Material Design" />
  <meta name="robots" content="noindex,nofollow" />
  <title>Fingerprint Attendance System</title>

  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $site_url ?>assets/images/favicon.png" />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Selecao
  * Template URL: https://bootstrapmade.com/selecao-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/images/logo-w.png" alt="">
        <img src="assets/images/logo-w-text.png" alt="">
        <!-- <h1 class="sitename">Selecao</h1> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#team">Team</a></li>
          <li><a href="#testimonials">Testimonials</a></li>
          <!-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li> -->
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="btn login" href="<?php echo $site_url ?>login">Login</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div id="hero-carousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

        <!-- Slide 1 -->
        <div class="carousel-item active">
          <div class="carousel-container">
            <h2 class="animate__animated animate__fadeInDown">Welcome to <br>
              <div class="text-uppercase">Fingerprint Attendance System</div>
            </h2>
            <p class="animate__animated animate__fadeInUp">Effortlessly manage and track attendance with our
              state-of-the-art fingerprint system. Secure, reliable, and easy to use, ensuring accuracy and efficiency
              in your organization. Experience the seamless integration of technology and convenience with our system.
            </p>
            <!-- <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a> -->
          </div>
        </div>


      </div>

      <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28 " preserveAspectRatio="none">
        <defs>
          <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
        </defs>
        <g class="wave1">
          <use xlink:href="#wave-path" x="50" y="3"></use>
        </g>
        <g class="wave2">
          <use xlink:href="#wave-path" x="50" y="0"></use>
        </g>
        <g class="wave3">
          <use xlink:href="#wave-path" x="50" y="9"></use>
        </g>
      </svg>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>About</h2>
        <p>Who we are</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <p>
              Advantages of the Fingerprint Attendance System :
            </p>
            <ul>
              <li><i class="bi bi-check2-circle"></i> <span>Streamline attendance management with quick and reliable
                  fingerprint scanning.</span></li>
              <li><i class="bi bi-check2-circle"></i> <span>Enhance data security with biometric authentication,
                  ensuring accurate records.</span></li>
              <li><i class="bi bi-check2-circle"></i> <span>Simplify attendance tracking with an easy-to-use,
                  hassle-free system.</span></li>
            </ul>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <p>Discover a streamlined way to manage attendance. Our system ensures accuracy, security, and ease-of-use,
              making attendance tracking a breeze. Join us in</p>
            <a href="<?php echo $site_url ?>login" class="read-more"><span>Experience</span><i
                class="bi bi-arrow-right"></i></a>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

      <div class="container">

        <ul class="nav nav-tabs row  d-flex" data-aos="fade-up" data-aos-delay="100">
          <li class="nav-item col-3">
            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
              <i class="bi bi-binoculars"></i>
              <h4 class="d-none d-lg-block">Modi sit est dela pireda nest</h4>
            </a>
          </li>
          <li class="nav-item col-3">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
              <i class="bi bi-box-seam"></i>
              <h4 class="d-none d-lg-block">Unde praesenti mara setra le</h4>
            </a>
          </li>
          <li class="nav-item col-3">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
              <i class="bi bi-brightness-high"></i>
              <h4 class="d-none d-lg-block">Pariatur explica nitro dela</h4>
            </a>
          </li>
          <li class="nav-item col-3">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-4">
              <i class="bi bi-command"></i>
              <h4 class="d-none d-lg-block">Nostrum qui dile node</h4>
            </a>
          </li>
        </ul><!-- End Tab Nav -->

        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

          <div class="tab-pane fade active show" id="features-tab-1">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                <p class="fst-italic">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                  dolore
                  magna aliqua.
                </p>
                <ul>
                  <li><i class="bi bi-check2-all"></i>
                    <spab>Ullamco laboris nisi ut aliquip ex ea commodo consequat.</spab>
                  </li>
                  <li><i class="bi bi-check2-all"></i> <span>Duis aute irure dolor in reprehenderit in voluptate
                      velit</span>.</li>
                  <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat.
                      Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu
                      fugiat nulla pariatur.</span></li>
                </ul>
                <p>
                  Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate
                  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                  sunt in
                  culpa qui officia deserunt mollit anim id est laborum
                </p>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="assets/images/working-1.jpg" alt="" class="img-fluid">
              </div>
            </div>
          </div><!-- End Tab Content Item -->

          <div class="tab-pane fade" id="features-tab-2">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Neque exercitationem debitis soluta quos debitis quo mollitia officia est</h3>
                <p>
                  Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate
                  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                  sunt in
                  culpa qui officia deserunt mollit anim id est laborum
                </p>
                <p class="fst-italic">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                  dolore
                  magna aliqua.
                </p>
                <ul>
                  <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                      consequat.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Duis aute irure dolor in reprehenderit in voluptate
                      velit.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Provident mollitia neque rerum asperiores dolores quos qui
                      a. Ipsum neque dolor voluptate nisi sed.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat.
                      Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu
                      fugiat nulla pariatur.</span></li>
                </ul>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="assets/images/working-2.jpg" alt="" class="img-fluid">
              </div>
            </div>
          </div><!-- End Tab Content Item -->

          <div class="tab-pane fade" id="features-tab-3">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Voluptatibus commodi ut accusamus ea repudiandae ut autem dolor ut assumenda</h3>
                <p>
                  Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate
                  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                  sunt in
                  culpa qui officia deserunt mollit anim id est laborum
                </p>
                <ul>
                  <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                      consequat.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Duis aute irure dolor in reprehenderit in voluptate
                      velit.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Provident mollitia neque rerum asperiores dolores quos qui
                      a. Ipsum neque dolor voluptate nisi sed.</span></li>
                </ul>
                <p class="fst-italic">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                  dolore
                  magna aliqua.
                </p>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="assets/images/working-3.jpg" alt="" class="img-fluid">
              </div>
            </div>
          </div><!-- End Tab Content Item -->

          <div class="tab-pane fade" id="features-tab-4">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Omnis fugiat ea explicabo sunt dolorum asperiores sequi inventore rerum</h3>
                <p>
                  Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate
                  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                  sunt in
                  culpa qui officia deserunt mollit anim id est laborum
                </p>
                <p class="fst-italic">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                  dolore
                  magna aliqua.
                </p>
                <ul>
                  <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                      consequat.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Duis aute irure dolor in reprehenderit in voluptate
                      velit.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo consequat.
                      Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu
                      fugiat nulla pariatur.</span></li>
                </ul>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="assets/images/working-4.jpg" alt="" class="img-fluid">
              </div>
            </div>
          </div><!-- End Tab Content Item -->

        </div>

      </div>

    </section><!-- /Features Section -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section dark-background">

      <div class="container">

        <div class="row" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-9 text-center text-xl-start">
            <h3>Discover the Future of Attendance!</h3>
            <p>Effortlessly manage attendance with our secure and efficient fingerprint technology. Simple, accurate,
              and reliable—making attendance tracking effortless.</p>
          </div>
          <div class="col-xl-3 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="<?php echo $site_url ?>">Experience Now</a>
          </div>
        </div>

      </div>

    </section><!-- /Call To Action Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>What we do offer</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item  position-relative">
              <div class="icon">
                <i class="bi bi-cash-stack" style="color: #0dcaf0;"></i>
              </div>
              <!-- <a href="service-details.html" class="stretched-link"> -->
              <h3>Fingerprint Attendance Management</h3>
              <!-- </a> -->
              <p>Ensure seamless and accurate attendance tracking with our state-of-the-art fingerprint recognition
                system, reducing manual errors and saving time.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="bi bi-calendar4-week" style="color: #fd7e14;"></i>
              </div>
              <!-- <a href="service-details.html" class="stretched-link"> -->
              <h3>Real-Time Data Access</h3>
              <!-- </a> -->
              <p>Gain instant access to attendance data from anywhere, enabling timely decision-making and efficient
                management of schedules.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="bi bi-chat-text" style="color: #20c997;"></i>
              </div>
              <!-- <a href="service-details.html" class="stretched-link"> -->
              <h3>Secure Data Storage</h3>
              <!-- </a> -->
              <p>Your attendance data is securely stored and encrypted, ensuring privacy and protection against
                unauthorized access.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="bi bi-credit-card-2-front" style="color: #df1529;"></i>
              </div>
              <!-- <a href="service-details.html" class="stretched-link"> -->
              <h3>User-Friendly Interface</h3>
              <!-- </a> -->
              <p>Our system is designed with ease of use in mind, making it simple for administrators and employees
                alike to navigate and utilize its features.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="bi bi-globe" style="color: #6610f2;"></i>
              </div>
              <!-- <a href="service-details.html" class="stretched-link"> -->
              <h3>Integration with Existing Systems</h3>
              <!-- </a> -->
              <p>Seamlessly integrate our attendance system with your current HR and payroll systems, ensuring smooth
                data flow and synchronization.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="bi bi-clock" style="color: #f3268c;"></i>
              </div>
              <!-- <a href="service-details.html" class="stretched-link"> -->
              <h3>Multi-Device Support</h3>
              <!-- </a> -->
              <p>Access and manage attendance data from multiple devices, including desktops, tablets, and smartphones,
                providing flexibility and convenience.</p>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Services Section -->

    <?php


    $query =

      "SELECT * FROM feedback ORDER BY LENGTH(content) DESC, rate1 DESC, rate2 DESC, rate3 DESC, time_add DESC";

    $feedback = mysqli_query($db, $query);

    if ($feedback) {

      if (mysqli_num_rows($feedback) > 0) {



        ?>
        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials section">

          <!-- Section Title -->
          <div class="container section-title" data-aos="fade-up">
            <h2>Testimonials</h2>
            <p>What they are saying about us</p>
          </div><!-- End Section Title -->

          <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">
              <script type="application/json" class="swiper-config">
                                                                                                        {
                                                                                                          "loop": true,
                                                                                                          "speed": 600,
                                                                                                          "autoplay": {
                                                                                                            "delay": 5000
                                                                                                          },
                                                                                                          "slidesPerView": "auto",
                                                                                                          "pagination": {
                                                                                                            "el": ".swiper-pagination",
                                                                                                            "type": "bullets",
                                                                                                            "clickable": true
                                                                                                          },
                                                                                                          "breakpoints": {
                                                                                                            "320": {
                                                                                                              "slidesPerView": 1,
                                                                                                              "spaceBetween": 40
                                                                                                            },
                                                                                                            "1200": {
                                                                                                              "slidesPerView": 3,
                                                                                                              "spaceBetween": 10
                                                                                                            }
                                                                                                          }
                                                                                                        }
                                                                                                      </script>
              <div class="swiper-wrapper">
                <?php while ($row = mysqli_fetch_assoc($feedback)) { ?>
                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <!-- <img src="assets/images/testimonials/testimonials-1.jpg" class="testimonial-img" alt=""> -->
                      <h2 class="text-uppercase"><?php echo $row['nama'] ?></h2>

                      <?php if ($row['rate1']) { ?>
                        <h3>Cara Penyampaian</h3>
                        <!-- <h4>Ceo &amp; Founder</h4> -->
                        <div class="stars">
                          <?php
                          $rating = $row['rate1'];
                          for ($i = 1; $i <= 5; $i++) {
                            if ($i <= floor($rating)) {

                              echo '<i class="bi bi-star-fill"></i>';
                            } else if ($i == ceil($rating) && $rating - floor($rating) >= 0.5) {

                              echo '<i class="bi bi-star-half"></i>';

                            } else {

                              echo '<i class="bi bi-star"></i>';
                            }
                          }


                          ?>
                        </div> <?php }
                      ?>

                      <?php if ($row['rate2']) { ?>

                        <h3>Pandangan keseluruhan anda tentang projek</h3>
                        <!-- <h4>Ceo &amp; Founder</h4> -->
                        <div class="stars">
                          <?php
                          $rating = $row['rate2'];
                          for ($i = 1; $i <= 5; $i++) {
                            if ($i <= floor($rating)) {

                              echo '<i class="bi bi-star-fill"></i>';
                            } else if ($i == ceil($rating) && $rating - floor($rating) >= 0.5) {

                              echo '<i class="bi bi-star-half"></i>';

                            } else {

                              echo '<i class="bi bi-star"></i>';
                            }
                          }



                          ?>
                        </div> <?php }
                      ?>
                      <?php if ($row['rate3']) { ?>

                        <h3>Kesesuaian isi projek dengan tugas</h3>
                        <!-- <h4>Ceo &amp; Founder</h4> -->
                        <div class="stars">
                          <?php
                          $rating = $row['rate3'];
                          for ($i = 1; $i <= 5; $i++) {
                            if ($i <= floor($rating)) {

                              echo '<i class="bi bi-star-fill"></i>';
                            } else if ($i == ceil($rating) && $rating - floor($rating) >= 0.5) {

                              echo '<i class="bi bi-star-half"></i>';

                            } else {

                              echo '<i class="bi bi-star"></i>';
                            }
                          }



                          ?>
                        </div>
                      <?php }
                      ?>

                      <?php if ($row['content']) { ?>
                        <p>
                          <i class="bi bi-quote quote-icon-left"></i>
                          <span><?php echo $row['content'] ?></span>
                          <i class="bi bi-quote quote-icon-right"></i>
                        </p>

                      <?php }
                      ?>
                    </div>
                  </div><!-- End testimonial item -->
                <?php } ?>

              </div>
              <!-- <div class="swiper-pagination"></div> -->
            </div>

          </div>

        </section><!-- /Testimonials Section -->
        <?php

      }
    } ?>

    <!-- Faq Section -->
    <section id="faq" class="faq section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
        <p>Frequently Asked Questions</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-12">
            <div class="custom-accordion" id="accordion-faq">
              <div class="accordion-item">
                <h2 class="mb-0">
                  <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-1">
                    How to download and register?
                  </button>
                </h2>

                <div id="collapse-faq-1" class="collapse show" aria-labelledby="headingOne"
                  data-parent="#accordion-faq">
                  <div class="accordion-body">
                    Far far away, behind the word mountains, far from the countries
                    Vokalia and Consonantia, there live the blind texts. Separated
                    they live in Bookmarksgrove right at the coast of the Semantics,
                    a large language ocean.
                  </div>
                </div>
              </div>
              <!-- .accordion-item -->

              <div class="accordion-item">
                <h2 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-faq-2">
                    How to create your paypal account?
                  </button>
                </h2>
                <div id="collapse-faq-2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-faq">
                  <div class="accordion-body">
                    A small river named Duden flows by their place and supplies it
                    with the necessary regelialia. It is a paradisematic country, in
                    which roasted parts of sentences fly into your mouth.
                  </div>
                </div>
              </div>
              <!-- .accordion-item -->

              <div class="accordion-item">
                <h2 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-faq-3">
                    How to link your paypal and bank account?
                  </button>
                </h2>

                <div id="collapse-faq-3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                  <div class="accordion-body">
                    When she reached the first hills of the Italic Mountains, she
                    had a last view back on the skyline of her hometown
                    Bookmarksgrove, the headline of Alphabet Village and the subline
                    of her own road, the Line Lane. Pityful a rethoric question ran
                    over her cheek, then she continued her way.
                  </div>
                </div>
              </div>
              <!-- .accordion-item -->

            </div>
          </div>
        </div>
      </div>
    </section><!-- /Faq Section -->

    <!-- Team Section -->
    <section id="team" class="team section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Team</h2>
        <p>Our Hardworking Team</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4 justify-content-center">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/images/team/fyp2.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Hijazi</h4>
                <span>Team Leader</span>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/images/team/fyp1.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Siti</h4>
                <span>Product Manager</span>
              </div>
            </div>
          </div><!-- End Team Member -->


          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/images/team/fyp3.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Afif</h4>
                <span>Product Manager</span>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Team Section -->


    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Contact Us</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Address</h3>
                <p>A108 Adam Street, New York, NY 535022</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+6011 1245 6300</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>info@example.com</p>
              </div>
            </div><!-- End Info Item -->


            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <!-- <i class="bi bi-envelope flex-shrink-0"></i> -->
              <div>
                <h3>Rate Us</h3>
                <!-- <p>info@example.com</p> -->
                <button class="btn login" id="rate-button" data-bs-toggle="modal" data-bs-target="#exampleModal">Rate
                  Now</button>
              </div>
            </div><!-- End Info Item -->
          </div>

          <div class="col-lg-8">

            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2653.2879339845003!2d100.6974965304708!3d4.865684079136129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31caac2365fecdc5%3A0x2d36285eabc19b9a!2sPusat%20Latihan%20Teknologi%20Tinggi%20(ADTEC)%20Taiping!5e0!3m2!1sen!2smy!4v1731638889781!5m2!1sen!2smy"
              width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>


          <!-- <div class="col-lg-8">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
              data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div> -->
          <!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Maklum Balas Projek Fingerprint Attendance System</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" />


              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Cara penyampaian</label>
                <input type="range" class="form-range" min="1" max="10" step="1" id="rating1" name="rating1" value="10"
                  oninput="changerating(this)" required>
                <div class="stars d-flex justify-content-between"><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i></div>

              </div>
              <div class="mb-3">
                <label for="message-text" class="col-form-label">Pandangan keseluruhan anda tentang projek </label>
                <input type="range" class="form-range" min="1" max="10" step="1" id="rating2" name="rating2" value="10"
                  oninput="changerating(this)" required>
                <div class="stars d-flex justify-content-between"><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i></div>

              </div>
              <div class="mb-3">
                <label for="message-text" class="col-form-label">Kesesuaian isi projek dengan tugas
                </label>
                <input type="range" style="accent-color:#ff0000" class="form-range" min="1" max="10" step="1"
                  id="rating3" name="rating3" value="10" oninput="changerating(this)" required>
                <div class="stars d-flex justify-content-between"><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i></div>
              </div>
              <div class="mb-3">
                <label for="message-text" class="col-form-label">Penambahbaikan (jika Ada)</label>
                <textarea class="form-control" id="message-text"></textarea>
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary " style="border-radius:50px;padding:8px 20px"
              data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn login" id="ratingSubmit">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container">
      <h3 class="sitename">FINGERPRINT ATTENDANCE SYSTEM</h3>
      <p>Seamlessly manage attendance with our secure and efficient fingerprint technology. Simple, accurate, and
        reliable—making attendance tracking effortless.</p>
      <div class="social-links d-flex justify-content-center">
        <a href=""><i class="bi bi-twitter-x"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-skype"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a>
      </div>
      <div class="container">
        <div class="copyright">
          <span>Copyright</span> <strong class="px-1 sitename">ADTEC Taiping</strong> <span>All Rights Reserved</span>
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you've purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
          <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="<?php echo $site_url ?>assets/libs/jquery/dist/jquery.min.js"></script>

  <script>




    function changerating(rangeInput) {
      const value = $(rangeInput).val(); // Get the slider's current value
      let stars = "";

      // Calculate the number of full, half, and empty stars
      const fullStars = Math.floor(value / 2); // Each 2 units equal one full star
      const isHalfStar = value % 2 !== 0; // Check if there’s a remainder for half star
      const emptyStars = 5 - fullStars - (isHalfStar ? 1 : 0); // Remaining stars are empty

      // Add full stars
      for (let i = 0; i < fullStars; i++) {
        stars += "<i class='bi bi-star-fill'></i>";
      }

      // Add half star if needed
      if (isHalfStar) {
        stars += "<i class='bi bi-star-half'></i>"; // Unicode character for half star
      }

      // Add empty stars
      for (let i = 0; i < emptyStars; i++) {
        stars += "<i class='bi bi-star'></i>";
      }
      // Update sibling div with new stars
      $(rangeInput).siblings(".stars").html(stars);
    }


    $('#ratingSubmit').click(function () {
      // const formData = $('#ratingForm').serialize();  // Serialize the form data
      var nama = document.getElementById("nama").value;
      var rating1 = document.getElementById("rating1").value;
      var rating2 = document.getElementById("rating2").value;
      var rating3 = document.getElementById("rating3").value;
      var content = document.getElementById("message-text").value;

      // console.log(nama)
      // console.log(rating1)
      // console.log(rating2)
      // console.log(rating3)
      // console.log(content)
      $.ajax({
        url: 'submitrating',  // PHP script to handle each rating individually
        type: 'POST',
        data: {
          send_rating: "test",
          nama: nama,
          rating1: rating1,
          rating2: rating2,
          rating3: rating3,
          content: content,
        },
        success: function (response) {
          // console.log(response);  // Log the server response

          $('#exampleModal').modal('hide')


        },
        error: function (xhr, status, error) {
          console.error('There was an error submitting the rating:', error);
        }
      });
    });
  </script>
</body>

</html>