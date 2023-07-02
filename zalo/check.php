<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <textarea type="text" name="code" placeholder="Nhập code"></textarea> <br>

        <select name="kv" id="">
            <option selected value="4">PE Hồ Chí Minh</option>
            <option value="3">PA Miền Bắc</option>
            <option value="5">PK Miền Nam</option>
            <option value="1">PC Miền Trung</option>
            <option value="2">PD Hà Nội</option>
        </select>
        <button type="submit">Check</button>
    </form>


    <style>
    body {
        font-family: sans-serif;
    }
        form {
            width: calc(100% - 20px);
            padding: 10px;
        }
        div{
            border: 2px solid yellowgreen;
            padding: 7px;
        }
        h3{
            margin: 0px;
        }
        textarea{

            width: calc(100% - 14px);
}
        textarea,
        button ,select{
            padding: 7px;
            border-radius: 3px;
            resize: none;
            border: 2px solid yellowgreen;

        }

        li {
            font-weight: bold;
           
        }

        span {
            color: green;
        }
        .tred{
            color: red;
            font-weight: bold;
            font-size: 14pt;
        }
    </style>
    <?php
    
    if (isset($_POST['code'])) {
        $code = $_POST['code'];
        $kv = $_POST['kv']; 
        $regex = '';
        
        switch($kv){
            case 1: {
                $regex = '/[A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{7}/';
                break;
            }
            case 2: {
                $regex = '/[PD]{2}[0-9]{11}/';
                break;
            }
            case 3: {
                $regex = '/[PA]{2}[0-9]{11}/';
                break;
            }
            case 4: {
                $regex = '/[PE]{2}[0-9]{11}/';
                break;
            }
            case 5: {
                $regex = '/[PK]{2}[0-9]{11}/';
                break;
            }
            default:{

                break;
            } 
        }
        
        $arr = [];
        preg_match_all($regex, $code, $arr);

        foreach ($arr[0] as $row) {
            
           echo ' <div> <h3>Mã HĐ: <span>'. $row.'</span></h3> <span class="tred">'. getInfo($row,$kv) .'</span> </div><br>';

        }
        
    }

    function getInfo($code,$id)
    {
        $err = '';
        $cty = '';
        $dola = 0;
        $name = ''; 
        $html ='';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sapi.zalopay.vn/v1/billing/add-bill?appID=17&supplierID='.$id.'&customerCode=' . $code . '&isRemainCustomer=0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'cookie: h5token=b435f3e33e86608d2a82b31a333363269DE6qMrShP8Rq6kLUVUlVp4aW8EmbhL1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response, true);
        sleep(1);
        if ($data['error']['code'] == 0) {
            $cty = $data['data']['supplierName'];
            $dola = $data['data']['bills'][0]['amount'];
            $name = $data['data']['bills'][0]['customerName'];
            $html = '<ul>
            <li>KV: <span>'. $cty .'</span></li>
            <li>KH: <span>'.$name.'</span></li>
            <li>Tiền TT: <span>'. number_format($dola) .'</span> đ</li>
            
        </ul>';
        } else if ($data['error']['code'] == -700) {
            $html =  "Chưa Tới Kỳ Thanh Toán Mới!";
        } else  $html = 'Sai Mã Hợp Đồng!';
        return $html;
    }
    ?>
    <script>
        
       setTimeout(() => {
        var myobj = document.querySelector("body > div:last-child");
myobj.remove();
       }, 1000);
    </script>
</body>

</html>