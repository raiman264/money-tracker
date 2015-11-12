<?php

require_once realpath(dirname(__FILE__))."/connectionModel.php";
require_once realpath(dirname(__FILE__))."/../vendor/idiorm/idiorm.php";

class DBMySql extends ConnectionModel {

    public function __construct( $connex ) {
        ORM::configure( array(
            'connection_string' => 'mysql:host='.$connex['server'].';dbname='.$connex['name'],
            'username' => $connex['user'],
            'password' => $connex['pass'],
            'driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        ) );
    }

    /**
     * saves data
     * @param  array  $values associative array of values, where the key is the name of the field
     * @param  string $target name of the table
     * @return mixed          inserted ID
     */
    public function insert( array $values, $target ) {
        
        $newEntry = ORM::for_table($target)->create();
        
        foreach ($values as $field => $value) {
            $newEntry->{$field} = $value;
        }

        $newEntry->save();

        return $newEntry->id();
    }

    /**
     * executes a query
     * @param  string $query
     * @param  array  $params assoc array of params used in the $query
     * @return array          array of resulting rows
     */
    public function query( $query, array $params = array() ) {
        $re = "/FROM\\s([^\\s]+)/i";
        preg_match($re, $query, $matches);

        $results = ORM::for_table( $matches[1] )->raw_query($query)->find_array();
        return $results;
    }

    /**
     * get info from db
     * @param  mixed  $fields fields to retreive, could be array or string " * "
     * @param  string $source name of the table
     * @param  mixed  $filter or condition
     * @param  string $limit  end of the subset of results
     * @param  string $offset start of the subset of results
     * @return array          array of rows
     */
    public function get( $fields, $source, $filter = null, $limit = null, $offset = null ) {
        $query = " SELECT $fields FROM $source ";
        if ( isset( $filter ) ) {
            $query .= " WHERE $filter ";
        }
        if ( isset( $limit ) ) {
            $query .= " LIMIT $filter ";
        }
        if ( isset( $offset ) ) {
            $query .= " OFFSET $filter ";
        }

        $results = ORM::for_table( $source )->raw_query($query)->find_many();
        return $results;
    }
}