<?php
require('header_connect_session.php');

if ($_POST) {
    foreach ($_POST as $key => $value) {
        $del_items = explode(',', $key);

        foreach ($del_items as $item) {
            $query = "DELETE FROM program_category WHERE Id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $item, PDO::PARAM_INT);
            $statement->execute();
        }
    }
}
