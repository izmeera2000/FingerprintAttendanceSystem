<?php




if (isset($_POST['send_rating'])) {
    // echo "test";
    // var_dump(($_POST));
    $nama = $_POST['nama'];  // Records per page
  
    $rating1 = $_POST['rating1'] / 2;  // Records per page
    $rating2 = $_POST['rating2'] / 2;  // Records per page
    $rating3 = $_POST['rating3'] / 2;  // Records per page
    $content = $_POST['content'];  // Records per page
    // $mula = $_POST['mula'];  // Records per page
    // $tamat = $_POST['tamat'];  // Records per page
  
  
  
    $query = "INSERT INTO feedback (nama,rate1,rate2,rate3,content) VALUES ('$nama','$rating1','$rating2','$rating3','$content');";
  
    // debug_to_console($query);
    $results = mysqli_query($db, $query);
    // header('location:' . $site_url . 'course/create');
    die();
  }
  