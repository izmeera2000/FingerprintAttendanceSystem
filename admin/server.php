<?php
require __DIR__ . '/../route.php';



// require __DIR__ . '/vendor/autoload.php';

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
// $dotenv->load();
// initializing variables

$site_url = $_ENV['site2'];
// debug_to_console2($site_url);

// $username = "";
// $email = "";
// global $$errors;
$errors = array();
$toast = array();
// $GLOBALS['$errors']= array();
// connect to the database
$db = mysqli_connect($_ENV['host'], $_ENV['user'], $_ENV['pass'], $_ENV['database2']);



// REGISTER USER
if (isset($_POST['user_register'])) {
  // receive all input values from the form
  // $username = mysqli_real_escape_string($db, $_POST['username']);


  // Check if image file is a actual image or fake image
  // if (isset($_POST["submit"])) {
  //   $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  //   if ($check !== false) {
  //     echo "File is an image - " . $check["mime"] . ".";
  //     $uploadOk = 1;
  //   } else {
  //     echo "File is not an image.";
  //     $uploadOk = 0;
  //   }
  // }


  if (empty($_POST['ndp'])) {
    $errors['ndp'] = "NDP requred";
  } else {
    $ndp = mysqli_real_escape_string($db, $_POST['ndp']);

  }
  if (empty($_POST['fullname'])) {
    $errors['fullname'] = "fullname requred";
  } else {
    $fullname = mysqli_real_escape_string($db, $_POST['fullname']);

  }
  if (empty($_POST['kp'])) {
    $errors['kp'] = "kp requred";
  } else {
    $kp = mysqli_real_escape_string($db, $_POST['kp']);

  }
  if (empty($_POST['jantina'])) {
    $errors['jantina'] = "jantina requred";
  } else {
    $jantina = mysqli_real_escape_string($db, $_POST['jantina']);

  }
  if (empty($_POST['agama'])) {
    $errors['agama'] = "agama requred";
  } else {
    $agama = mysqli_real_escape_string($db, $_POST['agama']);

  }
  if (empty($_POST['statuskahwin'])) {
    $errors['statuskahwin'] = "statuskahwin requred";
  } else {
    $statuskahwin = mysqli_real_escape_string($db, $_POST['statuskahwin']);

  }
  if (empty($_POST['bangsa'])) {
    $errors['bangsa'] = "bangsa requred";
  } else {
    $bangsa = mysqli_real_escape_string($db, $_POST['bangsa']);

  }
  if (empty($_POST['email'])) {
    $errors['email'] = "email requred";
  } else {
    $email = mysqli_real_escape_string($db, $_POST['email']);

  }
  if (empty($_POST['phone'])) {
    $errors['phone'] = "phone requred";
  } else {
    $phone = mysqli_real_escape_string($db, $_POST['phone']);

  }
  if (empty($_POST['password1'])) {
    $errors['password1'] = "password1 requred";
  } else {
    $password1 = mysqli_real_escape_string($db, $_POST['password1']);

  }
  if (empty($_POST['password2'])) {
    $errors['password2'] = "password2 requred";
  } else {
    $password2 = mysqli_real_escape_string($db, $_POST['password2']);

  }




  $role = 2;



  if (!empty($_POST['password1']) && !empty($_POST['password2'])) {

    if ($password1 != $password2) {
      $errors['password1'] = "Passwords dont match";
      $errors['password2'] = "Passwords dont match";
    }

  }




  // var_dump($_POST);
  //error handlng utk check data
  if (isset($ndp) && isset($email) && isset($phone) && isset($kp)) {

    $user_check_query = "SELECT * FROM user WHERE ndp='$ndp' OR email='$email'  OR phone='$phone'    OR kp='$kp'   LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
      if ($user['ndp'] === $ndp) {
        // $arrndp = array(
        //   "ndp" => "NDP already registered"
        // );
        $errors['ndp'] = "NDP already registered";
        // array_push($errors['ndp'], "NDP already registered");
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

    $query = "INSERT INTO user (role, ndp,password, nama,email,phone,kp,jantina,agama,status_kahwin,bangsa) 
                          VALUES('$role','$ndp','$password','$fullname','$email','$phone','$kp','$jantina','$agama','$statuskahwin','$bangsa')";
    mysqli_query($db, $query);


    //verify
    $query = "SELECT * FROM user WHERE (ndp='$ndp' OR email='$email') AND password='$password'";
    $results = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($results);

    $filename = uploadpic_id($user['id'], $errors);
    // echo $filename;

    $query2 = "UPDATE user SET image_url='$filename' WHERE email='$email'";
    mysqli_query($db, $query2);

    $results = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($results);
    $user['password'] = "";

    //array
    $_SESSION['user_details'] = $user;
    // $_SESSION['user_details']['password'] = "";


    header('location:' . $site_url . '');
  }
}

if (isset($_POST['user_login'])) {
  $login = mysqli_real_escape_string($db, $_POST['login']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  // debug_to_console("test");

  // if (empty($username)) {
  //       array_push($errors, "Username is required");
  // }
  // if (empty($password)) {
  //       array_push($errors, "Password is required");
  // }

  if (count($errors) == 0) {






    $password = md5($password);


    $query = "SELECT * FROM user WHERE (ndp='$login' or email='$login') AND password='$password'";
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

      header('location:' . $site_url . '');
    } else {
      $errors['login'] = "User doesn't exist or wrong password";
    }
  }

}

if (isset($_POST['edit_profile'])) {
  $username = $_SESSION['user_details']['username'];
  $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $phone = mysqli_real_escape_string($db, $_POST['phone']);

  $query = "UPDATE user SET fullname = '$fullname', email='$email',phone_number='$phone' WHERE username='$username' ";
  $results = mysqli_query($db, $query);
  // debug_to_console($fullname);
}

function debug_to_console($data)
{
  $enable = 1;
  $output = $data;
  if (is_array($output))
    $output = implode(',', $output);
  if ($enable) {
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
  }
}




if (isset($_POST['calendarfetch'])) {


  // echo (json_encode($_POST));

  $id = $_SESSION['user_details']['id'];

  $start = ($_POST['calendarfetch']['start']);
  $end = ($_POST['calendarfetch']['end']);
  // print_r($cart_id);
  // echo date('Y-m-d', strtotime($start));
  $start = date("Y-m-d", strtotime($start));
  $end = date("Y-m-d", strtotime($end));
  // echo (json_encode($start));
  // echo (json_encode($end));

  $query = "SELECT a.id,masalah ,tarikh as start,tarikh, event_status, b.ndp as ndp, b.id as user_id ,sebab , kaunselor_id FROM kaunselor_jadual a INNER JOIN ( SELECT id, ndp FROM user ) b  ON b.id = a.user_id WHERE (tarikh BETWEEN ('$start') AND ('$end')) ORDER BY tarikh  ASC ";
  // echo json_encode($query);

  $result = mysqli_query($db, $query);
  $eventArray = array();
  // $eventArray['color'] = "red";

  while ($row = mysqli_fetch_assoc($result)) {

    $row['title'] = $row['masalah'] . " (" . $row['ndp'] . ")";


    if ($row['event_status'] == "0") {

      $row['color'] = "red";

    }

    if ($row['event_status'] == "2") {
      $row['color'] = "green";

    }
    if ($row['user_id'] != $id) {
      $row['color'] = "gray";
      $row['title'] = "";
      $row['masalah'] = "";
      $row['ndp'] = "";

    }

    // if ($row['event_status'] == "2" && $row['user_id'] != $id) {
    //   $row['color'] = "gray";
    //   $row['title'] = "";
    //   $row['masalah'] = "";
    //   $row['ndp'] = "";
    // }
    // $row['tarikh'] = "";(


    if ($row['user_id'] == $id) {

      array_push($eventArray, $row);

    } else {
      if ($row['event_status'] != "0") {
        array_push($eventArray, $row);

      }
    }

    $row['allDay'] = "true";


  }
  // mysqli_free_result($result);

  echo json_encode($eventArray);
  die();

}
if (isset($_POST['calendarfetch2'])) {


  // echo (json_encode($_POST));

  // $id = $_SESSION['user_details']['id'];

  $start = ($_POST['calendarfetch2']['start']);
  $end = ($_POST['calendarfetch2']['end']);
  // print_r($cart_id);
  // echo date('Y-m-d', strtotime($start));
  $start = date("Y-m-d", strtotime($start));
  $end = date("Y-m-d", strtotime($end));
  // echo (json_encode($start));
  // echo (json_encode($end));

  $query = "SELECT a.id,masalah ,tarikh as start, event_status, b.ndp as ndp, b.id as user_id ,sebab , kaunselor_id FROM kaunselor_jadual a INNER JOIN ( SELECT id, ndp FROM user ) b  ON b.id = a.user_id WHERE (tarikh BETWEEN ('$start') AND ('$end')) ORDER BY id";
  // echo json_encode($query);

  $result = mysqli_query($db, $query);
  $eventArray = array();
  // $eventArray['color'] = "red";

  while ($row = mysqli_fetch_assoc($result)) {

    $row['title'] = $row['masalah'] . " (" . $row['ndp'] . ")";


    if ($row['event_status'] == "0") {
      $row['color'] = "red";

    }


    $row['allDay'] = "true";

    array_push($eventArray, $row);

  }
  // mysqli_free_result($result);

  echo json_encode($eventArray);
  die();

}


if (isset($_POST['calendaraddna'])) {



  // print_r($cart_id);

  $title = $_POST['calendaraddna']['title'];
  $start = $_POST['calendaraddna']['start'];
  $user_id = $_POST['calendaraddna']['user_id'];




  // $user_check_query = "SELECT * FROM kaunselor_jadual WHERE user_id='$user_id' AND tarikh='$start'   LIMIT 1";
  // $result = mysqli_query($db, $user_check_query);
  // $existed = mysqli_fetch_assoc($result);
  // debug_to_console("asdads");

  // echo $start;
  // if (!$existed) { // if user exists

  $query = "INSERT INTO  kaunselor_jadual (user_id,masalah,tarikh) VALUES ('$user_id','$title','$start')";
  // debug_to_console("test");
  // echo $query;
  $result = mysqli_query($db, $query);


  // $eventArray = array();
  // while ($row = mysqli_fetch_assoc($result)) {
  //     array_push($eventArray, $row);
  // }
  // // mysqli_free_result($result);

  // echo json_encode($eventArray);
  // } else {
  //   // showtoast("Existed", $toast);
  //   // array_push($toast, "Existed");
  //   echo "existed";

  // }
  die();

}



if (isset($_POST['calendardeletena'])) {



  // print_r($cart_id);

  $title = $_POST['calendardeletena']['title'];
  $start = $_POST['calendardeletena']['start'];
  $user_id = $_POST['calendardeletena']['user_id'];




  // $user_check_query = "SELECT * FROM kaunselor_jadual WHERE user_id='$user_id' AND tarikh='$start'   LIMIT 1";
  // $result = mysqli_query($db, $user_check_query);
  // $existed = mysqli_fetch_assoc($result);
  // debug_to_console("asdads");

  // echo $start;
  // if (!$existed) { // if user exists

  $query = "DELETE FROM  kaunselor_jadual WHERE id ='$user_id' ";
  // debug_to_console("test");
  // echo $query;
  $result = mysqli_query($db, $query);


  // $eventArray = array();
  // while ($row = mysqli_fetch_assoc($result)) {
  //     array_push($eventArray, $row);
  // }
  // // mysqli_free_result($result);

  // echo json_encode($eventArray);
  // } else {
  //   // showtoast("Existed", $toast);
  //   // array_push($toast, "Existed");
  //   echo "existed";

  // }
  die();

}


if (isset($_POST['borang_psikologi_send_a'])) {
  // var_dump($_POST);
//   foreach ($jwb as $key => $value) {
//     echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
// }  
  $user_id = $_POST['user_id'];
  $answer = array();

  $query = "SELECT id as kategori_id FROM borang_psikologi_kategori";

  $result = mysqli_query($db, $query);
  $katArray = array();
  while ($row = mysqli_fetch_assoc($result)) {
    array_push($katArray, $row);
  }
  // debug_to_console(  json_encode($katArray[1]));


  foreach ($_POST as $key => $value) {
    if (strpos($key, 'soalan-') === 0) {
      // value starts with book_
      // $soalan_id = str_replace("soalan-", "", $key);
      // debug_to_console($key);

      $last = explode("-", $key, 3);
      $soalan_id = $last[1];
      $kategori = $last[2];
      // debug_to_console($soalan_id);
      // debug_to_console($kategori);
      foreach ($katArray as $id => $column) {
        if ($kategori == $katArray[$id]['kategori_id']) {
          // debug_to_console(  json_encode($katArray[$id]['id']));


          // $newt = array(
          //   $katArray[$id]['id'] => $value
          // );
          // array_push($totalkat, $newt);
          if (!array_key_exists("value", $katArray[$id])) {

            $katArray[$id]['value'] = 0;
          }
          $katArray[$id]['value'] = $katArray[$id]['value'] + $value;
        }

      }

      $newarr = array(
        $soalan_id => $value
      );
      array_push($answer, $newarr);

    }
  }
  debug_to_console(json_encode($katArray));
  $answer = json_encode($answer);
  $katArray = json_encode($katArray);
  debug_to_console($user_id);

  $query = "INSERT INTO  user_psikologi (user_id,jawapan_psikologi,keputusan) VALUES ('$user_id','$answer','$katArray')";
  $result = mysqli_query($db, $query);
  // debug_to_console($query);

  // debug_to_console(json_decode($_POST['borang_psikologi_send_a']));
  header('location:' . $site_url . '');

}

function formvalidatelabel($key, $arr)
{
  // global $errors;
  // var_dump($arr);
  if ($arr) {
    $error = "";
    if (array_key_exists($key, $arr)) {

      if ($arr[$key]) {
        echo "is-invalid";
      } else {
        echo "is-valid";

      }


    } else {
      echo "is-valid";

    }
  }
  // debug_to_console($arr[$key]);
  // $arr[$key] = "NDP requred";

}
function formvalidateerr($key, $arr)
{
  if ($arr) {

    if (array_key_exists($key, $arr)) {
      echo $arr[$key];




    }
  }
}

function checkuploadpid($id, &$err)
{

  $uploadOk = 1;


  $target_dir = "./assets/img/user/test/";

  $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
  // $check = getimagesize($_FILES["gambar"]["tmp_name"]);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $target_file = $target_dir . "gambar." . $imageFileType;

  echo $imageFileType;

  if ($_FILES["gambar"]["size"] > 500000) {
    $err['gambar'] = "File too large";
    $uploadOk = 0;

  }
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $err['gambar'] = "Sorry, only JPG, JPEG & PNG  files are allowed.";
    $uploadOk = 0;

  }

}

