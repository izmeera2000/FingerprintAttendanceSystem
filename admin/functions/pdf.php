<?php
if (isset($_POST['get_pdf'])) {


 

    include(getcwd() . '/admin/vendor/setasign/fpdf/fpdf.php');
    include(getcwd() . '/admin/vendor/setasign/fpdf/exfpdf.php');
    include(getcwd() . '/admin/vendor/setasign/fpdf/easyTable.php');



    $week = $_POST['week'];
    $year = $_POST['year'];
    $month = $_POST['month'];
    $sem_start = $_POST['sem'];
    $kursus = $_POST['kursus'];
    // $startDate = "2024-10-29";
// $endDate = "2024-11-05";

    $weekRange = getWeekRangeOfMonth($month, $year, $week);
    // debug_to_console($startDate);

    $startDate = $weekRange['start_date'];
    $endDate = $weekRange['end_date'];


    $start_datea = new DateTime($weekRange['start_date']);
    $start_date2a = $start_datea->format('Y-m-d');
    $end_datea = new DateTime($weekRange['end_date']);
    $end_date2a = $end_datea->format('Y-m-d');

    $date_diff = $start_datea->diff($end_datea)->days;



    $query = "SELECT
                a.*,
                d.slot,
                b.nama AS course,
                c.subjek_nama,
                c.subjek_kod,
                d.masa_mula,
                d.masa_tamat,
                d.masa_mula2,
                d.masa_tamat2,
                e.nama AS sem2,
                e.start_date,
                e.end_date,
                att.user_id,
                att.verify,
                a.assign_to,
                usa.assign_to as assign2,
                usa.tarikh_mula as assign2_m,
                usa.tarikh_tamat as assign2_t,
                CASE WHEN COUNT(
                    CASE WHEN att.verify = 1 THEN 1
                END
            ) = COUNT(att.user_id) THEN 'All' ELSE 'Not_All'
            END AS verification_status
            FROM
                user_subjek a
            INNER JOIN course b ON
                b.id = a.course_id
            INNER JOIN subjek c ON
                c.id = a.subjek_id
            INNER JOIN time_slot d ON
                d.id = a.slot_id
            INNER JOIN sem e ON
                e.id = a.sem_id
            INNER JOIN user_staff st ON
                st.user_id = a.assign_to
            LEFT JOIN attendance_slot att ON
                att.slot = d.slot
            LEFT JOIN user_staff_absence usa ON usa.user_id = st.user_id
            WHERE b.id = '$kursus' AND e.nama = '$sem_start'
            GROUP BY
                d.slot,
                a.day;";
    $results = mysqli_query($db, $query);
    $events = array();


    while ($row = $results->fetch_assoc()) {
        $start_time = new DateTime($row['masa_mula']);  // Start time of the slot
        $end_time = new DateTime($row['masa_tamat']);  // End time of the slot

        // Get the day for recurrence (adjusting 1=Sunday, 2=Monday, ...)
        $day_of_week = (int) $row['day'];  // Assuming `day` column uses 1=Sunday, 2=Monday, ...
        $day_of_week_php = $day_of_week - 1; // Convert to PHP's day numbering (0=Sunday)

        // Generate events for the specified day until the end_date
        $current_date = clone $start_datea;
        // Find the first occurrence of the specified day on or after the start_date
        if ((int) $current_date->format('w') !== $day_of_week_php) {
            $current_date->modify('next ' . jddayofweek($day_of_week_php, 1));
        }



        // Compare the event's start date with the absence period


        while ($current_date <= $end_datea) {
            $start_datetime = clone $current_date;
            $start_datetime->setTime((int) $start_time->format('H'), (int) $start_time->format('i'));

            $end_datetime = clone $current_date;
            $end_datetime->setTime((int) $end_time->format('H'), (int) $end_time->format('i'));

            $assign = $row['assign_to'];
            if (isset($row['assign2'])) {
                $assign2_m = new DateTime($row['assign2_m']); // Assign start date
                $assign2_t = new DateTime($row['assign2_t']); // Assign end date

                if ($start_datetime >= $assign2_m && $start_datetime <= $assign2_t) {
                    // Event start date is within the absence period, do something (e.g., exclude or mark)
                    // You can add this to your $events array or handle it differently
                    // echo  " falls within the absence period.\n";
                    $assign = $row['assign2'];
                }
            }
            // Add event to the array
            $events[$start_datetime->format('Y-m-d')] = array(
                'id' => $row['id'],                 // Unique identifier for the event
                'resourceId' => $day_of_week,       // Day value (1=Sunday, 2=Monday, ...)
                'title' => $row['subjek_nama'],     // Event title (subject name)
                'slot' => $row['slot'],     // Event title (subject name)
                'verify' => $row['verification_status'],
                'assign' => $assign,
            );

            // Modify to the next week's occurrence only if the date range is > 7 days
            if ($date_diff > 7) {
                $current_date->modify('+1 week');
            } else {
                break;
            }
        }
    }


    // $query = "SELECT * FROM `user_staff_absence`";
    // $results = mysqli_query($db, $query);
    // $events2 = array();


    // while ($row = $results->fetch_assoc()) {

    //     $events[$row['id']] = array(
    //         'id' => $row['id'],                 // Unique identifier for the event
    //         'resourceId' => $day_of_week,       // Day value (1=Sunday, 2=Monday, ...)
    //         'title' => $row['subjek_nama'],     // Event title (subject name)
    //         'slot' => $row['slot'],     // Event title (subject name)
    //         'verify' => $row['verification_status'],
    //         'sign' => $row['sign_path'],
    //         'assign' => $row['assign_to'],
    //     );
    // }

    class PDF extends exFPDF
    {


    }
    function getMonthName($date)
    {
        return date('F', strtotime($date));
    }

    $months = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Mac', 'April' => 'April', 'May' => 'Mei', 'June' => 'Jun', 'July' => 'Julai', 'August' => 'Ogos', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Disember'];

    $month1 = getMonthName($startDate);

    $month1 = $months[$month1];
    $month2 = getMonthName($endDate);
    $month2 = $months[$month2];





    $students_attendance = [];

    $query =

        "SELECT a.*, b.masa_mula, b.masa_tamat, c.nama, c.role, c.ndp , d.course_id   , e.nama AS  sem_start
  FROM attendance_slot a
  INNER JOIN time_slot b ON a.slot = b.slot
  INNER JOIN user c ON c.id = a.user_id
  INNER JOIN user_enroll d ON c.id = d.user_id
  INNER JOIN sem e ON e.id = d.sem_start
  WHERE c.role = 4
  AND (a.slot NOT IN ('rehat1', 'rehat2'))
  AND (a.tarikh BETWEEN '$startDate' AND '$endDate')
  AND e.nama = '$sem_start'
  AND course_id = '$kursus'
  ORDER BY a.slot ASC";


    $results2 = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($results2)) {
        $user_id = $row['user_id']; // Group by user_id

        // Store student's information
        $students_attendance[$user_id]['info'] = [
            'nama' => strtoupper($row['nama']),
            'ndp' => $row['ndp']
        ];

        // Append the attendance record grouped by date
        $students_attendance[$user_id]['attendance'][$row['tarikh']][] = [
            'slot' => $row['slot'],
            'slot_status' => $row['slot_status']
        ];
    }




    $dates = getDatesFromRange($startDate, $endDate);

    if ($dates) {



        $query =
            "SELECT COUNT(*) as total FROM `user_enroll` a
                INNER JOIN sem b ON b.id = a.sem_start
                WHERE   b.nama  = '$sem_start' AND course_id = '$kursus';";


        $results = mysqli_query($db, $query);

        while ($row = $results->fetch_assoc()) {
            $pelajartotal = $row['total'];
        }





        $timeslot = ["1", "2", "3", "4", "5"];

        $dayslot = count($dates);
        $slottotal = $dayslot * count($timeslot);


        $widtharray = array();

        array_push($widtharray, "10", "30", "40", "20");


        for ($i = 0; $i < (count($timeslot) * $dayslot); $i++) {
            array_push($widtharray, "5");
        }

        array_push($widtharray, "20", "15", "20", "25");
        $output = '{' . implode(', ', $widtharray) . ',' . '}';




        $pdf = new PDF('L');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('arial', '', 10);

        if ($month1 == $month2) {


            $month = strtoupper($month1);
        } else {

            $month = strtoupper($month1) . " & " . strtoupper($month2);
        }



        $tableB = new easyTable($pdf, $output, ' align:L{LC};font-size:10;  border:1');


        tablebheader($tableB, $dayslot, $timeslot, $dates, $month, $pdf);


        $d = 0;




        foreach ($students_attendance as $student_id => $data) {



            $asd = $d + 1;
            if ($pdf->GetY() == 10 || $pdf->GetY() > 90) {
                // Add a new page and table header
                if ($pdf->GetY() > 90) {
                    $pdf->AddPage();
                }
                tablebheader($tableB, $dayslot, $timeslot, $dates, $month, $pdf);
            }


            $tableB->easyCell($asd, ';align:C;valign:M');
            $tableB->easyCell($data['info']['nama'], ';colspan:2;align:L;valign:M;');
            $tableB->easyCell($data['info']['ndp'], ';align:C;valign:M');
            $slot_takhadir = 0;

            foreach ($dates as $date) {
                foreach ($timeslot as $slot) {
                    // $tableB->easyCell("yrst", ';align:C;valign:M');

                    $attendance = $data['attendance'][$date] ?? null; // Get attendance for the specific date
                    $slot_found = false;
                    if ($attendance) {
                        foreach ($attendance as $att) {
                            if ($att['slot'] == "slot" . $slot) {
                                // Check the slot status and add the correct symbol
                                switch ($att['slot_status']) {
                                    case 0:
                                    case 2:
                                    case 3:
                                    case 5:
                                        $tableB->easyCell("0", ';align:C;valign:M');
                                        $slot_takhadir++;
                                        break;
                                    case 4:
                                        $tableB->easyCell("K", ';align:C;valign:M');
                                        break;
                                    case 7:
                                        $tableB->easyCell(" ", ';align:C;valign:M');
                                        break;
                                    default:
                                        $tableB->easyCell("/", ';align:C;valign:M');
                                }
                                $slot_found = true;
                                break;
                            }
                        }
                    }
                    if (!$slot_found) {
                        $tableB->easyCell(" ", ';align:C;valign:M');
                        $slot_takhadir++;
                    }

                }


            }

            $tableB->easyCell($slottotal, 'rowspan:' . 1 . ';align:C;valign:M');
            $tableB->easyCell($slot_takhadir, ';align:C;valign:M');
            $tableB->easyCell((($slottotal - $slot_takhadir) / $slottotal) * 100 . "%", ';align:C;valign:M');
            $tableB->easyCell("Catatan", ';align:C;valign:M');
            $tableB->printRow();






            if ($pdf->GetY() > 140 || ($pelajartotal == $d + 1)) {
                tablebfooter($tableB, $dates, $timeslot, $slottotal, $events, $pdf);


            }
            $d = $d + 1;

        }






        $tableB->endTable(10);




        $pdf->Output('F', 'assets/pdf_gen/attendance.pdf');


        // header('location:' . $site_url . 'attendance/generate_pdf');


        // debug_to_console(var_dump($students_attendance));

    }
    // debug_to_console("test");
    echo $site_url. "assets/pdf_gen/attendance.pdf";    

}




