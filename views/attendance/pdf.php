<?php include(getcwd() . '/admin/server.php');
use chillerlan\QRCode\{QRCode, QRCodeException, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QRImagick;
use chillerlan\QRCode\Output\Image\PngImage;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Test Form</title>
</head>

<body>
    <h1>Test Form</h1>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" id="fp_name" name="get_pdf" required><br><br>

        <input type="text"  name="week" required><br><br>
        <input type="text"   name="month" required><br><br>
        <input type="text"   name="year" required><br><br>
        <input type="text"   name="sem" required><br><br>
        <input type="text"   name="kursus" required><br><br>

        <!-- <label for="email">fp:</label>
        <input type="email" id="fp" name="fp" required><br><br> -->
        <input type="submit" value="Submit" name="get_pdf">
    </form>

    <?php
   $data = "https://example.com";
   $logoPath = __DIR__ . '/../../assets/images/logo-w.png'; // Path to your logo image
   
   $base64QRCode = generateQRCodeWithLogo($data, $logoPath);
    ?>

    <img src="data:image/png;base64,<?php echo $base64QRCode; ?>" alt="QR Code" />

</body>

</html>