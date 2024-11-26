<?php
require __DIR__ . '/../route.php';





$site_url = $_ENV['site2'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use setasign\Fpdi\Fpdi;

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
    $query = "SELECT a.*, b.nama as role_name FROM `user` a INNER JOIN user_role b ON a.role = b.id WHERE (ndp='$ndp' OR email='$email') AND password='$password'";
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


    header('location:' . $site_url . 'dashboard');
  }
}

if (isset($_POST['user_login'])) {
  $login = mysqli_real_escape_string($db, $_POST['login']);
  $password = mysqli_real_escape_string($db, $_POST['password']);


  if (count($errors) == 0) {






    $password = md5($password);


    $query = "SELECT a.*, b.nama as role_name FROM `user` a INNER JOIN user_role b ON a.role = b.id WHERE (ndp='$login' or email='$login') AND password='$password'";
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


  $query = "SELECT a.*,b.role
FROM attendance a 
INNER JOIN user b ON a.user_id = b.id
WHERE (
    (DATE(masa_mula) BETWEEN '$start_date2' AND '$end_date2')
    OR 
    (DATE(masa_tamat) BETWEEN '$start_date2' AND '$end_date2') ) AND role= '4'
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
        'end' => $end->format('Y-m-d H:i:s'),       // Date of the attendance
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




















// akan run cron jobs setapi  1 hour 8-5
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
  // $time_limit = 50;
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
      //late modifier

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


          case ($slot_name == "rehat1" || $slot_name == "rehat2"):
            $slot_status = 6; // rehat
            break;

          case ($overlap_duration < ($supposed_time - 10)):
            $slot_status = 5; // Left  Early
            break;


          case ($masa_mula > $late_time):
            // Attendance is more than 10 minutes past the start time
            // echo "Attendance from {$row['masa_mula']} to {$masa_tamat->format('Y-m-d H:i:s')} .<br>";

            $slot_status = 2; // Late
            break;



          // case ($masa_tamat < $end_time):
          //   // Attendance ends before the time slot ends
          //   $slot_status = 5; // Leave or another appropriate status
          //   break;


          default:
            // Default case for on-time attendance
            $slot_status = 1; // Present
            break;
        }



      } else {
        // No overlap case

        if ($now < $start_time) {
          $slot_status = 7; // not yet

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


if (isset($_POST['fetch_holiday_o'])) {



  $url = "https://www.perak.gov.my/index.php/rakyat/info-umum/hari-kelepasan-am-negeri-perak";
  $html = file_get_contents($url);
  $dom = new DOMDocument();
  @$dom->loadHTML($html);
  $tables = $dom->getElementsByTagName('table');

  // Assuming the holidays are in the first table
  $table = $tables->item(0);
  $rows = $table->getElementsByTagName('tr');

  $holidays = [];
  $monthNames = ["Januari" => "01", "Februari" => "02", "Mac" => "03", "April" => "04", "Mei" => "05", "Jun" => "06", "Julai" => "07", "Ogos" => "08", "September" => "09", "Oktober" => "10", "November" => "11", "Disember" => "12"];
  foreach ($rows as $row) {
    $cols = $row->getElementsByTagName('td');
    if ($cols->length > 0) {
      if (!empty($cols->item(1)->nodeValue)) {

        $name = preg_replace('/\s*\([^)]*\)/', '', ($cols->item(1)->nodeValue));

        $date = trim($cols->item(2)->nodeValue);

        $dateParts = explode(" ", $date);
        if (strpos($date, 'dan') !== false) {
          $day1 = str_pad($dateParts[0], 2, "0", STR_PAD_LEFT);
          $day2 = str_pad($dateParts[2], 2, "0", STR_PAD_LEFT);
          $month = $monthNames[$dateParts[3]];

          $year = trim($cols->item(3)->nodeValue);
          $day = trim($cols->item(4)->nodeValue);
          $holidays[] = [
            'formatdate' => "$year-$month-$day1",
            'name' => $name,
            'day' => $day,
          ];
          $holidays[] = [
            'formatdate' => "$year-$month-$day2",
            'name' => $name,
            'day' => $day,
          ];
        } else {
          $day2 = str_pad($dateParts[0], 2, "0", STR_PAD_LEFT);
          $month = $monthNames[$dateParts[1]];

          $year = trim($cols->item(3)->nodeValue);
          $day = trim($cols->item(4)->nodeValue);
          $holidays[] = [
            'formatdate' => "$year-$month-$day2",

            'name' => $name,
            'day' => $day,
          ];
        }

      }
    }
  }
  // 
  // var_dump($holidays);

  foreach ($holidays as $holiday) {
    $formatdate = $holiday['formatdate'];
    $name = $holiday['name'];

    $query = "INSERT IGNORE INTO holiday (tarikh, nama) VALUES ('$formatdate', '$name') ";
    $results = mysqli_query($db, $query);

  }





}



if (isset($_POST['holiday_findall'])) {

  $holiday = array();

  $limit = $_POST['holiday_findall']['limit'];  // Records per page
  $offset = $_POST['holiday_findall']['offset'];  // Record starting point
  $draw = $_POST['holiday_findall']['draw'];
  $searchTerm = isset($_POST['holiday_findall']['search']) ? $_POST['holiday_findall']['search'] : '';

  // Query to get total number of records in the 'sem' table with search filter
  $queryTotal = "SELECT COUNT(*) as total FROM holiday ORDER BY TARIKH ASC";
  if (!empty($searchTerm)) {
    $queryTotal .= " WHERE nama LIKE '%$searchTerm%'";
  }

  $resultTotal = mysqli_query($db, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultTotal);
  $recordsTotal = $rowTotal['total'];

  // Query to get paginated records with search filter
  $query = "SELECT * FROM holiday";
  if (!empty($searchTerm)) {
    $query .= " WHERE nama LIKE '%$searchTerm%'";
  }
  $query .= " LIMIT $limit OFFSET $offset";
  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
      $holiday[] = array(
        "a" => $row['nama'],
        "b" => date("d/m/Y", strtotime($row['tarikh'])),
        "c" => $row['verify'],
      );
    }
  }

  // Create the response with proper record counts
  $response = [
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,  // Total records in the table
    "recordsFiltered" => $recordsTotal,  // Records filtered by search
    "data" => $holiday
  ];

  echo json_encode($response);
  die();
}


