<div class="h-100 row pb-5">
    <div class="col-md-6 col-lg-6 pb-5 h-100 col-sm-6 container">

        <div class="bg-dark h-100 p-4">




            <form action="/zalo/bigc-check/" method="post">
                <div class="mb-3">
                    <label for="Cookie" class="form-label text-light mb-0">Cookie</label>
                    <input type="text" autofocus class="form-control" id="Cookie" placeholder="Nhập Cookie" name="cookie"> 
                </div> 
                <button type="submit" name="check" class="btn btn-primary w-100 mt-3">Kiểm Tra</button>
            </form>
        </div>

        <div class="mt-2 pb-5 text-light text-center">
            <h2 class="text-light">THÔNG TIN</h2>
          
            <?php
            if (isset($bigc)) {
            ?> 
                <h3 class="">BIG-C K: <?= $bigc ?></h3>
              
         
                <h3 class="text-warning">LIST VOUCHER</h3>
                <?= $ls ?>

            <?php } ?>
        </div>

    </div>
</div>