<div class="row">
    <?php
    if (isset($_SESSION['passwordmyweb']) &&  $_SESSION['passwordmyweb'] == 'hts') {

    ?>
        <style>
            .td-update-box {
                position: relative;
                cursor: pointer;
            }

            .td-update-box:hover .div-update-device {
                display: block;
            }

            .div-update-device {
                bottom: 0px;
                left: -87px;
                height: auto;
                position: absolute;
                display: none;

            }

            .div-update-device p {
                margin: 0;
                text-align: center;
                align-items: center;
                background-color: #0599ea;
                padding: 3px 10px;
                border-radius: 10px;
                margin-top: 1px;

            }

            .div-update-device p a {
                color: white;
            }

            .div-update-device p:hover {
                background-color: #422fff;
                color: red;

            }

            .td-editname {
                position: relative;
                /* display: none; */
            }

            .td-editname:hover .div-boxedit {
                display: block;
            }

            .div-boxedit {
                right: 20px;
                bottom: 40px;
                position: absolute;
                padding: 10px;
                border-radius: 6px;
                background-color: #70d2ff;
            }

            .div-boxedit input {
                width: 150px;
                outline: #ffa700 1px solid;
                border-radius: 10px;
                border: #0599ea 1px solid;
            }

            .div-boxedit button {
                outline: #ffa700 1px solid;
                border-radius: 10px;
                border: #0599ea 1px solid;
                background-color: #ffa700;
                color: white;
            }

            .div-boxedit button:hover {
                background-color: #c38000;
                color: white;
            }
        </style>
        <div class="container-lg col-sm-8">
            <div class="white-box rounded-3">
                <h3 class="box-title  text-center">Danh Sách thiết bị ( <span id="count" class="text-success"></span> ) </h3>

                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center border-top-0">ID</th>
                                <th class="text-center border-top-0">ID Thiết bị</th>
                                <th class="text-center border-top-0">Tên</th>
                                <th class="text-center border-top-0">Trạng Thái</th>
                                <th class="text-center border-top-0">Xoá</th>
                            </tr>

                        </thead>
                        <tbody id="form">
                            <?php
                            foreach ($data as $key => $value) {

                                $status = "Chưa cho phép";
                                if ($value["status"] == "1") $status = "Đã cho phép";
                                else if ($value["status"] == "0") $status = "Chưa cho phép";
                                else $status = "Đã khoá";

                            ?>
                                <tr>
                                    <td><?= $value["id"] ?></td>
                                    <td><?= $value["device_id"] ?></td>
                                    <td class="td-editname">
                                        <?= $value["note"] ?>
                                        <div class="div-boxedit">
                                            <form action="/zalo/update-devicename/" method="get">
                                                <input type="text" name="name" class="input-decvicename">
                                                <button>Lưu</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="td-update-box"><?= $status ?>
                                        <div class="div-update-device">
                                            <p> <a href="/zalo/update-device/<?= $value["id"] ?>/0">Chưa cho phép</a></p>
                                            <p><a href="/zalo/update-device/<?= $value["id"] ?>/1">Cho phép</a></p>
                                            <p><a href="/zalo/update-device/<?= $value["id"] ?>/2">Khoá</a></p>
                                        </div>
                                    </td>
                </div>
                </td>
                <td><a href="/zalo/delete-device/<?= $value["id"] ?>" onclick="return confirm('Có chắc là muốn xoá?');">Xoá</a></td>
                </tr>
            <?php
                            }

            ?>
            </tbody>


            </table>

            </div>

        </div>
</div>
<?php

    } else {

?>

    <div class="container bg-dark col-sm-4 mt-5 p-5">
        <form method="post" action="/zalo/site/controllers/home.php?act=login" class=" ">
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label    btn btn-dark  w-100">Nhập Mật khẩu</label>
                <input type="password" class="form-control" name="password" placeholder="Mật khẩu" id="exampleInputPassword1">
            </div>

            <button type="submit" name="dangnhap" class="btn btn-danger text-light w-100">Đăng Nhập</button>
        </form>
    </div>

<?php
    }

?>
</div>