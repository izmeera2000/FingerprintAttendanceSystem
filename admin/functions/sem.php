<?php


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
  
  
  
  
  