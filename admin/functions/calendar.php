<?php


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
