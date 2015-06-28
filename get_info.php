<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config/db_config.php";


    $mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }

    $result = $mysqli->query("
        SELECT * FROM `data`;
    ");

    /* execute statement */
    //$result->execute();

    // /* bind result variables */
    // $result->bind_result($name, $code);

    /* fetch values */
    echo "<table border=1>";
    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        foreach ($data as $key => $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }

    echo "</table>";

    $result->close();
