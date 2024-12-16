<?php


if (isset($_POST['program_findall'])) {

  $course = array();

  $limit = $_POST['program_findall']['limit'];  // Records per page
  $offset = $_POST['program_findall']['offset'];  // Record starting point
  $draw = $_POST['program_findall']['draw'];
  $searchTerm = isset($_POST['program_findall']['search']) ? $_POST['program_findall']['search'] : '';

  // Query to get total number of records in the 'sem' table with search filter
  $queryTotal = "SELECT COUNT(*) as total FROM program ORDER BY time_add DESC";
  if (!empty($searchTerm)) {
    $queryTotal .= " WHERE nama LIKE '%$searchTerm%'";
  }

  $resultTotal = mysqli_query($db, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultTotal);
  $recordsTotal = $rowTotal['total'];

  // Query to get paginated records with search filter
  $query = "SELECT a.*, b.nama as user_nama  , c.nama as course ,  e.nama as sem
   FROM program a
  INNER JOIN user b ON b.id = a.created_by
  INNER JOIN course c ON c.id = a.course_id
   INNER JOIN sem e ON e.id = a.sem_id
  ";
  if (!empty($searchTerm)) {
    $query .= "GROUP BY uniq_id WHERE nama LIKE '%$searchTerm%'";
  }
  $query .= " LIMIT $limit OFFSET $offset";
  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
      // Check if the uniq_id already exists in the array
      if (!isset($course[$row['uniq_id']])) {
        $course[$row['uniq_id']] = array(
          "a" => $row['nama'],        // Program Name
          "courses" => [],            // Store multiple courses
          "c" => $row['tarikh_mula'] . " - " . $row['tarikh_tamat'],   // Created By
          "d" => $row['user_nama'],   // Created By
          "uniq_id" => $row['uniq_id'],   // Created By
          "href" => "<a class='btn btn-primary' href='" . $site_url . "program/" . $row['uniq_id'] . "'>Show Details</a>"
        );
      }
      // Check if the course is already in the courses array
      if (!in_array($row['course'], $course[$row['uniq_id']]['courses'])) {
        $course[$row['uniq_id']]['courses'][] = $row['course'];  // Add course if not already present
      }

      // Ensure the semester is not already added for the course
      if (!isset($course[$row['uniq_id']]['courses_sems'][$row['course']])) {
        $course[$row['uniq_id']]['courses_sems'][$row['course']] = [];
      }

      // Add the semester to the course if not already added
      if (!in_array(getSemesterByNumber($row['sem']), $course[$row['uniq_id']]['courses_sems'][$row['course']])) {
        $course[$row['uniq_id']]['courses_sems'][$row['course']][] = getSemesterByNumber($row['sem']);
      }
    }
  }

  // Create the response with proper record counts
  $response = [
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,  // Total records in the table
    "recordsFiltered" => $recordsTotal,  // Records filtered by search
    "data" => array_values($course),
  ];

  echo json_encode($response);
  die();
}


if (isset($_POST['program_createf'])) {
  // echo "test";
// var_dump(($_POST));
  $user_id = $_POST['user_id'];  // Records per page

  $nama = $_POST['nama'];  // Records per page
  // $bengkel = $_POST['bengkel'];  // Records per page
  $course = $_POST['course'];  // Records per page
  $sem = $_POST['sem'];  // Records per page
  $mula = $_POST['mula'];  // Records per page
  $tamat = $_POST['tamat'];  // Records per page
  $smula = $_POST['smula'];  // Records per page
  $stamat = $_POST['stamat'];  // Records per page
// $mula = $_POST['mula'];  // Records per page
// $tamat = $_POST['tamat'];  // Records per page

  $query = "SELECT  * FROM time_slot  WHERE nama = '$smula' OR nama = '$stamat' ";
  $results = mysqli_query($db, $query);
  while ($row = $results->fetch_assoc()) {
    if ($smula == $row['nama']) {

      $mula_date = new DateTime($mula);  // Convert $mula (string) into DateTime object
      $day = $mula_date->format('l');  // Get the day of the week (e.g., 'Friday')
      if ($day === 'Friday' && $row['masa_mula2'] != "") {
        $tarikh_mula = new DateTime($mula . ' ' . $row['masa_mula2']);
      } else {
        $tarikh_mula = new DateTime($mula . ' ' . $row['masa_mula']);

      }
      $formatted_tarikh_mula = $tarikh_mula->format('Y-m-d H:i:s');  // Example format

    }
    if ($stamat == $row['nama']) {

      $tamat_date = new DateTime($tamat);  // Convert $mula (string) into DateTime object
      $day = $tamat_date->format('l');  // Get the day of the week (e.g., 'Friday')
      if ($day === 'Friday' && $row['masa_tamat2'] != "") {
        $tarikh_tamat = new DateTime($tamat . ' ' . $row['masa_tamat2']);
      } else {
        $tarikh_tamat = new DateTime($tamat . ' ' . $row['masa_tamat']);

      }
      $formatted_tarikh_tamat = $tarikh_tamat->format('Y-m-d H:i:s');  // Example format

    }
  }

  $randomID = generateIncrementalID($db);


  // Loop through the data and insert only once with the generated ID
  // foreach ($bengkel as $bengkel2) {
  foreach ($course as $course2) {
    foreach ($sem as $sem2) {
      // Prepare the insert query with the generated random ID
      $query = "INSERT INTO program (nama,  course_id, sem_id, tarikh_mula, tarikh_tamat, created_by, uniq_id)
                    VALUES ('$nama', '$course2', '$sem2', '$formatted_tarikh_mula', '$formatted_tarikh_tamat', '$user_id', '$randomID');";

      // Execute the query
      $results = mysqli_query($db, $query);

      // Debug output (you can remove this in production)
      debug_to_console(" $course2 $sem2");
    }
  }
  // }

  // debug_to_console($query);
  // $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'program/create');
  // die();
}

