<?php
require('header_connect_session.php');

$valid = true;
$subject = "User Login";
$year = date("Y");

if ($_POST) {
    $ur_name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ur_ps = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ur_cps = filter_input(INPUT_POST, 'cpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($ur_name) || (isset($ur_name) == false)) {
        $valid = false;
        $error_code = 1;
    }

    if (strcmp($ur_ps, $ur_cps) != 0) {
        $valid = false;
        $error_code = 2;
    }

    if ($valid) {
        $query = "SELECT * FROM registered_user WHERE Name = :ur_name_r";
        $statement = $db->prepare($query); // Returns a PDOStatement object.
        $statement->bindValue(':ur_name_r', $ur_name);

        $statement->execute();
        $users = $statement->fetchAll();
        $user_matched_cnt = count($users);
        if ($user_matched_cnt != 0) {
            $valid = false;
            $error_code = 3;
        } else {
            $query = "INSERT INTO registered_user (Name, Password) values (:username, :password)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $ur_name);
            $statement->bindValue(':password', password_hash($ur_ps, PASSWORD_DEFAULT));
            $statement->execute();
        }
    }
}
//password_hash
//password_verify
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
        <?php if ($valid) : ?>
            <h3>You are successfully registered.</h3>
            <a href="./user_login.php">Back to Login</a>
        <?php else : ?>
            <?php if ($error_code == 1) : ?>
                <h3>User name needed.</h3>
            <?php elseif ($error_code == 2) : ?>
                <h3>Password not match.</h3>
            <?php elseif ($error_code == 3) : ?>
                <h3>Please choose another user name.</h3>
            <?php endif ?>
        <?php endif ?>

        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>