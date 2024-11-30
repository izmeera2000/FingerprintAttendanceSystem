<?php


if (isset($_POST['user_login'])) {
  $login = mysqli_real_escape_string($db, $_POST['login']);
  $password = mysqli_real_escape_string($db, $_POST['password']);


  if (count($errors) == 0) {






    $password = md5($password);


    $query = "SELECT a.*, b.nama as role_name ,c.course_id AS course FROM `user` a 
INNER JOIN user_role b ON a.role = b.id
LEFT JOIN user_staff c ON a.id = c.user_id WHERE (ndp='$login' or email='$login') AND password='$password'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) {
      // $_SESSION['success'] = "You are now logged in";
      $user = mysqli_fetch_assoc($results);
      // debug_to_console("test2");
      $user['password'] = "";

      $_SESSION['user_details'] = $user;
      // $_SESSION['username'] = $user["username"];
      // $user_id = $user['id'];
      // var_dump($_SESSION['username2']);

      header('location:' . $site_url . 'dashboard');
    } else {
      $errors['login'] = "User doesn't exist or wrong password";
    }
  }

}


