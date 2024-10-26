<?php
require __DIR__ . '/../route.php';





$site_url = $_ENV['site2'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$errors = array();
$toast = array();
// $GLOBALS['$errors']= array();
// connect to the database
$db = mysqli_connect($_ENV['host'], $_ENV['user'], $_ENV['pass'], $_ENV['database2']);

date_default_timezone_set('Asia/Kuala_Lumpur');


// REGISTER USER
if (isset($_POST['user_register'])) {


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




  $role = 4;



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

    $query = "INSERT INTO user (role, ndp,password, nama,email,phone,kp,jantina,agama,status_kahwin,bangsa) 
                          VALUES('$role','$ndp','$password','$fullname','$email','$phone','$kp','$jantina','$agama','$statuskahwin','$bangsa')";
    mysqli_query($db, $query);


    //verify
    $query = "SELECT a.*, b.name as role_name FROM `user` a INNER JOIN user_role b ON a.role = b.id WHERE (ndp='$ndp' OR email='$email') AND password='$password'";
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


  if (count($errors) == 0) {






    $password = md5($password);


    $query = "SELECT a.*, b.name as role_name FROM `user` a INNER JOIN user_role b ON a.role = b.id WHERE (ndp='$login' or email='$login') AND password='$password'";
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














//validation on label

function formvalidatelabel($key, $arr)
{

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


}
//validation on label

function formvalidateerr($key, $arr)
{
  if ($arr) {

    if (array_key_exists($key, $arr)) {
      echo $arr[$key];




    }
  }
}
//check pic by id

function checkuploadpid($id, &$err)
{

  $uploadOk = 1;


  $target_dir = "./assets/images/user/test/";

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
//upload pic by id

function uploadpic_id($id, &$err)
{
  $uploadOk = 1;

  if (!is_dir("./assets/images/user/$id/")) {
    mkdir("./assets/images/user/$id/", 0755, true);
  }

  $target_dir = "./assets/images/user/$id/";

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

// verify_email.php

if (isset($_GET['admin_token'])) {
  $token = $_GET['admin_token'];

  // Check if token exists and is not expired
  $query = "SELECT * FROM email_verification  WHERE token = '$token' LIMIT 1";
  $results = mysqli_query($db, $query);
  $row = $result->fetch_assoc();

  if ($row && strtotime($row['expires_at']) > time()) {
    // Token is valid and not expired
    $id = $row['user_id'];

    // Update the admin's status to verified
    $query = "UPDATE user SET email_verified = 1 WHERE id = '$id'";
    $results = mysqli_query($db, $query);

    // Delete the token after verification
    $query = "DELETE FROM   email_verification   WHERE user_id = '$id'";

    $results = mysqli_query($db, $query);


    echo "Email successfully verified!";
  } else {
    echo "Invalid or expired token.";
  }
}  


function validateAdminEmail($email)
{
  // Check if the email starts with 8 digits
  if (preg_match('/^\d{8}@/', $email)) {
    return false; // Invalid for admin email
  }
  return true; // Valid for admin email
}

function generateVerificationToken($id, $db)
{
  $token = bin2hex(random_bytes(32)); // Generate a secure random token
  $expiresAt = date('Y-m-d H:i:s', strtotime('+1 day')); // Set expiration time (e.g., 1 day from now)

  // Insert the token into the email_verification_tokens table

  $query = "INSERT INTO  email_verification (user_id, token, expires_at) VALUES ('$id','$token','$expiresAt')";
  $results = mysqli_query($db, $query);

  return $token;
}

if (isset($_POST['fetchresource'])) {
  $query =
    "SELECT * FROM user WHERE role = 4";
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

  $start_date = new DateTime($_POST['fetchevent']['start']);
  $start_date2 = $start_date->format('Y-m-d');

  $end_date = new DateTime($_POST['fetchevent']['end']);
  $end_date2 = $end_date->format('Y-m-d');


  $query = "SELECT *
FROM attendance
WHERE 
    (DATE(masa_mula) BETWEEN '$start_date2' AND '$end_date2')
    OR 
    (DATE(masa_tamat) BETWEEN '$start_date2' AND '$end_date2')
";
  $results = mysqli_query($db, $query);
  $events = array();



  while ($row = $results->fetch_assoc()) {

    if ($row['event_status'] == 1) {
      $color = "blue";
    } else {
      $color = "red";

    }
    if (empty($row['masa_tamat'])) {

      $masa_tamat = date("Y-m-d H:i:s", strtotime("now"));
    } else {
      $masa_tamat = $row['masa_tamat'];
    }
    $events[] = array(
      'id' => $row['user_id'],                       // Unique identifier for the event
      'resourceId' => $row['user_id'],          // ID of the user (resource)
      // 'title' => "asdasd",                // Status or description of the event
      'start' => $row['masa_mula'],       // Date of the attendance
      'end' => $masa_tamat,       // Date of the attendance
      // 'masa' => date("Y-m-d H:i:s", strtotime("now")),
      'color' => $color,       // Date of the attendance
      // Optionally add 'end' or other event properties here
    );
  }

  echo json_encode($events);
  die();

}

if (isset($_POST['fetchevent2'])) {


  $start_date = new DateTime($_POST['fetchevent2']['start']);
  $start_date2 = $start_date->format('Y-m-d');

  $end_date = new DateTime($_POST['fetchevent2']['end']);
  $end_date2 = $end_date->format('Y-m-d');
  //slot
  ;


  $query = "SELECT a.*, b.masa_mula, b.masa_tamat, c.role
FROM attendance_slot a
INNER JOIN time_slot b ON a.slot = b.slot
INNER JOIN user c ON c.id = a.user_id
WHERE c.role = 4
AND DATE(a.tarikh) BETWEEN '$start_date2' AND '$end_date2' ";
  $results = mysqli_query($db, $query);
  $events = array();




  while ($row = $results->fetch_assoc()) {


    $sebab = $row['reason'];
    $file_path = $row['file_path'];
    $tarikh2 = $row['tarikh2'];
    $verify = $row['verify'];

    $slot_statuses = [
      0 => "Unattended / Unexcused Absence",
      1 => "Present",
      2 => "Late",
      3 => "Pending Excuse of Absence",
      4 => "Excused Absence",
      5 => "Left Early",
      6 => "Break",
      7 => "Not Yet",

    ];

    switch (true) {
      case ($row['slot_status'] == 0):
        $color = 'red';
        $textC = "white";

        break;
      case ($row['slot_status'] == 2):
        $color = 'yellow';
        $textC = "black";
        break;
      case ($row['slot_status'] == 3):
        $color = 'red';
        $textC = "white";

        break;
      case ($row['slot_status'] == 4):
        $color = 'blue';
        $textC = "white";

        break;
      case ($row['slot_status'] == 5):
        $color = 'yellow';
        $textC = "black";

        break;
      case ($row['slot_status'] == 7):
        $color = 'grey';
        $textC = "black";

        break;



      default:
        $color = 'green';
        $textC = "white";

        break;


    }

    $start = new DateTime($row['tarikh'] . " " . $row['masa_mula']);
    // $start->format('Y-m-d H:i:s');

    $end = new DateTime($row['tarikh'] . " " . $row['masa_tamat']);
    // $end->format('Y-m-d H:i:s');

    if ($row['slot_status'] != 6) {
      $events[] = array(
        'id' => $row['user_id'],                       // Unique identifier for the event
        'resourceId' => $row['user_id'],          // ID of the user (resource)
        'title' => $row['slot_status'],
        'start' => $start->format('Y-m-d H:i:s'),       // Date of the attendance
        'end' => $end->format(format: 'Y-m-d H:i:s'),       // Date of the attendance
        'status' => $row['slot_status'],        // Status or description of the event
        'status_description' => $slot_statuses[$row['slot_status']],
        'tarikh' => $row['tarikh'],
        'textColor' => $textC,
        'sebab' => $sebab,
        'file_path' => $file_path,
        'tarikh2' => $tarikh2,
        'verify' => $verify,
        'color' => $color,
      );
    }

  }

  echo json_encode($events);
  die();

}

if (isset($_POST['eventmasuk'])) {

  $user_id = $_SESSION['user_details']['id'];

  $date_now = date("Y-m-d H:i:s", strtotime("now"));

  $query = "INSERT INTO attendance (user_id, event_status, masa_mula) VALUES ('7','1','$date_now');";
  $results = mysqli_query($db, $query);

  // $query = "INSERT INTO attendance_slot  (user_id, slot,slot_status,tarikh) VALUES ('7','1','1','$date_now');";
  // $results = mysqli_query($db, $query);


}



if (isset($_POST['eventkeluar'])) {


  $query = "SELECT * FROM attendance WHERE event_status = '1' AND user_id ='7' AND masa_tamat IS NULL";
  $results = mysqli_query($db, $query);
  while ($row = $results->fetch_assoc()) {
    $id = $row['id'];

  }

  $now = date("Y-m-d H:i:s", strtotime("now"));
  $masa_tamat = date("Y-m-d H:i:s", strtotime("today 18:00"));

  $query = "UPDATE attendance SET masa_tamat='$now' WHERE id='$id'";
  $results = mysqli_query($db, $query);


  if (($masa_tamat > $now)) {
    $query = "INSERT INTO attendance (user_id, event_status, masa_mula)
    VALUES ('7','1','$now');";
    $results = mysqli_query($db, $query);


  }

}





function sendmail($receiver, $title, $filepath, $var = "")
{





  $mail = new PHPMailer(true);

  try {

    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->Host = 'kaunselingadtectaiping.com.my';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['email2_username'];
    $mail->Password = $_ENV['email2_password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465; // Adjust as needed (e.g., 465 for SSL)


    $mail->setFrom('appointment@kaunselingadtectaiping.com.my', 'Temu Janji');
    $mail->addAddress($receiver);


    $emailBodyContent = getEmailContent($filepath, $var);


    // $mail->addEmbeddedImage(getcwd() . '/assets/img/logo3.png', 'logo_cid'); // 'logo_cid' is a unique ID





    $mail->isHTML(true);

    $mail->Subject = $title;
    if (!$var) {


      $mail->Body = 'This is the HTML message body <b>in bold!</b>';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    } else {
      $mail->Body = $emailBodyContent;         // Set the body with the content from the .php file
      $mail->AltBody = $title;
    }
    $mail->send();
    // echo 'Message has been sent';
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}





if (isset($_POST['class_findall'])) {

  $class = array();

  $limit = $_POST['class_findall']['limit'];  // Records per page
  $offset = $_POST['class_findall']['offset'];  // Record starting point
  $draw = $_POST['class_findall']['draw'];
  $searchTerm = isset($_POST['class_findall']['search']) ? $_POST['class_findall']['search'] : '';

  // Query to get total number of records in the 'kelas' table with search filter
  $queryTotal = "SELECT COUNT(*) as total FROM kelas a 
                 LEFT JOIN fp_device b1 ON a.fp_entrance = b1.id
                 LEFT JOIN fp_device b2 ON a.fp_exit = b2.id";
  if (!empty($searchTerm)) {
    $queryTotal .= " WHERE a.nama_kelas LIKE '%$searchTerm%' 
                     OR a.location LIKE '%$searchTerm%' 
                     OR b1.nama LIKE '%$searchTerm%' 
                     OR b2.nama LIKE '%$searchTerm%'";
  }

  $resultTotal = mysqli_query($db, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultTotal);
  $recordsTotal = $rowTotal['total'];

  // Query to get paginated records with search filter
  $query = "SELECT a.*, b1.nama as fp_entrance_name, b2.nama as fp_exit_name
            FROM kelas a
            LEFT JOIN fp_device b1 ON a.fp_entrance = b1.id
            LEFT JOIN fp_device b2 ON a.fp_exit = b2.id";
  if (!empty($searchTerm)) {
    $query .= " WHERE a.nama_kelas LIKE '%$searchTerm%' 
                OR a.location LIKE '%$searchTerm%' 
                OR b1.nama LIKE '%$searchTerm%' 
                OR b2.nama LIKE '%$searchTerm%'";
  }
  $query .= " LIMIT $limit OFFSET $offset";
  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
      $class[] = array(
        "a" => $row['nama_kelas'],
        "b" => $row['location'],
        "c" => $row['fp_entrance'] != 0 ? $row['fp_entrance_name'] : "Not Assigned",
        "d" => $row['fp_exit'] != 0 ? $row['fp_exit_name'] : "Not Assigned",
        "id" => $row['id'],
      );
    }
  }

  // Create the response with proper record counts
  $response = [
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,  // Total records in the table
    "recordsFiltered" => $recordsTotal,  // Records filtered by search
    "data" => $class
  ];

  echo json_encode($response);
  die();
}


if (isset($_POST['class_createf'])) {
  // echo "test";
  // var_dump(($_POST));

  $nama = $_POST['nama'];  // Records per page
  $location = $_POST['location'];  // Records per page
  $fpin = $_POST['fpin']; // Assign null if 'fpin' is not set
  $fpout = $_POST['fpout']; // Assign null if 'fpin' is not set


  $query = "INSERT INTO kelas (nama_kelas, location, fp_entrance,fp_exit  ) VALUES ('$nama','$location','$fpin','$fpout');";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'class/create');

}

if (isset($_POST['class_editf'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  $nama = $_POST['nama'];  // Records per page
  $location = $_POST['location'];  // Records per page
  $fpin = $_POST['fpin']; // Assign null if 'fpin' is not set
  $fpout = $_POST['fpout']; // Assign null if 'fpin' is not set


  $query = "UPDATE  kelas SET nama_kelas='$nama', location='$location',fp_entrance ='$fpin' ,fp_exit ='$fpout' WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'class/create');

}


if (isset($_POST['class_deletef'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  // $nama = $_POST['nama'];  // Records per page
  // $location = $_POST['location'];  // Records per page
  // $fpin = $_POST['fpin'] ; // Assign null if 'fpin' is not set
  // $fpout =  $_POST['fpout'] ; // Assign null if 'fpin' is not set


  $query = "DELETE FROM   kelas   WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'class/create');

}




if (isset($_POST['fp_findall'])) {

  $fp = array();

  $limit = $_POST['fp_findall']['limit'];  // Records per page
  $offset = $_POST['fp_findall']['offset'];  // Record starting point
  $draw = $_POST['fp_findall']['draw'];
  $searchTerm = isset($_POST['fp_findall']['search']) ? $_POST['fp_findall']['search'] : '';

  // Query to get total number of records in the 'fp_device' table with search filter
  $queryTotal = "SELECT COUNT(*) as total FROM fp_device";
  if (!empty($searchTerm)) {
    $queryTotal .= " WHERE nama LIKE '%$searchTerm%'";
  }

  $resultTotal = mysqli_query($db, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultTotal);
  $recordsTotal = $rowTotal['total'];

  // Query to get paginated records with search filter
  $query = "SELECT * FROM `fp_device`";
  if (!empty($searchTerm)) {
    $query .= " WHERE nama LIKE '%$searchTerm%'";
  }
  $query .= " LIMIT $limit OFFSET $offset";
  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
      $fp[] = array(
        "a" => $row['nama'],
        "b" => $row['entrance'] != 0 ? "Entrance" : "Exit",
        "id" => $row['id'],
      );
    }
  }

  // Create the response with proper record counts
  $response = [
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,  // Total records in the table
    "recordsFiltered" => $recordsTotal,  // Records filtered by search
    "data" => $fp
  ];

  echo json_encode($response);
  die();
}


if (isset($_POST['fp_createf'])) {
  // echo "test";
  // var_dump(($_POST));

  $nama = $_POST['nama'];  // Records per page
  $type = $_POST['type'];  // Records per page



  $query = "INSERT INTO fp_device (nama,entrance) VALUES ('$nama','$type');";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'fp/create');

}

if (isset($_POST['fp_editf'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  $nama = $_POST['nama'];  // Records per page
  $type = $_POST['type'];  // Records per page


  $query = "UPDATE  fp_device SET nama='$nama', entrance='$type' WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'fp/create');

}


if (isset($_POST['fp_deletef'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  // $nama = $_POST['nama'];  // Records per page
  // $location = $_POST['location'];  // Records per page
  // $fpin = $_POST['fpin'] ; // Assign null if 'fpin' is not set
  // $fpout =  $_POST['fpout'] ; // Assign null if 'fpin' is not set


  $query = "DELETE FROM   fp_device   WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'fp/create');

}





if (isset($_POST['subjek_findall'])) {

  $subjek = array();

  $limit = $_POST['subjek_findall']['limit'];  // Records per page
  $offset = $_POST['subjek_findall']['offset'];  // Record starting point
  $draw = $_POST['subjek_findall']['draw'];
  $searchTerm = isset($_POST['subjek_findall']['search']) ? $_POST['subjek_findall']['search'] : '';


  // Query to get total number of records in the 'kelas' table
  $queryTotal = "SELECT COUNT(*) as total FROM subjek";
  if (!empty($searchTerm)) {
    $queryTotal .= " WHERE subjek_nama LIKE '%$searchTerm%' OR subjek_kod LIKE '%$searchTerm%'";
  }
  $resultTotal = mysqli_query($db, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultTotal);
  $recordsTotal = $rowTotal['total'];

  // Query to get paginated records
  $query = "SELECT * FROM `subjek` ";
  if (!empty($searchTerm)) {
    $query .= " WHERE subjek_nama LIKE '%$searchTerm%' OR subjek_kod LIKE '%$searchTerm%'";
  }
  $query .= " LIMIT $limit OFFSET $offset";

  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
      $subjek[] = array(
        "a" => $row['subjek_nama'],
        "b" => $row['subjek_kod'],
        "id" => $row['id'],
      );
    }
  }


  // Create the response with proper record counts
  $response = [
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,  // Total records in the table
    "recordsFiltered" => $recordsTotal,  // No filtering applied in this case
    "data" => $subjek
  ];

  echo json_encode($response);
  die();
}

if (isset($_POST['subjek_createf'])) {
  // echo "test";
  // var_dump(($_POST));

  $nama = $_POST['nama'];  // Records per page
  $kod = $_POST['kod'];  // Records per page



  $query = "INSERT INTO subjek (subjek_nama,subjek_kod) VALUES ('$nama','$kod');";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'subjek/create');

}

if (isset($_POST['subjek_editf'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  $nama = $_POST['nama'];  // Records per page
  $kod = $_POST['kod'];  // Records per page


  $query = "UPDATE  subjek SET subjek_nama='$nama', subjek_kod='$kod' WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'subjek/create');

}


if (isset($_POST['subjek_deletef'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  // $nama = $_POST['nama'];  // Records per page
  // $location = $_POST['location'];  // Records per page
  // $fpin = $_POST['fpin'] ; // Assign null if 'fpin' is not set
  // $fpout =  $_POST['fpout'] ; // Assign null if 'fpin' is not set


  $query = "DELETE FROM   subjek   WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'subjek/create');

}



if (isset($_POST['sem_findall'])) {

  $subjek = array();

  $limit = $_POST['sem_findall']['limit'];  // Records per page
  $offset = $_POST['sem_findall']['offset'];  // Record starting point
  $draw = $_POST['sem_findall']['draw'];
  $searchTerm = isset($_POST['sem_findall']['search']) ? $_POST['sem_findall']['search'] : '';

  // Query to get total number of records in the 'sem' table with search filter
  $queryTotal = "SELECT COUNT(*) as total FROM sem";
  if (!empty($searchTerm)) {
    $queryTotal .= " WHERE nama LIKE '%$searchTerm%'";
  }

  $resultTotal = mysqli_query($db, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultTotal);
  $recordsTotal = $rowTotal['total'];

  // Query to get paginated records with search filter
  $query = "SELECT * FROM `sem`";
  if (!empty($searchTerm)) {
    $query .= " WHERE nama LIKE '%$searchTerm%'";
  }
  $query .= " LIMIT $limit OFFSET $offset";
  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
      $subjek[] = array(
        "a" => $row['nama'],
        "b" => date("d/m/Y", strtotime($row['start_date'])),
        "c" => date("d/m/Y", strtotime($row['end_date'])),
        "id" => $row['id'],
      );
    }
  }

  // Create the response with proper record counts
  $response = [
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,  // Total records in the table
    "recordsFiltered" => $recordsTotal,  // Records filtered by search
    "data" => $subjek
  ];

  echo json_encode($response);
  die();
}


if (isset($_POST['sem_createf'])) {
  // echo "test";
  // var_dump(($_POST));

  $nama = $_POST['nama'];  // Records per page
  $mula = $_POST['mula'];  // Records per page
  $tamat = $_POST['tamat'];  // Records per page



  $query = "INSERT INTO sem (nama,start_date,end_date) VALUES ('$nama','$mula','$tamat');";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'sem/create');

}

if (isset($_POST['sem_editf'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  $nama = $_POST['nama'];  // Records per page
  $mula = $_POST['mula'];  // Records per page
  $tamat = $_POST['tamat'];  // Records per page



  $query = "UPDATE  sem SET nama='$nama', start_date='$mula' , end_date='$tamat'  WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'sem/create');

}


if (isset($_POST['sem_deletef'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  // $nama = $_POST['nama'];  // Records per page
  // $location = $_POST['location'];  // Records per page
  // $fpin = $_POST['fpin'] ; // Assign null if 'fpin' is not set
  // $fpout =  $_POST['fpout'] ; // Assign null if 'fpin' is not set


  $query = "DELETE FROM   sem   WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'sem/create');

}





















if (isset($_POST['slot_checktime'])) {


  $slot_statuses = [
    0 => "Unattended / Unexcused Absence",
    1 => "Present",
    2 => "Late",
    3 => "Pending Excuse of Absence",
    4 => "Excused Absence",
    5 => "Left Early",
    6 => "Break",
    7 => "Not Yet",

  ];

  // $start_timeb = microtime(true);

  $time_slots = []; // Initialize an empty array
  $time_limit = 50;
  $nowdate = date('Y-m-d');
  $now = new DateTime();
  $now2 = $now->format('Y-m-d H:i:s');

  $query = "SELECT * FROM time_slot ORDER BY id ASC";
  $results = mysqli_query($db, $query);
  while ($row = mysqli_fetch_assoc($results)) {
    $time_slots[] = $row;
  }



  $query = "SELECT a.*,b.role FROM attendance a INNER JOIN user b ON b.id = a.user_id WHERE DATE(masa_mula) = CURDATE()  AND `role`='4'";
  $results = mysqli_query($db, $query);

  while ($row = $results->fetch_assoc()) {
    $id = $row['user_id'];

    $masa_mula = new DateTime($row['masa_mula']);
    $masa_tamat = !empty($row['masa_tamat']) ? new DateTime($row['masa_tamat']) : new DateTime(); // Use current time if masa_tamat is empty

    // Loop through the time slots
    foreach ($time_slots as $time_slot) {
      $start_time = new DateTime($nowdate . ' ' . $time_slot['masa_mula']);
      $end_time = new DateTime($nowdate . ' ' . $time_slot['masa_tamat']);
      $slot_name = $time_slot['slot'];


      $late_time = clone $start_time; // Clone the start time to avoid modifying the original
      $late_time->modify('+10 minutes'); // Add 10 minutes to the start time

      // Check for overlap
      if ($masa_mula < $end_time && $masa_tamat > $start_time) {
        $overlap_start = max($masa_mula->getTimestamp(), $start_time->getTimestamp());
        $overlap_end = min($masa_tamat->getTimestamp(), $end_time->getTimestamp());

        // Calculate duration in minutes
        $overlap_duration = ceil(($overlap_end - $overlap_start) / 60); // Convert seconds to minutes

        $interval = $start_time->diff($end_time);

        $supposed_time = ($interval->h * 60) + $interval->i;


        // Switch case to determine slot status
        switch (true) {
          case ($masa_mula > $late_time):
            // Attendance is more than 10 minutes past the start time
            // echo "Attendance from {$row['masa_mula']} to {$masa_tamat->format('Y-m-d H:i:s')} .<br>";

            $slot_status = 2; // Late
            break;

          case ($overlap_duration < ($supposed_time - 10)):
            $slot_status = 5; // Left  Early
            break;

          // case ($masa_tamat < $end_time):
          //   // Attendance ends before the time slot ends
          //   $slot_status = 5; // Leave or another appropriate status
          //   break;

          case ($slot_name == "rehat1" || $slot_name == "rehat2"):
            $slot_status = 6; // rehat
            break;

          default:
            // Default case for on-time attendance
            $slot_status = 1; // Present
            break;
        }



      } else {
        // No overlap case

        if ($now < $start_time) {
          $slot_status = 7; // rehat

        } else {

          $slot_status = 0; // Unattended
        }

        if ($slot_name == "rehat1" || $slot_name == "rehat2") {
          $slot_status = 6; // rehat

        }
      }

      $query2 = "INSERT INTO attendance_slot (user_id, slot, slot_status, tarikh)
           VALUES ('$id', '$slot_name', '$slot_status', '$nowdate')
           ON DUPLICATE KEY UPDATE
               slot_status = CASE 
                   WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(slot_status)
                   ELSE slot_status
               END,
               tarikh = CASE 
                   WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(tarikh)
                   ELSE tarikh
               END";
      $results2 = mysqli_query($db, $query2);

      // echo " $supposed_time min<br>";
      if (!$results2) {
        // Query failed, output the error message
        die("Error in query: " . mysqli_error($db));
      } else {
        $start_time2 = $start_time->format('Y-m-d H:i:s');
        $end_time2 = $end_time->format('Y-m-d H:i:s');
        $masa_tamat2 = $masa_tamat->format('Y-m-d H:i:s');
        $masa_mula2 = $masa_mula->format('Y-m-d H:i:s');
        echo " $slot_status  $slot_name  ($masa_mula2 < $end_time2 && $masa_tamat2 > $start_time2 ) <br> ";
      }


    }

  }

  $query = "SELECT s.id, s.role 
  FROM user s 
  LEFT JOIN attendance a 
  ON s.id = a.user_id 
  AND DATE(a.masa_mula) = CURDATE() 
  WHERE a.user_id IS NULL 
  AND s.role = '4'";

  $results = mysqli_query($db, $query);

  while ($row = $results->fetch_assoc()) {
    foreach ($time_slots as $time_slot) {
      $start_time = new DateTime($nowdate . ' ' . $time_slot['masa_mula']);
      $end_time = new DateTime($nowdate . ' ' . $time_slot['masa_tamat']);
      $slot_name = $time_slot['slot'];

      if ($now < $start_time) {
        $slot_status = 7;  // Not yet
      } else {
        $slot_status = 0;  // Unattended
      }

      if ($slot_name == "rehat1" || $slot_name == "rehat2") {
        $slot_status = 6;  // Break
      }

      $id = $row['id'];

      $query2 = "INSERT INTO attendance_slot (user_id, slot, slot_status, tarikh)
           VALUES ('$id', '$slot_name', '$slot_status', '$nowdate')
           ON DUPLICATE KEY UPDATE
               slot_status = CASE 
                   WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(slot_status)
                   ELSE slot_status
               END,
               tarikh = CASE 
                   WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(tarikh)
                   ELSE tarikh
               END";

      $results2 = mysqli_query($db, $query2);
    }
  }




}
?>