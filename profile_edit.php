<?php
require('header_connect_session.php');
require('lib\ImageResize.php');

use \Gumlet\ImageResize;

$title = "Update Profle";

if (isset($_POST["submit"])) {

    $target_dir = "images-upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    $fileInfo = pathinfo($target_file);
    $fileName = $_SESSION['username'] . '_profile';
    $fileExtension = $fileInfo['extension'];

    $target_file = $target_dir . '/' . $fileName . '.' . $fileExtension;
    $target_file_medium = $target_dir . '/' . $fileName . "_medium." . $fileExtension;
    $target_file_thumbnail = $target_dir . '/' . $fileName . "_thumbnail." . $fileExtension;

    $uploadOk = 1;
    //$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

    $fileType = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);


    // Allow certain file formats
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
            //echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.<br>";

            if ($fileType != "application/pdf") {
                $image = new ImageResize($target_file);
                $image->resizeToWidth(400, $allow_enlarge = True);
                $image->save($target_file_medium);
                $image->resizeToWidth(50, $allow_enlarge = True);
                $image->save($target_file_thumbnail);
                //
            }
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}
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
    <div>
        <h3>Current Profile</h3>
        <img src="images-upload/<?= $_SESSION['username'] . '_profile.jpg' ?>" width="300px" height="300px">
    </div>
    <form method="post" enctype="multipart/form-data" action="">
        <fieldset>
            <label for="image">New Profile:</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
        </fieldset>
    </form>

</body>

</html>