<?php session_start(); ?>
<style>
    #sdt {
        width: 100%;
        margin-top: 5px;
        border-radius: 10px;
        padding: 10px;
        border: solid 4px #9df99d;
        font-size: 30pt;
        outline: none;
    }

    #pass {
        margin-top: 10px;
        width: 100%;
        border-radius: 10px;
        padding: 10px;
        border: solid 4px #9df99d;
        font-size: 30pt;
        outline: none;

    }

    #submit {
        margin-top: 10px;
        border-radius: 10px;
        padding: 10px;
        border: solid 4px #9df99d;
        font-size: 30pt;
        width: 50%;
        background-color: greenyellow;
        color: red;
        cursor: pointer;
    }
</style>
<div style="width: calc(100% - 40px); padding: 5px 20px;">

    <form action="" style="width: 100%; text-align: center;" method="post">
        <input type="text" id="sdt" placeholder="SỐ ĐIỆN THOẠI" value="<?= (isset($_POST["sdt"])) ? $_POST["sdt"] : "" ?>" name="sdt">
        <input type="text" id="pass" placeholder="MẬT KHẨU" value="cqd113" name="pass">
        <button type="submit" id="submit">ĐỔI SĐT</button>
    </form>


</div>



<?php
try {

    if (isset($_POST["sdt"])) {
        $sdt = $_POST["sdt"];
        $pass = $_POST["pass"];

        $dataLogin = goLogin($sdt, $pass);
        $usname = $dataLogin['user']['id'];
        $token = $dataLogin['token'];
        if ($token != "") {
            a:
            while (true) {
                $phonevdata = json_decode(getPhoneV(), true);
                $phonev = $phonevdata['data']['re_phone_number'];
                $vid = $phonevdata['data']['request_id'];
                $checkphonev = checkPhoneV($phonev);


                if ($checkphonev == 1) {
                    break;
                }
            }

            $tokenC = requestOTP($phonev);
            if ($tokenC != null) {
                $i = 0;
                while (true) {

                    try {
                        $vOtp = getCodePhoneV($vid);
                        if ($vOtp != null) {

                            $tokenC = verOTP($vOtp, $tokenC);
                            changePhone($token, $tokenC, $phonev, $usname);
                            break;
                        } else {
                            sleep(1);
                            $i++;
                            if ($i >= 10) goto a;
                        }
                    } catch (Exception $er) {
                        break;
                    }
                }
            }
        }
    }
} catch (Exception $err) {
}

function changePhone($token, $tokenC, $phone, $usname)
{


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.baemin.vn/v3/users/' . $usname,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => 'phone=' . $phone . '&provider=local&uid=' . $tokenC,
        CURLOPT_HTTPHEADER => array(
            'x-access-token:' . $token,
            'user-agent: okhttp/3.12.12',
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    echo '<br>
    <div style="font-size: 20pt; font-weight: bold; color: red;">
        ==> Đổi SĐT: 
        <span style="font-size: 17pt; font-weight: bold; color: green;">' . $response . '</span>
    </div>';
}

function verOTP($otp, $tokenC)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.baemin.vn/v3/notifications/verify-otp',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'requestToken=' . $tokenC . '&otpCode=' . $otp,
        CURLOPT_HTTPHEADER => array(
            'user-agent: okhttp/3.12.12',
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);
    echo '<br>
    <div style="font-size: 20pt; font-weight: bold; color: red;">
        ==> SUBMIT OTP: 
        <span style="font-size: 17pt; font-weight: bold; color: green;">' . $response . '</span>
    </div>';
    curl_close($curl);
    return json_decode($response, true)["token"];
}

function requestOTP($sdt)
{


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.baemin.vn/v3/notifications/request-otp',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'phone=' . $sdt,
        CURLOPT_HTTPHEADER => array(
            'user-agent: okhttp/3.12.12',
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);
    echo '<br>
    <div style="font-size: 20pt; font-weight: bold; color: red;">
        ==> YC OTP: 
        <span style="font-size: 17pt; font-weight: bold; color: green;">' . $response . '</span>
    </div>';
    curl_close($curl);
    return json_decode($response, true)["token"];
}


function getCodePhoneV($id)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.viotp.com/session/getv2?requestId=' . $id . '&token=6da02b69278e49ce8d7b6d51b4e8d56d',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    echo '<br>
    <div style="font-size: 20pt; font-weight: bold; color: red;">
        ==> YC VIOTP: 
        <span style="font-size: 17pt; font-weight: bold; color: green;">' . $response . '</span>
    </div>';
    curl_close($curl);
    return json_decode($response, true)["data"]["Code"];
}

function getPhoneV()
{


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.viotp.com/request/getv2?token=6da02b69278e49ce8d7b6d51b4e8d56d&serviceId=332',
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
    echo '<br>
    <div style="font-size: 20pt; font-weight: bold; color: red;">
        ==> Lấy SĐT VIOTP: 
        <span style="font-size: 17pt; font-weight: bold; color: green;">' . $response . '</span>
    </div>';
    return $response;
}


function checkPhoneV($sdt)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.baemin.vn/v3/auth/users/check?phone=' . $sdt,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'user-agent: okhttp/3.12.12'
        ),
    ));

    $response = curl_exec($curl);
    echo '<br>
    <div style="font-size: 20pt; font-weight: bold; color: red;">
        ==> CHECK SĐT VOTP: 
        <span style="font-size: 17pt; font-weight: bold; color: green;">' . $response . '</span>
    </div>';
    curl_close($curl);
    $res = json_decode($response, true)["result"];
    if ($res == "NON_EXISTS") return 1;
    else return 0;
}

function goLogin($sdt, $pass)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.baemin.vn/v3/auth/users/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'phone=' . $sdt . '&password=' . $pass,
        CURLOPT_HTTPHEADER => array(
            'user-agent: okhttp/3.12.12',
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo '<br>
    <div style="font-size: 20pt; font-weight: bold; color: red;">
        ==> ĐĂNG NHẬP: 
        <span style="font-size: 17pt; font-weight: bold; color: green;">' . $response . '</span>
    </div>';
    return json_decode($response, true);
}


?>