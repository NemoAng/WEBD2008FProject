<?php
require('header_connect_session.php');

if ($_POST) {
    session_destroy();
    header('Location: ./index.php');
}

$campuses = [
    ['text' => 'Campus Information List<1>', 'link' => "./campus_list.php"],
    ['text' => 'Campus Zone Information List<2>', 'link' => "./campus_zone_list.php"],
    ['text' => 'Program Category List<3>', 'link' => "./program_category_list.php"],
    //['text' => 'Program Type Information<4>', 'link' => "./program_time_type.php"],
    ['text' => 'Program List<5>', 'link' => "./program_list.php"],
];

$campuses_adm = [
    ['text' => 'Create Campus<1>', 'link' => "./campus_create.php"],
    ['text' => 'Create Campus Zone<2>', 'link' => "./campus_zone_create.php"],
    ['text' => 'Create Category<3>', 'link' => "./program_category_create.php"],
    ['text' => 'Create Program<5>', 'link' => "./program_create.php"],
];

$year = date("Y");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Index</title>
    <link rel="stylesheet" href="style_main.css" type="text/css">
    <link rel="icon" href="./graphing_red.png" sizes="16x16 32x32" type="image/x-icon" />

    <style>
        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php
        require('login_header.php');
        ?>

        <h1 class="rrc_header_h1">Red River College Information List</h1>
        <ul id="index_menu">
            <?php foreach ($campuses as $campus) : ?>
                <li><a href="<?= $campus['link'] ?>" target="_blank"><?= $campus['text'] ?></a></li>
            <?php endforeach ?>
        </ul>
        <hr>
        <?php if ($user_logined) : ?>
            <ul id="index_menu">
                <?php foreach ($campuses_adm as $campuse_adm) : ?>
                    <li><a href="<?= $campuse_adm['link'] ?>" target="_blank"><?= $campuse_adm['text'] ?></a></li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>

        <div class="footer">
            <a href="https://cocowang.freeoda.com/access_record_list.php" target="_blank">*</a>Copyright © <?= $year ?> RRC. All Rights Reserved <a href="https://newserv.freewha.com/" target="_blank">🌎</a>
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->

    <script>
        function session_clear() {
            sessionStorage["username"] = "";
            sessionStorage.setItem("username", "");
            sessionStorage.clear();
        }
    </script>
</body>

</html>