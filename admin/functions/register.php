<?php
if (isset($_POST['user_register'])) {


  if (empty($_POST['ndp'])) {
    $errors['ndp'] = "NDP required";
  } else {
    $ndp = mysqli_real_escape_string($db, $_POST['ndp']);

  }
  if (empty($_POST['fullname'])) {
    $errors['fullname'] = "fullname required";
  } else {
    $fullname = mysqli_real_escape_string($db, $_POST['fullname']);

  }
  if (empty($_POST['kp'])) {
    $errors['kp'] = "kp required";
  } else {
    $kp = mysqli_real_escape_string($db, $_POST['kp']);

  }
  if (empty($_POST['jantina'])) {
    $errors['jantina'] = "jantina required";
  } else {
    $jantina = mysqli_real_escape_string($db, $_POST['jantina']);

  }
  if (empty($_POST['agama'])) {
    $errors['agama'] = "agama required";
  } else {
    $agama = mysqli_real_escape_string($db, $_POST['agama']);

  }
  if (empty($_POST['statuskahwin'])) {
    $errors['statuskahwin'] = "statuskahwin required";
  } else {
    $statuskahwin = mysqli_real_escape_string($db, $_POST['statuskahwin']);

  }
  if (empty($_POST['bangsa'])) {
    $errors['bangsa'] = "bangsa required";
  } else {
    $bangsa = mysqli_real_escape_string($db, $_POST['bangsa']);

  }
  if (empty($_POST['email'])) {
    $errors['email'] = "email required";
  } else {
    $email = mysqli_real_escape_string($db, $_POST['email']);

  }
  if (empty($_POST['phone'])) {
    $errors['phone'] = "Phone required";
  } else {
    $phone = mysqli_real_escape_string($db, $_POST['phone']);

  }
  if (empty($_POST['password1'])) {
    $errors['password1'] = "Password 1 required";
  } else {
    $password1 = mysqli_real_escape_string($db, $_POST['password1']);

  }
  if (empty($_POST['password2'])) {
    $errors['password2'] = "Password 2 required";
  } else {
    $password2 = mysqli_real_escape_string($db, $_POST['password2']);

  }
  if (empty($_POST['bengkel'])) {
    $errors['bengkel'] = "Bengekel required";
  } else {
    $bengkel = mysqli_real_escape_string($db, $_POST['bengkel']);

  }
  if (empty($_POST['sem1'])) {
    $errors['sem1'] = "Semester required";
  } else {
    $sem1 = mysqli_real_escape_string($db, $_POST['sem1']);

  }
  if (empty($_POST['sem2'])) {
    $errors['sem2'] = "Semester required";
  } else {
    $sem2 = mysqli_real_escape_string($db, $_POST['sem2']);

  }

  if (empty($_POST['course'])) {
    $errors['course'] = "kursus required";
  } else {
    $course = mysqli_real_escape_string($db, $_POST['course']);

  }


  $role = 4;


  
  $sem_q = "SELECT * FROM `sem` WHERE CURDATE() BETWEEN start_date AND end_date;";
  $resultsem = mysqli_query($db, $sem_q);
  $sem = mysqli_fetch_assoc($resultsem);

  $sem_now =$sem['id'];


  if (!empty($_POST['password1']) && !empty($_POST['password2'])) {

    if ($password1 != $password2) {
      $errors['password1'] = "Passwords dont match";
      $errors['password2'] = "Passwords dont match";
    }

  }




  //error handlng utk check data
  if (isset($ndp) && isset($email) && isset($phone) && isset($kp)) {

    $user_check_query = "SELECT * FROM user WHERE ndp='$ndp' OR email='$email'  OR phone='$phone'    OR kp='$kp'   LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
      if ($user['ndp'] === $ndp) {

        $errors['ndp'] = "NDP already registered";
      }

      if ($user['email'] === $email) {
        $errors['email'] = "Email already registered";

      }

      if ($user['phone'] === $phone) {
        $errors['phone'] = "Phone already registered";

      }

      if ($user['kp'] === $kp) {
        $errors['kp'] = "KP already registered";

      }
    }
  }
  checkuploadpid("test", $errors);

  // echo $filename;

  if (count($errors) == 0) {

    //encrypt password
    $password = md5($password1);

    $query = "INSERT INTO user (role, ndp,password, nama,email,phone,kp,jantina,agama,status_kahwin,bangsa,bengkel_id) 
                          VALUES('$role','$ndp','$password','$fullname','$email','$phone','$kp','$jantina','$agama','$statuskahwin','$bangsa','$bengkel')";
    mysqli_query($db, $query);


    //verify
    $query = "SELECT a.*, b.nama as role_name FROM `user` a INNER JOIN user_role b ON a.role = b.id WHERE (ndp='$ndp' OR email='$email') AND password='$password'";
    $results = mysqli_query($db, $query);
    $user3 = mysqli_fetch_assoc($results);
    $id3 = $user3['id'];
    $filename = uploadpic_id($user3['id'], $errors);
    // echo $filename;

    $query2 = "UPDATE user SET image_url='$filename' WHERE id='$id3'";
    mysqli_query($db, $query2);

    $results = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($results);

    $query = "INSERT INTO user_enroll (user_id, course_id sem_start,sem_now,sem_end,user_status) 
                          VALUES('$id3','$course','$sem1','$sem_now','$sem2','1')";
    mysqli_query($db, $query);

    $user3['password'] = "";


    //array
    $_SESSION['user_details'] = $user;
    // $_SESSION['user_details']['password'] = "";


    header('location:' . $site_url . 'dashboard');
  }
}