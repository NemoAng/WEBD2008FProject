<?php
require('header_connect_session.php');

$valid = true;

$campus_id = filter_input(INPUT_POST, 'cps_campus', FILTER_SANITIZE_NUMBER_INT);
$campus_zone_id = filter_input(INPUT_POST, 'cps_campus_zone', FILTER_SANITIZE_NUMBER_INT);
$program_category_id = filter_input(INPUT_POST, 'cps_pategory', FILTER_SANITIZE_NUMBER_INT);
$program_name = filter_input(INPUT_POST, 'cps_program', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (empty($program_name) || (isset($program_name) == false)) {
    $valid = false;
    $error_code = 1;
    print_r($campus_id);
} else {
    if ($_POST['command'] == 'Create') {
        $query = "INSERT INTO programs (CampusId, CampusZoneId, ProgramCategoryId, Name) values (:campus_id, :campus_zone_id, :category_id, :name)";

        $statement = $db->prepare($query);
        $statement->bindValue(':campus_id', $campus_id);
        $statement->bindValue(':campus_zone_id', $campus_zone_id);
        $statement->bindValue(':category_id', $program_category_id);
        $statement->bindValue(':name', $program_name);
        $statement->execute();
        header('Location: program_list.php');
    } else if ($_POST['command'] == 'Update') {
        $program_id =
            filter_input(INPUT_POST, 'program_id', FILTER_SANITIZE_NUMBER_INT);

        $query = "UPDATE programs SET Name = :program, CampusId = :campus_id, CampusZoneId = :campus_zone_id, ProgramCategoryId = :program_category_id WHERE Id = :program_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':program', $program_name);
        $statement->bindValue(':campus_id', $campus_id);
        $statement->bindValue(':campus_zone_id', $campus_zone_id);
        $statement->bindValue(':program_category_id', $program_category_id);
        $statement->bindValue(':program_id', $program_id);
        $statement->execute();

        header('Location: program_list.php');
    }
}

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
            <?php if ($valid) : ?>
                <h3>Program Adding Successful.</h3>
                <a href="./program_list.php">Back to Program List.</a>
            <?php elseif ($error_code == 1) : ?>
                <p3>Program Name is Null.</p3>
            <?php endif ?>
        </div>
        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div>
    </div> <!-- END div id="wrapper" -->
</body>

</html>