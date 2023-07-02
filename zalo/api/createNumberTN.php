<?php
if(isset($_GET['cookie'])){
  $cookie = $_GET['cookie'];  
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://textnow.vn/v2/get_phone',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('service_id' => '28'),
  CURLOPT_HTTPHEADER => array(
    'Accept:  application/json, text/javascript, */*; q=0.01',
    'Accept-Encoding:  gzip, deflate, br',
    'Accept-Language:  en-US,en;q=0.9,vi;q=0.8',
    'Connection:  keep-alive',
    'Cookie: '.$cookie,
    'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36',
    'X-Requested-With:  XMLHttpRequest'
  ),
));

$response = curl_exec($curl);
// echo $response;
curl_close($curl);
 $data = json_decode( $response,true)['data_row'];
 
 
    $regex = "/[0-9]{9}/";
    $sdt = [];
     preg_match($regex,$data,$sdt);
     if(isset($sdt[0])) echo $sdt[0];
     else echo '0';
 
   
}
