<?php

class TelegramBot {
    public $api_url = "https://api.telegram.org/bot";
    public $auth_token = "";

    public function __construct($token) {
        $this->auth_token = $token;
    }

    public function request($method, $data = null, $verb = "GET") {
        $url = $this->api_url.$this->auth_token."/".$method;
        _log($url);

        $encodePostFields = true;
        $ch = curl_init($url);

        #CURLOPT_PUT
        #CURLOPT_POST
        
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        #curl_setopt($ch, CURLOPT_VERBOSE, true);

        if(isset($data)) {

            switch ($verb) {
                case "FILE":
                    $headers = array("Content-Type:multipart/form-data");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $encodePostFields = false;

                case "POST":
                    curl_setopt($ch, CURLOPT_POST, 1);
                    break;
                
                default:
                    curl_setopt($ch, CURLOPT_HTTPGET);
                    break;
            }

            if ( $encodePostFields ) {
                $encoded = "";

                foreach($data as $name => $value) {
                    $encoded .= urlencode($name).'='.urlencode($value).'&';
                }
                // chop off last ampersand
                $data = substr($encoded, 0, strlen($encoded)-1);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        }

        $output = curl_exec($ch);
        curl_close($ch);

        #print_r($output); die("eee");

        return json_decode($output);
    }

    public function getUpdates($offset = 0, $limit = null) {
        $options = array("offset"=>$offset);
        if (isset($limit)) {
            $options["limit"] = $limit;
        }

        $updates = $this->request('getUpdates',$options,"POST");

        #error_log(print_r($updates,1));
        #print_r($updates);
        return ($updates);
    }

    /**
     * sendMessage
     * @param  int $chat_id  Integer Yes Unique identifier for the message recipient — User or GroupChat id
     * @param  int $text  String  Yes Text of the message to be sent
     * @param  array $options
     *        - disable_web_page_preview  Boolean Optional  Disables link previews for links in this message
     *        - reply_to_message_id Integer Optional  If the message is a reply, ID of the original message
     *        - reply_markup  ReplyKeyboardMarkup or ReplyKeyboardHide or ForceReply  Optional  Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.
     * @return [type]
     */
    public function sendMessage($chat_id,$text,$options = array()) {
        $validOptions = array("disable_web_page_preview", "reply_to_message_id", "reply_markup");

        $data = array(
            "chat_id" => $chat_id,
            "text" => $text
        );

        foreach ($validOptions as $option) {
            if (isset($options[$option])) {
                $data[$option] = $options[$option];
            }
        }

        $message = $this->request('sendMessage',$data,"POST");

        return $message;
    }

    /**
     * setWebhook
     * When webhook is setted getUpdates will not work
     * @param string $url  target URL for the webhook
     * @param string $cert CA cert to trust in, in case you use a self signed certificate
     */
    public function setWebhook($url, $cert = null) {
        $data = array("url" => $url);
        if ( isset($cert) ) {
            $data["certificate"] = curl_file_create( $cert, "application/octet-stream", "certificate" );
        }
        return $this->request("setWebhook", $data, "FILE");
    }
}