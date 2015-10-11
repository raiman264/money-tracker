<?php

ini_set("display_errors", true);
ini_set("error_log", realpath(dirname(__FILE__))."/bot_log.txt");
error_reporting(E_ALL);

###########################################################
#
#   UPDATE THIS VARIABLE TO MATCH YOUR SSL CERT LOCATION
#   to get this file run  
#   openssl s_client -showcerts -connect <server>:443 > cacert.pem
#   
#   be sure that you already have https enable and running
#
    $ssl_cert_location = dirname(__FILE__)."/../config/cacert.pem";
#
###########################################################

#own libraries
require realpath(dirname(__FILE__))."/classes/TelegramBotAPI.php";

#config
require realpath(dirname(__FILE__))."/../config/config.php";

function _log($str) {
    print_r($str);
}


function isSecure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}

$setHook = true;

$deleteWebhook = isset($_GET['delete']);

if ( !isSecure() ) {
    _log("You need to use a secure conection to set a webhook \n\n");
    $setHook = false;
} else {
    _log("This connection is secure \n\n");
}

if ( file_exists($ssl_cert_location) ) {
    _log("Certificate found \n\n");
} else {
    _log("Certificate NOT found \n\n");
    $setHook = false;
}

if ( $setHook || $deleteWebhook ) {


    $telegram = new TelegramBot(BOT_AUTH_TOKEN);

    if ( !$deleteWebhook ) {
        $url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = substr( $url, 0, strrpos($url, "/") + 1 ) . "bot.php";
    } else {
        $url = '';
        $ssl_cert_location = null;
    }

    _log("Setting webhook address to: ".$url);

    _log($telegram->setWebhook($url,$ssl_cert_location));

}

