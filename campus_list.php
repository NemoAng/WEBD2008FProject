<?php
require('header_connect_session.php');

if ($_POST) {
    session_destroy();
    header('Location: ./campus_list.php');
}

$query = "SELECT cps.*, 
    cpsz.Name AS CpszName
    FROM campus cps
    JOIN campus_zone cpsz ON cps.CampusZoneId = cpsz.Id";
$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute();
$campuses = $statement->fetchAll();

$subject = "Campus Information List";

$year = date("Y");
$valid = true;
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
            console.log(deletes);
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

                fetch(request)
                    .then(function(result) {
                        return result.json(); // Promise for parsed JSON.
                    })
                    .then(function(response) {
                        if (response.success == true) {
                            if (confirm('Are you sure to delete these recoard?')) {
                                deletes.sort(function(a, b) {
                                    return a - b
                                });
                                if (deletes.length != 0) {
                                    console.log(del_items);

                                    var del_items = deletes.join(",");
                                    $.post("campus_delete.php", del_items);

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
        <?php if ($valid) : ?>
            <div id="top">
                <table>
                    <colgroup>
                        <?php if ($user_logined) : ?>
                            <col span="1" style="width: 5%;">
                            <col span="1" style="width: 25%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 5%;">
                            <col span="1" style="width: 5%;">
                        <?php else : ?>
                            <col span="1" style="width: 20%;">
                            <col span="1" style="width: 34%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 6%;">
                        <?php endif ?>
                    </colgroup>

                    <thead>
                        <tr>
                            <?php if ($user_logined) : ?>
                                <th>Delete</th>
                            <?php endif ?>
                            <th>Campus Name</th>
                            <th>Address</th>
                            <th>Post Code</th>
                            <th>Tel</th>
                            <th>Campus Zone</th>
                            <th>Detail</th>
                            <?php if ($user_logined) : ?>
                                <th>Edit</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($campuses as $campus) : ?>
                            <tr id=<?= $campus['Id'] ?> onclick="tr_selects(this)">
                                <?php if ($user_logined) : ?>
                                    <td class="center"><input type="checkbox" name="delete" value="<?= $campus['Id'] ?>" onclick="selects(this, event)" /></td>
                                <?php endif ?>
                                <td><?= $campus['Name'] ?></td>
                                <td><?= $campus['Address'] ?></td>
                                <td><?= $campus['ZipCode'] ?></td>
                                <td><?= $campus['Tel'] ?></td>
                                <td><?= $campus['CpszName'] ?></td>
                                <td><a href="campus_view.php?id=<?= $campus['Id'] ?>" target="_blank">View</a></td>
                                <?php if ($user_logined) : ?>
                                    <td><a href="campus_edit.php?id=<?= $campus['Id'] ?>">Edit</a></td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        <?php endif ?>

        <div class=" footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>