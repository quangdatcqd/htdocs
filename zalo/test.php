<?php


$text = "chào mừng các bạn đến với trang web chúng tôi";
$text1 = "chào mừng các bạn đến với trang web chúng tôi";
if (isset($_POST['text']) && $_POST['text'] != "") $text = $_POST['text'];


// $text = strip_tags($text);  
// if (strlen($text) >= 20) {  
   
//     $strCut = substr($text,0,50);  
   
//     $text = substr($strCut, 0, strrpos($strCut, ' '));  

//     $strCut1 = substr($text,0,50);  
//     $text1 = substr($strCut1, 0, strrpos($strCut1, ' '));  
//     echo strlen($text).",".strlen($text1);
    
// }

function getAudio($text)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.zalo.ai/v1/tts/synthesize',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'input=' . urlencode($text) . '&speed=1&encode_type=1&speaker_id=1',
        CURLOPT_HTTPHEADER => array(
            'apikey: NOaWwaO7JD45eALMnjCgoaHlVL93CfqP',
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true)['data']['url'];
     
}

$data = getAudio($text);
$data1 = getAudio($text1);
sleep(1);
 

?>
<style>
    textarea {
        width: 100%;
        border-color: greenyellow;
        outline: greenyellow;
        color: blue;
    }

    button {
        width: 100px;
        background-color: red;
        color: white;
        border-color: red;
        cursor: pointer;
        margin: 10px 0px;
        height: 35px;
        outline: none;
    }

    h1 {
        margin-top: 10px;
        color: blue;
        font-family: 'Courier New', Courier, monospace;
    }

    p {
        color: red;
        font-weight: bolder;
    }
</style>
<center>
    <h1>Nhập văn bản chuyển giọng nói</h1>
    <p>( Tối đa 2000 Ký tự )</p>
    <form action="" method="post">
        <textarea name="text" id="" cols="30" rows="10"></textarea>
        <button type="submit" style="border-radius: 30px;">Convert</button> <br>
    </form>
    <audio controls="" id="audio"   onended="nextAudioNode()">
        <source src="<?= $data ?>" type="audio/mp3">
    </audio>
    <audio controls="" id="d">
        <source src="<?= $data1 ?>" type="audio/mp3">
    </audio>
</center>
 <script>
     function nextAudioNode(){
         var btn = document.getElementById("d");
         btn.play();
     }
 </script>