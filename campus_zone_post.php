<?php
require('header_connect_session.php');

$year = date("Y");
$valid = true;

if ($_POST) {
    //$title = $_POST['title'];
    $c_zone = filter_input(INPUT_POST, 'c_zone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($_POST['command'] == 'Create') {
        if ($valid) {
            $query = "INSERT INTO campus_zone (Name) values (:c_zone)";
            $statement = $db->prepare($query);
            $statement->bindValue(':c_zone', $c_zone);
            $statement->execute();
            header('Location: campus_zone_list.php');
            exit();
        }
    } else if ($_POST['command'] == 'Update') {
        $campus_zone_id
            = filter_input(INPUT_POST, 'cps_zone_id', FILTER_SANITIZE_NUMBER_INT);
        if ($valid) {
            //require('connect.php');
            //$content = str_replace("'", "''", $content);

            $query = "UPDATE campus_zone SET Name = :c_zone WHERE Id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':c_zone', $c_zone);
            $statement->bindValue(':id', $campus_zone_id);

            $statement->execute();
            header('Location: campus_zone_list.php');
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Error</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php"></a></h1>
        </div> <!-- END div id="header" -->

        <h1>An error occured while processing your command.</h1>
        <p>
            Both the title and content must be at least one character. </p>
        <a href="index.php">Return Home</a>

        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div>
    </div> <!-- END div id="wrapper" -->
</body>

</html>