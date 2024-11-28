<?php




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
  
  