<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include dirname( __FILE__ ) . "/config/config.php";
include dirname( __FILE__ ) . "/helpers/init_db_conex.php";

if(isset($_POST['amount'])){

    $date = strtotime($_POST['date']);

    $db_connect->insert(
        array(
            'concept' => $_POST['concept'],
            'amount'  => $_POST['amount'],
            'label'   => $_POST['label'],
            'source'  => 'web',
            'date'    => $date
        ),
        'data'
    );

        echo "info saved";
    

}