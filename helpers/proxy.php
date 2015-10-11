<?php

/*

    Proxy to redirect https conections
    from a Server with Trusted Certifcate
    to a server with a self signed certificate

    Use Get params, u => url, k => validation key 
    inorder to get the validation key you need to make a call using 'u' and '<your-secret-key>' (aka PROXY_KEY) as params
 */

require("../config/config.php");

if( validate_request($_GET['u'],$_GET['k']) ){
  $request_body = file_get_contents('php://input');

  $ch = curl_init( $_GET['u'] );

  curl_setopt( $ch, CURLOPT_POST, true );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $_POST );

  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
  //curl_setopt( $ch, CURLOPT_HEADER, true );
  //curl_setopt ($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");

  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );

  curl_setopt( $ch, CURLOPT_USERAGENT, PROXY_USER_AGENT);


  curl_exec( $ch );

  $status = curl_getinfo( $ch );
  print_r($status);

  curl_close( $ch );
} else {
  header("HTTP/1.0 403 Forbidden");
  echo "403 Forbidden";
}


function validate_request($url,$code) {
  $encType = "sha1";
  $signature = hash_hmac ( $encType , $url , PROXY_KEY);

  if(isset($_GET[PROXY_KEY]))
    die($signature);

  return $code == $signature;
}