<?php
if(isset($_GET["cookie"]) && $_GET["cookie"] != ""){
  $cookie = $_GET["cookie"]; 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://trumotp.com/otporder/post',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"allowCall":true,"OO_OrderCategoryId":271}',
  CURLOPT_HTTPHEADER => array(
    'content-type:  application/json;charset=UTF-8',
    'cookie: '.$cookie
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
}