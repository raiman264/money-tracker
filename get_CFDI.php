<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

define('APPLICATION_NAME', 'Gmail API Quickstart');
define('CREDENTIALS_PATH', '.credentials/gmail-api-quickstart.json');
define('CLIENT_SECRET_PATH', 'config/client_secret_app.json');
define('SCOPES', implode(' ', array(
  Google_Service_Gmail::GMAIL_READONLY)
));

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfigFile(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  var_dump(file_exists($credentialsPath), $credentialsPath);
  if (file_exists($credentialsPath)) {
    $accessToken = file_get_contents($credentialsPath);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->authenticate($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, $accessToken);
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->refreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, $client->getAccessToken());
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Gmail($client);

// Print the labels in the user's account.
$user = 'me';

/*
$results = $service->users_labels->listUsersLabels($user);

if (count($results->getLabels()) == 0) {
  print "No labels found.\n";
} else {
  print "Labels:\n";
  foreach ($results->getLabels() as $label) {
    printf("- %s\n", $label->getName());
  }
}
*/

$options = Array (
  "labelIds" => "Label_54",
  "q" => "newer:2015/05/01"
);

$results = $service->users_messages->listUsersMessages($user,$options);

if (count($results->getMessages()) == 0) {
  print "No labels found.\n";
} else {
  print "Messsages:\n";
  foreach ($results->getMessages() as $message) {
    $mid = $message->getId();
    printf("- %s ", $mid);

    $attachments = $service->users_messages->get($user,$mid)->getPayload()->getParts();

    foreach ($attachments as $attachment) {
        
        printf("\n-- %s %s ", $attachment->getFilename(),$attachment->getMimeType());

        $re = "/^.*\\.xml$/";  
         
        if(preg_match($re, $attachment->getFilename(), $matches)){
          printf("go ahead");

          $aid = $attachment->getBody()->getAttachmentId();

          # Actions
          $xml = $service->users_messages_attachments->get($user,$mid,$aid)->getData();

          #save file
          $xml = strtr($xml, array('-' => '+', '_' => '/'));
          file_put_contents($attachment->getFilename(), base64_decode($xml));

          #read content

          // include_once "cfdi_reader.php";
          // cfdi_reader($xml);


        }
    }
    
    printf("\n");
  }
}