if (isset($_POST['program_editf'])) {
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


if (isset($_POST['program_deletef'])) {
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




if (isset($_POST['updateattprogram'])) {

  $program_id = $_POST['updateattprogram']['program_id'];  // Records per page
  $student_id = $_POST['updateattprogram']['student_id'];  // Records per page
  $tamat = $_POST['updateattprogram']['tamat'];  // Records per page
  $mula = $_POST['updateattprogram']['mula'];  // Records per page
  $scan_by = $_POST['updateattprogram']['scan_by'];  // Records per page
  
  // $nama = $_POST['nama'];  // Records per page
  // $location = $_POST['location'];  // Records per page
  // $fpin = $_POST['fpin'] ; // Assign null if 'fpin' is not set
  // $fpout =  $_POST['fpout'] ; // Assign null if 'fpin' is not set
  
  
    $query = "INSERT INTO program_attendance (program_id,student_id,scan_by)
                    VALUES ('$program_id', '$student_id', '$scan_by')";
  
    // debug_to_console($query);
    $results = mysqli_query($db, $query);


    $query = "INSERT INTO attendance (user_id, event_status,masa_mula,masa_tamat)  VALUES ('$student_id','1','$mula','$tamat');";
    $results = mysqli_query($db, $query);

    // header('location:' . $site_url . 'program/');
  die();
 }

 


if (isset($_POST['program_findall2'])) {

  $course = array();

  $limit = $_POST['program_findall']['limit'];  // Records per page
  $offset = $_POST['program_findall']['offset'];  // Record starting point
  $draw = $_POST['program_findall']['draw'];
  $searchTerm = isset($_POST['program_findall']['search']) ? $_POST['program_findall']['search'] : '';

  // Query to get total number of records in the 'sem' table with search filter
  $queryTotal = "SELECT a.nama ,a.ndp, a.image_url, d.nama as course , e.nama as sem FROM `user` a 
LEFT JOIN program_attendance b ON b.student_id = a.id
INNER JOIN user_enroll c ON c.user_id = a.id
INNER JOIN course d ON d.id = c.course_id
INNER JOIN sem e ON e.id = c.sem_start
WHERE b.scan_by IS NOT NULL;";
  if (!empty($searchTerm)) {
    $queryTotal .= " WHERE nama LIKE '%$searchTerm%'";
  }

  $resultTotal = mysqli_query($db, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultTotal);
  $recordsTotal = $rowTotal['total'];

  // Query to get paginated records with search filter
  $query = "SELECT a.*, b.nama as user_nama  , c.nama as course ,  e.nama as sem
   FROM program a
  INNER JOIN user b ON b.id = a.created_by
  INNER JOIN course c ON c.id = a.course_id
   INNER JOIN sem e ON e.id = a.sem_id
  ";
  if (!empty($searchTerm)) {
    $query .= "GROUP BY uniq_id WHERE nama LIKE '%$searchTerm%'";
  }
  $query .= " LIMIT $limit OFFSET $offset";
  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
      // Check if the uniq_id already exists in the array
      if (!isset($course[$row['uniq_id']])) {
        $course[$row['uniq_id']] = array(
          "a" => $row['nama'],        // Program Name
          "courses" => [],            // Store multiple courses
          "c" => $row['tarikh_mula'] . " - " . $row['tarikh_tamat'],   // Created By
          "d" => $row['user_nama'],   // Created By
          "uniq_id" => $row['uniq_id'],   // Created By
          "href" => "<a class='btn btn-primary' href='" . $site_url . "program/" . $row['uniq_id'] . "'>Show Details</a>"
        );
      }
      // Check if the course is already in the courses array
      if (!in_array($row['course'], $course[$row['uniq_id']]['courses'])) {
        $course[$row['uniq_id']]['courses'][] = $row['course'];  // Add course if not already present
      }

      // Ensure the semester is not already added for the course
      if (!isset($course[$row['uniq_id']]['courses_sems'][$row['course']])) {
        $course[$row['uniq_id']]['courses_sems'][$row['course']] = [];
      }

      // Add the semester to the course if not already added
      if (!in_array(getSemesterByNumber($row['sem']), $course[$row['uniq_id']]['courses_sems'][$row['course']])) {
        $course[$row['uniq_id']]['courses_sems'][$row['course']][] = getSemesterByNumber($row['sem']);
      }
    }
  }

  // Create the response with proper record counts
  $response = [
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,  // Total records in the table
    "recordsFiltered" => $recordsTotal,  // Records filtered by search
    "data" => array_values($course),
  ];

  echo json_encode($response);
  die();
}