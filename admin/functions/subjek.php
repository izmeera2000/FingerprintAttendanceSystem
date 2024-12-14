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
  
    $nama = $_POST['nama'];  // Records per page
    $kod = $_POST['kod'];  // Records per page
  
  
  
    $query = "INSERT INTO user_subjek (course_id,subjek_id,assign_to,day,slot_id,status,sem_id,tarikh_mula,tarikh_tamat) VALUES ('$nama','$kod');";
  
    // debug_to_console($query);
    $results = mysqli_query($db, $query);
    header('location:' . $site_url . 'subjek/create');
  
  }