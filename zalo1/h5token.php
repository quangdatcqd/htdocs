<?php





$step = 0;
while ($step <= 10000) {
    $randomString = substr(str_shuffle("0123456789abcdef"), 0, 32);
    $randomString1 = substr(str_shuffle("0123456789abcdef"), 0, 32);
    $randomString2 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);

    $h5token =  $randomString.$randomString1 . $randomString2;

    $step++;
    echo $step;
    echo $h5token;
    echo doref($h5token) . "<br>";
}


function doref($h5token)
{
    set_time_limit(0);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://uudai.zalopay.vn/referral/api/do-referral',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
  "eventName": "do-referral",
  "shareKey": "210506000010051"
}',
        CURLOPT_HTTPHEADER => array(
            'cookie:h5token=' . $h5token,
            'Content-Type: text/plain'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
} 
