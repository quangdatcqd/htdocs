<?php
require_once "../models/models_home.php";
session_start();

class home
{

  function __construct()
  {

    $this->model = new models_home();
    $act = "findfriends";
    if (isset($_GET['act'])) $act = $_GET['act'];
    $this->$act();
  }

  // controller Tìm bạn bè

  function findfriends()
  {
    $friends = [];
    if (isset($_GET['type']) && $_GET['type'] == 'decode') {

      $sdt = $_SESSION['number'];
      $friends = $this->model->get_list_friends($sdt);
      $_SESSION['number'] = '';
    }
    if (isset($_POST['lay'])) {
      $sdt = $_POST['sdt'];
      $_SESSION['number'] = $sdt;
      $friends = $this->model->get_list_friends($sdt);
    } 
    $pagename = "XÁC MINH BẠN BÈ";
    $pathfile = '../views/find_friends.php';

    require_once "../views/layout.php";
  }

  // controller đăng nhập
  function login()
  {

    if (isset($_POST['dangnhap'])) {
      $password =  strip_tags($_POST['password']);
      if ($password == 'hts') {
        $_SESSION['passwordmyweb'] = 'hts';
      }
    }

    header("location: /zalo/lay-so-dien-thoai/");
  }


  // controller lấy số điện thoại
  function getnumber()
  {
    $pagename = "LẤY SỐ ĐIỆN THOẠI";
    $pathfile = '../views/getnumber.php';
    require_once "../views/layout.php";
  }

