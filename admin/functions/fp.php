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







if (isset($_POST['fingerprintlogin'])) {

    $user_id = "";

    $query = "SELECT * FROM attendance WHERE DATE(masa_mula) = CURRENT_DATE AND masa_tamat IS  NULL;";
    $results = mysqli_query($db, $query);
    if ($result->num_rows > 0) {

        while ($row = mysqli_fetch_assoc($results)) {
            $id = $row['id'];
            $query = "UPDATE `attendance` SET `masa_tamat` = NOW() WHERE id = $id";
        }

    } else {

        $query = "INSERT INTO attendance (user_id) VALUES ('$user_id') ";
        $results = mysqli_query($db, $query);


    }
}


if (isset($_POST['fingerprintregister'])) {

    $user_id = "";

    $query = "SELECT * FROM user WHERE fp = '1' ";
    $results = mysqli_query($db, $query);
    if ($result->num_rows > 0) {

        while ($row = mysqli_fetch_assoc($results)) {
            $id = $row['id'];
            $query = "UPDATE `attendance` SET `masa_tamat` = NOW() WHERE id = $id";
        }

    } else {

        $query = "INSERT INTO attendance (user_id) VALUES ('$user_id') ";
        $results = mysqli_query($db, $query);


    }
}




if (isset($_POST['post_fp2'])) {


    $query = "SELECT id ,fp FROM `user` WHERE fp='R';";
    $results = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($results)) {
        $id = $row['id'];
        echo $id;

    }


}


if (isset($_POST['post_fp'])) {

    $id = $_POST['post_fp'];

    $query = "UPDATE user SET fp ='D' WHERE  id = '$id' ";
    $results = mysqli_query($db, $query);

    if ($results) {
        echo "data posted:";
        var_dump($_POST);
    } else {
        echo "not Ok";
    }


}


if (isset($_POST['login_fp'])) {

    $id = $_POST['login_fp'];
    $ent = $_POST['entrance'];
    if ($ent) {

        $query = "SELECT * FROM attendance WHERE user_id = '$id' AND masa_tamat IS NULL  ORDER BY time_add DESC LIMIT 1;";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 0) {


            $query = "INSERT INTO attendance (user_id, event_status)  VALUES ('$id','1');";
            $results = mysqli_query($db, $query);
            while ($row = mysqli_fetch_assoc($results)) {
                $id2 = $row['id'];
                // echo $id2;

            }
        }
    } else {


        $query = "SELECT * FROM `attendance` WHERE user_id = '$id'  AND masa_tamat IS NULL  ORDER BY time_add DESC LIMIT 1;";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($result) == 0) {

            while ($row = mysqli_fetch_assoc($results)) {
                $id2 = $row['id'];
                // echo $id2;

            }


            $query = "UPDATE attendance SET masa_tamat = NOW()  WHERE id ='$id2' ";
            $results = mysqli_query($db, $query);

        } else {
            echo "no_in_detected";
        }

    }

}




if (isset($_POST['fp_mode'])) {

    $fp = $_POST['fp_name'];

    $query = "SELECT a.id, a.nama_kelas, c.nama , b.mode FROM `kelas`a  
        INNER JOIN fp_settings b ON a.id =b.kelas_id 
        INNER JOIN fp_device c ON c.id = 	a.fp_exit WHERE nama= '$fp';  ";
    $results = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($results)) {
        $mode = $row['mode'];
        if ($mode == 0) {
            echo "register";
        }
        if ($mode == 1) {
            echo "login";
        }
        if ($mode == 2) {
            echo "emptydb";
        }
    }


}




