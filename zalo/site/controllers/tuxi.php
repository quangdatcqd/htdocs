<button onclick=vip()>coppy</button>
<?php


$datacop = null;
foreach ($data as $item) {
    $datacop += '   |  ' . utf8_decode($item['name']);
}

$datacop += '   |     ==> TỔNG: ' . count($data);
echo $datacop;

?>
<input type="hidden" id="data" value="<?= $datacop ?>">

<script>
    function vip() {
        e.preventDefault();
        number = document.querySelector("#data").nodeValue;

        number.select();
        number.setSelectionRange(0, 99999)
        document.execCommand("copy");
        console.log(number);


    };
</script>