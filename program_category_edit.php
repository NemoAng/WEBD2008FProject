<?php
require('header_connect_session.php');

$subject = 'Program Category Edit';
//UPDATE `campus` SET `Address` = '222' WHERE `campus`.`Id` = 47;
if ($_GET) {
    $prog_cat_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM program_category WHERE Id = $prog_cat_id";

    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $prog_cat = $statement->fetch();
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

        <form action="program_category_post.php" method="post">
            <fieldset>
                <legend>Progam Category Edit</legend>
                <p>
                    <label for="category">Progam Category</label>
                    <input name="category" id="pcc_title" value="<?= $prog_cat['Name'] ?>" />
                </p>
                <p id="hidden_input">
                    <input name="prog_cat_id" value="<?= $prog_cat['Id'] ?>" />
                </p>
                <p class="adm">
                    <input type="submit" name="command" value="Update" />
                </p>
            </fieldset>
        </form>
    </div>
</body>