<?php

ini_set("display_errors", true);
ini_set("error_log", realpath(dirname(__FILE__))."/bot_log.txt");
error_reporting(E_ALL);


function _log($str) {
    echo $str."\n";
    file_put_contents(realpath(dirname(__FILE__))."/test_bot.txt", $str."\n",FILE_APPEND);
    error_log($str);
}

#own libraries
require_once realpath(dirname(__FILE__))."/classes/TelegramBotAPI.php";
require_once realpath(dirname(__FILE__))."/classes/moneyBot.php";

#config
require_once realpath(dirname(__FILE__))."/../config/config.php";

require_once realpath(dirname(__FILE__))."/../helpers/init_db_conex.php";


$request_body = file_get_contents('php://input');


$bot = new MoneyBot( BOT_AUTH_TOKEN, $db_connect );

$user_id = 1; // waiting to have a ssystem for more users

if ( !empty($request_body) ) {
    #webhook request
    $update = json_decode($request_body);
    $bot->processMessage($update->message);

    // $lastUpdate = ORM::for_table('user_config')->create();
    // $lastUpdate->user_id = $user_id;
    // $lastUpdate->config_type = 'bot_lastUpdate';
    // $lastUpdate->value = $update->update_id;
    // $lastUpdate->save();

} else {
    #cronjob, getUpdates method

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
}
