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






require  'admin/functions/login.php';
require  'admin/functions/register.php';
require  'admin/functions/test.php';
require  'admin/functions/course.php';
require  'admin/functions/class.php';
require  'admin/functions/cron.php';
require  'admin/functions/fp.php';
require  'admin/functions/holiday.php';
require  'admin/functions/landing.php';
require  'admin/functions/sem.php';
require  'admin/functions/subjek.php';
require  'admin/functions/calendar.php';








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
    $err['gambar'] = "Image too large";
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



function getEmailContent($filePath, $var = "")
{
  ob_start(); // Start output buffering
  extract($var);
  include(getcwd() . '/views/email/' . $filePath); // Include the PHP file
  $content = ob_get_clean(); // Get the content of the output buffer and clean it
  return $content;


}

function sendmail($receiver, $title, $filepath, $var = "")
{





  $mail = new PHPMailer(true);

  try {

    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->Host = 'fast.e-veterinar.com';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['email4_username'];
    $mail->Password = $_ENV['email4_password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465; // Adjust as needed (e.g., 465 for SSL)


    $mail->setFrom('kedatangan@fast.e-veterinar.com', 'Attendance');
    $mail->addAddress($receiver);


    $emailBodyContent = getEmailContent($filepath, $var);


    // $mail->addEmbeddedImage(getcwd() . '/assets/img/logo3.png', 'logo_cid'); // 'logo_cid' is a unique ID

    if ($var['attachment']) {


      $mail->addAttachment($var['attachment'], $var['attachment_name']);
    }


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