
<form action="" method="post">
    <input type="text" name="cookie"/>
    <button>check</button>
</form>
<?php

if(isset($_POST['cookie']) && $_POST['cookie']!="" ){
    $cookie = $_POST['cookie'];
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/wallet/balance',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Cookie:'.$cookie,
        'Accept: application/json'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    $data = json_decode($response,true);
if(isset($data['data']))
echo "Tiền còn: ".$data['data'];
else echo "cookie có vấn đề";
}
?>
