<?php




// akan run cron jobs setapi  1 hour 8-5
if (isset($_POST['slot_checktime'])) {


    $slot_statuses = [
        0 => "Unattended / Unexcused Absence",
        1 => "Present",
        2 => "Late",
        3 => "Pending Excuse of Absence",
        4 => "Excused Absence",
        5 => "Left Early",
        6 => "Break",
        7 => "Not Yet",

    ];

    // $start_timeb = microtime(true);

    $time_slots = []; // Initialize an empty array
    // $time_limit = 50;
    $nowdate = date('Y-m-d');
    $now = new DateTime();
    $now2 = $now->format('Y-m-d H:i:s');
    $day_of_week = date('l'); // Get the day of the week (e.g., "Monday", "Friday")

    // if ($day_of_week != "Saturday" || $day_of_week != "Sunday") {
    //     exit;
    // }

    $query = "SELECT * FROM time_slot ORDER BY id ASC";
    $results = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($results)) {

        if ($day_of_week === 'Friday' && $row['slot'] === 'rehat2') {
            $row['masa_mula'] = $row['masa_mula2'];
            $row['masa_tamat'] = $row['masa_tamat2'];
        }
        $time_slots[] = $row;
    }



    $query = "SELECT 
                    a.*, 
                    b.role, 
                    CASE 
                        WHEN h.user_id IS NOT NULL THEN 'Yes' 
                        ELSE 'No' 
                    END AS on_holiday
                FROM 
                    attendance a
                INNER JOIN 
                    user b ON b.id = a.user_id
                LEFT JOIN 
                    user_holiday h ON h.user_id = a.user_id 
                    AND CURDATE() >= DATE(h.tarikh_mula) 
                    AND CURDATE() <= DATE(h.tarikh_tamat)
                WHERE 
                    DATE(a.masa_mula) = CURDATE() 
                    AND b.role = '4';";
    $results = mysqli_query($db, $query);

    while ($row = $results->fetch_assoc()) {
        $id = $row['user_id'];

        $masa_mula = new DateTime($row['masa_mula']);
        $masa_tamat = !empty($row['masa_tamat']) ? new DateTime($row['masa_tamat']) : new DateTime(); // Use current time if masa_tamat is empty

        // Loop through the time slots
        foreach ($time_slots as $time_slot) {
            $start_time = new DateTime($nowdate . ' ' . $time_slot['masa_mula']);
            $end_time = new DateTime($nowdate . ' ' . $time_slot['masa_tamat']);
            $slot_name = $time_slot['slot'];


            $late_time = clone $start_time; // Clone the start time to avoid modifying the original
            $late_time->modify('+10 minutes'); // Add 10 minutes to the start time
            //late modifier

            // Check for overlap
            if ($masa_mula < $end_time && $masa_tamat > $start_time) {
                $overlap_start = max($masa_mula->getTimestamp(), $start_time->getTimestamp());
                $overlap_end = min($masa_tamat->getTimestamp(), $end_time->getTimestamp());

                // Calculate duration in minutes
                $overlap_duration = ceil(($overlap_end - $overlap_start) / 60); // Convert seconds to minutes

                $interval = $start_time->diff($end_time);

                $supposed_time = ($interval->h * 60) + $interval->i;


                // Switch case to determine slot status
                switch (true) {


                    case ($slot_name == "rehat1" || $slot_name == "rehat2"):
                        $slot_status = 6; // rehat
                        break;

                    case ($overlap_duration < ($supposed_time - 15)):
                        $slot_status = 5; // Left  Early
                        break;


                    case ($masa_mula > $late_time):
                        // Attendance is more than 10 minutes past the start time
                        // echo "Attendance from {$row['masa_mula']} to {$masa_tamat->format('Y-m-d H:i:s')} .<br>";

                        $slot_status = 2; // Late
                        break;



                    // case ($masa_tamat < $end_time):
                    //   // Attendance ends before the time slot ends
                    //   $slot_status = 5; // Leave or another appropriate status
                    //   break;


                    default:
                        // Default case for on-time attendance
                        $slot_status = 1; // Present
                        break;
                }



            } else {
                // No overlap case

                if ($now < $start_time) {
                    $slot_status = 7; // not yet

                } else {

                    $slot_status = 0; // Unattended
                }

                if ($slot_name == "rehat1" || $slot_name == "rehat2") {
                    $slot_status = 6; // rehat

                }
            }

            $query2 = "INSERT INTO attendance_slot (user_id, slot, slot_status, tarikh)
             VALUES ('$id', '$slot_name', '$slot_status', '$nowdate')
             ON DUPLICATE KEY UPDATE
                 slot_status = CASE 
                     WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(slot_status)
                     ELSE slot_status
                 END,
                 tarikh = CASE 
                     WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(tarikh)
                     ELSE tarikh
                 END";
            $results2 = mysqli_query($db, $query2);

            // echo " $supposed_time min<br>";
            if (!$results2) {
                // Query failed, output the error message
                die("Error in query: " . mysqli_error($db));
            } else {
                $start_time2 = $start_time->format('Y-m-d H:i:s');
                $end_time2 = $end_time->format('Y-m-d H:i:s');
                $masa_tamat2 = $masa_tamat->format('Y-m-d H:i:s');
                $masa_mula2 = $masa_mula->format('Y-m-d H:i:s');
                echo " $slot_status  $slot_name  ($masa_mula2 < $end_time2 && $masa_tamat2 > $start_time2 ) \n";
            }


        }

    }

    $query = "SELECT s.id, s.role 
    FROM user s 
    LEFT JOIN attendance a 
    ON s.id = a.user_id 
    AND DATE(a.masa_mula) = CURDATE() 
    WHERE a.user_id IS NULL 
    AND s.role = '4'";

    $results = mysqli_query($db, $query);

    while ($row = $results->fetch_assoc()) {
        foreach ($time_slots as $time_slot) {
            $start_time = new DateTime($nowdate . ' ' . $time_slot['masa_mula']);
            $end_time = new DateTime($nowdate . ' ' . $time_slot['masa_tamat']);
            $slot_name = $time_slot['slot'];

            if ($now < $start_time) {
                $slot_status = 7;  // Not yet
            } else {
                $slot_status = 0;  // Unattended
            }

            if ($slot_name == "rehat1" || $slot_name == "rehat2") {
                $slot_status = 6;  // Break
            }

            $id = $row['id'];

            $query2 = "INSERT INTO attendance_slot (user_id, slot, slot_status, tarikh)
                    VALUES ('$id', '$slot_name', '$slot_status', '$nowdate')
                    ON DUPLICATE KEY UPDATE
                        slot_status = CASE 
                            WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(slot_status)
                            ELSE slot_status
                        END,
                        tarikh = CASE 
                            WHEN slot_status NOT IN (1,2,3, 4,5) THEN VALUES(tarikh)
                            ELSE tarikh
                        END";

            $results2 = mysqli_query($db, $query2);
        }
    }




}





