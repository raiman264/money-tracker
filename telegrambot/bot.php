<?php

ini_set("display_errors", true);
error_reporting(E_ALL);
error_log("bot_log.txt");


function _log($str) {
    echo $str."\n";
}



#own libraries
require realpath(dirname(__FILE__))."/classes/TelegramBotAPI.php";
require realpath(dirname(__FILE__))."/classes/moneyBot.php";

#config
require realpath(dirname(__FILE__))."/../config/config.php";

require realpath(dirname(__FILE__))."/../helpers/init_db_conex.php";



$bot = new MoneyBot(BOT_AUTH_TOKEN);

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$user_id = 1; // waiting to have a ssystem for more users

$lastUpdate = ORM::for_table('user_config')
            ->select('id')
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
    $lastUpdate->save();
}

