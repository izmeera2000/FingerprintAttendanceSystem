<?php include(getcwd() . '/admin/server.php');





include(getcwd() . '/admin/vendor/setasign/fpdf/fpdf.php');
include(getcwd() . '/admin/vendor/setasign/fpdf/exfpdf.php');
include(getcwd() . '/admin/vendor/setasign/fpdf/easyTable.php');

class PDF extends exFPDF
{


}

$students_attendance = [];

$query =

    "SELECT a.*, b.masa_mula, b.masa_tamat, c.nama, c.role, c.ndp
    FROM attendance_slot a
    INNER JOIN time_slot b ON a.slot = b.slot
    INNER JOIN user c ON c.id = a.user_id
    WHERE c.role = 4
    AND a.slot NOT IN ('rehat1', 'rehat2')
    AND a.tarikh BETWEEN '2024-10-21' AND '2024-10-25'
    ORDER BY a.slot ASC
";

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

function getDatesFromRange($start, $end)
{
    $dates = [];
    $currentDate = new DateTime($start);
    $endDate = new DateTime($end);

    while ($currentDate <= $endDate) {
        $dates[] = $currentDate->format('Y-m-d'); // Format the date as 'YYYY-MM-DD'
        $currentDate->modify('+1 day'); // Move to the next day
    }

    return $dates;
}

$startDate = "2024-10-21";
$endDate = "2024-10-25";

$dates = getDatesFromRange($startDate, $endDate);



$query =
    "SELECT COUNT(*) as total FROM user WHERE role = 4";
$results = mysqli_query($db, $query);

while ($row = $results->fetch_assoc()) {
    $pelajartotal = $row['total'];
}


// $timeslot = 5;
$timeslot = ["1", "2", "3", "4", "5"];

$dayslot = count($dates);
$slottotal = $dayslot * count($timeslot);

// $pelajartotal = 27;

$widtharray = array();

array_push($widtharray, "10", "30", "40", "20");


for ($i = 0; $i < (count($timeslot) * $dayslot); $i++) {
    array_push($widtharray, "5");
}

array_push($widtharray, "20", "15", "20", "25");
$output = '{' . implode(', ', $widtharray) . ',' . '}';



// var_dump($output);

$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('arial', '', 10);


// $tableA = new easyTable($pdf, 2, 'width:100; align:L{LC};  border:1;font-size:12; font-style:B;');

// $tableA->easyCell("BULAN : DISEMBER", '');
// $tableA->easyCell("TAHUN : TAHUN", '');
// //  $tableA->easyCell("", 'colspan:10');
// $tableA->printRow(true);

// $tableA->endTable(10);

function tablebheader($tableB, $dayslot, $timeslot, $dates, $pdf)
{

    $tableB->rowStyle('font-style:B;border:0');

    $tableB->easyCell("BULAN : DISEMBER", 'colspan:2;');
    $tableB->easyCell("TAHUN : TAHUN", '');

    $tableB->printRow();
    $tableB->rowStyle('font-style:B');

    $tableB->easyCell("BIL", 'rowspan:3;width:10;align:C;valign:M');
    $tableB->easyCell("NAMA", 'rowspan:3;colspan:2;align:C;valign:M');
    $tableB->easyCell("Tarikh", ';align:C;valign:M');
    foreach ($dates as $date) {
        $tableB->easyCell($date, 'colspan:5;align:C;valign:M');


    }
    // $tableB->easyCell("Tarikh1", 'colspan:5;align:C;valign:M');
    // $tableB->easyCell("Tarikh2", 'colspan:5;align:C;valign:M');
    // $tableB->easyCell("Tarikh3", 'colspan:5;align:C;valign:M');
    // $tableB->easyCell("Tarikh4", 'colspan:5;align:C;valign:M');
    // $tableB->easyCell("Tarikh5", 'colspan:5;align:C;valign:M');
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

function tablebfooter($tableB, $dayslot, $timeslot, $slottotal, $pdf)
{
    $tableB->easyCell("", 'rowspan:2');
    $tableB->easyCell("Tanda-tanda yang digunakan dalam Senarai Kehadiran adalah seperti berikut:\n/ - Hadir\n0 - Tidak Hadir\nK - Cuti Dengan Kebenaran/Lain-lain aktiviti", 'rowspan:2;colspan:2');
    $tableB->easyCell("Disahkan oleh:", ';align:C;valign:M');
    for ($a = 0; $a < ($dayslot); $a++) {

        for ($i = 0; $i < (count($timeslot)); $i++) {

            $tableB->easyCell(" ", ';align:C;valign:M');
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

$tableB = new easyTable($pdf, $output, ' align:L{LC};font-size:10;  border:1');


tablebheader($tableB, $dayslot, $timeslot, $dates, $pdf);

$ystart = 34;

$d = 0;


// for ($d = 0; $d < $pelajartotal; $d++) {


// $pelajartotal = $row['total_count'];
foreach ($students_attendance as $student_id => $data) {



    $asd = $d + 1;
    if ($pdf->GetY() > 140) {
        $pdf->AddPage();
        tablebheader($tableB, $dayslot, $timeslot, $dates, $pdf);
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
                    if ($att['slot'] == $slot) {
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
        tablebfooter($tableB, $dayslot, $timeslot, $slottotal, $pdf);


    }
    $d = $d + 1;

}



// }



$tableB->endTable(10);



//-----------------------------------------

$pdf->Output('I');



?>