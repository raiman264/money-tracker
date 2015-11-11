<?php

require_once realpath(dirname(__FILE__))."/connectionModel.php";
require_once realpath(dirname(__FILE__))."/../vendor/idiorm/idiorm.php";

class DBMySql extends ConnectionModel {

    public function __construct( $connex ) {
        ORM::configure( array(
            'connection_string' => 'mysql:host='.$connex['server'].';dbname='.$connex['name'],
            'username' => $connex['user'],
            'password' => $connex['pass'],
            'driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        ) );
    }

    /**
     * saves data
     * @param  array  $values associative array of values, where the key is the name of the field
     * @param  string $target name of the table
     * @return mixed          inserted ID
     */
    public function insert( array $values, $target ) {
        
        $newEntry = ORM::for_table($target)->create();
        
        foreach ($values as $field => $value) {
            $newEntry->{$field} = $value;
        }

        $newEntry->save();

        return $newEntry->id();
    }
}