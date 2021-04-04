<?php
require('header_connect_session.php');

if ($user_logined == false) {
    header('Location: ./index.php');
}

$title = "Program Category Create";
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
            <form action="program_category_post.php" method="post">
                <fieldset>
                    <legend>New Program Category Create</legend>
                    <p>
                        <label for="category">New Category Name</label>
                        <input name="category" id="pcc_title" />
                    </p>
                    <p class="adm">
                        <input type="submit" name="command" value="Create" />
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