if (isset($_POST['holiday_createf'])) {
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

if (isset($_POST['holiday_editf'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  $nama = $_POST['nama'];  // Records per page
  $mula = $_POST['mula'];  // Records per page
  $tamat = $_POST['tamat'];  // Records per page



  $query = "UPDATE  holiday SET nama='$nama', start_date='$mula' , end_date='$tamat'  WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'sem/create');

}


if (isset($_POST['holiday_deletef'])) {
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


if (isset($_POST['fingerprintlogin'])) {

  $user_id = "";

  $query = "SELECT * FROM attendance WHERE DATE(masa_mula) = CURRENT_DATE AND masa_tamat IS  NULL;";
  $results = mysqli_query($db, $query);
  if ($result->num_rows > 0) {

    while ($row = mysqli_fetch_assoc($results)) {
      $id = $row['id'];
      $query = "UPDATE `attendance` SET `masa_tamat` = NOW() WHERE id = $id";
    }

  } else {

    $query = "INSERT INTO attendance (user_id) VALUES ('$user_id') ";
    $results = mysqli_query($db, $query);


  }
}


if (isset($_POST['fingerprintregister'])) {

  $user_id = "";

  $query = "SELECT * FROM user WHERE fp = '1' ";
  $results = mysqli_query($db, $query);
  if ($result->num_rows > 0) {

    while ($row = mysqli_fetch_assoc($results)) {
      $id = $row['id'];
      $query = "UPDATE `attendance` SET `masa_tamat` = NOW() WHERE id = $id";
    }

  } else {

    $query = "INSERT INTO attendance (user_id) VALUES ('$user_id') ";
    $results = mysqli_query($db, $query);


  }
}



if (isset($_POST['get_pdf'])) {





  include(getcwd() . '/admin/vendor/setasign/fpdf/fpdf.php');
  include(getcwd() . '/admin/vendor/setasign/fpdf/exfpdf.php');
  include(getcwd() . '/admin/vendor/setasign/fpdf/easyTable.php');



  $week = $_POST['week'];
  $year = $_POST['year'];
  $month = $_POST['month'];
  $sem = $_POST['sem'];
  $kursus = $_POST['kursus'];
  // $startDate = "2024-10-29";
  // $endDate = "2024-11-05";

  $weekRange = getWeekRangeOfMonth($month, $year, $week);
  // debug_to_console($startDate);

  $startDate = $weekRange['start_date'];
  $endDate = $weekRange['end_date'];


  class PDF extends exFPDF
  {


  }
  function getMonthName($date)
  {
    return date('F', strtotime($date));
  }

  $months = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Mac', 'April' => 'April', 'May' => 'Mei', 'June' => 'Jun', 'July' => 'Julai', 'August' => 'Ogos', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Disember'];

  $month1 = getMonthName($startDate);

  $month1 = $months[$month1];
  $month2 = getMonthName($endDate);
  $month2 = $months[$month2];





  $students_attendance = [];

  $query =

    "SELECT a.*, b.masa_mula, b.masa_tamat, c.nama, c.role, c.ndp
    FROM attendance_slot a
    INNER JOIN time_slot b ON a.slot = b.slot
    INNER JOIN user c ON c.id = a.user_id
    WHERE c.role = 4
    AND a.slot NOT IN ('rehat1', 'rehat2')
    AND a.tarikh BETWEEN '$startDate' AND '$endDate'
    ORDER BY a.slot ASC";


  $results2 = mysqli_query($db, $query);

  while ($row = mysqli_fetch_assoc($results2)) {
    $user_id = $row['user_id']; // Group by user_id

    // Store student's information
    $students_attendance[$user_id]['info'] = [
      'nama' => strtoupper($row['nama']),
      'ndp' => $row['ndp']
    ];

    // Append the attendance record grouped by date
    $students_attendance[$user_id]['attendance'][$row['tarikh']][] = [
      'slot' => $row['slot'],
      'slot_status' => $row['slot_status']
    ];
  }




  $dates = getDatesFromRange($startDate, $endDate);

  if ($dates) {



    $query =
      "SELECT COUNT(*) as total FROM user WHERE role = 4";
    $results = mysqli_query($db, $query);

    while ($row = $results->fetch_assoc()) {
      $pelajartotal = $row['total'];
    }



 

    $timeslot = ["1", "2", "3", "4", "5"];

    $dayslot = count($dates);
    $slottotal = $dayslot * count($timeslot);


    $widtharray = array();

    array_push($widtharray, "10", "30", "40", "20");


    for ($i = 0; $i < (count($timeslot) * $dayslot); $i++) {
      array_push($widtharray, "5");
    }

    array_push($widtharray, "20", "15", "20", "25");
    $output = '{' . implode(', ', $widtharray) . ',' . '}';




    $pdf = new PDF('L');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('arial', '', 10);

    if ($month1 == $month2) {


      $month = strtoupper($month1);
    } else {

      $month = strtoupper($month1) . " & " . strtoupper($month2);
    }


    function tablebheader($tableB, $dayslot, $timeslot, $dates, $month, $pdf)
    {

      $tableB->rowStyle('font-style:B;border:0');



      $tableB->easyCell("BULAN : " . $month . '<s "font-color:#ffffff">test123</s>' . "    TAHUN : 2024", 'colspan:7;');


      // $tableB->easyCell("TAHUN : 2024", 'colspan:;');

      $tableB->printRow();
      $tableB->rowStyle('font-style:B');

      $tableB->easyCell("BIL", 'rowspan:3;width:10;align:C;valign:M');
      $tableB->easyCell("NAMA", 'rowspan:3;colspan:2;align:C;valign:M');
      $tableB->easyCell("Tarikh", ';align:C;valign:M');
      foreach ($dates as $date) {
        $tableB->easyCell("$date", 'colspan:5;align:C;valign:M');


      }

      $tableB->easyCell("JUMLAH SLOT", 'rowspan:3');
      $tableB->easyCell("SLOT TIDAK HADIR", 'rowspan:3');
      $tableB->easyCell("PERATUS KEHADIR-AN", 'rowspan:3');
      $tableB->easyCell("*CATATAN", 'rowspan:3;align:C;valign:M');

      $tableB->printRow();


      $tableB->rowStyle('font-style:B;');

      $tableB->easyCell("NDP", 'rowspan:2;align:C;valign:M');

      foreach ($dates as $date) {
        $tableB->easyCell("SLOT", 'colspan:5;align:C;valign:M');

      }
      $tableB->printRow();

      $tableB->rowStyle('font-style:B;');
      for ($a = 0; $a < ($dayslot); $a++) {
        for ($i = 0; $i < (count($timeslot)); $i++) {
          $tableB->easyCell($i + 1);
        }

      }

      $tableB->printRow();
    }

    function tablebfooter($tableB, $dayslot, $timeslot, $slottotal, $pdf)
    {
      $tableB->easyCell("", 'rowspan:2');
      $tableB->easyCell("Tanda-tanda yang digunakan dalam Senarai Kehadiran adalah seperti berikut:\n/ - Hadir\n0 - Tidak Hadir\nK - Cuti Dengan Kebenaran/Lain-lain aktiviti", 'rowspan:2;colspan:2');
      $tableB->easyCell("Disahkan oleh:", ';align:C;valign:M');
      for ($a = 0; $a < ($dayslot); $a++) {

        for ($i = 0; $i < (count($timeslot)); $i++) {

          $tableB->easyCell(" ", ';align:C;valign:M');
        }
      }
      $tableB->easyCell("Kiraan Peratus Kehadiran (%)\n(A-B)/A x 100%", 'rowspan:2;colspan:4 ;align:C;valign:M');

      $tableB->printRow();

      $tableB->easyCell("Disemak oleh:", ';align:C;valign:M');
      $tableB->easyCell(" ", 'colspan:' . $slottotal);

      $tableB->printRow();

      $pdf->SetFont('arial', 'B', 10);
      $pdf->Cell(150, 10, "*Catatan : TG - Tangguh ; BH - Berhenti ; DBH - Diberhentikan", 0, 0, 'L', false); // Width 0 for full width, height 10, border 1, left aligned
      $pdf->SetFont('arial', '', 10);
      $pdf->Cell(0, 10, "Helaian " . $pdf->PageNo() . ' Daripada {nb}', 0, 0, 'R', false); // Width 0 for full width, height 10, border 1, left aligned
      $pdf->SetFont('arial', '', 10);


    }

    $tableB = new easyTable($pdf, $output, ' align:L{LC};font-size:10;  border:1');


    tablebheader($tableB, $dayslot, $timeslot, $dates, $month, $pdf);

    $ystart = 34;

    $d = 0;




    foreach ($students_attendance as $student_id => $data) {



      $asd = $d + 1;
      if ($pdf->GetY() > 120) {
        $pdf->AddPage();
        tablebheader($tableB, $dayslot, $timeslot, $dates, $month, $pdf);
      }


      $tableB->easyCell($asd, ';align:C;valign:M');
      $tableB->easyCell($data['info']['nama'], ';colspan:2;align:L;valign:M;');
      $tableB->easyCell($data['info']['ndp'], ';align:C;valign:M');
      $slot_takhadir = 0;

      foreach ($dates as $date) {
        foreach ($timeslot as $slot) {
          // $tableB->easyCell("yrst", ';align:C;valign:M');

          $attendance = $data['attendance'][$date] ?? null; // Get attendance for the specific date
          $slot_found = false;
          if ($attendance) {
            foreach ($attendance as $att) {
              if ($att['slot'] == "slot".$slot) {
                // Check the slot status and add the correct symbol
                switch ($att['slot_status']) {
                  case 0:
                  case 2:
                  case 3:
                  case 5:
                    $tableB->easyCell("0", ';align:C;valign:M');
                    $slot_takhadir++;
                    break;
                  case 4:
                    $tableB->easyCell("K", ';align:C;valign:M');
                    break;
                  case 7:
                    $tableB->easyCell(" ", ';align:C;valign:M');
                    break;
                  default:
                    $tableB->easyCell("/", ';align:C;valign:M');
                }
                $slot_found = true;
                break;
              }
            }
          }
          if (!$slot_found) {
            $tableB->easyCell(" ", ';align:C;valign:M');
            $slot_takhadir++;
          }

        }


      }

      $tableB->easyCell($slottotal, 'rowspan:' . 1 . ';align:C;valign:M');
      $tableB->easyCell($slot_takhadir, ';align:C;valign:M');
      $tableB->easyCell((($slottotal - $slot_takhadir) / $slottotal) * 100 . "%", ';align:C;valign:M');
      $tableB->easyCell("Catatan", ';align:C;valign:M');
      $tableB->printRow();






      if ($pdf->GetY() > 120 || ($pelajartotal == $d + 1)) {
        tablebfooter($tableB, $dayslot, $timeslot, $slottotal, $pdf);


      }
      $d = $d + 1;

    }






    $tableB->endTable(10);




    $pdf->Output('F', 'test.pdf');

    // debug_to_console(var_dump($students_attendance));

  }
  // debug_to_console("test");
}



if (isset($_POST['get_pdf2'])) {

  $nama = strtoupper($_POST['nama']);
  $sem = $_POST['sem'];
  $kursus = strtoupper($_POST['kursus']);
  $amaran = $_POST['amaran'];




  $pdf = new Fpdi();
  // add a page
  $pdf->SetFont('arial', '', 12);

  $pdf->AddPage();
  // set the source file
  if ($amaran == 1) {

    $pdf->setSourceFile("assets/pdf/sp1b.pdf");

  } else {
    $pdf->setSourceFile("assets/pdf/sp2b.pdf");

  }
  // import page 1
  $tplId = $pdf->importPage(1);
  // use the imported page and place it at point 10,10 with a width of 100 mm
  $pdf->useTemplate($tplId, ['adjustPageSize' => true]);
  $pdf->SetXY(64, 61.6);

  $pdf->Write(0, $nama);
  $pdf->SetXY(102, 66.5);
  $pdf->Write(0, $sem . ' ' . $kursus);

  $pdf->SetFont('arial', 'B', 12);
  if ($amaran == 1) {

    $pdf->SetXY(70, 126.9);
    $text = '( 10/9/24 - 1 slot, 27/9/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot )';
  } else {
    $pdf->SetXY(70, 141.9);
    $text = '( 10/9/24 - 1 slot, 27/9/24 - 1 slot,   3/10/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot )';
  }
  // Use MultiCell for wrapping text
  $width = 100; // Width of the cell
  $lineHeight = 5.9; // Height of each line
  $pdf->MultiCell($width, $lineHeight, $text, 0, 'L');

  $pdf->Output('F', 'test2.pdf');

  // debug_to_console("test");
}



if (isset($_POST['get_pdf3'])) {



  $id = $_POST['id'];


  $query = "SELECT a.id,a.nama,a.kp,a.ndp,c.nama as kursus ,d.nama as sem_start  FROM user a 
            INNER JOIN user_enroll b ON b.user_id = a.id
            INNER JOIN course c ON c.id = b.course_id
            INNER JOIN sem d ON d.id = b.sem_start
            WHERE a.id = '$id'";
  $results = mysqli_query($db, $query);
  while ($row = $results->fetch_assoc()) {
    $nama = $row['nama'];
    $kp = $row['kp'];
    $kursus = $row['kursus'];
    $ndp = $row['ndp'];
    $sem_start = $row['sem_start'];

  }
  $sem = getSemesterByNumber($sem_start);


  $pdf = new Fpdi();
  // add a page
  $pdf->SetFont('arial', '', 12);

  $pdf->AddPage();
  // set the source file
  $pdf->setSourceFile("assets/pdf/jtp2.pdf");

  // import page 1
  $tplId = $pdf->importPage(1);
  // use the imported page and place it at point 10,10 with a width of 100 mm
  $pdf->useTemplate($tplId, ['adjustPageSize' => true]);
  $pdf->SetXY(67, 102.6);
  $pdf->Write(0, $nama);

  $pdf->SetXY(67, 107.6);
  $pdf->Write(0, $kp);

  $pdf->SetXY(67, 112.6);
  $pdf->Write(0, $ndp);

  $pdf->SetXY(67, 117.6);
  $pdf->Write(0, $kursus);

  $pdf->SetXY(67, 122.6);
  $pdf->Write(0, $sem);

  $pdf->AddPage();                // Create a new page in the output PDF
  // // import page 1
  $tplId = $pdf->importPage(2);
  // use the imported page and place it at point 10,10 with a width of 100 mm
  $pdf->useTemplate($tplId, ['adjustPageSize' => true]);



  $pdf->SetXY(67, 44.2);
  $pdf->Write(0, $nama);

  $pdf->SetXY(67, 49.1);
  $pdf->Write(0, $kp);

  $pdf->SetXY(67, 54);
  $pdf->Write(0, $ndp);

  $pdf->SetXY(67, 58.9);
  $pdf->Write(0, $kursus);

  $pdf->SetXY(67, 63.8);
  $pdf->Write(0, $sem);
  $pdf->Ln(10);


  // $table = new easyTable($pdf, '%{30, 35, 35}', 'align:R; border:1');
  // $table->easyCell('Text 1', 'rowspan:2; bgcolor:#ffb3ec');
  // $table->easyCell('Text 2', 'colspan:2; bgcolor:#FF66AA');
  // $table->printRow();

  // $table->easyCell('Text 3', 'bgcolor:#33ffff');
  // $table->easyCell('Text 4', 'bgcolor:#ffff33');
  // $table->printRow();
  // $table->endTable(5);


  // $pdf->SetXY(102, 66.5);
  // $pdf->Write(0, $sem . ' ' . $kursus);

  // $pdf->SetFont('arial', 'B', 12);
  // if ($amaran == 1) {

  //   $pdf->SetXY(70, 126.9);
  //   $text = '( 10/9/24 - 1 slot, 27/9/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot )';
  // } else {
  //   $pdf->SetXY(70, 141.9);
  //   $text = '( 10/9/24 - 1 slot, 27/9/24 - 1 slot,   3/10/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot )';
  // }
  // // Use MultiCell for wrapping text
  // $width = 100; // Width of the cell
  // $lineHeight = 5.9; // Height of each line
  // $pdf->MultiCell($width, $lineHeight, $text, 0, 'L');



  $pdf->Output('F', 'test3.pdf');

  // debug_to_console("test");
}


if (isset($_POST['post_fp2'])) {


  $query = "SELECT id ,fp FROM `user` WHERE fp='R';";
  $results = mysqli_query($db, $query);
  while ($row = mysqli_fetch_assoc($results)) {
    $id = $row['id'];
    echo $id;

  }


}


if (isset($_POST['post_fp'])) {

  $id = $_POST['post_fp'];

  $query = "UPDATE user SET fp ='D' WHERE  id = '$id' ";
  $results = mysqli_query($db, $query);

  if ($results) {
    echo "data posted:";
    var_dump($_POST);
  } else {
    echo "not Ok";
  }


}


if (isset($_POST['login_fp'])) {

  $id = $_POST['login_fp'];
  $ent = $_POST['entrance'];
  if ($ent) {

    $query = "SELECT * FROM attendance WHERE user_id = '$id' AND masa_tamat IS NULL  ORDER BY time_add DESC LIMIT 1;";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 0) {


      $query = "INSERT INTO attendance (user_id, event_status)  VALUES ('$id','1');";
      $results = mysqli_query($db, $query);
      while ($row = mysqli_fetch_assoc($results)) {
        $id2 = $row['id'];
        // echo $id2;

      }
    }
  } else {


    $query = "SELECT * FROM `attendance` WHERE user_id = '$id'  AND masa_tamat IS NULL  ORDER BY time_add DESC LIMIT 1;";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 0) {

      while ($row = mysqli_fetch_assoc($results)) {
        $id2 = $row['id'];
        // echo $id2;

      }


      $query = "UPDATE attendance SET masa_tamat = NOW()  WHERE id ='$id2' ";
      $results = mysqli_query($db, $query);

    } else {
      echo "no_in_detected";
    }

  }

}




if (isset($_POST['fp_mode'])) {

  $fp = $_POST['fp_name'];

  $query = "SELECT a.*, b.nama  FROM fp_settings a  INNER JOIN fp_device b ON b.id = a.fp_id WHERE nama= '$fp' ";
  $results = mysqli_query($db, $query);
  while ($row = mysqli_fetch_assoc($results)) {
    $mode = $row['mode'];
    if ($mode == 0) {
      echo "register";
    }
    if ($mode == 1) {
      echo "login";
    }
    if ($mode == 2) {
      echo "emptydb";
    }
  }


}











if (isset($_POST['course_findall'])) {

  $course = array();

  $limit = $_POST['course_findall']['limit'];  // Records per page
  $offset = $_POST['course_findall']['offset'];  // Record starting point
  $draw = $_POST['course_findall']['draw'];
  $searchTerm = isset($_POST['course_findall']['search']) ? $_POST['course_findall']['search'] : '';

  // Query to get total number of records in the 'sem' table with search filter
  $queryTotal = "SELECT COUNT(*) as total FROM course ORDER BY time_add DESC";
  if (!empty($searchTerm)) {
    $queryTotal .= " WHERE nama LIKE '%$searchTerm%'";
  }

  $resultTotal = mysqli_query($db, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultTotal);
  $recordsTotal = $rowTotal['total'];

  // Query to get paginated records with search filter
  $query = "SELECT * FROM course";
  if (!empty($searchTerm)) {
    $query .= " WHERE nama LIKE '%$searchTerm%'";
  }
  $query .= " LIMIT $limit OFFSET $offset";
  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
      $course[] = array(
        "a" => $row['nama'],
        "b" => date("d/m/Y", strtotime($row['time_add'])),
        // "c" => $row['verify'],
      );
    }
  }

  // Create the response with proper record counts
  $response = [
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,  // Total records in the table
    "recordsFiltered" => $recordsTotal,  // Records filtered by search
    "data" => $course
  ];

  echo json_encode($response);
  die();
}


