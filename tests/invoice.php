<?php
error_reporting(-1);
ini_set('display_errors', 1);

session_start();

set_time_limit(60*5);
header("Content-Type: text/html");

$verbose = fopen('php://temp', 'w+');


//MAKE THE LOGIN IN THE TOOL IN ORDER TO OBTAIN THE AUTHORIZATION TOKEN AND SESSION ID
$authorization = "Authorization: Basic ". base64_encode("admin:admin");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://devserver/slim/public/auth/"); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization) );
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_STDERR, $verbose);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
rewind($verbose);
$verboseLog = stream_get_contents($verbose);
//echo "\n\nVerbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
//echo "\n-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
//echo $result;
//echo "\n\n\n\n\n";


//STORE THE AUTHORIZATION DATA INTO THE VAR
$auth_data = json_decode($result, true);
$token = $auth_data['auth-jwt'];
$session_id = $auth_data['session_id'];
$authorization = "X-Token:".$token;




//FOR ANY REQUEST, YOU NEED TO RE-HASH THE BODY SO THAT WE PROVIDE TO CORRECT HASH FOR VALIDATING THE REQUEST


if (function_exists('curl_file_create')) { // php 5.5+
  $cFile = curl_file_create($file_name_with_full_path);
} else { // 
  $cFile = '@' . realpath($file_name_with_full_path);
}
$body = array('extra_info' => '123456','file_contents'=> $cFile);
$messageHash = "X-Token-Hash:". hash_hmac('SHA512', $body, $session_id.time());
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://devserver/slim/public/books/29"); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization, $messageHash, "Content-type: application/json") );
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_STDERR, $verbose);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
rewind($verbose);
$verboseLog = stream_get_contents($verbose);
//echo "\n\nVerbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
//echo "\n-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
echo $result;
//echo "\n\n\n\n\n";




//USE THE TOKEN AND SESSION ID PROVIDED ABOVE TO POPULATE THE REQUEST HEADERS WITH PROPER AUTHORIZATION AND MAKE THE REQUEST TO THE RESOURCE NEEDED
$body='';
$messageHash = "X-Token-Hash:". hash_hmac('SHA512', $body, $session_id.time());
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/slim/public/books"); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization, $messageHash, "Content-type: application/json") );
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_STDERR, $verbose);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
rewind($verbose);
$verboseLog = stream_get_contents($verbose);
//echo "\n\nVerbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
//echo "\n-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
echo $result;
//echo "\n\n\n\n\n";





//FOR ANY REQUEST, YOU NEED TO RE-HASH THE BODY SO THAT WE PROVIDE TO CORRECT HASH FOR VALIDATING THE REQUEST
$body='';
$messageHash = "X-Token-Hash:". hash_hmac('SHA512', $body, $session_id.time());
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://devserver/slim/public/logout/admin"); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization, $messageHash, "Content-type: application/json") );
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_STDERR, $verbose);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
rewind($verbose);
$verboseLog = stream_get_contents($verbose);
//echo "\n\nVerbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
//echo "\n-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
//echo $result;
//echo "\n\n\n\n\n";
