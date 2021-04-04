<?php
require('header_connect_session.php');

$subject = 'Campus Edit';
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
    $campuse = $statement->fetch();
    //var_dump($campuse);

    $query = "SELECT * FROM campus_zone ORDER BY Id ASC";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $campus_zones = $statement->fetchAll();
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

        <h1 class="rrc_header_h1"><?= $subject ?></h1>

        <form action="campus_post.php" method="post" id="id_cc">
            <fieldset>
                <legend>Edit Campus</legend>
                <p>
                    <label for="cps_campus_zone">Campus Zone</label>
                    <select name="cps_campus_zone">
                        <?php foreach ($campus_zones as $campus_zone) : ?>
                            <option value="<?= $campus_zone['Id'] ?>" <?php if ($campus_zone['Id'] == $campuse['CampusZoneId']) : ?>selected<?php endif ?>><?= $campus_zone['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </p>
                <p>
                    <label for="cps_name">Campus Name</label>
                    <input name="cps_name" value="<?= $campuse['Name'] ?>" />
                </p>
                <p>
                    <label for="cps_add">Address</label>
                    <input name="cps_add" value="<?= $campuse['Address'] ?>" />
                </p>
                <p>
                    <label for="cps_pcode">Post Code</label>
                    <input name="cps_pcode" value="<?= $campuse['ZipCode'] ?>" />
                </p>
                <p>
                    <label for="cps_tel">Tel</label>
                    <input name="cps_tel" value="<?= $campuse['Tel'] ?>" />
                </p>
                <p id="hidden_input">
                    <input name="cps_id" value="<?= $cps_id ?>" />
                </p>

                <p class="adm">
                    <button type="submit" name="command_type" value="Update">Update</button>
                </p>
            </fieldset>
        </form>
        <div class=" footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>