<?php
require('header_connect_session.php');

$subject = 'Campus Zone Edit';
//UPDATE `campus` SET `Address` = '222' WHERE `campus`.`Id` = 47;
if ($_GET) {
    $cps_zone_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM campus_zone WHERE Id = $cps_zone_id";

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

        <h1 class="rrc_header_h1"><?= $subject ?></h1>

        <form action="campus_zone_post.php" method="post">
            <fieldset>
                <legend>Campus Zone Edit</legend>
                <p>
                    <label for="c_zone">Campus Zone Name</label>
                    <input name="c_zone" id="pcc_title" value="<?= $campus_zone['Name'] ?>" />
                </p>
                <p id="hidden_input">
                    <input name="cps_zone_id" value="<?= $cps_zone_id ?>" />
                </p>
                <p class="adm">
                    <input type="submit" name="command" value="Update" />
                </p>
            </fieldset>
        </form>
    </div>
</body>