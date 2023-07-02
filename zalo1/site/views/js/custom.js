$(function () {
    "use strict";

    $(".preloader").fadeOut();
    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on('click', function () {
        $("#main-wrapper").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
    });
    $(".search-box a, .search-box .app-search .srh-btn").on('click', function () {
        $(".app-search").toggle(200);
        $(".app-search input").focus();
    });

    // ============================================================== 
    // Resize all elements
    // ============================================================== 
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();

    //****************************
    /* This is for the mini-sidebar if width is less then 1170*/
    //**************************** 
    var setsidebartype = function () {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        if (width < 1170) {
            $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        } else {
            $("#main-wrapper").attr("data-sidebartype", "full");
        }
    };
    $(window).ready(setsidebartype);
    $(window).on("resize", setsidebartype);

});

// get phone number


$(document).ready(function () {
    $("body > div:nth-child(4)").hide();
    // $("#hidde").hide("fast");
    // $("#panel").show("fast");
    // $("#flip").click(function() {
    //     if ($("#panel").is(":hidden")) {
    //         $("#panel").show("fast");
    //         $("#hidde").hide("fast");
    //     } else {
    //         $("#hidde").show("fast");
    //         $("#panel").hide("fast");
    //     }
    
    // });
$("#hidecookie").click(function(){
   if($(this).is(":checked"))  $(".cookie").hide();
   else  $(".cookie").show();
  
});
 

    
    // var  consd = [];
    // $(window).scroll(function() { 
    //         if($(window).scrollTop() + $(window).height() > $(document).height()-50 ) {
              
    //             var page  = $("#readmore").attr("page");
    //             cons = page;
    //             var totalpage = $("#readmore").attr("totalpage");
    //             if(parseInt(page) <= parseInt(totalpage)){
                     
    //                 showphone(page);
    //             } 
                
    //         }
        
    //  });
    var limit = 250;
     $("#readmore").click(function(){
        limit = $("#row").val();
        var page  = $("#readmore").attr("page");
        // cons = page;
        var totalpage = $("#readmore").attr("totalpage");
        if(parseInt(page) <= parseInt(totalpage)){
             
            showphone(page,limit);
        } 
     });
    if($("#form").is(":visible") == true) {
        limit = $("#row").val();
        showphone(1 , limit);

    }
    $("#row").change(function(){
        
        limit = $(this).val(); 
        $("#form").html("");
       
            showphone(1 , limit);
         
 
    });


    
    function showphone(num, limit){
        
    
    
        var nextpage =num; 
        
       
         
        $.get("/zalo/site/controllers/home.php?act=getnumberdata&page="+nextpage+"&limit="+limit, function (data, status) {
            
            if(data==-1)  return -1;
            var json = JSON.parse(data);
            nextpage = json['pagenext']; 
            $("#readmore").attr("totalpage",json['totalpage']);
            var html = "";
            var checked = '';
            console.log(json['data']);
            json['data'].forEach(item => {
                if(item['used'] ==1) checked = 'checked';
                else checked = '';
                html = '<tr class="div-" id="flip">'+
                '<input type="hidden" value="'+item['number']+'" name="">'+
                '<td class="sortnum">'+
                    '<input type="text" readonly class="number_input btn border-success number" name="number" id="number" value="'+0+item['number']+'">'+
                '</td>'+
    
                '<td class="form-check form-switch   ">'+
                    '<input type="checkbox"  class="used form-check-input ms-2" name="used" '+checked+' id="used">'+
                '</td>'+
                '<td class="sortnote">'+
                    '<textarea name="note" id="note" class="note btn border-success text-left" cols="30" rows="3"> '+item['note']+'</textarea>'+
                '</td>'+
                '<td>'+
                    '<textarea name="cookie" id="cookie" readonly class="cookie btn border-success" cols="30" rows="10">'+item['banbe']+' </textarea>'+
                '</td>'+
                '<td>'+
                    '<button class="delete btn btn-outline-primary" name="submit">X</button>'+
                '</td>'+
            '</tr>' ;
    
            $("#form").append(html);
                
            });
    
            $("#count").text(document.querySelectorAll("#flip").length);
            $("#readmore").attr("page",nextpage);
            
            
        });
    
        

      
    }
    
    

    $("#form").on("click", ".number", (function (e) {
        e.preventDefault();
        var td = $(this).parent();
        var tr = $(td).parent();
        var number = $(tr).children()[1];
        number = $(number).children()[0];

        number.select();
        number.setSelectionRange(0, 99999)
        document.execCommand("copy");
        console.log(number);


    }));

    $("#form").on("click", ".delete", (function (e) {
        e.preventDefault();
        $acc = confirm("xoá nha!");
        if ($acc == 1) {
            e.preventDefault();
            var td = $(this).parent();
            var tr = $(td).parent();
            var id = $(tr).children()[0];
            id = $(id).val();

            $.post("/zalo/delete/", {
                id: id
            },
                function (data, status) {

                });
            console.log(id, check, note, cookie)
        }

    }));
    $("#form").on("click", ".used", (function (e) {

        var td = $(this).parent();
        var tr = $(td).parent();
        var id = $(tr).children()[0];
        id = $(id).val(); 

        var check = $(tr).children()[2];
        check = $(check).children()[0];

        var note = $(tr).children()[3];
        note = $(note).children()[0];
        note = $(note).val();

      

        if ($(check).is(":checked")) {
            check = '1';

        } else {
            check = '0';

        }


        $.post("/zalo/update/", {
            id: id,
            check: check,
            note: note 

        },
            function (data, status) {

            });

        console.log(id, check, note)



    }));
    $("#form").on("keyup", ".note", (function (e) {
        e.preventDefault();
        var td = $(this).parent();
        var tr = $(td).parent();
        var id = $(tr).children()[0];
        id = $(id).val();
        var number = $(tr).children()[1];
        number = $(number).children()[0];

        var check = $(tr).children()[2];
        check = $(check).children()[0];

        var note = $(tr).children()[3];
        note = $(note).children()[0];
        note = $(note).val();

        var cookie = $(tr).children()[4];
        cookie = $(cookie).children()[0];
        cookie = $(cookie).val();



        if ($(check).is(":checked")) {
            check = '1';

        } else {
            check = '0';

        }


        $.post("/zalo/update/", {
            id: id,
            check: check,
            note: note,
            cookie: cookie

        },
            function (data, status) {

            });
        console.log(id, check, note, cookie)


    }));



    $("#form").on("click", ".cookie", (function (e) {


        var td = $(this).parent();
        var tr = $(td).parent();
        var cookie = $(tr).children()[4];
        cookie = $(cookie).children()[0];


        cookie.select();
        cookie.setSelectionRange(0, 99999)
        document.execCommand("copy");


        // var td = $(this).parent();
        // var tr = $(td).parent();
        // var id = $(tr).children()[0];
        // id = $(id).val();
        // var number = $(tr).children()[1];
        // number = $(number).children()[0];

        // var check = $(tr).children()[2];
        // check = $(check).children()[0];

        // var note = $(tr).children()[3];
        // note = $(note).children()[0];
        // note = $(note).val();

        // var cookie = $(tr).children()[4];
        // cookie = $(cookie).children()[0];
        // cookie = $(cookie).val();



        // if ($(check).is(":checked")) {
        //     check = '1';

        // } else {
        //     check = '0';

        // }


        // $.post("home.php?act=update", {
        //         id: id,
        //         check: check,
        //         note: note,
        //         cookie: cookie

        //     },
        //     function(data, status) {
        //         console.log("Data: " + data + "\nStatus: " + status);
        //     });




    }));









});