function tablebheader($tableB, $dayslot, $timeslot, $dates, $month, $pdf)
{

    $tableB->rowStyle('font-style:B;border:0');



    $tableB->easyCell("BULAN : " . $month . '<s "font-color:#ffffff">test123</s>' . "    TAHUN : 2024", 'colspan:7;');


    // $tableB->easyCell("TAHUN : 2024", 'colspan:;');

    $tableB->printRow();
    $tableB->rowStyle('font-style:B');

    $tableB->easyCell("BIL", 'rowspan:3;width:10;align:C;valign:M');
    $tableB->easyCell("NAMA", 'rowspan:3;colspan:2;align:C;valign:M');
    $tableB->easyCell("Tarikh", ';align:C;valign:M');
    foreach ($dates as $date) {
        $tableB->easyCell("$date", 'colspan:5;align:C;valign:M');


    }

    $tableB->easyCell("JUMLAH SLOT", 'rowspan:3');
    $tableB->easyCell("SLOT TIDAK HADIR", 'rowspan:3');
    $tableB->easyCell("PERATUS KEHADIR-AN", 'rowspan:3');
    $tableB->easyCell("*CATATAN", 'rowspan:3;align:C;valign:M');

    $tableB->printRow();


    $tableB->rowStyle('font-style:B;');

    $tableB->easyCell("NDP", 'rowspan:2;align:C;valign:M');

    foreach ($dates as $date) {
        $tableB->easyCell("SLOT", 'colspan:5;align:C;valign:M');

    }
    $tableB->printRow();

    $tableB->rowStyle('font-style:B;');
    for ($a = 0; $a < ($dayslot); $a++) {
        for ($i = 0; $i < (count($timeslot)); $i++) {
            $tableB->easyCell($i + 1);
        }

    }

    $tableB->printRow();
}

