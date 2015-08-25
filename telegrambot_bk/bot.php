<?php

ini_set("display_errors", true);
error_reporting(E_ALL);

require("api.php");

class MoneyBot extends TelegramBot{

  public $updatesProcessLimit = 100;

  public function runUpdates($offset) {
    $updates = $this->getUpdates($offset, $this->updatesProcessLimit);

    if (isset($updates) && $updates->ok) {
      foreach ($updates->result as $update) {
        if (isset($update->message)) {
          $this->processMessage($update->message);
        }
      }
    }
    print_r($updates);
  }

  public function processMessage($message) {
    $regex = "/^(\/[^\s]*)?(.*)/";
    preg_match_all($regex, $message->text, $matches);
    $command = $matches[1][0];
    $params = explode(" ",trim($matches[2][0]));

    print_r(array($command,$params));

    switch ($command) {
      case '/a':
      case '/add':
        # code...
        break;
      
      default:
        $this->sendMessage($message->chat->id," I didn't understand your command :( ",array("reply_to_message_id" => $message->message_id));
        break;
    }
  }
}

$bot = new MoneyBot(BOT_AUTH_TOKEN);

$updates = $bot->runUpdates(316505738+1);

