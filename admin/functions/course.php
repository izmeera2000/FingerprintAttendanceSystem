

<?php


if (isset($_POST['course_findall'])) {

$course = array();

$limit = $_POST['course_findall']['limit'];  // Records per page
$offset = $_POST['course_findall']['offset'];  // Record starting point
$draw = $_POST['course_findall']['draw'];
$searchTerm = isset($_POST['course_findall']['search']) ? $_POST['course_findall']['search'] : '';

// Query to get total number of records in the 'sem' table with search filter
$queryTotal = "SELECT COUNT(*) as total FROM course ORDER BY time_add DESC";
if (!empty($searchTerm)) {
  $queryTotal .= " WHERE nama LIKE '%$searchTerm%'";
}

$resultTotal = mysqli_query($db, $queryTotal);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$recordsTotal = $rowTotal['total'];

// Query to get paginated records with search filter
$query = "SELECT * FROM course";
if (!empty($searchTerm)) {
  $query .= " WHERE nama LIKE '%$searchTerm%'";
}
$query .= " LIMIT $limit OFFSET $offset";
$results = mysqli_query($db, $query);

if (mysqli_num_rows($results) > 0) {
  while ($row = mysqli_fetch_assoc($results)) {
    $course[] = array(
      "a" => $row['nama'],
      "b" => date("d/m/Y", strtotime($row['time_add'])),
      "id" => $row['id'],
      // "c" => $row['verify'],
    );
  }
}

// Create the response with proper record counts
$response = [
  "draw" => $draw,
  "recordsTotal" => $recordsTotal,  // Total records in the table
  "recordsFiltered" => $recordsTotal,  // Records filtered by search
  "data" => $course
];

echo json_encode($response);
die();
}


if (isset($_POST['course_createf'])) {
// echo "test";
// var_dump(($_POST));

$nama = $_POST['nama'];  // Records per page
// $mula = $_POST['mula'];  // Records per page
// $tamat = $_POST['tamat'];  // Records per page



$query = "INSERT INTO course (nama) VALUES ('$nama');";

// debug_to_console($query);
$results = mysqli_query($db, $query);
header('location:' . $site_url . 'course/create');

}

if (isset($_POST['course_editf'])) {
// echo "test";
// var_dump(($_POST));

$id = $_POST['id'];  // Records per page
$nama = $_POST['nama'];  // Records per page
// $mula = $_POST['mula'];  // Records per page
// $tamat = $_POST['tamat'];  // Records per page



$query = "UPDATE  course SET nama='$nama'   WHERE id = '$id' ";

// debug_to_console($query);
$results = mysqli_query($db, $query);
header('location:' . $site_url . 'course/create');
 
}


if (isset($_POST['course_deletef'])) {
// echo "test";
// var_dump(($_POST));

$id = $_POST['id'];  // Records per page
// $nama = $_POST['nama'];  // Records per page
// $location = $_POST['location'];  // Records per page
// $fpin = $_POST['fpin'] ; // Assign null if 'fpin' is not set
// $fpout =  $_POST['fpout'] ; // Assign null if 'fpin' is not set


$query = "DELETE FROM   course   WHERE id = '$id' ";

// debug_to_console($query);
$results = mysqli_query($db, $query);
header('location:' . $site_url . 'course/create');

}