  function getnumberdata()
  {

    $totalrow =   count($this->model->get_list_number());
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit  = isset($_GET['limit']) ? $_GET['limit'] : 200;
    $total_page = ceil($totalrow / $limit);
    $start = ($current_page - 1) * $limit;
    $data = [
      "data" => $this->model->get_page_number($start, $limit),
      "pagenext" => $current_page + 1,
      "totalpage" => $total_page
    ];

    echo json_encode($data);
  }
  // Định dạng ngày giờ
  function getTime($timestamp)
  {
    $date = date_create();

    date_timestamp_set($date, $timestamp);
    return date_format($date, 'U = Y-m-d H:i:s') . "\n";
  }

  
  // controller check các voucher 
  function checkvoucher()
  {

    $err = '';
    $_SESSION['check'] = '';
    $_SESSION['bm'] = '';
    $_SESSION['CP'] = '';
    $_SESSION['CM'] = '';
    if (isset($_POST['check'])) {
      if (isset($_POST['addzlp'])) {
        $_SESSION['check'] = 'checked';
      } else $_SESSION['check'] = '';

      if (isset($_POST['CM'])) {
        $_SESSION['CM'] = 'checked';
      } else $_SESSION['CM'] = '';

      if (isset($_POST['CP'])) $_SESSION['CP'] = 'checked';
      else $_SESSION['CP'] = '';

      $h5cookie = $_POST['cookie'];

      $api = $_POST['api'];
      if (isset($_POST['bm']))
        $_SESSION['bm'] = 'checked';

      $token =  $this->get_token($h5cookie);
      if ($token === 0) {
        $err = 'Sai Cookie!';
      } else {
        $note = "N";
        $mm = 0;
        $vc1 = 'NONE';
        $tasks = "";
        $baemin = '';
        $bm = "";
        //check BAEMIN
        if (isset($_SESSION['bm']) && $_SESSION['bm'] == 'checked') {
          $bmdata =   $this->checkbm($h5cookie);
          if ($bmdata['code'] == 200) {
            $note = "BM";
            $bm = '1';
            $baemin =  '<h3>BAEMIN:<span class="text-success">"OK"</span></h3>';
          } else $baemin =  '<h3>BAEMIN: <span class="text-danger">"NOT"</span></h3>';
        }

// check cooopmart
$cm= "";
$checkcoopmart = '';
if ($_SESSION['CM'] == "checked") {


  $checkcoopmart = json_decode($this->checkCoopMart($h5cookie), true);
  if ($checkcoopmart == 1) {
    $cm = 1;
    $coop =  '<h3>COOP_MART:<span class="text-success">"OK"</span></h3>';
    $note = 'CM';
  } else $coop =  '<h3>COOP_MART: <span class="text-danger">"NOT"</span></h3>';
} else $coop = "";


        // check bigc
        $c = "";
        $checkbigc = '';
        if ($_SESSION['CP'] == "checked") {


          $checkbigc = json_decode($this->check_bigc($h5cookie), true);
          if ($checkbigc == 1) {
            $c = 1;
            $bigc =  '<h3>BIG_C:<span class="text-success">"OK"</span></h3>';
            $note = 'Z';
          } else $bigc =  '<h3>BIG_C: <span class="text-danger">"NOT"</span></h3>';
        } else $bigc = "undefine";
        // END check bigc


        // if (true) {
        //   $checkNH = $this->checkMM($h5cookie);
        //   if ($checkNH["status"] == 200) {
        //     $vc1 = 1;
        //     $mm = 1;
        //     $c = '<h3 class="">MĂM: <span class="text-success">"OK"</span> </h3> ';
        //   } else {
        //     $c = '<h3 class="">MĂM: <span class="text-danger">"NOT"</span> </h3> ';
        //   }
        // }

        $vc = 'undefine';
        // $check_circle = $this->check_vc_circle($h5cookie);
        $checkvc = json_decode($this->checkvc($h5cookie), true);

        if ($checkvc == 1) {
          $family =  '<h3 class="">TÙ XÌ: <span class="text-success">"OK"</span</h3>';
          $note .= "V";
        } else $family =  '<h3 class="">TÙ XÌ: <span class="text-danger">"NOT"</span></h3>';


        $checkbigc = json_decode($this->check_bigc($h5cookie), true);
        if ($checkbigc == 1) {
          $c = 1;
          $bigc =  '<h3>BIG_C:<span class="text-success">"OK"</span></h3>';
          $note = 'Z';
        } else $bigc =  '<h3>BIG_C: <span class="text-danger">"NOT"</span></h3>';
        // list voucher
        $listvc = $this->getlistvc($h5cookie);

        $ls = '';
        if (isset($listvc['data']['campaigns']) && is_array($listvc['data']['campaigns'])) {

          foreach ($listvc['data']['campaigns'] as $listvc) {
            $ls .= "<h4><img width='40px' src='" . $listvc['avatar'] . "'>" . $listvc['voucherName'] . " | <span>Hạn: " .   $listvc['UseConditionExpiredDate'] . "</span></h4>";
            if ($listvc['voucherCode'] == '5087-210415000215669') {
              $vc = 1;
            }
          }
        }



        $addzalopay = '';

        // if (isset($_POST['addzlp'])  && ($vc == 1 || $checkvc1 == 1 || $check_circle == 1)) {
        if (isset($_POST['addzlp'])  &&  ($checkvc == 1 || $checkbigc == 1 || $bm == '1' || $cm ==1)) {
          // echo $_POST['addzlp'];

          $addz = $this->addzlp($h5cookie, $api);
          if ($addz == "0") {
            $note .= "h";
            $addz = "Đã có zalopay";
          }
          $addzalopay = '<h3 class="">ZALOPAY: ' . $addz . '</h3>';
        }

        $tong = "undefine";
        if (isset($_POST['sdt']) && ($_POST['sdt'] != '')) {
          $data = $this->getdata($token);
          $tong = count($data);
          $sdt = $_POST['sdt'];
          $used = 0;
          $check = $this->model->queryOne("SELECT * FROM banbe where number = '$sdt' ");
          $check1 = $this->model->queryOne("SELECT * FROM phone_number where number = '$sdt' ");
          if (is_array($check1)) {
            $this->model->execute("DELETE FROM `phone_number` WHERE number = '$sdt'");
          }
          if (is_array($check)) {
            $this->model->execute("DELETE FROM `banbe` WHERE number = '$sdt'");
          }

          $sql = "INSERT INTO `phone_number` ( `number`, `used`, `note`,`banbe`) VALUES ( '$sdt', '$used', '$note', '$h5cookie')";
          $this->model->execute($sql);




          foreach ($data as $fradd) {

            $name = $this->loc_xoa_dau($fradd['name']);
            $name = UTF8_encode($name);
            $img = $fradd['picture']['data']['url'];
            $sql = "INSERT INTO `banbe` (`id`, `name`, `image`, `number`) VALUES (NULL, '$name', '$img', '$sdt')";

            $this->model->execute($sql);
          }
        }
      }
    }
    $pagename = "CHECK VOUCHER";
    $pathfile = '../views/checkvoucher.php';
    require_once "../views/layout.php";
  }


