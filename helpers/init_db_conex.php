<?php

switch ( DATA_STORE_TYPE ) {
  case 'gDataStore':
     # code...
    break;
  case 'mysql':
  default:
    require_once realpath(dirname(__FILE__))."/../classes/dbMysql.php";
    $db_connect = new DBMySql( array(
        'server' => DB_SERVER,
        'name'   => DB_NAME,
        'user'   => DB_USER,
        'pass'   => DB_PASS
      ) );

    ORM::configure('id_column_overrides', array(
        'data' => 'id',
        'user_config' => 'id'
      ));

    # code...
    break;
 }


