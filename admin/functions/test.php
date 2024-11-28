<?php


if (isset($_POST['eventmasuk'])) {

    $user_id = $_SESSION['user_details']['id'];
  
    $date_now = date("Y-m-d H:i:s", strtotime("now"));
  
    $query = "INSERT INTO attendance (user_id, event_status, masa_mula) VALUES ('7','1','$date_now');";
    $results = mysqli_query($db, $query);
  
    // $query = "INSERT INTO attendance_slot  (user_id, slot,slot_status,tarikh) VALUES ('7','1','1','$date_now');";
    // $results = mysqli_query($db, $query);
  
  
  }
  
  
  
  if (isset($_POST['eventkeluar'])) {
  
  
    $query = "SELECT * FROM attendance WHERE event_status = '1' AND user_id ='7' AND masa_tamat IS NULL";
    $results = mysqli_query($db, $query);
    while ($row = $results->fetch_assoc()) {
      $id = $row['id'];
  
    }
  
    $now = date("Y-m-d H:i:s", strtotime("now"));
    $masa_tamat = date("Y-m-d H:i:s", strtotime("today 18:00"));
  
    $query = "UPDATE attendance SET masa_tamat='$now' WHERE id='$id'";
    $results = mysqli_query($db, $query);
  
  
    if (($masa_tamat > $now)) {
      $query = "INSERT INTO attendance (user_id, event_status, masa_mula)
      VALUES ('7','1','$now');";
      $results = mysqli_query($db, $query);
  
  
    }
  
  }
  
  

  