if (isset($_POST['check_slot_email'])) {


    include(getcwd() . '/admin/vendor/setasign/fpdf/exfpdf.php');
    include(getcwd() . '/admin/vendor/setasign/fpdf/easyTable.php');

    $enabled = 1;
    if (!$enabled) {
        $query = "SELECT * 
    FROM `sem` 
    WHERE start_date <= NOW() 
      AND end_date >= NOW(); ";
        $results = mysqli_query($db, $query);

        while ($date = mysqli_fetch_assoc($results)) {
            $start_date = $date['start_date'];
            $end_date = $date['end_date'];
        }



        $querya = "SELECT user_id, COUNT(*) AS count
        FROM `attendance_slot`
        WHERE tarikh BETWEEN '$start_date' AND '$end_date'
        GROUP BY user_id, tarikh
        ORDER BY user_id, tarikh;";

        $resultsa = mysqli_query($db, $querya);

        while ($attslot = mysqli_fetch_assoc($resultsa)) {
            $id = $attslot['user_id'];

            if ($attslot['count'] >= 15) {








                $query2 = "SELECT a.id,a.nama,a.kp,a.ndp,c.nama as kursus ,d.nama as sem_start, a.email  FROM user a 
              INNER JOIN user_enroll b ON b.user_id = a.id
              INNER JOIN course c ON c.id = b.course_id
              INNER JOIN sem d ON d.id = b.sem_start
              WHERE a.id = '$id'";
                $results2 = mysqli_query($db, $query2);
                while ($row = $results2->fetch_assoc()) {
                    $id2 = $row['id'];
                    $nama = $row['nama'];
                    $kp = $row['kp'];
                    $kursus = $row['kursus'];
                    $ndp = $row['ndp'];
                    $sem_start = $row['sem_start'];
                    $email = $row['email'];
                    $bengkel_id = $row['bengkel_id'];
                    echo $email;

                    $sem = getSemesterByNumber($sem_start);

                    $pdf = new exFPDF();
                    // add a page
                    $pdf->SetFont('arial', '', 12);

                    $pdf->AddPage();
                    // set the source file
                    $pdf->setSourceFile("assets/pdf/jtp2.pdf");

                    // import page 1
                    $tplId = $pdf->importPage(1);
                    // use the imported page and place it at point 10,10 with a width of 100 mm
                    $pdf->useTemplate($tplId, ['adjustPageSize' => true]);
                    $pdf->SetXY(67, 102.6);
                    $pdf->Write(0, $nama);

                    $pdf->SetXY(67, 107.6);
                    $pdf->Write(0, $kp);

                    $pdf->SetXY(67, 112.6);
                    $pdf->Write(0, $ndp);

                    $pdf->SetXY(67, 117.6);
                    $pdf->Write(0, $kursus);

                    $pdf->SetXY(67, 122.6);
                    $pdf->Write(0, $sem);

                    $pdf->AddPage();                // Create a new page in the output PDF
                    // // import page 1
                    $tplId = $pdf->importPage(2);
                    // use the imported page and place it at point 10,10 with a width of 100 mm
                    $pdf->useTemplate($tplId, ['adjustPageSize' => true]);



                    $pdf->SetXY(67, 44.2);
                    $pdf->Write(0, $nama);

                    $pdf->SetXY(67, 49.1);
                    $pdf->Write(0, $kp);

                    $pdf->SetXY(67, 54);
                    $pdf->Write(0, $ndp);

                    $pdf->SetXY(67, 58.9);
                    $pdf->Write(0, $kursus);

                    $pdf->SetXY(67, 63.8);
                    $pdf->Write(0, $sem);
                    $pdf->Ln(10);


                    $table = new easyTable($pdf, '%{10,25, 30, 25,10}', 'align:C; border:1 ;border-width:0.1;');
                    $table->easyCell('', 'border:0');
                    $table->easyCell('TARIKH', '  bgcolor:#d9d9d9; align:C;font-style:B;border-width:0.1;');
                    $table->easyCell('KURSUS', '  bgcolor:#d9d9d9;align:C;font-style:B;border-width:0.1;');
                    $table->easyCell('SLOT', '  bgcolor:#d9d9d9;align:C;font-style:B;border-width:0.1;');
                    $table->easyCell('', 'border:0');

                    $table->printRow();


                    $query = "SELECT  DATE_FORMAT(tarikh, '%d/%m/%Y') AS tarikh_f, COUNT(*) as count  
                  FROM `attendance_slot` 
                  WHERE user_id = '$id' 
                    AND tarikh BETWEEN '$start_date' AND '$end_date';";
                    $results = mysqli_query($db, $query);
                    $total = 0;
                    while ($attslot = mysqli_fetch_assoc($results)) {

                        $table->easyCell('', 'border:0');
                        $table->easyCell($attslot['tarikh_f'], 'align:C;border-width:0.1;');
                        $table->easyCell('-', 'align:C;border-width:0.1;');
                        $table->easyCell($attslot['count'], 'align:C;border-width:0.1; ');
                        $table->easyCell('', 'border:0');
                        $table->printRow();
                        $total = $total + $attslot['count'];
                    }




                    $table->easyCell('', 'border:0');
                    $table->easyCell(' JUMLAH SLOT', '   bgcolor:#d9d9d9; align:L;font-style:B;border:LTB;border-width:0.1;');
                    $table->easyCell(' ', ' bgcolor:#d9d9d9; border:BT;border-width:0.1;');
                    $table->easyCell('22', '  bgcolor:#d9d9d9;align:C;font-style:B;border-width:0.1;');
                    $table->easyCell('', 'border:0');
                    $table->printRow();

                    $table->endTable(5);




                    $pdf->Output('F', 'jtp2.pdf');
                    $filePath = __DIR__ . '/../jtp2.pdf';

                    $var = array(
                        // 'link' => $site_url . "kaunseling/temujanji/$event_id", // Example variable
                        'attachment' => $filePath,
                        'attachment_name' => 'jtp2.pdf',
                        'alasan' => "test", // Example variable
                    );
                    // echo "test2";
                    sendmail($email, "Aduan Disiplin Pelajar", 'jtp2.php', $var);

                    $query5 = "SELECT  * FROM user WHERE bengkel_id= '$bengkel_id' AND role = '4' ";
                    $results5 = mysqli_query($db, $query5);
                    while ($row = $results5->fetch_assoc()) {
                        sendmail($row['email'], "Aduan Disiplin Pelajar", 'jtp2.php', $var);

                    }
                    $query5 = "SELECT  * FROM user WHERE bengkel_id= '$bengkel_id' AND role = '2' ";
                    $results5 = mysqli_query($db, $query5);
                    while ($row = $results5->fetch_assoc()) {
                        sendmail($row['email'], "Aduan Disiplin Pelajar", 'jtp2.php', $var);

                    }
                    unlink('jtp2.pdf'); // Removes the file after sending the email
                }
            } else if ($attslot['count'] >= 10) {

                // $nama = strtoupper($_POST['nama']);
                // $sem = $_POST['sem'];
                // $kursus = strtoupper($_POST['kursus']);
                // $amaran = $_POST['amaran'];


                $query2 = "SELECT a.id,a.nama,a.kp,a.ndp,c.nama as kursus ,d.nama as sem_start, a.email  FROM user a 
              INNER JOIN user_enroll b ON b.user_id = a.id
              INNER JOIN course c ON c.id = b.course_id
              INNER JOIN sem d ON d.id = b.sem_start
              WHERE a.id = '$id'";
                $results2 = mysqli_query($db, $query2);
                while ($row = $results2->fetch_assoc()) {

                    $id2 = $row['id'];
                    $nama = $row['nama'];
                    $kp = $row['kp'];
                    $kursus = $row['kursus'];
                    $ndp = $row['ndp'];
                    $sem_start = $row['sem_start'];
                    $email = $row['email'];
                    $sem = getSemesterByNumber($sem_start);

                    $pdf = new Fpdi();
                    // add a page
                    $pdf->SetFont('arial', '', 12);

                    $pdf->AddPage();
                    // set the source file

                    $pdf->setSourceFile("assets/pdf/sp2b.pdf");


                    // import page 1
                    $tplId = $pdf->importPage(1);
                    // use the imported page and place it at point 10,10 with a width of 100 mm
                    $pdf->useTemplate($tplId, ['adjustPageSize' => true]);
                    $pdf->SetXY(64, 61.6);

                    $pdf->Write(0, $nama);
                    $pdf->SetXY(102, 66.5);
                    $pdf->Write(0, $sem . ' ' . $kursus);

                    $pdf->SetFont('arial', 'B', 12);

                    $pdf->SetXY(70, 141.9);
                    $query = "SELECT  DATE_FORMAT(tarikh, '%d/%m/%Y') AS tarikh_f, COUNT(*) as count  
          FROM `attendance_slot` 
          WHERE user_id = '$id' 
            AND tarikh BETWEEN '$start_date' AND '$end_date';";
                    $results = mysqli_query($db, $query);
                    $text = '( ';
                    $textArray = []; // Initialize an array to store the parts
                    while ($attslot = mysqli_fetch_assoc($results)) {


                        // $text .= $attslot['tarikh_f'] . " - " . $attslot['count'] . " ,";
                        $textArray[] = $attslot['tarikh_f'] . " - " . $attslot['count']; // Add each part to the array

                    }
                    $text .= implode(', ', $textArray); // Join with a comma and a space

                    $text .= ' )';

                    // Use MultiCell for wrapping text
                    $width = 100; // Width of the cell
                    $lineHeight = 5.9; // Height of each line
                    $pdf->MultiCell($width, $lineHeight, $text, 0, 'L');

                    $pdf->Output('F', 'amaran2.pdf');


                    $filePath = __DIR__ . '/../amaran2.pdf';

                    $var = array(
                        // 'link' => $site_url . "kaunseling/temujanji/$event_id", // Example variable
                        'attachment' => $filePath,
                        'attachment_name' => 'amaran2.pdf',
                        'alasan' => "test", // Example variable
                    );

                    sendmail($email, "SURAT PERINGATAN TIDAK HADIR LATIHAN", 'amaran2.php', $var);

                    
                    $query5 = "SELECT  * FROM user WHERE bengkel_id= '$bengkel_id' AND role = '4' ";
                    $results5 = mysqli_query($db, $query5);
                    while ($row = $results5->fetch_assoc()) {
                        sendmail($email, "SURAT PERINGATAN TIDAK HADIR LATIHAN", 'amaran2.php', $var);

                    }
                    $query5 = "SELECT  * FROM user WHERE bengkel_id= '$bengkel_id' AND role = '2' ";
                    $results5 = mysqli_query($db, $query5);
                    while ($row = $results5->fetch_assoc()) {
                        sendmail($email, "SURAT PERINGATAN TIDAK HADIR LATIHAN", 'amaran2.php', $var);

                    }
                    unlink('amaran2.pdf'); // Removes the file after sending the email

                }
            } else if ($attslot['count'] >= 5) {

                // $nama = strtoupper($_POST['nama']);
                // $sem = $_POST['sem'];
                // $kursus = strtoupper($_POST['kursus']);
                // $amaran = $_POST['amaran'];


                $query2 = "SELECT a.id,a.nama,a.kp,a.ndp,c.nama as kursus ,d.nama as sem_start, a.email  FROM user a 
              INNER JOIN user_enroll b ON b.user_id = a.id
              INNER JOIN course c ON c.id = b.course_id
              INNER JOIN sem d ON d.id = b.sem_start
              WHERE a.id = '$id'";
                $results2 = mysqli_query($db, $query2);
                while ($row = $results2->fetch_assoc()) {

                    $id2 = $row['id'];
                    $nama = $row['nama'];
                    $kp = $row['kp'];
                    $kursus = $row['kursus'];
                    $ndp = $row['ndp'];
                    $sem_start = $row['sem_start'];
                    $email = $row['email'];
                    $sem = getSemesterByNumber($sem_start);

                    $pdf = new Fpdi();
                    // add a page
                    $pdf->SetFont('arial', '', 12);

                    $pdf->AddPage();
                    // set the source file

                    $pdf->setSourceFile("assets/pdf/sp1b.pdf");


                    // import page 1
                    $tplId = $pdf->importPage(1);
                    // use the imported page and place it at point 10,10 with a width of 100 mm
                    $pdf->useTemplate($tplId, ['adjustPageSize' => true]);
                    $pdf->SetXY(64, 61.6);

                    $pdf->Write(0, $nama);
                    $pdf->SetXY(102, 66.5);
                    $pdf->Write(0, $sem . ' ' . $kursus);

                    $pdf->SetFont('arial', 'B', 12);

                    $pdf->SetXY(70, 126.9);
                    $query = "SELECT  DATE_FORMAT(tarikh, '%d/%m/%Y') AS tarikh_f, COUNT(*) as count  
          FROM `attendance_slot` 
          WHERE user_id = '$id' 
            AND tarikh BETWEEN '$start_date' AND '$end_date';";
                    $results = mysqli_query($db, $query);
                    $text = '( ';
                    $textArray = []; // Initialize an array to store the parts
                    while ($attslot = mysqli_fetch_assoc($results)) {


                        // $text .= $attslot['tarikh_f'] . " - " . $attslot['count'] . " ,";
                        $textArray[] = $attslot['tarikh_f'] . " - " . $attslot['count']; // Add each part to the array

                    }
                    $text .= implode(', ', $textArray); // Join with a comma and a space

                    $text .= ' )';
                    // Use MultiCell for wrapping text
                    $width = 100; // Width of the cell
                    $lineHeight = 5.9; // Height of each line
                    $pdf->MultiCell($width, $lineHeight, $text, 0, 'L');

                    $pdf->Output('F', 'amaran1.pdf');


                    $filePath = __DIR__ . '/../amaran1.pdf';

                    $var = array(
                        // 'link' => $site_url . "kaunseling/temujanji/$event_id", // Example variable
                        'attachment' => $filePath,
                        'attachment_name' => 'amaran1.pdf',
                        'alasan' => "test", // Example variable
                    );
                    sendmail($email, "SURAT PERINGATAN TIDAK HADIR LATIHAN", 'amaran1.php', $var);

                    $query5 = "SELECT  * FROM user WHERE bengkel_id= '$bengkel_id' AND role = '4' ";
                    $results5 = mysqli_query($db, $query5);
                    while ($row = $results5->fetch_assoc()) {
                        sendmail($email, "SURAT PERINGATAN TIDAK HADIR LATIHAN", 'amaran1.php', $var);

                    }
                    $query5 = "SELECT  * FROM user WHERE bengkel_id= '$bengkel_id' AND role = '2' ";
                    $results5 = mysqli_query($db, $query5);
                    while ($row = $results5->fetch_assoc()) {
                        sendmail($email, "SURAT PERINGATAN TIDAK HADIR LATIHAN", 'amaran1.php', $var);

                    }
                    unlink('amaran1.pdf'); // Removes the file after sending the email

                }
            } else {

            }

        }

    }
}