if (isset($_POST['course_createf'])) {
  // echo "test";
  // var_dump(($_POST));

  $nama = $_POST['nama'];  // Records per page
  // $mula = $_POST['mula'];  // Records per page
  // $tamat = $_POST['tamat'];  // Records per page



  $query = "INSERT INTO course (nama) VALUES ('$nama');";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'course/create');

}

if (isset($_POST['course_editf'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id'];  // Records per page
  $nama = $_POST['nama'];  // Records per page
  $mula = $_POST['mula'];  // Records per page
  $tamat = $_POST['tamat'];  // Records per page



  $query = "UPDATE  holiday SET nama='$nama', start_date='$mula' , end_date='$tamat'  WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'sem/create');

}


if (isset($_POST['course_deletef'])) {
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



function getWeekRangeOfMonth($month, $year, $weekNumber)
{
  // Calculate the first day of the month
  $firstDayOfMonth = strtotime("$year-$month-01");

  // Get the weekday of the first day (1 = Monday, 7 = Sunday)
  $firstDayWeekday = date('N', $firstDayOfMonth);  // 1 = Monday, 7 = Sunday

  // Calculate the date of the first Monday of the month
  $startDay = $firstDayOfMonth;
  if ($firstDayWeekday != 1) {
    // If the first day is not Monday, find the previous Monday
    $startDay = strtotime("last Monday", $firstDayOfMonth);
  }

  // Calculate the start and end date of the requested week
  // Calculate the start date of the given week number (weekNumber starts from 1)
  $startDate = date('Y-m-d', strtotime("+" . ($weekNumber - 1) . " weeks", $startDay));

  // Calculate the end date of the given week (6 days after the start date)
  $endDate = date('Y-m-d', strtotime("$startDate +6 days"));

  // If the end date is outside the current month, adjust it to the last day of the current month
  if (date('m', strtotime($endDate)) != $month) {
    $endDate = date('Y-m-t', strtotime($startDate)); // Get the last day of the current month
  }

  // Return the start and end dates as an associative array
  return [
    'start_date' => $startDate,
    'end_date' => $endDate
  ];
}



function getSemesterByNumber($startSem)
{
  // Parse the start semester
  list($startSemPart, $startYear) = explode('/', $startSem);
  $startSemPart = (int) $startSemPart;  // 1 or 2
  $startYear = (int) $startYear;        // Year as integer

  // Get the current year and month
  $currentYear = (int) date('Y');      // Current year
  $currentMonth = (int) date('n');    // Current month (1-12)

  // Determine the current semester part
  $currentSemPart = $currentMonth < 7 ? 1 : 2;

  // Calculate total semesters from the start year to the current year
  $semesterNumber = (($currentYear - $startYear) * 2) + $currentSemPart;

  // Adjust for start semester part
  if ($startSemPart === 2) {
    $semesterNumber--;
  }

  return $semesterNumber;
}



if (isset($_POST['fp_setnull'])) {
  $id = $_POST['id'];

  // var_dump($_POST);

  $query = "UPDATE `user` SET `fp` = NULL WHERE `user`.`id` = '$id';";
  mysqli_query($db, $query);

}

if (isset($_POST['fp_setregister'])) {
  $id = $_POST['id'];


  $query = "UPDATE user SET fp='R'  WHERE id = '$id'";
  mysqli_query($db, $query);

}


function getDatesFromRange($start, $end)
{
  $dates = [];
  $currentDate = new DateTime($start);
  $endDate = new DateTime($end);

  while ($currentDate <= $endDate) {
    // Check for weekdays (Monday to Friday)
    if ($currentDate->format('N') != 6 && $currentDate->format('N') != 7) {
      
      // Stop if we have 5 valid weekdays
      if (count($dates) < 5) {
        $dates[] = $currentDate->format('Y-m-d'); // Add the date
      }
    }
    $currentDate->modify('+1 day'); // Move to the next day
  }

  return $dates;
}

?>