if (isset($_POST['get_pdf'])) {





    include(getcwd() . '/admin/vendor/setasign/fpdf/fpdf.php');
    include(getcwd() . '/admin/vendor/setasign/fpdf/exfpdf.php');
    include(getcwd() . '/admin/vendor/setasign/fpdf/easyTable.php');
  
  
  
    $week = $_POST['week'];
    $year = $_POST['year'];
    $month = $_POST['month'];
    $sem = $_POST['sem'];
    $kursus = $_POST['kursus'];
    // $startDate = "2024-10-29";
    // $endDate = "2024-11-05";
  
    $weekRange = getWeekRangeOfMonth($month, $year, $week);
    // debug_to_console($startDate);
  
    $startDate = $weekRange['start_date'];
    $endDate = $weekRange['end_date'];
  
  
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
  
      "SELECT a.*, b.masa_mula, b.masa_tamat, c.nama, c.role, c.ndp
      FROM attendance_slot a
      INNER JOIN time_slot b ON a.slot = b.slot
      INNER JOIN user c ON c.id = a.user_id
      WHERE c.role = 4
      AND a.slot NOT IN ('rehat1', 'rehat2')
      AND a.tarikh BETWEEN '$startDate' AND '$endDate'
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
        "SELECT COUNT(*) as total FROM user WHERE role = 4";
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
  
  
      tablebheader($tableB, $dayslot, $timeslot, $dates, $month, $pdf);
  
      $ystart = 34;
  
      $d = 0;
  
  
  
  
      foreach ($students_attendance as $student_id => $data) {
  
  
  
        $asd = $d + 1;
        if ($pdf->GetY() > 120) {
          $pdf->AddPage();
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
  
  
  
  
  
  
        if ($pdf->GetY() > 120 || ($pelajartotal == $d + 1)) {
          tablebfooter($tableB, $dayslot, $timeslot, $slottotal, $pdf);
  
  
        }
        $d = $d + 1;
  
      }
  
  
  
  
  
  
      $tableB->endTable(10);
  
  
  
  
      $pdf->Output('F', 'test.pdf');
  
      // debug_to_console(var_dump($students_attendance));
  
    }
    // debug_to_console("test");
  }
  
  
  
  if (isset($_POST['get_pdf2'])) {
  
    $nama = strtoupper($_POST['nama']);
    $sem = $_POST['sem'];
    $kursus = strtoupper($_POST['kursus']);
    $amaran = $_POST['amaran'];
  
  
  
  
    $pdf = new Fpdi();
    // add a page
    $pdf->SetFont('arial', '', 12);
  
    $pdf->AddPage();
    // set the source file
    if ($amaran == 1) {
  
      $pdf->setSourceFile("assets/pdf/sp1b.pdf");
  
    } else {
      $pdf->setSourceFile("assets/pdf/sp2b.pdf");
  
    }
    // import page 1
    $tplId = $pdf->importPage(1);
    // use the imported page and place it at point 10,10 with a width of 100 mm
    $pdf->useTemplate($tplId, ['adjustPageSize' => true]);
    $pdf->SetXY(64, 61.6);
  
    $pdf->Write(0, $nama);
    $pdf->SetXY(102, 66.5);
    $pdf->Write(0, $sem . ' ' . $kursus);
  
    $pdf->SetFont('arial', 'B', 12);
    if ($amaran == 1) {
  
      $pdf->SetXY(70, 126.9);
      $text = '( 10/9/24 - 1 slot, 27/9/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot )';
    } else {
      $pdf->SetXY(70, 141.9);
      $text = '( 10/9/24 - 1 slot, 27/9/24 - 1 slot,   3/10/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot )';
    }
    // Use MultiCell for wrapping text
    $width = 100; // Width of the cell
    $lineHeight = 5.9; // Height of each line
    $pdf->MultiCell($width, $lineHeight, $text, 0, 'L');
  
    $pdf->Output('F', 'test2.pdf');
  
    // debug_to_console("test");
  }
  
  
  
  if (isset($_POST['get_pdf3'])) {
  
  
  
    include(getcwd() . '/admin/vendor/setasign/fpdf/exfpdf.php');
    include(getcwd() . '/admin/vendor/setasign/fpdf/easyTable.php');
    $id = $_POST['id'];
  
  
    $query = "SELECT * 
    FROM `sem` 
    WHERE start_date <= NOW() 
      AND end_date >= NOW(); ";
    $results = mysqli_query($db, $query);
  
    while ($row = mysqli_fetch_assoc($results)) {
      $start_date = $row['start_date'];
      $end_date = $row['end_date'];
    }
  
  
  
  
  
  
  
    $query = "SELECT a.id,a.nama,a.kp,a.ndp,c.nama as kursus ,d.nama as sem_start  FROM user a 
              INNER JOIN user_enroll b ON b.user_id = a.id
              INNER JOIN course c ON c.id = b.course_id
              INNER JOIN sem d ON d.id = b.sem_start
              WHERE a.id = '$id'";
    $results = mysqli_query($db, $query);
    while ($row = $results->fetch_assoc()) {
      $nama = $row['nama'];
      $kp = $row['kp'];
      $kursus = $row['kursus'];
      $ndp = $row['ndp'];
      $sem_start = $row['sem_start'];
  
    }
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
  
  
    // $pdf->SetXY(102, 66.5);
    // $pdf->Write(0, $sem . ' ' . $kursus);
  
    // $pdf->SetFont('arial', 'B', 12);
    // if ($amaran == 1) {
  
    //   $pdf->SetXY(70, 126.9);
    //   $text = '( 10/9/24 - 1 slot, 27/9/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot )';
    // } else {
    //   $pdf->SetXY(70, 141.9);
    //   $text = '( 10/9/24 - 1 slot, 27/9/24 - 1 slot,   3/10/24 - 1 slot, 3/10/24 - 1 slot, 3/10/24 - 1 slot )';
    // }
    // // Use MultiCell for wrapping text
    // $width = 100; // Width of the cell
    // $lineHeight = 5.9; // Height of each line
    // $pdf->MultiCell($width, $lineHeight, $text, 0, 'L');
  
  
  
    $pdf->Output('F', 'test3.pdf');
  
    // debug_to_console("test");
  }
  