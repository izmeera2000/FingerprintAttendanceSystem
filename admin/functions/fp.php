<?php




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
  