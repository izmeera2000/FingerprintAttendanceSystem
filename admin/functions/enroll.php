<?php
if (isset($_POST['enroll_findall'])) {
    // Initialize the response array
    $enroll = array();

    // Get the limit, offset, and draw values from the POST data
    $limit = $_POST['enroll_findall']['limit'];  // Records per page
    $offset = $_POST['enroll_findall']['offset'];  // Record starting point
    $draw = $_POST['enroll_findall']['draw'];  // DataTables draw counter
    $col2 = $_POST['enroll_findall']['col2'];  // Filter column 2
    $col3 = $_POST['enroll_findall']['col3'];  // Filter column 3

    // Base SQL Query for data fetching
    $sql = "SELECT u.id,a.user_status, u.image_url, u.nama, u.ndp, 
            b.nama AS b_nama, 
            c.nama AS c_nama, 
            d.nama AS d_nama, 
            e.nama AS e_nama 
            FROM user_enroll a
            INNER JOIN user u ON u.id = a.user_id
            INNER JOIN bengkel b ON u.bengkel_id = b.id
            INNER JOIN course c ON c.id = a.course_id
            INNER JOIN sem d ON d.id = a.sem_start
            INNER JOIN sem e ON e.id = a.sem_now
            WHERE u.role = 4";

    // Add filters for col2 and col3 if not empty
    if ($col2 != '') {
        $sql .= " AND d.nama = '$col2' ";
    }

    if ($col3 != '') {
        $sql .= " AND c.nama = '$col3' ";
    }
    $user_status = ['Berhenti' , 'Aktif' , 'Tangguh', 'Diberhentikan'];
    
    // Append LIMIT and OFFSET for pagination
    $sql .= " LIMIT $limit OFFSET $offset";

    // Execute the query to fetch the filtered data
    $results = mysqli_query($db, $sql);

    // Check if the query was successful
    if ($results) {
        // Loop through the results and store them in the $enroll array
        while ($row = mysqli_fetch_assoc($results)) {
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
                "b" => $row['d_nama'],
                "c" => $row['c_nama'],
                "d" => $user_status[$row['user_status']],
                "id" => $row['id'],
            );
        }

        // Query to get the total number of records (no filters)
        $sqlTotal = "SELECT COUNT(*) AS total 
                     FROM user_enroll a
                     INNER JOIN user u ON u.id = a.user_id
                     INNER JOIN bengkel b ON u.bengkel_id = b.id
                     INNER JOIN course c ON c.id = a.course_id
                     INNER JOIN sem d ON d.id = a.sem_start
                     INNER JOIN sem e ON e.id = a.sem_now 
                     WHERE u.role = 4";

        // Execute the total count query
        $totalResults = mysqli_query($db, $sqlTotal);
        $totalRow = mysqli_fetch_assoc($totalResults);
        $recordsTotal = $totalRow['total'];  // Total records in the table (without filters)

        // Query to get the filtered number of records
        $sqlFiltered = "SELECT COUNT(*) AS total 
                        FROM user_enroll a
                        INNER JOIN user u ON u.id = a.user_id
                        INNER JOIN bengkel b ON u.bengkel_id = b.id
                        INNER JOIN course c ON c.id = a.course_id
                        INNER JOIN sem d ON d.id = a.sem_start
                        INNER JOIN sem e ON e.id = a.sem_now 
                        WHERE u.role = 4";

        // Apply the same filters for $col2 and $col3 in the filtered count query
        if ($col2 != '') {
            $sqlFiltered .= " AND d.nama = '$col2' ";
        }

        if ($col3 != '') {
            $sqlFiltered .= " AND c.nama = '$col3' ";
        }

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

?>
