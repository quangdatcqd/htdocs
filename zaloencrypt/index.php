<?php
$ivDefault = "AAAAAAAAAAAAAAAAAAAAAA==";

try {
      if (isset($_GET["type"])) {


            $type  = $_GET["type"];
            if ($type == 'encode') {
                  $message = $_POST["message"];
                  $key = $_POST["key"];
                  $output = $_POST["output"];
                  $type = isset($_POST["type"]) ? $_POST["type"] : 0;
                  $data =  encryptAES($message, $key, $ivDefault, $output, $type);
                  echo $data;

                  // switch ($action) {
                  //       case 'getserverinfo':

                  //             $imei = $_POST["imei"];
                  //             $computer_name = $_POST["computer_name"];
                  //             $client_version = $_POST["client_version"];
                  //             $sign = getSignKey("getServerInfo", '{"imei":"' . $imei . '","type":24,"client_version":"' . $client_version . '","computer_name":"' . $computer_name  . '"}');
                  //             echo json_encode([
                  //                   'signKey' => $sign
                  //             ]);
                  //             break;
                  //       case 'verifyphone':
                  //             $imei = $_POST["imei"];
                  //             $computer_name = $_POST["computer_name"];
                  //             $client_version = $_POST["client_version"];
                  //             $phone_number = $_POST["client_version"];
                  //             $zcid = $_POST["zcid"];
                  //             $zcid_ext = $_POST["zcid_ext"];
                  //             $key = getKey($zcid, $zcid_ext);

                  //             $param =  '{"imei":"' .  $imei . '","phone_num": "' . $phone_number . '","iso_code":"VN","active_type":1,"computer_name":" ' . $computer_name . '"}';
                  //             $paramEncrypt = encryptAES($param, $key, $ivDefault, "base64");
                  //             $paramUrlencode = urlencode($paramEncrypt);
                  //             $sign = getSignKey("verifyPhone",  '{"zcid":"' . $zcid . '","zcid_ext":"' . $zcid_ext . '","enc_ver":"v2","params":" ' . $paramEncrypt . '","type":24,"client_version":"' . $client_version . '"}');
                  //             echo json_encode([
                  //                   'signKey' => $sign,
                  //                   'param' => $paramUrlencode,
                  //                   'key' => $key
                  //             ]);
                  //             break;
                  // }
            } else {
                  $message = $_POST["message"];
                  $key = $_POST["key"];
                  $type = isset($_POST["type"]) ? $_POST["type"] : 0;
                  $data =  decryptAES($message, $key, $ivDefault,  $type);
                  echo $data;
            }
      }
} catch (Exception $ex) {
}





function base64_decoded($input)
{
      $data = base64_decode($input);
      return utf8_encode($data);
}

// fNXfkUDycx2M6ydSPBAo2w ==

function decryptAES($cipherData, $key, $ivString, $type = 0)
{
      $ivString = base64_decode($ivString);

      $iv = mb_convert_encoding($ivString, 'UTF-8');
      $enc = "AES-256-CBC";
      if ($type == 1) {
            $key =  base64_decode($key);
            $enc = 'AES-128-CBC';
      }
      try {
            $decryptedData = openssl_decrypt(base64_decode($cipherData), $enc, $key, OPENSSL_RAW_DATA, $iv);

            return $decryptedData;
      } catch (Exception $e) {
            echo 'A Cryptographic error occurred: ' . $e->getMessage();
            return '';
      }
}
function encryptAES($message, $KeyString, $IVString, $output, $type = 0)
{
      $ivString = base64_decode($IVString);
      $enc = 'AES-256-CBC';


      if ($type == 1) {
            $KeyString =  base64_decode($KeyString);
            $enc = 'AES-128-CBC';
      }

      $encrypted = null;
      try {
            $ciphertext = openssl_encrypt($message, $enc, $KeyString, OPENSSL_RAW_DATA, $ivString);
            if ($output == "hex") {
                  $encrypted = bin2hex($ciphertext);
            } else {
                  $encrypted = base64_encode($ciphertext);
            }
      } catch (Exception $e) {
            echo "An error occurred: {$e->getMessage()}";
            return "";
      }
      return $encrypted;
}


function randomStr($length)
{
      $chars = "abcdefghijklmnopqrstuvwxyz";
      $str = "";
      for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, strlen($chars) - 1)];
      }
      return $str;
}


function milliseconds()
{
      $timeUtc = new DateTime("now", new DateTimeZone("UTC"));
      $cstZone = new DateTimeZone("Asia/Ho_Chi_Minh");
      $cstTime = $timeUtc->setTimezone($cstZone);
      $epoch = new DateTime("1970-01-01 00:00:00", new DateTimeZone("UTC"));
      $elapsedTime = $cstTime->getTimestamp() - $epoch->getTimestamp();
      return ($elapsedTime * 1000) - (3600000 * 7);
}


