<div class="row">
<?php
            if (isset($_SESSION['passwordmyweb']) &&  $_SESSION['passwordmyweb'] == 'hts') {

            ?>
    <div class="container-lg col-sm-8">
        <div class="white-box rounded-3">
            <h3 class="box-title  text-center">Danh Sách Số Điện Thoại ( <span id="count" class="text-success"></span> ) </h3>
             
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                            <th class="text-center border-top-0"> 
                                    <input  onkeyup="myFunction2()" id="filter1" class=" btn border-primary text-left" cols="30" rows="3"> 
                               </th>
                                <th class="text-center border-top-0 "><select name="row" id="row" class="btn border-primary">
                                    <option value="250">250</option>
                                    <option value="400">400</option>
                                    <option value="600">600</option>
                                    <option value="800">800</option>
                                    <option value="1000">1.000</option>
                                    <option value="10000">10.000</option>
                                </select></th>
                                <th class="text-center border-top-0"> 
                                    <input  onkeyup="myFunction1()" id="filter" class="note btn border-primary text-left" cols="30" rows="3"> 
                               </th>
                                <th class="text-center border-top-0" >Cookie Hide<input type="checkbox"  class="hidecookie form-check-input ms-2" name="hidecookie" id="hidecookie"></th>
                                <th class="text-center border-top-0">Xoá</th>
                            </tr>
                            
                        </thead>
                        <tbody id="form"> 
                                <!-- <tr class="div-" id="flip">
                                    <input type="hidden" value="" name="">
                                    <td class="sortnum">
                                        <input type="text" readonly class="number_input btn border-success number" name="number" id="number" value="">
                                    </td>

                                    <td class="form-check form-switch   ">
                                        <input type="checkbox"  class="used form-check-input ms-2" name="used" id="used">
                                    </td>
                                    <td class="sortnote">
                                        <textarea name="note" id="note" class="note btn border-success text-left" cols="30" rows="3"> </textarea>
                                    </td>
                                    <td>
                                        <textarea name="cookie" id="cookie" readonly class="cookie btn border-success" cols="30" rows="10"> </textarea>
                                    </td>
                                    <td>
                                        <button class="delete btn btn-outline-primary" name="submit">X</button>
                                    </td>
                                </tr> -->
                            
                        </tbody>

                        
                    </table>
                    <button id="readmore" page="2" class="btn btn-outline-success m-2 w-100" >Xem thêm </button>
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