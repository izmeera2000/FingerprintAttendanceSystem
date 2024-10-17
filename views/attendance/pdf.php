<?php include(getcwd() . '/admin/server.php');



include(getcwd() . '/admin/vendor/setasign/fpdf/fpdf.php');
include(getcwd() . '/admin/vendor/setasign/fpdf/exfpdf.php');
include(getcwd() . '/admin/vendor/setasign/fpdf/easyTable.php');

class PDF extends exFPDF
{


}

$timeslot = 5;
$dayslot = 5;
$slottotal = $dayslot * $timeslot;

$pelajartotal = 27;

$widtharray = array();

array_push($widtharray, "10", "30", "40", "20");


for ($i = 0; $i < ($timeslot * $dayslot); $i++) {
    array_push($widtharray, "5");
}

array_push($widtharray, "20", "15", "20", "25");
$output = '{' . implode(', ', $widtharray) . ',' . '}';



// var_dump($output);

$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('arial', '', 12);


// $tableA = new easyTable($pdf, 2, 'width:100; align:L{LC};  border:1;font-size:12; font-style:B;');

// $tableA->easyCell("BULAN : DISEMBER", '');
// $tableA->easyCell("TAHUN : TAHUN", '');
// //  $tableA->easyCell("", 'colspan:10');
// $tableA->printRow(true);

// $tableA->endTable(10);

function tablebheader($tableB, $dayslot, $timeslot, $pdf)
{

    $tableB->rowStyle('font-style:B;border:0');

    $tableB->easyCell("BULAN : DISEMBER", 'colspan:2;');
    $tableB->easyCell("TAHUN : TAHUN", '');

    $tableB->printRow();
    $tableB->rowStyle('font-style:B');

    $tableB->easyCell("BIL", 'rowspan:3;width:10;align:C;valign:M');
    $tableB->easyCell("NAMA", 'rowspan:3;colspan:2;align:C;valign:M');
    $tableB->easyCell("Tarikh", ';align:C;valign:M');
    $tableB->easyCell("Tarikh1", 'colspan:5;align:C;valign:M');
    $tableB->easyCell("Tarikh2", 'colspan:5;align:C;valign:M');
    $tableB->easyCell("Tarikh3", 'colspan:5;align:C;valign:M');
    $tableB->easyCell("Tarikh4", 'colspan:5;align:C;valign:M');
    $tableB->easyCell("Tarikh5", 'colspan:5;align:C;valign:M');
    $tableB->easyCell("JUMLAH SLOT", 'rowspan:3');
    $tableB->easyCell("SLOT TIDAK HADIR", 'rowspan:3');
    $tableB->easyCell("PERATUS KEHADIR-AN", 'rowspan:3');
    $tableB->easyCell("*CATATAN", 'rowspan:3;align:C;valign:M');

    $tableB->printRow();


    $tableB->rowStyle('font-style:B;');

    $tableB->easyCell("NDP", 'rowspan:2;align:C;valign:M');
    $tableB->easyCell("SLOT", 'colspan:5;align:C;valign:M');
    $tableB->easyCell("SLOT", 'colspan:5;align:C;valign:M');
    $tableB->easyCell("SLOT", 'colspan:5;align:C;valign:M');
    $tableB->easyCell("SLOT", 'colspan:5;align:C;valign:M');
    $tableB->easyCell("SLOT", 'colspan:5;align:C;valign:M');


    $tableB->printRow();
    $tableB->rowStyle('font-style:B;');

    for ($a = 0; $a < ($dayslot); $a++) {

        for ($i = 0; $i < ($timeslot); $i++) {

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

        for ($i = 0; $i < ($timeslot); $i++) {

            $tableB->easyCell("/", ';align:C;valign:M');
        }
    }
    $tableB->easyCell("Kiraan Peratus Kehadiran (%)\n(A-B)/A x 100%", 'rowspan:2;colspan:4 ;align:C;valign:M');

    $tableB->printRow();

    $tableB->easyCell("Disemak oleh:", ';align:C;valign:M');
    $tableB->easyCell("asdasdada", 'colspan:' . $slottotal);

    $tableB->printRow();

    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(150, 10, "*Catatan : TG - Tangguh ; BH - Berhenti ; DBH - Diberhentikan", 0, 0, 'L', false); // Width 0 for full width, height 10, border 1, left aligned
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(0, 10, "Helaian " . $pdf->PageNo() . ' Daripada {nb}', 0, 0, 'R', false); // Width 0 for full width, height 10, border 1, left aligned
    $pdf->SetFont('arial', '', 10);


}

$tableB = new easyTable($pdf, $output, ' align:L{LC};font-size:10;  border:1');


tablebheader($tableB, $dayslot, $timeslot, $pdf);

$ystart = 34;




for ($d = 0; $d < $pelajartotal; $d++) {

    


    $asd = $d + 1;
    if ($pdf->GetY() > 140) {
        $pdf->AddPage();
        tablebheader($tableB, $dayslot, $timeslot, $pdf);
    }

    $tableB->easyCell("1", ';align:C;valign:M');
    $tableB->easyCell("test jaz 12312312 "  , ';colspan:2;align:L;valign:M;');
    $tableB->easyCell("29218160", ';align:C;valign:M');
    for ($a = 0; $a < ($dayslot); $a++) {

        for ($i = 0; $i < ($timeslot); $i++) {

            $tableB->easyCell("/", ';align:C;valign:M');
        }
    }
    // if ($pdf->GetY() > 150) {

    $tableB->easyCell("25", 'rowspan:' . 1 . ';align:C;valign:M');
    // }

    $tableB->easyCell("0", ';align:C;valign:M');
    $tableB->easyCell("0", ';align:C;valign:M');
    $tableB->easyCell("Catatan", ';align:C;valign:M');

    $tableB->printRow();

    if ($pdf->GetY() > 140 || ($pelajartotal == $d + 1)) {
        tablebfooter($tableB, $dayslot, $timeslot, $slottotal, $pdf);


    }


}





$tableB->endTable(10);



//-----------------------------------------

$pdf->Output();
?>