function uploadpic_id($id, &$err)
{
  $uploadOk = 1;

  if (!is_dir("./assets/img/user/$id/")) {
    mkdir("./assets/img/user/$id/", 0755, true);
  }

  $target_dir = "./assets/img/user/$id/";

  $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
  // $check = getimagesize($_FILES["gambar"]["tmp_name"]);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $target_file = $target_dir . "gambar." . $imageFileType;


  if ($_FILES["gambar"]["size"] > 500000) {
    $err['gambar'] = "File too large";
    $uploadOk = 0;

  }
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $err['gambar'] = "Sorry, only JPG, JPEG & PNG  files are allowed.";
    $uploadOk = 0;

  }
  if ($uploadOk == 1) {

    if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
      $err['gambar'] = "Sorry, there was an error uploading your file.";
    } else {
      return "gambar." . $imageFileType;

    }
  }

}

function showtoast($message, &$toast)
{
  // $toasted = "asd";
  array_push($toast, $message);


  echo '<script>document.addEventListener("DOMContentLoaded", function(event){
  $.each($(".toast"), function (i, item) {coreui.Toast.getOrCreateInstance(item).show();});
});</script>';
}


function showmodal($modal_name)
{




  echo '    <script>  const myModal = new coreui.Modal("#' . $modal_name . '")
      myModal.show();</script>';
}