function generator_uuid()
{
      while (true) {
            $guid = sprintf(
                  '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                  mt_rand(0, 0xffff),
                  mt_rand(0, 0xffff),
                  mt_rand(0, 0xffff),
                  mt_rand(0, 0x0fff) | 0x4000,
                  mt_rand(0, 0x3fff) | 0x8000,
                  mt_rand(0, 0xffff),
                  mt_rand(0, 0xffff),
                  mt_rand(0, 0xffff)
            );
            $four = substr($guid, 14, 1);
            $ab89 = substr($guid, 19, 1);
            if ($four != '4') continue;
            if ($ab89 != 'a' && $ab89 != 'b' && $ab89 != '8' && $ab89 != '9') continue;
            return $guid;
      }
}
function generator_imei()
{
      $uuid =  generator_uuid();
      $arrayUuid = explode("-", $uuid);
      $imei = $uuid . '-' . md5Encode($arrayUuid[0] . $arrayUuid[2] . $arrayUuid[4]);
      return $imei;
}

function generator_Zcid($imei)
{
      global $ivDefault;

      $seconds = milliseconds();
      $loginInfo = "30," . $imei . "," . $seconds;
      $zcid = strtoupper(encryptAES($loginInfo, "3FC4F0D2AB50057BCE0D90D9187A22B1", $ivDefault, "hex"));
      return $zcid;
}



function md5Encode($input)
{
      return strtolower(md5($input));
}

function x2Array($arrInput)
{
      $arr = array();
      $arr[0] = array();
      $arr[1] = array();
      for ($i = 0; $i < count($arrInput); $i++) {
            if ($i % 2 == 0) {
                  array_push($arr[0], $arrInput[$i]);
            } else {
                  array_push($arr[1], $arrInput[$i]);
            }
      }
      return $arr;
}

function getKey($zcid, $zcid_ext)
{
      $zcidArr = str_split($zcid);
      $zcidArrx2 = x2Array($zcidArr);
      $zcidArrx2[1] = array_reverse($zcidArrx2[1]);
      $key1 = implode("", array_slice($zcidArrx2[0], 0, 12));
      $key2 = implode("", array_slice($zcidArrx2[1], 0, 12));

      $md5_zcid_ext = strtoupper(md5Encode($zcid_ext));
      $md5_zcidArr = str_split($md5_zcid_ext);
      $md5_zcidArrx2 = x2Array($md5_zcidArr);
      $key3 = implode("", array_slice($md5_zcidArrx2[0], 0, 8));

      $key = $key3 . $key1 . $key2;
      return $key;
}

function getSignKey($type, $param)
{
      $oData = json_decode($param);
      if (is_null($oData)) {
            return '';
      }

      $arrKey = array_keys((array)$oData);
      sort($arrKey);

      $sign = 'zsecure' . strtolower($type);
      foreach ($arrKey as $key) {
            $sign .= $oData->{$key};
      }

      return md5Encode($sign);
}

// $phonenumFogot = "0352402200";
// $zcid_ext = randomStr(12);
// $imei = generator_imei();
// $zcid  = generator_Zcid($imei);
// $computer_nameFogot = "DESKTOP-" . strtoupper(randomStr(7));
// $key = getKey($zcid, $zcid_ext);

// $param = '{"imei":"' . $imei . '","phone_num":"' . $phonenumFogot . '","iso_code":"VN","active_type":1,"computer_name":"' . $computer_nameFogot . '"}';
// $paramEncrypt = encryptAES($param, $key, $ivDefault, "base64");
// $paramUrlencode = urlencode($paramEncrypt);
// $sign = getSignKey("getActiveCodeBySms", '{"zcid":"' . $zcid . '","zcid_ext":"' . $zcid_ext . '","enc_ver":"v2","params":"' . $paramEncrypt . '","type":24,"client_version":"224"}');
// $url =  "https://wpa.chat.zalo.me/api/register/getActiveCodeBySms?zcid={$zcid}&zcid_ext={$zcid_ext}&enc_ver=v2&params={$paramUrlencode}&type=24&client_version=224&signkey={$sign}";



// // Initialize curl
// $curl = curl_init();

// // Set curl options
// curl_setopt_array($curl, array(
//       CURLOPT_URL => $url,
//       CURLOPT_RETURNTRANSFER => true,
//       CURLOPT_ENCODING => "",
//       CURLOPT_MAXREDIRS => 10,
//       CURLOPT_TIMEOUT => 0,
//       CURLOPT_FOLLOWLOCATION => true,
//       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//       CURLOPT_CUSTOMREQUEST => "GET",
//       CURLOPT_HTTPHEADER => [
//             "Connection: keep-alive",
//             "Accept: application/json, text/plain, /",
//             "Sec-Fetch-Dest: empty",
//             "User-Agent: ZaloPC-win32-24v224",
//             "Sec-Fetch-Mode: gzip, deflate, br",
//             "Accept-Language: en-US"
//       ]
// ));

// // Execute curl request
// $response = curl_exec($curl);

// // Check for errors
// if (curl_errno($curl)) {
//       echo "cURL Error: " . curl_error($curl);
//       exit;
// }

// curl_close($curl);


// // echo  json_decode($response, true)["data"] . "\n";
// // echo $zcid . "\n";
// echo $response;
