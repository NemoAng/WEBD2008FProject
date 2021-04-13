<?php
require('header_connect_session.php');

$subject = 'Campus View';
//UPDATE `campus` SET `Address` = '222' WHERE `campus`.`Id` = 47;
if ($_GET) {
    $cps_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT cps.*, 
    cpsz.Name AS CpszName
    FROM campus cps
    JOIN campus_zone cpsz ON cps.CampusZoneId = cpsz.Id
    WHERE cps.Id = $cps_id";

    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $campus = $statement->fetch();

    $cps_zone_id = $campus['CampusZoneId'];
    //var_dump($campuse);

    $query = "SELECT * FROM campus_zone
    WHERE Id = $cps_zone_id";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $campus_zone = $statement->fetch();
}
$year = date("Y");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $subject ?></title>
    <link rel="stylesheet" href="style_main.css" type="text/css">
    <link rel="icon" href="./graphing_red.png" sizes="16x16 32x32" type="image/x-icon" />
</head>

<body>
    <div id="wrapper">
        <?php
        require('login_header.php');
        ?>

        <div id="campus_img">
            <img src="./images-upload/<?= $campus['Images'] ?>">

            <h3>Campus Name:</h3>
            <h4><?= $campus['Name'] ?></h4>
            <h3>Address:</h3>
            <h4><?= $campus['Address'] ?></h4>
            <h3>Post Code:</h3>
            <h4><?= $campus['ZipCode'] ?></h4>
            <h3>Tel:</h3>
            <h4><?= $campus['Tel'] ?></h4>
            <h3>Campus Zone:</h3>
            <h4><?= $campus_zone['Name'] ?></h4>
        </div>



        <div class=" footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>