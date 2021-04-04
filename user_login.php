<?php
require('header_connect_session.php');

$error_code = 0;

if ($_POST) {
    $ur_name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ur_ps = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //$query = "SELECT * FROM Registered_User WHERE Name = :ur_name_r AND Password = :ur_ps_r";
    $query = "SELECT * FROM registered_user WHERE Name = :ur_name_r";
    $statement = $db->prepare($query); // Returns a PDOStatement object.

    $statement->bindValue(':ur_name_r', $ur_name);
    //$statement->bindValue(':ur_ps_r', $ur_ps);

    $statement->execute();
    $users = $statement->fetchAll();
    $user_matched_cnt = count($users);

    if ($user_matched_cnt == 0) {
        //$user_unavailable = true;
        $error_code = 1;
    } else if ($user_matched_cnt == 1) {
        $password = $users[0]['Password'];
        if (password_verify($ur_ps, $password)) {
            $_SESSION['username'] = $users[0]['Name'];
            $_SESSION['userid'] = $users[0]['Id'];

            $user_logined = true;
            header('Location: index.php');
        } else {
            //print_r($ur_ps);
            //print_r($password);
            //print_r(password_hash($ur_ps, PASSWORD_DEFAULT));
            $error_code = 2;
        }
    }
}

$subject = "User Login";

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
        <h1 class="rrc_header_h1"><?= $subject ?></h1>

        <?php if ($user_logined) : ?>
            <h3>Welcome <?= $_SESSION['username'] ?></h3>
        <?php else : ?>
            <form action="?" method="post" class="adm">
                <p>
                    <label for="username">User Name:</label>
                    <input name="username" id="user_reg_form1" />
                </p>
                <p>
                    <label for="password">Password:</label>
                    <input name="password" type="password" id="user_reg_form2" />
                </p>
                <p>
                    <input type="submit" name="register" value="Login" />
                    <?php if ($error_code == 1) : ?>
                <h3 class="error">User doesn't exist.</h3>
            <?php elseif ($error_code == 2) : ?>
                <h3 class="error">Password error.</h3>
            <?php endif ?>
            </p>
            </form>
        <?php endif ?>

        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>