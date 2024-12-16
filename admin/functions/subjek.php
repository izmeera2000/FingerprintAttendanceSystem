<?php



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

if (isset($_POST['subjek_assign'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['id2'];  // Records per page

  $user = $_POST['user'];  // Records per page
  $course = $_POST['course'];  // Records per page
  $sem = $_POST['sem'];  // Records per page
  $day = $_POST['day'];  // Records per page
  $slot = $_POST['slot'];  // Records per page
  $tarikh_mula = $_POST['tarikh1'];  // Records per page
  $tarikh_tamat = $_POST['tarikh2'];  // Records per page



  $query = "INSERT INTO user_subjek (course_id,subjek_id,assign_to,day,slot_id,status,sem_id,tarikh_mula,tarikh_tamat) 
    VALUES ('$course','$id','$user','$day','$slot','1','$sem','$tarikh_mula','$tarikh_tamat');";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  header('location:' . $site_url . 'subjek/create');

}


if (isset($_POST['subjek2_findall'])) {

 $hari =  [2 => 'Isnin', 3 => 'Selasa', 4 => 'Rabu', 5 => 'Khamis', 6 => 'Jumaat'];

  $subjek = array();

  $limit = $_POST['subjek2_findall']['limit'];  // Records per page
  $offset = $_POST['subjek2_findall']['offset'];  // Record starting point
  $draw = $_POST['subjek2_findall']['draw'];
  $searchTerm = isset($_POST['subjek2_findall']['search']) ? $_POST['subjek2_findall']['search'] : '';


  // Query to get total number of records in the 'kelas' table
  $queryTotal = "SELECT COUNT(*) as total FROM user_subjek a INNER JOIN subjek b ON b.id =a.subjek_id";
  if (!empty($searchTerm)) {
    $queryTotal .= " WHERE b.subjek_nama LIKE '%$searchTerm%'  ";
  }
  $resultTotal = mysqli_query($db, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultTotal);
  $recordsTotal = $rowTotal['total'];

  // Query to get paginated records
  $query = "SELECT 
  a.*, b.subjek_nama,b.subjek_kod,c.nama as user_nama,c.email  ,e.nama as sem, f.nama as slotnum , d.nama as course
  FROM `user_subjek` a  
  INNER JOIN subjek b  ON b.id =a.subjek_id 
  INNER JOIN user c ON c.id = a.assign_to
  INNER JOIN course d ON d.id = a.course_id
  INNER JOIN sem e ON e.id = a.sem_id
  INNER JOIN time_slot f ON f.id = a.slot_id
  ";
  if (!empty($searchTerm)) {
    $query .= " WHERE b.subjek_nama LIKE '%$searchTerm%' ";
  }
  $query .= " LIMIT $limit OFFSET $offset";

  $results = mysqli_query($db, $query);

  if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
      $dateObj1 = new DateTime($row['tarikh_mula']);
      $dateObj2 = new DateTime($row['tarikh_tamat']);

// Format the date as DD/MM/YYYY
$tarikh_mula = $dateObj1->format('d/m/Y');
$tarikh_tamat = $dateObj2->format('d/m/Y');
      $subjek[] = array(
        "a" => '<div class="d-flex no-block align-items-center">
                         
                        <div class="">
                            <h5 class="m-b-0 font-16 font-medium">' . $row['subjek_nama'] . '</h5>
                            <span class="text-muted">' . $row['subjek_kod'] . '</span>
                        </div>
                    </div>',
        "b" => '<div class="d-flex no-block align-items-center">
                         
                        <div class="">
                            <h5 class="m-b-0 font-16 font-medium">' . $row['user_nama'] . '</h5>
                            <span class="text-muted">' . $row['email'] . '</span>
                        </div>
                    </div>',
        "c" => '<div class="d-flex no-block align-items-center">
                         
                        <div class="">
                            <h5 class="m-b-0 font-16 font-medium">' . $row['course'] . '</h5>
                            <h5 class="m-b-0 font-16 font-medium">Semester ' . getSemesterByNumber($row['sem']) . '</h5>
                        </div>
                    </div>',
        "d" => '<div class="d-flex no-block align-items-center">
                         
                        <div class="">
                            <h5 class="m-b-0 font-16 font-medium">' . $hari[$row['day']] . '</h5>
                            <h5 class="m-b-0 font-16 font-medium">Slot ' . $row['slotnum'] . '</h5>
                        </div>
                    </div>',
        "e" => '<div class="d-flex no-block align-items-center">
                         
                        <div class="">
                            <h5 class="m-b-0 font-16 font-medium">' . $tarikh_mula. ' - ' . $tarikh_tamat . ' </h5>
                             
                        </div>
                    </div>',
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



if (isset($_POST['deleteassignslot'])) {
  // echo "test";
  // var_dump(($_POST));

  $id = $_POST['deleteassignslot']['id'];  // Records per page
  // $nama = $_POST['nama'];  // Records per page
  // $location = $_POST['location'];  // Records per page
  // $fpin = $_POST['fpin'] ; // Assign null if 'fpin' is not set
  // $fpout =  $_POST['fpout'] ; // Assign null if 'fpin' is not set


  $query = "DELETE FROM   user_subjek   WHERE id = '$id' ";

  // debug_to_console($query);
  $results = mysqli_query($db, $query);
  
  // header('location:' . $site_url . 'subjek/assignlist');
  die();

}