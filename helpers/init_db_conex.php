<?php

require realpath(dirname(__FILE__))."/../vendor/idiorm/idiorm.php";

ORM::configure(array(
    'connection_string' => 'mysql:host='.DB_SERVER.';dbname='.DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASS,
    'driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
));