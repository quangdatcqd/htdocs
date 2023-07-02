<?php
require_once "share.php";
    class bigc{

        public function __construct() 
        {
            $this->shareFunction = new share();
        }
        

        // controller check BIG_C
  function bigc_check()
  {
    if (isset($_POST['cookie']) &&  $_POST['cookie'] != "") {
      $h5cookie = $_POST['cookie'];
      $checkbigc = json_decode($this->check_bigc($h5cookie), true);
      if ($checkbigc == 1) {
        $bigc =  '<span class="text-success">"OK"</span>';
      } else $bigc =  '<span class="text-danger">"NOT"</span>';
      $listvc = $this->share->getlistvc($h5cookie);

      $ls = "";
      if (isset($listvc['data']['campaigns']) && is_array($listvc['data']['campaigns'])) {

        foreach ($listvc['data']['campaigns'] as $listvc) {
          $ls .= "<h4><img width='40px' src='" . $listvc['avatar'] . "'>" . $listvc['voucherName'] . " | <span>Hạn: " . date("d/m/Y", $listvc['UseConditionExpiredDate'] / 1000) . "</span></h4>";
        }
      }
    }

    $pagename = "CHECK VOUCHER BIGC";
    $pathfile = '../views/check_bigc.php';
    require_once "../views/layout.php";
  }

  // API check BIG_C
  function check_bigc($h5cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://zmc.zalopay.vn/zlp/promotion/?promotiontranid=210403000410919&merchant=bigcgovap',
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
