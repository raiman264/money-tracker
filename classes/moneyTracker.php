<?php

class MoneyTracker {

    public $cnx;

    public function __construct( ConnectionModel $cnx ) {
        $this->cnx = $cnx;
    }

    public function newEntry( $amount, $concept, $date, $label="", $source="" ) {

        if (!is_integer($date)) {
            $date = strtotime($date);
        }

        $data = array(
            'amount'  => $amount,
            'concept' => $concept,
            'date'    => $date,
            'label'   => $label,
            'source'  => $source
        );

        return $this->cnx->insert($data, 'data');
    }
}