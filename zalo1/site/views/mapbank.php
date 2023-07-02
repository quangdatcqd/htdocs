<div class="h-100 row pb-5">
    <div class="col-md-6 col-lg-6 pb-5 h-100 col-sm-6 container  mt-3">

        <div class="bg-dark h-100 p-4">




            <form action="/zalo/mapbank/" method="post">
                <div class="mb-3">
                    <label for="Cookie" class="form-label text-light mb-0">Cookie</label>
                    <input type="text" class="form-control" id="Cookie" autofocus placeholder="Nhập Cookie" name="cookie"> 
                </div> 
                <div class="mb-3">
                    <label for="cmnd" class="form-label text-light mb-0">Số CMND</label>
                    <input type="tel" class="form-control" id="cmnd" autofocus placeholder="Nhập CMND" value="<?php if(isset($_SESSION['cmnd'])) echo $_SESSION['cmnd'] ?>" name="cmnd"> 
                </div> 
                <div class="mb-3">
                    <label for="bankacc" class="form-label text-light mb-0">Số Thẻ</label>
                    <input type="tel" class="form-control" id="bankacc" autofocus placeholder="Nhập Số Thẻ" value="<?php if(isset($_SESSION['bankacc'])) echo $_SESSION['bankacc'] ?>"  name="bankacc"> 
                </div> 
                <div class="mb-3">
                    <label for="bankname" class="form-label text-light mb-0">Tên Thẻ (Viết In hoa, có dấu cách, không dấu)</label>
                    <input type="text" class="form-control" id="bankname" autofocus placeholder="Nhập Tên Thẻ" value="<?php if(isset($_SESSION['bankname'])) echo $_SESSION['bankname'] ?>"  name="bankname"> 
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
                <button type="submit" name="mapbank" class="btn btn-primary w-100 mt-3">Thêm</button>
            </form>
        </div>

        <div class="mt-2 pb-5 text-light text-center">
            <h2 class="text-light">THÔNG TIN</h2>
             <h3><?=$tb?></h3>
             <h3><?=$naptien?></h3>
        </div>

    </div>
</div>