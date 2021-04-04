<?php
require('header_connect_session.php');

$ajax_data = [
    "success" => false,
    //"password" => 'nemowang'
];

if ($_GET) {
    $user_input = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
    $password_input = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    $query = "SELECT * FROM registered_user where Name = '$user_input'";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute();
    $user = $statement->fetchAll();

    if (password_verify($password_input, $user[0]['Password'])) {
        $ajax_data['success'] = true;
    }
    header('Content-Type: application/json');
    echo json_encode($ajax_data);
}
