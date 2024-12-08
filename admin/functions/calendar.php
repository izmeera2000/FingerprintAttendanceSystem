<?php


if (isset($_POST['fetchresource'])) {

  // $subjek = $_POST['fetchresource']['subjek'];
  $course = $_POST['fetchresource']['course'];
  $bengkel = $_POST['fetchresource']['bengkel'];
  $sem = $_POST['fetchresource']['sem'];
  $query =
    "SELECT a.* FROM user a 
INNER JOIN user_enroll b ON b.user_id = a.id WHERE bengkel_id = '$bengkel' AND course_id ='$course' and b.sem_start = '$sem'";

  //  $query .= "  AND subjek='$subjek' ";

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


if (isset($_POST['fetchresource2'])) {

  // $course = $_POST['fetchresource']['course'];
  // $bengkel = $_POST['fetchresource']['bengkel'];
  // $sem = $_POST['fetchresource']['sem'];
  $query =
    "SELECT 
    c.nama AS course,
    d.nama AS sem
 FROM 
    user a
INNER JOIN 
    user_enroll b ON b.user_id = a.id
INNER JOIN 
    course c ON c.id = b.course_id
INNER JOIN 
    sem d ON d.id = b.sem_start
WHERE 
    a.bengkel_id = '1'
GROUP BY 
    c.nama, d.nama;";

  //  $query .= "  AND subjek='$subjek' ";

  $results = mysqli_query($db, $query);
  $resources = array();

  while ($row = $results->fetch_assoc()) {
    $resources[] = array(
      'id' => $row['id'],       // Unique identifier for the resource
      'title' => $row['course'],  // Name or title for the resource
      'sem' => $row['sem'],  // Name or title for the resource
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

  $subjek_id = $_POST['fetchevent2']['subjek'];

  $start_date = new DateTime($_POST['fetchevent2']['start']);
  $start_date2 = $start_date->format('Y-m-d');

  $end_date = new DateTime($_POST['fetchevent2']['end']);
  $end_date2 = $end_date->format('Y-m-d');
  //slot
  ;

  if ($subjek_id != "") {
    $query = "SELECT a.*, 
       DAYOFWEEK(a.tarikh) AS day_of_week, 
       b.masa_mula, 
       b.masa_tamat, 
       c.role, 
       d.subjek_id, 
       d.slot_id,
       ts.masa_mula AS ts_masa_mula, 
       ts.masa_tamat AS ts_masa_tamat
FROM attendance_slot a
INNER JOIN time_slot b ON a.slot = b.slot   
INNER JOIN user c ON c.id = a.user_id   
INNER JOIN user_subjek d ON DAYOFWEEK(a.tarikh) = d.day   
INNER JOIN time_slot ts ON d.slot_id = ts.id   
WHERE a.slot = ts.slot 
AND subjek_id = '$subjek_id' 
  AND DATE(a.tarikh) BETWEEN '$start_date2' AND '$end_date2'
 ";
  } else {
    $query = "SELECT a.*, DAYOFWEEK(a.tarikh)  ,  b.masa_mula, b.masa_tamat, c.role , d.subjek_id
  FROM attendance_slot a
  INNER JOIN time_slot b ON a.slot = b.slot
  INNER JOIN user c ON c.id = a.user_id
  INNER JOIN user_subjek d ON DAYOFWEEK(a.tarikh) = d.day
 
  WHERE DATE(a.tarikh) BETWEEN '$start_date2' AND '$end_date2'";
  }
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


if (isset($_POST['fetchevent3'])) {

  $user_id = $_POST['fetchevent3']['user_id'];
  $start_date = new DateTime($_POST['fetchevent3']['start']);
  $start_date2 = $start_date->format('Y-m-d');
  $end_date = new DateTime($_POST['fetchevent3']['end']);
  $end_date2 = $end_date->format('Y-m-d');

  // Calculate the difference in days
  $date_diff = $start_date->diff($end_date)->days;

  // Query to fetch events
  $query = "SELECT a.*, b.nama as course, c.subjek_nama, c.subjek_kod, d.masa_mula, d.masa_tamat, d.masa_mula2, d.masa_tamat2, e.nama as sem, e.start_date, e.end_date 
            FROM user_subjek a
            INNER JOIN course b ON b.id = a.course_id
            INNER JOIN subjek c ON c.id = a.subjek_id
            INNER JOIN time_slot d ON d.id = a.slot_id
            INNER JOIN sem e ON e.id = a.sem_id
            WHERE assign_to = '$user_id';
            ";
  $results = mysqli_query($db, $query);
  $events = array();

  // Loop through results
  while ($row = $results->fetch_assoc()) {
    $start_time = new DateTime($row['masa_mula']);  // Start time of the slot
    $end_time = new DateTime($row['masa_tamat']);  // End time of the slot

    // Get the day for recurrence (adjusting 1=Sunday, 2=Monday, ...)
    $day_of_week = (int) $row['day'];  // Assuming `day` column uses 1=Sunday, 2=Monday, ...
    $day_of_week_php = $day_of_week - 1; // Convert to PHP's day numbering (0=Sunday)

    // Generate events for the specified day until the end_date
    $current_date = clone $start_date;
    // Find the first occurrence of the specified day on or after the start_date
    if ((int) $current_date->format('w') !== $day_of_week_php) {
      $current_date->modify('next ' . jddayofweek($day_of_week_php, 1));
    }

    while ($current_date <= $end_date) {
      $start_datetime = clone $current_date;
      $start_datetime->setTime((int) $start_time->format('H'), (int) $start_time->format('i'));

      $end_datetime = clone $current_date;
      $end_datetime->setTime((int) $end_time->format('H'), (int) $end_time->format('i'));

      // Add event to the array
      $events[] = array(
        'id' => $row['id'],                 // Unique identifier for the event
        'resourceId' => $day_of_week,       // Day value (1=Sunday, 2=Monday, ...)
        'title' => $row['subjek_nama'],     // Event title (subject name)
        'start' => $start_datetime->format('Y-m-d H:i:s'), // Start date and time
        'end' => $end_datetime->format('Y-m-d H:i:s'),     // End date and time
      );

      // Modify to the next week's occurrence only if the date range is > 7 days
      if ($date_diff > 7) {
        $current_date->modify('+1 week');
      } else {
        break;
      }
    }
  }

  // Return the events as a JSON response
  echo json_encode($events);
  die();
}


if (isset($_POST['fetchevent3'])) {

  $user_id = $_POST['fetchevent3']['user_id'];
  $start_date = new DateTime($_POST['fetchevent3']['start']);
  $start_date2 = $start_date->format('Y-m-d');
  $end_date = new DateTime($_POST['fetchevent3']['end']);
  $end_date2 = $end_date->format('Y-m-d');

  // Calculate the difference in days
  $date_diff = $start_date->diff($end_date)->days;

  // Query to fetch events
  $query = "SELECT a.*, b.nama as course, c.subjek_nama, c.subjek_kod, d.masa_mula, d.masa_tamat, d.masa_mula2, d.masa_tamat2, e.nama as sem, e.start_date, e.end_date 
            FROM user_subjek a
            INNER JOIN course b ON b.id = a.course_id
            INNER JOIN subjek c ON c.id = a.subjek_id
            INNER JOIN time_slot d ON d.id = a.slot_id
            INNER JOIN sem e ON e.id = a.sem_id
            WHERE assign_to = '$user_id';
            ";
  $results = mysqli_query($db, $query);
  $events = array();

  // Loop through results
  while ($row = $results->fetch_assoc()) {
    $start_time = new DateTime($row['masa_mula']);  // Start time of the slot
    $end_time = new DateTime($row['masa_tamat']);  // End time of the slot

    // Get the day for recurrence (adjusting 1=Sunday, 2=Monday, ...)
    $day_of_week = (int) $row['day'];  // Assuming `day` column uses 1=Sunday, 2=Monday, ...
    $day_of_week_php = $day_of_week - 1; // Convert to PHP's day numbering (0=Sunday)

    // Generate events for the specified day until the end_date
    $current_date = clone $start_date;
    // Find the first occurrence of the specified day on or after the start_date
    if ((int) $current_date->format('w') !== $day_of_week_php) {
      $current_date->modify('next ' . jddayofweek($day_of_week_php, 1));
    }

    while ($current_date <= $end_date) {
      $start_datetime = clone $current_date;
      $start_datetime->setTime((int) $start_time->format('H'), (int) $start_time->format('i'));

      $end_datetime = clone $current_date;
      $end_datetime->setTime((int) $end_time->format('H'), (int) $end_time->format('i'));

      // Add event to the array
      $events[] = array(
        'id' => $row['id'],                 // Unique identifier for the event
        'resourceId' => $day_of_week,       // Day value (1=Sunday, 2=Monday, ...)
        'title' => $row['subjek_nama'],     // Event title (subject name)
        'start' => $start_datetime->format('Y-m-d H:i:s'), // Start date and time
        'end' => $end_datetime->format('Y-m-d H:i:s'),     // End date and time
      );

      // Modify to the next week's occurrence only if the date range is > 7 days
      if ($date_diff > 7) {
        $current_date->modify('+1 week');
      } else {
        break;
      }
    }
  }

  // Return the events as a JSON response
  echo json_encode($events);
  die();
}

