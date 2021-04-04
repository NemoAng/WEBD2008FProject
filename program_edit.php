<?php
require('header_connect_session.php');

$subject = 'Program Edit';
if ($_GET) {
    $program_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM programs WHERE Id = $program_id";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $program = $statement->fetch();


    $query = "SELECT * FROM campus ORDER BY Id ASC";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $campuses = $statement->fetchAll();

    $query = "SELECT * FROM campus_zone ORDER BY Id ASC";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $campus_zones = $statement->fetchAll();

    $query = "SELECT * FROM program_category ORDER BY Id ASC";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $program_category = $statement->fetchAll();
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

        <form action="program_post.php" method="post" id="id_cc">
            <fieldset>
                <legend>Program Edit</legend>
                <p>
                    <label for="cps_campus">Campus</label>
                    <select name="cps_campus">
                        <?php foreach ($campuses as $campus) : ?>
                            <option value="<?= $campus['Id'] ?>" <?php if ($campus['Id'] == $program['CampusId']) : ?>selected<?php endif ?>><?= $campus['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </p>
                <p>
                    <label for="cps_campus_zone">Campus Zone</label>
                    <select name="cps_campus_zone">
                        <?php foreach ($campus_zones as $campus_zone) : ?>
                            <option value="<?= $campus_zone['Id'] ?>" <?php if ($campus_zone['Id'] == $program['CampusZoneId']) : ?>selected<?php endif ?>><?= $campus_zone['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </p>
                <p>
                    <label for="cps_pategory">Program Category</label>
                    <select name="cps_pategory">
                        <?php foreach ($program_category as $category) : ?>
                            <option value="<?= $category['Id'] ?>" <?php if ($category['Id'] == $program['ProgramCategoryId']) : ?>selected<?php endif ?>><?= $category['Name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </p>
                <p>
                    <label for="cps_program">Program</label>
                    <input name="cps_program" value="<?= $program['Name'] ?>" />
                </p>
                <p id="hidden_input">
                    <input name="program_id" value="<?= $program['Id'] ?>" />
                </p>
                <p class="adm">
                    <button type="submit" name="command" value="Update">Update</button>
                </p>
            </fieldset>
        </form>
        <div class=" footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>