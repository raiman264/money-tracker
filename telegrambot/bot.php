<?php

ini_set("display_errors", true);
error_reporting(E_ALL);
error_log("bot_log.txt");


function _log($str) {
    echo $str."\n";
}


#vendor libraries
require "../vendor/idiorm/idiorm.php";

#own libraries
require "classes/TelegramBotAPI.php";
require "classes/moneyBot.php";

#config
require "../config/db_config.php";

$bot = new MoneyBot(BOT_AUTH_TOKEN);

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$user_id = 1; // waiting to have a ssystem for more users

ORM::configure(array(
    'connection_string' => 'mysql:host='.DB_SERVER.';dbname='.DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASS,
    'driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
));

$lastUpdate = ORM::for_table('user_config')
            ->select('value')
            ->where(array(
                'user_id' => $user_id,
                'config_type' => 'bot_lastUpdate'
            ))
            ->find_one();

if ($lastUpdate) {
    echo $lastUpdate->value;
    $offset = $lastUpdate->value + 1;
} else {
    echo "not set";
    $lastUpdate = ORM::for_table('user_config')->create();
    $lastUpdate->user_id = $user_id;
    $lastUpdate->config_type = 'bot_lastUpdate';
    $offset = 0;
}

$updates = $bot->runUpdates($offset);

if ($updates->lastUpdate) {
    $lastUpdate->value = $updates->lastUpdate;
    //$lastUpdate->save();
}

