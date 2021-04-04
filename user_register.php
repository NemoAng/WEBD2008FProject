<?php
$subject = "User Register";

$year = date("Y");

//print_r($campuses);
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
        <h1 class="rrc_header_h1"><?= $subject ?></h1>

        <form action="user_register_post.php" method="post">
            <p>
                <label for="username">User Name:</label>
                <input name="username" id="user_reg_form1" />
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" name="password" id="user_reg_form2" />
            </p>
            <p>
                <label for="cpassword">Conform Password:</label>
                <input type="password" name="cpassword" id="user_reg_form3" />
            </p>
            <p class="adm">
                <input type="submit" name="register" value="Create" id="user_reg_form_sub" />
            </p>

        </form>

        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>