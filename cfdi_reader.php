<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function cfdi_reader($xml_data){

  $xml = new SimpleXMLElement($xml_data);

  // if is a CFDI
  echo 'validating';
  if(array_key_exists("cfdi",$xml->getNamespaces())){
    print_r(
      // Array(
      //   $xml->children()
      // )
      //$xml->children("cfdi",true)->Conceptos
      $xml->attributes()->fecha
    );

    $date = (string)$xml->attributes()->fecha;
    $children = $xml->children("cfdi",true);

    print_r($children->Emisor->attributes()->nombre);

    foreach ($children->Conceptos->children("cfdi",true) as $value) {
      $values = $value->attributes();
      $data = array(
        "code" => (string)$values->noIdentificacion,
        "concept" => (string)$values->descripcion,
        "amount" => (string)$values->importe,
        "source" => "CFDI ".$children->Emisor->attributes()->nombre,
        "date" => $date
      );
      print_r($data);
      # code...
    }
  }

}

#test
$xml = file_get_contents("SECFD_20150603_040627.xml");

cfdi_reader($xml);

echo "fin";