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




if (isset($_POST['kelas_findall'])) {
  // Initialize the response array
  $enroll = array();

  // Get the limit, offset, and draw values from the POST data
  $limit = $_POST['kelas_findall']['limit'];  // Records per page
  $offset = $_POST['kelas_findall']['offset'];  // Record starting point
  $draw = $_POST['kelas_findall']['draw'];  // DataTables draw counter
  $bengkel = $_POST['kelas_findall']['bengkel'];  // Filter column 2
  $kelas = $_POST['kelas_findall']['kelas'];  // Filter column 2
  $course = $_POST['kelas_findall']['course'];  // Filter column 2

  // Base SQL Query for data fetching
  $sql = "SELECT a.id ,a.ndp,a.nama ,a.image_url, b.id as id2,b.fp_status , d.nama as course_nama  , fp_num
          FROM `user` a
          LEFT JOIN `user_fp` b ON a.id = b.user_id AND b.kelas_id = '$kelas'
          INNER JOIN user_enroll c ON c.user_id = a.id
          INNER JOIN course d ON d.id = c.course_id
          WHERE a.bengkel_id ='$bengkel' AND a.role = '4' 
 ";

  // Add filters for col2 and col3 if not empty
  if ($course != '') {
    $sql .= " AND c.course_id LIKE '%$course%' ";
  }

  // $user_status = ['Berhenti' , 'Aktif' , 'Tangguh', 'Diberhentikan'];

  // Append LIMIT and OFFSET for pagination
  $sql .= " LIMIT $limit OFFSET $offset";

  // Execute the query to fetch the filtered data
  $results = mysqli_query($db, $sql);

  // Check if the query was successful
  if ($results) {
    // Loop through the results and store them in the $enroll array
    $onlyone = 0;
    while ($row = mysqli_fetch_assoc($results)) {

      $id = $row['id'];
      if (!$row['fp_status']) {
        $status = '<button type="button" class="btn btn-secondary">Belum Register</button>';
        if (!$onlyone) {
        $id = "<button type='button' class='btn btn-primary insert-fp' data-id='$id' data-kelas='$kelas'><i class='bi bi-pencil-square'></i></button>";
          
        } else{
          
        }
      }
      if ($row['fp_status'] == 'R') {
        $status = '<button type="button" class="btn btn-warning">Dalam Process</button>';
        $onlyone++;
        $id = ' ';
      }
      if ($row['fp_status'] == 'D') {
        $status = '<button type="button" class="btn btn-success">'. $row['fp_num'].' </button>';
        $id = "<button type='button' class='btn btn-primary delete-fp' data-id='$id' data-kelas='$kelas'><i class='bi bi-trash'></i></button>";

      }


      $enroll[] = array(
        "a" => '
                    <div class="d-flex no-block align-items-center">
                        <div class="m-r-10">
                            <img
                                src="' . $site_url . 'assets/images/user/' . $row['id'] . '/' . $row['image_url'] . '"
                                alt="user" class="rounded-circle" width="45">
                        </div>
                        <div class="">
                            <h5 class="m-b-0 font-16 font-medium">' . $row['nama'] . '</h5>
                            <span class="text-muted">' . $row['ndp'] . '</span>
                        </div>
                    </div>',
        "b" => $row['course_nama'],
        "c" => $status,
        "id" => $id,
      );
    }

    // Query to get the total number of records (no filters)
    $sqlTotal = "SELECT COUNT(*) as total FROM `user`";

    // Execute the total count query
    $totalResults = mysqli_query($db, $sqlTotal);
    $totalRow = mysqli_fetch_assoc($totalResults);
    $recordsTotal = $totalRow['total'];  // Total records in the table (without filters)

    // Query to get the filtered number of records
    $sqlFiltered = "SELECT COUNT(*) as total FROM `user` ";

    // Apply the same filters for $col2 and $col3 in the filtered count query
    // if ($col2 != '') {
    //     $sqlFiltered .= " AND d.nama = '$col2' ";
    // }



    // Execute the filtered count query
    $filteredResults = mysqli_query($db, $sqlFiltered);
    $filteredRow = mysqli_fetch_assoc($filteredResults);
    $recordsFiltered = $filteredRow['total'];  // Filtered records count

    // Prepare the response
    $response = [
      "draw" => $draw,
      "recordsTotal" => $recordsTotal,  // Total records in the table (no filters)
      "recordsFiltered" => $recordsFiltered,  // Filtered records based on criteria
      "data" => $enroll,  // Data to populate the table
    ];

    // Return the response as JSON
    echo json_encode($response);
  } else {
    // Handle the case where the query fails
    echo json_encode([
      "draw" => $draw,
      "recordsTotal" => 0,
      "recordsFiltered" => 0,
      "data" => [],
    ]);
  }

  die();  // Ensure the script stops here after output
}


if (isset($_POST['kelas_insertfp'])) {

  $user_id = $_POST['kelas_insertfp']['user_id'];  // User ID
  $kelas_id = $_POST['kelas_insertfp']['kelas_id'];  // Class ID
  
   $query = "SELECT fp_num 
            FROM user_fp 
            WHERE kelas_id='$kelas_id' AND fp_num BETWEEN 1 AND 1000 ";
  
  $results = mysqli_query($db, $query);
  $used_fp_nums = [];
  
   while ($row = mysqli_fetch_assoc($results)) {
      $used_fp_nums[] = $row['fp_num'];
  }
  
   $next_fpnum = null;
  
  for ($i = 1; $i <= 1000; $i++) {
      if (!in_array($i, $used_fp_nums)) {
          $next_fpnum = $i;
          break;  
      }
  }
  
   if ($next_fpnum === null) {
      die('Error: No available fp_num in the range 1-1000');
  }
  
   $query = "INSERT INTO user_fp (user_id, kelas_id, fp_num,fp_status) 
            VALUES ('$user_id', '$kelas_id', '$next_fpnum','R')";
  
   $results = mysqli_query($db, $query);
  

  die();  // Ensure the script stops here after output


}


if (isset($_POST['kelas_deletefp'])) {

  $user_id = $_POST['kelas_deletefp']['user_id'];  // User ID
  $kelas_id = $_POST['kelas_deletefp']['kelas_id'];  // Class ID
  
  //  $query = "SELECT id 
  //           FROM user_fp 
  //           WHERE kelas_id='$kelas_id'  AND user_id ='$user_id' ";
  
  // $results = mysqli_query($db, $query);
   
  //  while ($row = mysqli_fetch_assoc($results)) {
  //     $id = $row['id'];
  // }
  
  
   
  
   $query = "DELETE FROM user_fp WHERE user_id= '$user_id' AND kelas_id = '$kelas_id' AND fp_status='D' ";
  
   $results = mysqli_query($db, $query);
  echo "deleted";

  die();  // Ensure the script stops here after output


}