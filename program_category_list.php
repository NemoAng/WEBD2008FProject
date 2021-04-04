<?php
require('header_connect_session.php');

if ($_POST) {
    session_destroy();
    header('Location: ./program_category.php');
}

$query = "SELECT * FROM program_category ORDER BY Id ASC";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute();
$programs = $statement->fetchAll();

$subject = "Program Category List";
$year = date("Y");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $subject ?></title>
    <link rel="stylesheet" href="style_main.css" type="text/css">
    <link rel="icon" href="./graphing_red.png" sizes="16x16 32x32" type="image/x-icon" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var deletes = [];

        function selects(cb, evX) {
            if (cb.checked == true) {
                deletes.push(cb.value);

            } else {
                for (var i = 0; i < deletes.length; i++) {
                    if (deletes[i] === cb.value) {
                        deletes.splice(i, 1);
                        break;
                    }
                }
            }
            evX.stopPropagation();
            //console.log(deletes);
        }

        function tr_selects(tr) {
            var elem = tr.childNodes[1].childNodes[0];
            elem.click();
        }

        function remove() {
            if (deletes.length == 0) {
                return;
            }

            var password = prompt("Password");
            if (password == null || password == "") {
                return;
            } else {
                //AJAX POST with JSON   
                let user = '<?= $_SESSION['username'] ?>';
                let request = 'data_delete_auth.php?user=' + user + '&password=' + password;

                //console.log(request);

                fetch(request)
                    .then(function(result) {
                        return result.json(); // Promise for parsed JSON.
                    })
                    .then(function(response) {
                        // If the API check was successful.
                        //console.log(response.success);

                        if (response.success == true) {
                            //if (deletes.length != 0 && confirm('Are you sure to delete these recoard?')) {
                            if (confirm('Are you sure to delete these recoard?')) {
                                deletes.sort(function(a, b) {
                                    return a - b
                                });
                                if (deletes.length != 0) {
                                    var del_items = deletes.join(",");
                                    $.post("program_category_delete.php", del_items);

                                    setTimeout(function() {
                                        location.reload();
                                    }, 500);
                                }
                            }
                        } else {
                            alert("Password wrong.");
                        }
                    });
            }
        }
    </script>

</head>

<body>
    <?php if ($user_logined) : ?>
        <form id="btn_delete">
            <input type="button" value="Delete Selected" onclick="remove()">
        </form>
    <?php endif ?>
    <div id="wrapper">
        <?php
        require('login_header.php');
        ?>

        <h1 class="rrc_header_h1"><?= $subject ?></h1>
        <table>
            <colgroup>
                <?php if ($user_logined) : ?>
                    <col span="1" style="width: 5%;">
                    <col span="1" style="width: 90%;">
                    <col span="1" style="width: 5%;">
                <?php else : ?>
                    <col span="1" style="width: 100%;">
                <?php endif ?>
            </colgroup>

            <thead>
                <tr>
                    <?php if ($user_logined) : ?>
                        <th>Delete</th>
                    <?php endif ?>
                    <th>Program Category Name</th>
                    <?php if ($user_logined) : ?>
                        <th>Edit</th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programs as $program) : ?>
                    <tr onclick="tr_selects(this)">
                        <?php if ($user_logined) : ?>
                            <td class="center"><input type="checkbox" name="delete" value="<?= $program['Id'] ?>" onclick="selects(this, event)" /></td>
                        <?php endif ?>
                        <td><?= $program['Name'] ?></td>
                        <?php if ($user_logined) : ?>
                            <td><a href="program_category_edit.php?id=<?= $program['Id'] ?>">Edit</a></td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->

    </div> <!-- END div id="wrapper" -->
</body>

</html>