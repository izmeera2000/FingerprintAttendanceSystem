<?php include(getcwd() . '/admin/server.php');
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
        <input type="text" id="fp_name" name="test" required><br><br>
        <!-- <label for="email">fp:</label>
        <input type="email" id="fp" name="fp" required><br><br> -->
        <input type="submit" value="Submit" name="check_slot_email">
    </form>
    <?php
 
//   $var = array(
    // 'link' => $site_url . "kaunseling/temujanji/$event_id", // Example variable
    // 'alasan' => $sebab // Example variable
//   );
//   echo "test2";
//   sendmail('saerahhassan603@gmail.com', "Aduan Disiplin Pelajar", 'jtp2.php', $var);
    ?>
</body>
</html>
