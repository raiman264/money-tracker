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

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($request_body)
  ));

  curl_setopt( $ch, CURLOPT_POSTFIELDS, $request_body );

  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
  // curl_setopt( $ch, CURLOPT_HEADER, true );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );

  curl_setopt( $ch, CURLOPT_USERAGENT, PROXY_USER_AGENT);

  // curl_setopt ($ch, CURLOPT_CAINFO, dirname(__FILE__)."/trust_cert.pem");

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
  $signature = hash_hmac ( $algo , $url , PROXY_KEY);

  if(isset($_GET[PROXY_KEY]))
    die($signature);

  return $code == $signature;
}