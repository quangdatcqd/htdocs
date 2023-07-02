<?php
class coopmart
{
    function __construct()
    {
    }


    public function checkCoopMart($h5cookie)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://zmc.zalopay.vn/zlp/promotion/?merchant=coopmart',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(

                'cookie:' . $h5cookie,
                'sec-fetch-dest:  document',
                'sec-fetch-mode:  navigate',
                'sec-fetch-site:  none',
                'sec-fetch-user:  ?1',
                'upgrade-insecure-requests:  1',
                'user-agent:  Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $regex = '{<title>Quà tặng</title>}';
        return preg_match($regex, $response);
    }
}
new coopmart();