// if (isset($_POST['user_calendaradd'])) {

// debug_to_console("test");
// showmodal("user_calendaradd");

// }

if (isset($_POST['senaraistudent'])) {

  $students = array();

  $query =
    "SELECT id,role,ndp,nama,email,phone,kp,jantina,agama,status_kahwin,bangsa,image_url,time_add FROM user WHERE  role='2'";
  $results = mysqli_query($db, $query);
  if (mysqli_num_rows($results) > 0) {


    while ($user = mysqli_fetch_assoc($results)) {

      $students[] = array(
        "a" => '<div class="avatar avatar-md"><img class="avatar-img"
                                                                src="' . $site_url . 'assets/img/user/' . $user['id'] . '/' . $user['image_url'] . '"
                                                                alt="' . $user['nama'] . '"></div>',           // Modify the key based on your column names
        "b" => '<div class="text-nowrap">' . $user['nama'] . '</div>
                                                        <div class="small text-body-secondary text-nowrap">
                                                            <span >Registered:
                                                            </span><span>' . $user['time_add'] . '</span>
                                                        </div>',          // Modify the key based on your column names
        "c" => $user['email'],         // Modify the key based on your column names
        "d" => '
            <a class="btn btn-success me-2" href="' . $site_url . 'kaunselor/student/' . $user['ndp'] . '">
        <svg class="icon">
            <use
                xlink:href="' . $site_url . '/assets/vendors/@coreui/icons/svg/free.svg#cil-magnifying-glass">
            </use>
        </svg></a>
        ',        // Add more fields if needed
      );

    }
  }



  $response = [
    "draw" => intval($_POST['draw'] ?? 1),
    "recordsTotal" => count($students),
    "recordsFiltered" => count($students),
    "data" => $students
  ];

  echo json_encode($response);
  die();
}

