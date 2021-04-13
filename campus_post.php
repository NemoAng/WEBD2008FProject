<?php
require('header_connect_session.php');
require('lib\ImageResize.php');

use \Gumlet\ImageResize;

$year = date("Y");

if ($_POST) {
    //$title = $_POST['title'];
    $cps_cps_zone = filter_input(INPUT_POST, 'cps_campus_zone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $cps_name = filter_input(INPUT_POST, 'cps_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cps_add = filter_input(INPUT_POST, 'cps_add', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cps_pcode = filter_input(INPUT_POST, 'cps_pcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cps_tel = filter_input(INPUT_POST, 'cps_tel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($_POST['command_type'] == 'Create') {
        if ($cps_name != null) {
            // print_r($cps_cps_zone . ',');
            // print_r($cps_name . ',');
            // print_r($cps_add . ',');
            // print_r($cps_pcode . ',');
            // print_r($cps_tel);

            $query = "INSERT INTO campus (CampusZoneId, Name, Address, ZipCode, Tel, Images) values (:cps_zone, :cps_name, :cps_add, :cps_pcode, :cps_tel, :cps_img)";
            //$query = "INSERT INTO Campus (Name, Address, ZipCode, Tel) values ('www', 'xxx', 'jjj', 'ttt')";
            $statement = $db->prepare($query);
            $statement->bindValue(':cps_zone', $cps_cps_zone);
            $statement->bindValue(':cps_name', $cps_name);
            $statement->bindValue(':cps_add', $cps_add);
            $statement->bindValue(':cps_pcode', $cps_pcode);
            $statement->bindValue(':cps_tel', $cps_tel);



            if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] != UPLOAD_ERR_NO_FILE) {

                $target_dir = "images-upload/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

                $fileInfo = pathinfo($target_file);
                $fileName = $fileInfo['filename'];

                $fileExtension = $fileInfo['extension'];
                $target_file_medium = $target_dir . '/' . $fileName . "_medium." . $fileExtension;
                $target_file_thumbnail = $target_dir . '/' . $fileName . "_thumbnail." . $fileExtension;

                $uploadOk = 1;
                //$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

                $fileType = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);

                if (
                    $fileType != "image/jpg" && $fileType != "image/jpeg" && $fileType != "image/png" && $fileType != "image/gif"
                    && $fileType != "application/pdf"
                ) {
                    echo "Sorry, only JPG, PNG, GIF & PDF files are allowed.<br>";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.<br>";

                        if ($fileType != "application/pdf") {
                            $image = new ImageResize($target_file);
                            $image->resizeToWidth(400, $allow_enlarge = True);
                            $image->save($target_file_medium);
                            $image->resizeToWidth(50, $allow_enlarge = True);
                            $image->save($target_file_thumbnail);

                            $statement->bindValue(':cps_img', basename($_FILES["fileToUpload"]["name"]));
                        }
                    } else {
                        echo "Sorry, there was an error uploading your file.<br>";
                    }
                }
            } else {
                $statement->bindValue(':cps_img', '');
            }

            $statement->execute();
        }
        header('Location: campus_list.php');
        exit();
    } else if ($_POST['command_type'] == 'Update') {
        if ($valid) {
            $cps_id =
                filter_input(INPUT_POST, 'cps_id', FILTER_SANITIZE_NUMBER_INT);

            $query = "UPDATE campus SET Name = :cps_name, Address = :cps_add, ZipCode = :cps_pcode, Tel = :cps_tel WHERE Id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':cps_name', $cps_name);
            $statement->bindValue(':cps_add', $cps_add);
            $statement->bindValue(':cps_pcode', $cps_pcode);
            $statement->bindValue(':cps_tel', $cps_tel);
            $statement->bindValue(':id', $cps_id);

            $statement->execute();
            header('Location: campus_list.php');
            exit();
        }
    } else if ($_POST['command_type'] == 'Delete') {
        $id = $_POST['id'];
        //require('connect.php');
        $query = "DELETE FROM campus WHERE Id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        header('Location: campus_list.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Error</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="icon" href="./graphing_red.png" sizes="16x16 32x32" type="image/x-icon" />
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php"></a></h1>
        </div> <!-- END div id="header" -->

        <h1>An error occured while processing your command.</h1>
        <p>
            Both the title and content must be at least one character. </p>
        <a href="index.php">Return Home</a>

        <div class="footer">
            Copyright © <?= $year ?> RRC. All Rights Reserved
        </div>
    </div> <!-- END div id="wrapper" -->
</body>

</html>