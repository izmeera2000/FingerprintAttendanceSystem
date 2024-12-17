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


    $query = "SELECT id ,fp_num FROM `user_fp` WHERE fp_status ='R';";
    $results = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($results)) {
        $id = $row['fp_num'];
        echo $id;

    }


}



if (isset($_POST['post_fp'])) {

    $fp_new = $_POST['post_fp'];

    $query = "SELECT id, fp_num FROM `user_fp` WHERE fp_status = 'R';";
    $results = mysqli_query($db, $query);

    // Check if the SELECT query was successful
    if ($results) {
        // Loop through each row and update corresponding user record
        while ($row = mysqli_fetch_assoc($results)) {
            $id = $row['id'];  // Assuming `id` is the column for user id
            $fp_num = $row['fp_num'];  // The `fp_num` value

            // Output the id and fp_num for debugging
            echo "Updating user with ID: $id and fp_num: $fp_num<br>";

            // Update user record: set fp to 'D' for this user
            $updateQuery = "UPDATE user_fp SET fp_status = 'D' WHERE user_id = '$id'";  // Be careful with raw queries
            $updateResult = mysqli_query($db, $updateQuery);

            // Check if the update was successful
            if ($updateResult) {
                echo "User with ID $id updated successfully.<br>";
            } else {
                echo "Failed to update user with ID $id. Error: " . mysqli_error($db) . "<br>";
            }
        }

        // Optionally, you can return a response after all updates
        echo "Data processed.";
    } else {
        // Handle case when the SELECT query fails
        echo "Error retrieving data: " . mysqli_error($db);
    }
}


if (isset($_POST['login_fp'])) {

    $id = $_POST['login_fp'];
    $ent = $_POST['entrance'];



    $query = "SELECT user_id ,fp_num FROM `user_fp` WHERE fp_num ='$id';";
    $results = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($results)) {
        $user_id = $row['user_id'];
        echo $user_id;

    }


    if ($ent) {

        $query = "SELECT * FROM attendance WHERE user_id = '$id' AND masa_tamat IS NULL  ORDER BY time_add DESC LIMIT 1;";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 0) {


            $query = "INSERT INTO attendance (user_id, event_status)  VALUES ('$id','1');";
            $results2 = mysqli_query($db, $query);
            //  $id2 = $row['id'];
            // echo $id2;


        }
    } else {


        $query = "SELECT * FROM `attendance` WHERE user_id = '$id'  AND masa_tamat IS NULL  ORDER BY time_add DESC LIMIT 1;";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {

            while ($row = mysqli_fetch_assoc($results)) {
                $id2 = $row['id'];
                $query = "UPDATE attendance SET masa_tamat = NOW()  WHERE id ='$id2' ";
                $results2 = mysqli_query($db, $query);

            }




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


if (isset($_POST['fp_findall2'])) {

    $fp = array();

    $limit = $_POST['fp_findall2']['limit'];  // Records per page
    $offset = $_POST['fp_findall2']['offset'];  // Record starting point
    $draw = $_POST['fp_findall2']['draw'];
    $searchTerm = isset($_POST['fp_findall2']['search']) ? $_POST['fp_findall2']['search'] : '';

    // Query to get total number of records in the 'fp_device' table with search filter
    $queryTotal = "SELECT COUNT(*) as total FROM fp_settings a  INNER JOIN kelas b ON a.kelas_id = b.id";
    if (!empty($searchTerm)) {
        $queryTotal .= " WHERE nama_kelas LIKE '%$searchTerm%'";
    }

    $resultTotal = mysqli_query($db, $queryTotal);
    $rowTotal = mysqli_fetch_assoc($resultTotal);
    $recordsTotal = $rowTotal['total'];

    // Query to get paginated records with search filter
    $query = "SELECT a.*,b.nama_kelas FROM fp_settings a  INNER JOIN kelas b ON a.kelas_id = b.id";
    if (!empty($searchTerm)) {
        $query .= " WHERE nama_kelas LIKE '%$searchTerm%'";
    }
    $query .= " LIMIT $limit OFFSET $offset";
    $results = mysqli_query($db, $query);
    $mode = [1 => 'Register', 2 => 'Login', 3 => 'Empty Database'];
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_assoc($results)) {

            $fp[] = array(
                "a" => $row['nama_kelas'],
                "b" => $mode[$row["mode"] + 1],
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


if (isset($_POST['fp_settingedit'])) {
    // echo "test";
    // var_dump(($_POST));

    $id = $_POST['fp_settingedit']['id'];  // Records per page
    $mode = $_POST['fp_settingedit']['mode'];  // Records per page


    $query = "UPDATE  fp_settings SET mode ='$mode' WHERE id = '$id' ";

    // debug_to_console($query);
    $results = mysqli_query($db, $query);
    // header('location:' . $site_url . 'fp/settings');
    die();

}
