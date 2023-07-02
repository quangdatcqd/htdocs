<div class="h-100 row pb-5  ">
    <div class="col-md-6 col-lg-6 pb-5 h-100 col-sm-6 container  mt-3">

        <div class="bg-dark h-100 p-4">




        <form action="/zalo/mapbank/" method="post">
        <div class="mb-3">
          <label for="otp" class="form-label text-light mb-0">Nhập OTP TIMO</label>
          <input type="text" class="form-control" id="otp" autofocus placeholder="Nhập OTP" name="otp">
        </div>
        <input type="hidden" name="zpid" value="<?= $ZPid ?>">
        <input type="hidden" name="cookie" value="<?= $cookie ?>">
        <button type="submit" name="addbank" class="btn btn-primary w-100 mt-3">Thêm</button>
      </form>
        </div>

        <div class="mt-2 pb-5 text-light text-center">
            <h2 class="text-light">THÔNG TIN</h2>
            <h3><?=$tb?></h3>
        </div>

    </div>
</div>