if (isset($_POST['order'])) {
  // echo json_encode($_POST);
  $order = $_POST['order'];

  foreach ($order as $row) {
    $id = $row['id'];
    $re_order = $row['re_order'];


    $query = "UPDATE borang_psikologi SET re_order = '$re_order' WHERE id = '$id'";
    mysqli_query($db, $query);

  }
  die();

}

if (isset($_POST['senaraisoalan'])) {

  $data = array();

  $query =
    "SELECT a.*,b.nama_kategori  FROM borang_psikologi a INNER JOIN  borang_psikologi_kategori b ON a.kategori = b.id ORDER BY re_order ASC";
  $results = mysqli_query($db, $query);
  if (mysqli_num_rows($results) > 0) {

    while ($row = $results->fetch_assoc()) {
      $data[] = array(
        "id" => $row['id'], // Include id in the response
        "a" => '<div class="text-center" >' . $row['re_order'] . '</div>',  // Formatting for re_order
        "b" => '<div class="text-center">' . $row['soalan'] . '</div>',   // Formatting for soalan
        "c" => '<div class="text-center">' . $row['nama_kategori'] . '</div>',  // Formatting for nama_kategori
        "d" => '
              <a class="btn btn-success" href="details.php?id=' . $row['id'] . '">
                  <svg class="icon">
                      <use xlink:href="icons.svg#icon-view"></use>
                  </svg>
              </a>
          ' // Button with link for status
      );
    }
  }

  echo json_encode(array('data' => $data));
  die();

}

if (isset($_POST['fetchresource'])) {
  $query =
    "SELECT * FROM user";
  $results = mysqli_query($db, $query);
  $resources = array();

  while ($row = $results->fetch_assoc()) {
    $resources[] = array(
      'id' => $row['id'],       // Unique identifier for the resource
      'title' => $row['nama'],  // Name or title for the resource
    );
  }

  echo json_encode($resources);
  die();

}


if (isset($_POST['fetchevent'])) {

  $query = "SELECT * FROM attendance";
  $results = mysqli_query($db, $query);
  $events = array();

  while ($row = $results->fetch_assoc()) {
    $events[] = array(
      'id' => $row['user_id'],                       // Unique identifier for the event
      'resourceId' => $row['user_id'],          // ID of the user (resource)
      'title' => "asdasd",                // Status or description of the event
      'start' => $row['masa_mula'],       // Date of the attendance
      'end' => $row['masa_tamat'],       // Date of the attendance
      // Optionally add 'end' or other event properties here
    );
  }

  echo json_encode($events);
  die();

}
?>