<?php

/*

    Proxy to redirect https conections
    from a Server with Trusted Certifcate
    to a server with a self signed certificate

 */

require("../config/config.php");

if( validate_request($_GET['u'],$_GET['k']) ){
  $request_body = file_get_contents('php://input');

  $ch = curl_init( $_GET['u'] );

  curl_setopt( $ch, CURLOPT_POST, true );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $_POST );

  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
  // curl_setopt( $ch, CURLOPT_HEADER, true );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );

  curl_setopt( $ch, CURLOPT_USERAGENT, USER_AGENT);


  curl_exec( $ch );

  $status = curl_getinfo( $ch );
  var_dump($status);

  curl_close( $ch );
} else {
  header("HTTP/1.0 403 Forbidden");
  echo "403 Forbidden";
}


function validate_request($url,$code) {
  $algo = "sha1";
  $signature = hash_hmac ( $algo , $url , KEY);

  if(isset($_GET[KEY]))
    die($signature);

  return $code == $signature;
}