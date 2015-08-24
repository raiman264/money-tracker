<?php

class MoneyTracker {

    public function __constructor($conex) {
        // ORM::configure(array(
        //     'connection_string' => 'mysql:host='.DB_SERVER.';dbname='.DB_NAME,
        //     'username' => DB_USER,
        //     'password' => DB_PASS,
        //     'driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        // ));
    }
    public function newEntry($amount, $concept, $date, $label="", $source="") {
        
        $newEntry = ORM::for_table('data')->create();
        
        $newEntry->amount = $amount;
        $newEntry->concept = $concept;
        $newEntry->date = $date;
        $newEntry->label = $label;
        $newEntry->source = $source;
        
        $newEntry->save();

        return $newEntry->id();
    }
}