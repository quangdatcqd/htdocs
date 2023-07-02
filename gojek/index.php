<?php

// $sLogin = base64_encode('muaproxy_JQIjX:nfMbUaFzH5_country-vn');

// $sURL = "http://beamtic.com/Examples/ip.php"; // The Request URL

// $aHTTP['http']['proxy']           = 'tcp://15.235.145.95:12325'; // The proxy ip and port number
// $aHTTP['http']['request_fulluri'] = true; // Use the full URI in the Request. I.e. http://beamtic.com/Examples/ip.php
// $aHTTP['http']['method']          = 'GET';
// $aHTTP['http']['header']          = "User-Agent: My PHP Script\r\n";
// $aHTTP['http']['header']         .= "Referer: http://beamtic.com/\r\n";
// $aHTTP['http']['header']         .= "Proxy-Authorization: Basic $sLogin";

// $context = stream_context_create($aHTTP);
// $contents = file_get_contents($sURL, false, $context);

// echo 'Real IP:' . $_SERVER['REMOTE_ADDR'] . '<hr>';
// echo 'Proxy IP:' . $contents;

?>
<?php

// $curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL => 'https://api.gojekapi.com/v6/customers/newrequest',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_PROXYTYPE => 'muaproxy_JQIjX:nfMbUaFzH5_country-vn@15.235.145.95:12325',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => false,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'POST',
//     CURLOPT_POSTFIELDS => '{"consent_given":true,"phone":"+84389854555"}',
//     CURLOPT_HTTPHEADER => array(
//         'X-Appversion:  4.56.1',
//         'X-Uniqueid:  c3a21c460d7c53ad',
//         'Content-Type:  application/json; charset=UTF-8'
//     ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// echo $response;
?>



<!-- <?php



        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_PROXY, $proxy);
        // curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HEADER, 1);
        // $curl_scraped_page = curl_exec($ch);
        // curl_close($ch);

        // echo $curl_scraped_page;
        ?> -->
<?php
$url = 'http://beamtic.com/Examples/ip.php';
$proxy = '15.235.145.95:12323';
$proxyauth = 'muaproxy_JQIjX:nfMbUaFzH5_country-vn';
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.gojekapi.com/poi/v3/findLatLng?placeid=GOOG-EkVMw6ogVHLhu41uZyBU4bqlbiwgVMOibiBQaMO6LCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0iLiosChQKEgnDiiPUWSl1MRH-Vc07vSDR4xIUChIJdZHmM_crdTER_iUzc1M01tg&service_type=5',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    // CURLOPT_PROXY => $proxy,
    // CURLOPT_PROXYUSERPWD => $proxyauth,
    CURLOPT_FOLLOWLOCATION => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'X-Session-Id:  6643284c-bd37-40f3-9cd3-5584ada17122',
        'Authorization:  Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6IiJ9.eyJhdWQiOlsiZ29qZWs6Y29uc3VtZXI6YXBwIl0sImRhdCI6eyJhY3RpdmUiOiJ0cnVlIiwiYmxhY2tsaXN0ZWQiOiJmYWxzZSIsImNvdW50cnlfY29kZSI6Iis4NCIsImNyZWF0ZWRfYXQiOiIyMDIyLTEyLTIyVDE1OjQ3OjQzWiIsImVtYWlsIjoiZGF0MjNkMzBuOWp6NmZvb3liazJAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOiJmYWxzZSIsImdvcGF5X2FjY291bnRfaWQiOiIwMS1mNDlhNTBlNWJlMDE0OWE3OTdiMzhhODA1YjU2N2MzOS0yMSIsIm5hbWUiOiJkYXQiLCJudW1iZXIiOiI4MTc4NjYwMzIiLCJwaG9uZSI6Iis4NDgxNzg2NjAzMiIsInNpZ25lZF91cF9jb3VudHJ5IjoiVk4iLCJ3YWxsZXRfaWQiOiIifSwiZXhwIjoxNjc0NDY4NjM1LCJpYXQiOjE2NzE3MjQwNjMsImlzcyI6ImdvaWQiLCJqdGkiOiJiNTk3OTllYi0zZDU1LTQ0ZjYtODhmYy1kYTU4ZjQ0Yzk3ODkiLCJzY29wZXMiOltdLCJzaWQiOiJjNjAyZWZkOC1kNjM1LTQ1OGYtOTNlNy1lZTQyMTI3M2EyZDMiLCJzdWIiOiI2MjM3NjQ3ZS04YTA1LTQ1MTItODIxNi01MDU3NGYxZmRmZTMiLCJ1aWQiOiI3OTEyNzExODciLCJ1dHlwZSI6ImN1c3RvbWVyIn0.URpgnJroefiachjDJ__5jprOoEI_MxPYC3W0SAbGULNDrOi8BC0FmLw2-4lcdVVYTpOkKYxn38aN_HMPSUXBhRTwJKs4x52ggPwsvBgKB6EyHdLOIpvReiw0ybuK6h11a0vvMjGU3jw-726e8ZLoHhihSobvOYijajeRgQAHFFA',
        'Accept-Language:  vi-VN',
        'X-User-Locale:  vi_VN'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
