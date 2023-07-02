<?php
class restAPIFunc
{
    public function __construct()
    {
    }





    // ++===================================================== CHECK VOUCHER ========================================================++


    // CHECK VOUCHER chơi lì xì
    function checkvc($h5cookie)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://uudai.zalopay.vn/scissorsrock/api/get-info',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'cookie: ' . $h5cookie
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $st =  json_decode($response, true)["message"];
        if ($st == "Successfully") return 1;
        else return 0;
    }




    //CHECK VOUCHER BAEMIN 
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
                'cookie: ' . $cookie,
                'content-type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }










    //++++++++++++++++++++++++++++++++++++++++++++++++ CHO THUÊ SIM CODE ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    // REST Số tiền bên cho thuê sim code
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
    } //END REST



    // REST Số code trả về bên cho thuê sim code
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



    // REST Số điện thoại bên cho thuê sim code
    function getphone($api)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://chothuesimcode.com/api?act=number&apik=' . $api . '&appId=1176',
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



    //REST huỷ số thuê
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









    //++++++++++++++++++++++++++++++++++++++++++++++++ OTP SIM ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


    // REST số tiền bên otp sim 
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
    } //END REST




    // REST số code trả về bên otp sim 
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


    // REST số code trả về bên otp sim 
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





    // ++======================================================= ZALO API===============================================================++




    function getfriends2($tokenh5)
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




    function getfriends1($tokenh5)
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









    //++===================================================== ZALOPAY API ===================================================================++


    // Gửi yêu cầu  OTP về điện thoại
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


    // CHECK COI SỐ NÀY ĐKÍ ZALOPAY CHƯA
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


    // submit otpCODE nhận đưỢc sim 
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


    // CHECK COI Thằng này đã có zalopay chưa
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



    // Tạo mật khảu cho zalo pau
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



    





}
new restAPIFunc();