  function loc_xoa_dau($str)
  {

    $str = preg_replace("/'/", "", $str);
    return $str;
  }
  function delete()
  {
    $id = $_POST['id'];
    if (isset($id) && $id != '') {
      $this->model->delete($id);
      $this->model->deletefr($id);
    }
  }

  function update()
  {
    $id = $_POST['id'];
    $note = $_POST['note'];
    $check = $_POST['check'];
    if (isset($id) && $id != '') $this->model->update($id, $note, $check);
  }


 


  function getdata($h5token)
  {

    $data = array();




    $dataa = json_decode($this->getn($h5token), true);
    foreach ($dataa['data'] as $dt) {

      array_push($data,  $dt);
    }
    while (isset($dataa['paging']['next'])) {

      $dataa = json_decode($this->getfrurl($dataa['paging']['next']), true);
      foreach ($dataa['data'] as  $dt) {
        array_push($data,  $dt);
      }
    }

    $datab = json_decode($this->getfr($h5token), true);
    foreach ($datab['data'] as  $dt) {

      array_push($data,  $dt);
    }
    while (isset($datab['paging']['next'])) {

      $datab = json_decode($this->getfrurl($datab['paging']['next']), true);
      foreach ($datab['data'] as  $dt) {

        array_push($data,  $dt);
      }
    }



    return $data;
  }


  function getfrurl($url)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
  }



  function addzlp($cookie, $api)
  {




    $token1 = '';
    if (isset($cookie) && $cookie != '') {
      $loop = 0;
      $checkuser = $this->check_zlp_avail($cookie);
      if ($checkuser == 1) {
        $nn = 1;
        while ($loop == 0) {

          // $tien = $this->getbalance($api);
          // if (isset($tien['Result']['Balance']) && $tien['Result']['Balance'] < 1) {
          //   $loop = 1;
          //   $_SESSION['api'] =  $api;
          //   $errr = 'API Hết Tiền';
          // }
          $tien = $this->getbalanceotp($api);

          if (isset($tien['data']['balance']) && $tien['data']['balance'] < 1000) {
            $loop = 1;
            $_SESSION['api'] =  $api;
            $errr = 'API Hết Tiền';
          }

          // if ($tien["ResponseCode"] != '0') {
          //   $errr = 'API Không đúng';
          //   break;
          // } else {
          if ($tien["status_code"] == '401') {
            $errr = 'API Không đúng';
            break;
          } else {

            $_SESSION['api'] =  $api;
            // $getphone = $this->getphone($api);

            if ($nn >= 4) $nn = 1;
            $getphone = $this->getphoneopt($api, $nn);
            $nn++;
            if (isset($getphone['data']['phone_number']) && $getphone['data']['session'] != '') {

              $number = $getphone['data']['phone_number'];
              $id = $getphone['data']['session'];
              // if (isset($getphone['Result']['Number']) && $getphone['Result']['Number'] != '') {
              //   $number = $getphone['Result']['Number'];
              //   $id = $getphone['Result']['Id'];
              $checkavai =  $this->getstatus($number, $cookie);
              if ($checkavai == 1) {
                $token1 =  $this->sendOTP($number, $cookie);
                if ($token1 != '') {
                  $c = 0;
                  $lop = 0;

                  while ($lop == 0) {

                    $c++;
                    $code = $this->getcodeotp($id, $api);
                    // $code = $this->getcode($id, $api)['Result']['Code'];
                    if (isset($code['data']['messages'][0]['otp']) && $code['data']['messages'][0]['otp'] != null) {
                      $code = $code['data']['messages'][0]['otp'];
                      $data = $this->submitOTP($token1, $code, $cookie);
                      $rs =  $this->setpin($data, $cookie);
                      if ($rs['error']['code'] == 0) $errr = "Đã add ZaloPay";
                      else $errr = 'Lỗi: ' . $rs['error']['message'];
                      $lop = 1;
                      $loop = 1;
                    } else sleep(3);
                    if ($c >= 10) {

                      $this->cancelotp($id, $api);
                      $lop = 1;
                    }
                  }
                } else $this->cancelotp($id, $api);
              } else {
                $this->cancelotp($id, $api);
              }
            }
          }
        }
      } else {
        $errr = "0";
      }
    } else $errr = "nhập cookie";
    return $errr;
  }


  

  // nap tien zalo


  // function getStatusPay($cookie, $session)
  // {


  //   $curl = curl_init();

  //   curl_setopt_array($curl, array(
  //     CURLOPT_URL => 'https://sapi.zalopay.vn/v1/wallet/history/' . $session,
  //     CURLOPT_RETURNTRANSFER => true,
  //     CURLOPT_ENCODING => '',
  //     CURLOPT_MAXREDIRS => 10,
  //     CURLOPT_TIMEOUT => 0,
  //     CURLOPT_FOLLOWLOCATION => true,
  //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //     CURLOPT_CUSTOMREQUEST => 'GET',
  //     CURLOPT_HTTPHEADER => array(
  //       'cookie: ' . $cookie
  //     ),
  //   ));

  //   $response = curl_exec($curl);

  //   curl_close($curl);
  //   return json_decode($response, true);
  // }