function loc_xoa_dau(str) {
    // Gộp nhiều dấu space thành 1 space
    str = str.replace(/\s+/g, ' ');
    // loại bỏ toàn bộ dấu space (nếu có) ở 2 đầu của chuỗi
    str = str.trim();
    // bắt đầu xóa dấu tiếng việt  trong chuỗi
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    return str;
}
// document.getElementById("findh").style = "display:none";

function myFunction1() {

    var input, filter, mydiv0, mydiv1, mydiv2, a, i, txtValue;
    input = document.getElementById("filter");
    filter = input.value.toUpperCase();
    mydiv0 = document.getElementById("form");
    mydiv1 = document.getElementsByClassName("div-");
    // mydiv2 = mydiv1.getElementsById("mydiv2");
    li = mydiv0.getElementsByClassName("sortnote");

    filter = loc_xoa_dau(filter);

    var count = 0;



    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("textarea")[0];
        txtValue = a.textContent || a.innerText;
        txtValue = loc_xoa_dau(txtValue);
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            count++;
            mydiv1[i].style.display = "";
        } else {

            mydiv1[i].style.display = "none";
        }
    }


}

function myFunction2() {

    var input, filter, mydiv0, mydiv1, mydiv2, a, i, txtValue;
    input = document.getElementById("filter1");
    filter = input.value.toUpperCase();
    mydiv0 = document.getElementById("form");
    mydiv1 = document.getElementsByClassName("div-");
    // mydiv2 = mydiv1.getElementsById("mydiv2");
    li = mydiv0.getElementsByClassName("sortnum");
    console.log(filter);
    filter = loc_xoa_dau(filter);

    var count = 0;

    console.log(li[0]);

    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("input")[0];
        txtValue = a.value || a.innerText;
        txtValue = loc_xoa_dau(txtValue);
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            count++;
            mydiv1[i].style.display = "";
        } else {

            mydiv1[i].style.display = "none";
        }
    }







}


function findfriend() {

    var input, filter, mydiv0, mydiv1, mydiv2, a, i, txtValue;
    input = document.getElementById("v");
    filter = input.value.toUpperCase();
    mydiv0 = document.getElementById("mydiv0");
    mydiv1 = document.getElementsByClassName("div-hide");
    // mydiv2 = mydiv1.getElementsById("mydiv2");
    li = mydiv0.getElementsByClassName("name_sort");

    filter = loc_xoa_dau(filter);

    var count = 0;

    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("p")[0];
        txtValue = a.textContent || a.innerText;
        txtValue = loc_xoa_dau(txtValue);
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            count++;
            mydiv1[i].style.display = "";
        } else {

            mydiv1[i].style.display = "none";
        }
    }

    if (input.value != '') document.getElementById("findh").innerHTML = '| Tìm Thấy <span class="text-danger" id="finded"></span>';
    else document.getElementById("findh").innerHTML = '';


    document.getElementById("finded").innerHTML = '"' + count + '"';




}


// scroll to top//Get the button
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

var inputfr = document.getElementById("v");
inputfr.addEventListener("keyup", function (event) {
    var x = event.key;
    if (x == "Shift") inputfr.value = "";
})