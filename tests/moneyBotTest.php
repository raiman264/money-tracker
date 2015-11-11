<?php

function _log($a){}

require realpath(dirname(__FILE__))."/../telegrambot/classes/TelegramBotAPI.php";
require realpath(dirname(__FILE__))."/../telegrambot/classes/moneyBot.php";

class MoneyBotTest extends PHPUnit_Framework_TestCase {

    protected $bot;

    protected function setUp() {
        $this->bot = new MoneyBot("123");
    }

    public function tearDown() {
        unset($this->bot);
    }

    /**
     * @dataProvider usersProvider
     */
    public function testValidUser($user, $expected) {
        $valid = $this->bot->isValidUser($user);
        $this->assertEquals($expected, $valid);
    }

    public function usersProvider() {
        return array(
            'validUser' => array("113812545",true),
            'invalidUser' => array("dasd asda",false)
        );
    }
}