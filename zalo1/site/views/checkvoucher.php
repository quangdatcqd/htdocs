<div class="h-100 row pb-5">
    <div class="col-md-6 col-lg-6 pb-5 h-100 col-sm-6 container">

        <div class="bg-dark h-100 p-4">




            <form action="/zalo/submit-check-vc/" method="post">
                <div class="mb-3">
                    <label for="Cookie" class="form-label text-light mb-0">Cookie</label>
                    <input type="text" autofocus class="form-control" id="Cookie" placeholder="Nhập Cookie" name="cookie">

                </div>
                <div class="mb-3">
                    <label for="sdt" class="form-label mb-0 text-light">Số Điện Thoại</label>
                    <input type="number" class="form-control" id="sdt" name="sdt" placeholder="Nhập sdt" aria-describedby="sdt">

                </div>
                <div class="row">
                    <div class="  col-sm-6">
                        <label for="api" class="form-label mb-0 text-light">API Key</label>
                        <input type="text" class="form-control" id="api" name="api" placeholder="Nhập api" value="<?php if (isset($_SESSION['api'])) echo $_SESSION['api'];
                                                                                                                    else echo ''; ?>" aria-describedby="api">

                    </div>

                    <div class="form-check form-switch m-0 col-sm-4 d-flex align-items-center justify-content-center">
                        <input class="form-check-input pe-auto " type="checkbox" name="addzlp" <?= $_SESSION['check'] ?> id="addzlp">
                        <label class="form-check-label  text-light mt-3 ms-2 pe-auto" for="addzlp"> Add Zalopay</label>
                    </div>
                    <div class="form-check form-switch m-0 col-sm-4 d-flex align-items-center justify-content-center">
                        <input class="form-check-input pe-auto " type="checkbox" name="CP" <?= $_SESSION['CP'] ?> id="CP">
                        <label class="form-check-label  text-light mt-3 ms-2 pe-auto" for="CP"> Check BigC</label>
                    </div>
                    <div class="form-check form-switch m-0 col-sm-4 d-flex align-items-center justify-content-center">
                        <input class="form-check-input pe-auto " type="checkbox" name="CM" <?= $_SESSION['CM'] ?> id="CM">
                        <label class="form-check-label  text-light mt-3 ms-2 pe-auto" for="CM"> Check Co.opM</label>
                    </div>
                    <div class="form-check form-switch m-0 col-sm-4 d-flex align-items-center justify-content-center">
                        <input class="form-check-input pe-auto " type="checkbox" name="bm" <?= $_SESSION['bm'] ?> id="bm">
                        <label class="form-check-label  text-light mt-3 ms-2 pe-auto" for="bm"> Check Baemin</label>
                    </div>


                </div>

                <button type="submit" name="check" class="btn btn-primary w-100 mt-3">Kiểm Tra</button>
            </form>
        </div>

        <div class="mt-2 pb-5 text-light text-center">
            <h2 class="text-light">THÔNG TIN</h2>
            <h3 class="text-danger"><?= $err ?></h3>
            <?php
            if (isset($family)) {
            ?>
                <h3 class="">TỔNG SỐ BẠN BÈ: <span class="text-success"> "<?= $tong ?>"</span> </h3>

                <?= $family ?>
                <?= $bigc ?>
                <?= $baemin ?>
                <?= $addzalopay ?>
                <?= $coop ?>
                <h3 class="text-warning">LIST VOUCHER</h3>
                <?= $ls ?>

            <?php } ?>
        </div>

    </div>
</div>