
<div class="h-100 row ">
    <div class="col-md-12 col-lg-12 h-100 col-sm-12">

        <div class="bg-dark h-100 p-4">

        
            <div class="topbar mb-1 p-0" data-navbarbg="skin5">

                <nav class="navbar  top-navbar navbar-expand-md navbar-dark">


                    <div class="navbar-collapse d-flex align-items-center   " id="navbarSupportedContent" data-navbarbg="skin5">
                        

                        <ul class="navbar-nav   " id="panel">


                            <li class="  ps-2 in">
                                <form action="/zalo/submit-fr/" method="post" class="d-flex">
                                    <input class="form-control rounded-pill me" autofocus type="search" name="sdt" id="v" onkeyup="findfriend()"  placeholder="Nhập Số Điện Thoại" aria-label="Search">
                                    <button class="btn btn-success rounded-circle" name="lay" type="submit">Lấy</button>
                                </form>

                            </li>



                        </ul>

                         
                    </div>
                </nav>
            </div>

            <p class="text-light m-0   text-center"><a href="/zalo/submit-fr-decode/" class="text-danger">Mã hoá</a> | Tổng ( <span class="text-success"> <?=number_format(count($friends))?> </span> ) <span id="findh"> </span></p>
            <div class="row" id="mydiv0">
            <?php
            if(isset($_GET['type']) && $_GET['type'] =='decode' ){
                foreach ($friends as $fr) {
                     
 
            ?>
                 
                <div class="col-4 col-sm-2 my-2 border-bottom  border-light py-2 div-hide" id="mydiv1">
                    <div class="card mb-0 bg-dark  " id="mydiv2">
                        <img src="<?= $fr['image'] ?>" class="rounded-circle card-img-top" alt="...">
                        <div class="p-0 name_sort  bg-dark card-body">
                            <p class="card-text text-center text-light fw-bold"><?= $fr['name'] ?></p>
                        </div>
                    </div>
                </div> 
            <?php 
            
                }
               
             }else { 
                foreach ($friends as $fr) {
                    if($fr['name'] == 'Tài khoản bị khóa'  ) ;
                        else{
 
            ?>

                <div class="col-4 col-sm-2 my-2 border-bottom  border-light py-2 div-hide" id="mydiv1">
                    <div class="card mb-0 bg-dark " id="mydiv2">
                        <img src="<?= $fr['image'] ?>" class="rounded-circle card-img-top" alt="...">
                        <div class="p-0 name_sort  bg-dark card-body">
                            <p class="card-text text-center text-light fw-bold"><?= utf8_decode($fr['name']) ?></p>
                        </div>
                    </div>
                </div> 
                    
            <?php 
            }
                }

            }
            ?>
                
            </div>

        </div>
    </div>
</div>