//   function t4($cookie, $ordertoken, $softoken)
//   {

//     $curl = curl_init();

//     curl_setopt_array($curl, array(
//       CURLOPT_URL => 'https://sapi.zalopay.vn/v2/cashier/pay',
//       CURLOPT_RETURNTRANSFER => true,
//       CURLOPT_ENCODING => '',
//       CURLOPT_MAXREDIRS => 10,
//       CURLOPT_TIMEOUT => 0,
//       CURLOPT_FOLLOWLOCATION => true,
//       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//       CURLOPT_CUSTOMREQUEST => 'POST',
//       CURLOPT_POSTFIELDS => '{
//   "authenticator": {
//     "authen_type": 1,
//     "pin": "91b4d142823f7d20c5f08df69122de43f35f057a988d9619f6d3138485c9a203"
//   },
//   "order_fee": [],
//   "order_token": "' . $ordertoken . '",
//   "promotion_token": "",
//   "service_id": 7,
//   "sof_token": "' . $softoken . '",
//   "user_fee": [
//     "0"
//   ],
//   "zalo_token": ""
// }',
//       CURLOPT_HTTPHEADER => array(
//         'cookie: ' . $cookie,
//         'Content-Type: text/plain'
//       ),
//     ));

//     $response = curl_exec($curl);

//     curl_close($curl);
//     return json_decode($response, true);
//   }

//   function t2($apptrans, $apptime, $appuser, $mac, $cookie)
//   {


//     $curl = curl_init();

//     curl_setopt_array($curl, array(
//       CURLOPT_URL => 'https://sapi.zalopay.vn/v2/cashier/assets',
//       CURLOPT_RETURNTRANSFER => true,
//       CURLOPT_ENCODING => '',
//       CURLOPT_MAXREDIRS => 10,
//       CURLOPT_TIMEOUT => 0,
//       CURLOPT_FOLLOWLOCATION => true,
//       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//       CURLOPT_CUSTOMREQUEST => 'POST',
//       CURLOPT_POSTFIELDS => '{
//   "order_data": {
//     "app_id": 454,
//     "app_trans_id": "' . $apptrans . '",
//     "app_time": ' . $apptime . ',
//     "amount": 10000,
//     "app_user": "' . $appuser . '",
//     "description": "Nạp tiền vào tài khoản ZaloPay",
//     "embed_data": "",
//     "mac": "' . $mac . '",
//     "item": "",
//     "trans_type": 1,
//     "product_code": "",
//     "zalo_token": "",
//     "service_fee": null
//   },
//   "bank_info": {
//     "bank_code": "VCCB",
//     "first_6_no": "900704",
//     "last_4_no": "5485",
//     "pmc_id": 37
//   },
//   "full_assets": true,
//   "order_type": 1
// }',
//       CURLOPT_HTTPHEADER => array(
//         'cookie: ' . $cookie,
//         'Content-Type: text/plain'
//       ),
//     ));

//     $response = curl_exec($curl);

//     curl_close($curl);
//     return json_decode($response, true);
//   }






//   function t1($cookie)
//   {
//     $curl = curl_init();

//     curl_setopt_array($curl, array(
//       CURLOPT_URL => 'https://sapi.zalopay.vn/v1/bank/order/top-up',
//       CURLOPT_RETURNTRANSFER => true,
//       CURLOPT_ENCODING => '',
//       CURLOPT_MAXREDIRS => 10,
//       CURLOPT_TIMEOUT => 0,
//       CURLOPT_FOLLOWLOCATION => true,
//       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//       CURLOPT_CUSTOMREQUEST => 'POST',
//       CURLOPT_POSTFIELDS => '{
//   "amount": "10000"
// }',
//       CURLOPT_HTTPHEADER => array(
//         'cookie:' . $cookie,
//         'Content-Type: text/plain'
//       ),
//     ));

