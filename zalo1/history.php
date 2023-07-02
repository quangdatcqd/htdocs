
<form action="" method="post">
    <input type="text" name="cookie" placeholder="nhap cookie" >
    <button type="submit">kiem tra</button>
</form>
<style>
    span{
        font-size: 16pt;
        color: green;
        font-weight: bold;
    }
    li{
        font-size: 14pt;
        color: brown;
        font-weight: bold;
    }
    </style>
<?php
$html = '';
if(isset($_POST['cookie'])){
    $cookie = $_POST['cookie'];
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sapi.zalopay.vn/v1/wallet/history?offset=0&limit=50',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'cookie: '. $cookie 
  ),
));

$response = curl_exec($curl);
 
curl_close($curl);
$data = json_decode( $response,true)['data']['histories'];
 
    
    foreach ($data as $row) {
        if( true){
            $html .= '<li>Tên: '.$row['description'] .'| <span>Ngày: '.date("d/m/Y", $row['updateTime'] / 1000) .' | '.number_format($row['amount']).'</span></li>';
   
        }
        }
        if(date("d/m/Y", $data[1]['updateTime'] / 1000) != '01/06/2021') echo "<span>Sài OK</span>" ;
        else echo "Không sài được!";     
}

?>
<ul>
    <?=$html?>
</ul>


