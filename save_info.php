<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config/db_config.php";

if(isset($_POST['amount'])){

    $mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }

    $res = $mysqli->query("
        INSERT INTO `data`(`concept`,`amount`,`label`,`source`,`date`)
        VALUES(
            '{$_POST['concept']}',
            '{$_POST['amount']}',
            '{$_POST['label']}',
            'web',
            '{$_POST['date']}'
        );

    ");

    if (!$res) {
        echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
    }else {
        echo "info saved";
    }

}