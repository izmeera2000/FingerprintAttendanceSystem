<?php
require __DIR__ . '/../route.php';





$site_url = $_ENV['site2'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use setasign\Fpdi\Fpdi;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

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
require  'admin/functions/pdf.php';








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
  $endDate = date('Y-m-d', strtotime("$startDate +4 days"));

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

function calculateSemesterIndex($semStart, $semNow) {
  // Split the semesters into semester number and year
  list($startSem, $startYear) = explode('/', $semStart);
  list($nowSem, $nowYear) = explode('/', $semNow);

  // Convert to integers
  $startSem = (int)$startSem;
  $startYear = (int)$startYear;
  $nowSem = (int)$nowSem;
  $nowYear = (int)$nowYear;

  // Calculate the difference in years
  $yearDifference = $nowYear - $startYear;

  // Calculate the semester index
  $semesterIndex = ($yearDifference * 2) + ($nowSem - $startSem + 1);

  return $semesterIndex;
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


 
function generateQRCodeWithLogo($data, $logoPath){
  $options = new QROptions([
      'outputType' => QRCode::OUTPUT_IMAGE_PNG,
      'eccLevel' => QRCode::ECC_H,
      'scale' => 10,
      'imageBase64' => false, // We will convert to base64 manually
  ]);

  // Generate the QR code image
  $qrOutputInterface = new QRCode($options);
  $qrImage = $qrOutputInterface->render($data);

  // Load the QR code and logo images
  $qrImageResource = imagecreatefromstring($qrImage);
  $logoImageResource = imagecreatefrompng($logoPath);

  // Get dimensions
  $qrWidth = imagesx($qrImageResource);
  $qrHeight = imagesy($qrImageResource);
  $logoWidth = imagesx($logoImageResource);
  $logoHeight = imagesy($logoImageResource);

  // Calculate logo placement
  $logoQRWidth = $qrWidth / 5; // Logo will cover 1/5th of the QR code
  $scaleFactor = $logoWidth / $logoQRWidth;
  $logoQRHeight = $logoHeight / $scaleFactor;

  $xPos = ($qrWidth - $logoQRWidth) / 2;
  $yPos = ($qrHeight - $logoQRHeight) / 2;

  // Merge logo onto QR code
  imagecopyresampled(
      $qrImageResource,
      $logoImageResource,
      $xPos,
      $yPos,
      0,
      0,
      $logoQRWidth,
      $logoQRHeight,
      $logoWidth,
      $logoHeight
  );

  // Output QR code with logo to a string
  ob_start();
  imagepng($qrImageResource);
  $outputImage = ob_get_clean();

  // Convert to base64
  $base64 = base64_encode($outputImage);

  // Free memory
  imagedestroy($qrImageResource);
  imagedestroy($logoImageResource);

  return $base64;
}


function renderBreadcrumb($pageTitle, $breadcrumbs = []) {
    ?>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"><?php echo htmlspecialchars($pageTitle); ?></h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <?php foreach ($breadcrumbs as $breadcrumb) : ?>
                                <li class="breadcrumb-item<?php echo $breadcrumb['active'] ? ' active' : ''; ?>"<?php echo $breadcrumb['active'] ? ' aria-current="page"' : ''; ?>>
                                    <?php if (!$breadcrumb['active']) : ?>
                                        <a href="<?php echo htmlspecialchars($breadcrumb['url']); ?>"><?php echo htmlspecialchars($breadcrumb['label']); ?></a>
                                    <?php else : ?>
                                        <?php echo htmlspecialchars($breadcrumb['label']); ?>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>