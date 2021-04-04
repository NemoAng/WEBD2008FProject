<?php
require('header_connect_session.php');

if ($user_logined == false) {
    header('Location: ./index.php');
}

$title = "Campus Zone Create";
$year = date("Y");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link rel="icon" href="./graphing_red.png" sizes="16x16 32x32" type="image/x-icon" />
    <link rel="stylesheet" href="style_main.css" type="text/css">
</head>

<body>
    <div id="wrapper">
        <h1 class="rrc_header_h1"><?= $title ?></h1>
        <div>
            <form action="campus_zone_post.php" method="post">
                <fieldset>
                    <legend>New Campus Create</legend>
                    <p>
                        <label for="c_zone">New Campus Name</label>
                        <input name="c_zone" id="pcc_title" />
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