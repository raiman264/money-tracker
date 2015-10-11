<?php

require realpath(dirname(__FILE__))."/../../classes/moneyTracker.php";

class MoneyBot extends TelegramBot{

    public $updatesProcessLimit = 100;
    public $moneyTracker = null;

    public function __construct($token) {
        parent::__construct($token);

        $this->moneyTracker = new MoneyTracker();
    }

    public function isValidUser($userTelegramId) {
        $validUser = array (
            "113812545" => "1"
        );

        if (isset($validUser[$userTelegramId])) {
            _log("valid user");
            return $validUser[$userTelegramId];
        }

        error_log("User ".$userTelegramId." is not valid");

        return false;
    }

    public function runUpdates($offset) {
        $updates = $this->getUpdates($offset, $this->updatesProcessLimit);

        $lastUpdate = null;
        if (isset($updates) && $updates->ok) {
            foreach ($updates->result as $update) {
                $lastUpdate = $update->update_id;
                if (isset($update->message) && $this->isValidUser($update->message->from->id)) {
                    $this->processMessage($update->message);
                }
            }
        }

        $result = new stdClass();
        $result->lastUpdate = $lastUpdate;
        print_r($updates);

        return $result;
    }

    public function processMessage($message) {
        $regex = "/^(\/[^\s]*)?(.*)/";
        preg_match_all($regex, $message->text, $matches);
        $command = $matches[1][0];

        if ( strpos($matches[2][0], ",") !== false ) {
            // parse as CSV
            $params = array_map( "trim", explode(",",$matches[2][0]) );
        } else {
            $params = explode(" ",trim($matches[2][0]));
        }

        print_r(array($command,$params));

        switch ($command) {
            case '/a':
            case '/add':
                // test if it has the requirments for add a new entry
                if ( is_numeric($params[0]) && isset($params[1])) {
                    $res = $this->moneyTracker->newEntry(
                        $params[0],
                        $params[1],
                        $message->date,
                        isset($params[2]) ? $params[2] : "",
                        "bot"
                    );
                    $text = "Your entry has been saved";
                } else {
                    $text = "Error parsing parameters, the proper way is \n/add <money_amount>, <concept>, <label>";
                }
                
                break;
            case '/ping':
                $text = "pong";
                break;
            default:
                $text = " I didn't understand your command :( ";
                break;
        }

        if (isset($text)) {
            _log($text);
            //array("reply_to_message_id" => $message->message_id)
            $this->sendMessage($message->chat->id,$text);
        }
    }
}