<?php
require('header_connect_session.php');

if ($user_logined == false) {
    header('Location: ./index.php');
}


$query = "SELECT * FROM campus_zone ORDER BY Id ASC";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute();
$campus_zones = $statement->fetchAll();



$title = "Campus Create";
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
            <form action="campus_post.php" method="post" id="id_cc">
                <fieldset>
                    <legend>New Campus</legend>
                    <p>
                        <label for="cps_campus_zone">Campus Zone</label>
                        <select name="cps_campus_zone">
                            <?php foreach ($campus_zones as $campus_zone) : ?>
                                <option value="<?= $campus_zone['Id'] ?>"><?= $campus_zone['Name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </p>
                    <p>
                        <label for="cps_name">Campus Name</label>
                        <input name="cps_name" />
                    </p>
                    <p>
                        <label for="cps_add">Address</label>
                        <input name="cps_add" />
                    </p>
                    <p>
                        <label for="cps_pcode">Post Code</label>
                        <input name="cps_pcode" />
                    </p>
                    <p>
                        <label for="cps_tel">Tel</label>
                        <input name="cps_tel" />
                    </p>

                    <p class="adm">
                        <button type="submit" name="command_type" value="Create">Create</button>
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