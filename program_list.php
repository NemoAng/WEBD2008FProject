<?php
require('header_connect_session.php');

$query = "SELECT prog.*,
       cps.Name AS CpsName, cpsz.Name AS CpszName, prog_ctg.Name AS CtgName
  FROM programs prog
  JOIN campus cps ON prog.CampusId = cps.Id
  JOIN campus_zone cpsz ON prog.CampusZoneId = cpsz.Id
  JOIN program_category prog_ctg ON prog.ProgramCategoryId = prog_ctg.id ORDER BY prog.Id ASC";

$statement = $db->prepare($query); // Returns a PDOStatement object.
$statement->execute();
$programs = $statement->fetchAll();

$valid = true;
$subject = "Program List";

$year = date("Y");

//print_r(count($campuses));
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
                                    $.post("program_delete.php", del_items);

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
                            <col span="1" style="width: 20%;">
                            <col span="1" style="width: 20%;">
                            <col span="1" style="width: 25%;">
                            <col span="1" style="width: 25%;">
                            <col span="1" style="width: 5%;">
                        <?php else : ?>
                            <col span="1" style="width: 25%;">
                            <col span="1" style="width: 25%;">
                            <col span="1" style="width: 25%;">
                            <col span="1" style="width: 25%;">
                        <?php endif ?>

                    </colgroup>

                    <thead>
                        <tr>
                            <?php if ($user_logined) : ?>
                                <th>Delete</th>
                            <?php endif ?>
                            <th>Program Name</th>
                            <th>Campus Name</th>
                            <th>Campus Zone</th>
                            <th>Program Category</th>
                            <?php if ($user_logined) : ?>
                                <th>Edit</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($programs as $program) : ?>
                            <tr id=<?= $program['Id'] ?> onclick="tr_selects(this)">
                                <?php if ($user_logined) : ?>
                                    <td class="center"><input type="checkbox" name="delete" value="<?= $program['Id'] ?>" onclick="selects(this, event)" /></td>
                                <?php endif ?>
                                <td><?= $program['Name'] ?></td>
                                <td><?= $program['CpsName'] ?></td>
                                <td><?= $program['CpszName'] ?></td>
                                <td><?= $program['CtgName'] ?></td>
                                <?php if ($user_logined) : ?>
                                    <td><a href="program_edit.php?id=<?= $program['Id'] ?>">Edit</a></td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        <?php endif ?>

        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>

</html>