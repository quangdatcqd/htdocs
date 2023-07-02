<?php
if(isset($_GET["cookie"]) && $_GET["cookie"] != ""){
$cookie = $_GET["cookie"]; 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://trumotp.com/otporder/getbalance',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'accept:  application/json, text/plain, */*',
    'accept-encoding:  gzip, deflate, br',
    'accept-language:  en-US,en;q=0.9,vi;q=0.8',
    'content-length:  0',
    'cookie: '.$cookie
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

}