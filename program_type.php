<?php
require('header_connect_session.php');

if ($_POST) {
    session_destroy();
    header('Location: ./index.php');
}

$query = "SELECT * FROM program_time_type ORDER BY Id ASC";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute();
$programtypes = $statement->fetchAll();

//print_r($programtypes);
array_unshift($programtypes, ["Id" => -1, "Name" => "Choose Your Interest()..."]);

$year = date("Y");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Program Types - Index</title>
    <link rel="stylesheet" href="style_main.css" type="text/css">
    <link rel="icon" href="./graphing_red.png" sizes="16x16 32x32" type="image/x-icon" />
</head>

<body>
    <div id="wrapper">

        <?php
        require('login_header.php');
        ?>

        <div class="rrc_header_h1">
            <h1>Full-time Programs</h1>
        </div>
        <p>With certificates, diplomas, and degrees, RRC offers more than 100 full-time programs that deliver the hands-on experience you need to succeed.</p>
        <div id="id_cc">
            <h6>Find Your Program</h6>
            <select id="select_programtype">
                <?php foreach ($programtypes as $programtype) : ?>
                    <option value="<?= $programtype['Id'] ?>"><?= $programtype['Name'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>