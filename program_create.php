<?php
require('header_connect_session.php');

if ($_POST) {
    session_destroy();
    header('Location: ./index.php');
}

if ($user_logined == false) {
    header('Location: ./index.php');
}

$query = "SELECT * FROM campus ORDER BY Id ASC";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute();
$campuses = $statement->fetchAll();

$query = "SELECT * FROM campus_zone ORDER BY Id ASC";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute();
$campus_zones = $statement->fetchAll();

// $query = "SELECT * FROM Program_Time_Type ORDER BY Id ASC";
// $statement = $db->prepare($query); // Returns a PDOStatement object.
// $statement->execute();
// $programtypes = $statement->fetchAll();

$query = "SELECT * FROM program_category ORDER BY Id ASC";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute();
$campus_ctgries = $statement->fetchAll();

$title = "Program Create";
$year = date("Y");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="style_main.css" type="text/css">
    <link rel="icon" href="./graphing_red.png" sizes="16x16 32x32" type="image/x-icon" />
</head>

<body>
    <div id="wrapper">
        <?php
        require('login_header.php');
        ?>

        <h1 class="rrc_header_h1"><?= $title ?></h1>
        <div>
            <form action="program_post.php" method="post" id="id_cc">
                <fieldset>
                    <legend>New Program</legend>
                    <p>
                        <label for="cps_campus">Campus</label>
                        <select name="cps_campus">
                            <?php foreach ($campuses as $campus) : ?>
                                <option value="<?= $campus['Id'] ?>"><?= $campus['Name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </p>
                    <p>
                        <label for="cps_campus_zone">Campus Zone</label>
                        <select name="cps_campus_zone">
                            <?php foreach ($campus_zones as $campus_zone) : ?>
                                <option value="<?= $campus_zone['Id'] ?>"><?= $campus_zone['Name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </p>
                    <p>
                        <label for="cps_pategory">Program Category</label>
                        <select name="cps_pategory">
                            <?php foreach ($campus_ctgries as $campus_ctg) : ?>
                                <option value="<?= $campus_ctg['Id'] ?>"><?= $campus_ctg['Name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </p>
                    <p>
                        <label for="cps_program">Program</label>
                        <input name="cps_program" />
                    </p>
                    <p class="adm">
                        <button type="submit" name="command" value="Create">Create</button>
                    </p>
                </fieldset>
            </form>
        </div>
        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div>
    </div> <!-- END div id="wrapper" -->
</body>

</html>