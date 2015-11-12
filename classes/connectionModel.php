<?php

abstract class ConnectionModel {

    /**
     * saves data
     * @param  array  $values associative array of values, where the key is the name of the field
     * @param  string $target name of the table
     * @return mixed          inserted ID
     */
    abstract public function insert( array $values, $target );

    /**
     * executes a query
     * @param  string $query
     * @param  array  $params assoc array of params used in the $query
     * @return array          array of resulting rows
     */
    abstract public function query( $query, array $params = array() );

    /**
     * get info from db
     * @param  mixed  $fields fields to retreive, could be array or string " * "
     * @param  string $source name of the table
     * @param  mixed  $filter or condition
     * @param  string $limit  end of the subset of results
     * @param  string $offset start of the subset of results
     * @return array          array of rows
     */
    abstract public function get( $fields, $source, $filter = null, $limit = null, $offset = null );

}