function tablebfooter($tableB, $days, $timeslot, $slottotal, $events, $pdf)
{
    $tableB->easyCell("", 'rowspan:2');
    $tableB->easyCell("Tanda-tanda yang digunakan dalam Senarai Kehadiran adalah seperti berikut:\n/ - Hadir\n0 - Tidak Hadir\nK - Cuti Dengan Kebenaran/Lain-lain aktiviti", 'rowspan:2;colspan:2');
    $tableB->easyCell("Disahkan oleh:", ';align:C;valign:M');

    foreach ($days as $day) {


        foreach ($timeslot as $slot) {
            $slot2 = "slot" . $slot;
            if (isset($events[$day]['slot'])) {

                if (($events[$day]['slot'] == $slot2) && ($events[$day]['verify'] == 'All')) {
                    // $signpath = $events[$dayofdate]['sign'];
                    $id = $events[$day]['assign'];
                    $tableB->easyCell(
                        " ",
                        ";align:C;valign:M;img:assets/images/sign/$id/$id.png;paddingX:0.5;paddingY:0.5"
                    );

                } else {
                    $tableB->easyCell("", ';align:C;valign:M;paddingX:0.5;paddingY:0.5');

                }

                // If the slot and day match, add the image to the table cell
            } else {
                // $new = $events[$dayofdate][$slot2];
                $tableB->easyCell("", ';align:C;valign:M;paddingX:0.5;paddingY:0.5');
            }
        }
    }
    $tableB->easyCell("Kiraan Peratus Kehadiran (%)\n(A-B)/A x 100%", 'rowspan:2;colspan:4 ;align:C;valign:M');

    $tableB->printRow();

    $tableB->easyCell("Disemak oleh:", ';align:C;valign:M');
    $tableB->easyCell(" ", 'colspan:' . $slottotal);

    $tableB->printRow();

    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(150, 10, "*Catatan : TG - Tangguh ; BH - Berhenti ; DBH - Diberhentikan", 0, 0, 'L', false); // Width 0 for full width, height 10, border 1, left aligned
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(0, 10, "Helaian " . $pdf->PageNo() . ' Daripada {nb}', 0, 0, 'R', false); // Width 0 for full width, height 10, border 1, left aligned
    $pdf->SetFont('arial', '', 10);


}