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
  