//     $response = curl_exec($curl);

//     curl_close($curl);
//     return json_decode($response, true);
//   }

//   function t3($ordertoken, $softoken, $cookie)
//   {


//     $curl = curl_init();

//     curl_setopt_array($curl, array(
//       CURLOPT_URL => 'https://sapi.zalopay.vn/v2/cashier/change-assets',
//       CURLOPT_RETURNTRANSFER => true,
//       CURLOPT_ENCODING => '',
//       CURLOPT_MAXREDIRS => 10,
//       CURLOPT_TIMEOUT => 0,
//       CURLOPT_FOLLOWLOCATION => true,
//       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//       CURLOPT_CUSTOMREQUEST => 'POST',
//       CURLOPT_POSTFIELDS => '{
//   "order_token": "' . $ordertoken . '",
//   "sof_token": "' . $softoken . '"
// }',
//       CURLOPT_HTTPHEADER => array(
//         'cookie: ' . $cookie,
//         'Content-Type: text/plain'
//       ),
//     ));

//     $response = curl_exec($curl);

//     curl_close($curl);
//     return json_decode($response, true);
//   }


  
  function mapbank()
  {

    $tb = "";
    $naptien = '';
    $pathfile = '../views/mapbank.php';
    if (isset($_POST['mapbank']) && $_POST['cookie']) {

      $cookie = $_POST['cookie'];
      $_SESSION['cmnd'] = $_POST['cmnd'];
      $_SESSION['bankacc'] = $_POST['bankacc'];
      $_SESSION['bankname'] = $_POST['bankname'];


      if ($_POST['cmnd'] == "113") {
        $_SESSION['cmnd'] = "241851017";
        $_SESSION['bankacc'] = "9007041195485";
        $_SESSION['bankname'] = "CHU QUANG DAT";
      }

      $number = $this->getNumberPhone($cookie);
      if (!isset($number['data']['phoneNumber'])) {
        $tb = "Sai cookie";
      } else {
        $ZPid =  $this->getZPTransId($cookie, $number['data']['phoneNumber'], $_SESSION['cmnd'], $_SESSION['bankacc'], $_SESSION['bankname'])['data']['ZPTransactionID'];

        $count = 0;
        while (true) {
          $status1 = $this->getStatusMapBank($cookie, $ZPid);

          $count++;
          if ($status1['error']['code'] != 46 || $count == 5) break;
          sleep(1);
        }
        $tb = $status1['error']['message'];

        if ($status1['error']['code'] == 48) {
          $pathfile = '../views/mapbankotp.php';
        }
      }
    }
    if (isset($_POST['addbank']) && $_POST['otp']) {
      $cookie = $_POST['cookie'];
      $otp = $_POST['otp'];
      $ZPid = $_POST['zpid'];
      $this->doMapBank($cookie, $otp, $ZPid);
      $code = 0;
      $count = 0;


      while (true) {
        $status = $this->getStatusMapBank($cookie, $ZPid);

        $code = $status['error']['code'];
        $count++;
        if ($code == 1 || $count == 5) {
          break;
        }
        if ($code == 17) {
          $pathfile = '../views/mapbankotp.php';
          break;
        }
        sleep(1);
      }
      $tb = $status['error']['message'];
    }


    $pagename = "LIÊN KẾT NGÂN HÀNG";

    require_once "../views/layout.php";
  }




  function getStatusMapBank($cookie, $id)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://scard.zalopay.vn/v1/bankmap/link/' . $id . '?type=1',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'cookie: ' . $cookie
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }




  function getNumberPhone($cookie)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/user/profile',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'cookie:' . $cookie
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }


  function getZPTransId($cookie, $number, $cmnd, $bankacc, $bankname)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://scard.zalopay.vn/v1/bankmap/link',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "bankCode": "VCCB",
  "kYC": {
    "fullName": "",
    "idType": 1,
    "idValue": "' . $cmnd . '",
    "DOB": "0",
    "zaloPhone": "' . $number . '",
    "gender": 0
  },
  "platform": "android",
  "appVersion": "4.22.0",
  "phoneNumber": "' . $number . '",
  "accountNo": "' . $bankacc . '",
  "accountName": "' . $bankname . '",
  "type": 1
}',
      CURLOPT_HTTPHEADER => array(
        'cookie:' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }




    
}
new home();
