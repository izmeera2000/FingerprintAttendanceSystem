<?php




if (isset($_POST['fetch_holiday_o'])) {



    $url = "https://www.perak.gov.my/index.php/rakyat/info-umum/hari-kelepasan-am-negeri-perak";
    $html = file_get_contents($url);
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $tables = $dom->getElementsByTagName('table');
  
    // Assuming the holidays are in the first table
    $table = $tables->item(0);
    $rows = $table->getElementsByTagName('tr');
  
    $holidays = [];
    $monthNames = ["Januari" => "01", "Februari" => "02", "Mac" => "03", "April" => "04", "Mei" => "05", "Jun" => "06", "Julai" => "07", "Ogos" => "08", "September" => "09", "Oktober" => "10", "November" => "11", "Disember" => "12"];
    foreach ($rows as $row) {
      $cols = $row->getElementsByTagName('td');
      if ($cols->length > 0) {
        if (!empty($cols->item(1)->nodeValue)) {
  
          $name = preg_replace('/\s*\([^)]*\)/', '', ($cols->item(1)->nodeValue));
  
          $date = trim($cols->item(2)->nodeValue);
  
          $dateParts = explode(" ", $date);
          if (strpos($date, 'dan') !== false) {
            $day1 = str_pad($dateParts[0], 2, "0", STR_PAD_LEFT);
            $day2 = str_pad($dateParts[2], 2, "0", STR_PAD_LEFT);
            $month = $monthNames[$dateParts[3]];
  
            $year = trim($cols->item(3)->nodeValue);
            $day = trim($cols->item(4)->nodeValue);
            $holidays[] = [
              'formatdate' => "$year-$month-$day1",
              'name' => $name,
              'day' => $day,
            ];
            $holidays[] = [
              'formatdate' => "$year-$month-$day2",
              'name' => $name,
              'day' => $day,
            ];
          } else {
            $day2 = str_pad($dateParts[0], 2, "0", STR_PAD_LEFT);
            $month = $monthNames[$dateParts[1]];
  
            $year = trim($cols->item(3)->nodeValue);
            $day = trim($cols->item(4)->nodeValue);
            $holidays[] = [
              'formatdate' => "$year-$month-$day2",
  
              'name' => $name,
              'day' => $day,
            ];
          }
  
        }
      }
    }
    // 
    // var_dump($holidays);
  
    foreach ($holidays as $holiday) {
      $formatdate = $holiday['formatdate'];
      $name = $holiday['name'];
  
      $query = "INSERT IGNORE INTO holiday (tarikh, nama) VALUES ('$formatdate', '$name') ";
      $results = mysqli_query($db, $query);
  
    }
  
  
  
  
  
  }
  
  
  
  if (isset($_POST['holiday_findall'])) {
  
    $holiday = array();
  
    $limit = $_POST['holiday_findall']['limit'];  // Records per page
    $offset = $_POST['holiday_findall']['offset'];  // Record starting point
    $draw = $_POST['holiday_findall']['draw'];
    $searchTerm = isset($_POST['holiday_findall']['search']) ? $_POST['holiday_findall']['search'] : '';
  
    // Query to get total number of records in the 'sem' table with search filter
    $queryTotal = "SELECT COUNT(*) as total FROM holiday ORDER BY TARIKH ASC";
    if (!empty($searchTerm)) {
      $queryTotal .= " WHERE nama LIKE '%$searchTerm%'";
    }
  
    $resultTotal = mysqli_query($db, $queryTotal);
    $rowTotal = mysqli_fetch_assoc($resultTotal);
    $recordsTotal = $rowTotal['total'];
  
    // Query to get paginated records with search filter
    $query = "SELECT * FROM holiday";
    if (!empty($searchTerm)) {
      $query .= " WHERE nama LIKE '%$searchTerm%'";
    }
    $query .= " LIMIT $limit OFFSET $offset";
    $results = mysqli_query($db, $query);
  
    if (mysqli_num_rows($results) > 0) {
      while ($row = mysqli_fetch_assoc($results)) {
        $holiday[] = array(
          "a" => $row['nama'],
          "b" => date("d/m/Y", strtotime($row['tarikh'])),
          "c" => $row['verify'],
        );
      }
    }
  
    // Create the response with proper record counts
    $response = [
      "draw" => $draw,
      "recordsTotal" => $recordsTotal,  // Total records in the table
      "recordsFiltered" => $recordsTotal,  // Records filtered by search
      "data" => $holiday
    ];
  
    echo json_encode($response);
    die();
  }
  
  
  if (isset($_POST['holiday_createf'])) {
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
  
  if (isset($_POST['holiday_editf'])) {
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
  
  
  if (isset($_POST['holiday_deletef'])) {
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