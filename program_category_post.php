<?php
require('header_connect_session.php');

$year = date("Y");
$valid = true;

if ($_POST) {
    //$title = $_POST['title'];
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($_POST['command'] == 'Create') {
        if ($valid) {
            //require('connect.php');

            $query = "INSERT INTO program_category (Name) values (:category)";
            $statement = $db->prepare($query);
            $statement->bindValue(':category', $category);
            $statement->execute();
            header('Location: program_category_list.php');
            exit();
        }
    } else if ($_POST['command'] == 'Update') {
        $id = filter_input(INPUT_POST, 'prog_cat_id', FILTER_SANITIZE_NUMBER_INT);

        if ($valid) {
            $query = "UPDATE program_category SET Name = :name WHERE Id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $category);
            $statement->bindValue(':id', $id);
            $statement->execute();
            header('Location: program_category_list.php');
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
    <link rel="icon" href="./graphing_red.png" sizes="16x16 32x32" type="image/x-icon" />
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