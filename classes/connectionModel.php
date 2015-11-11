<?php

abstract class ConnectionModel {

    /**
     * saves data
     * @param  array  $values associative array of values, where the key is the name of the field
     * @param  string $target name of the table
     * @return mixed          inserted ID
     */
    abstract public function insert( array $values, $target );

}