<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<style>
 
</style>
<label for="file">Downloading progress:</label>
<progress id="file" value="0" max="1000"> </progress>
    <ul id="myUL">

    </ul>
    <script>
        $(document).ready(function() {


            const url =  "http://localhost/zalo/api/gen.php";
            var key;
            var count = 0;
            var progr = 0;
            while(count <= 1000){
    

    count++;
            const randomNumber = new Promise((resolve, reject) => {
                 
                 let request = new XMLHttpRequest();

                 request.open('GET', url);
                 request.onload = function() {
                     if (request.status == '200') {
                        
                         resolve(request.response);
                     } else {
                         reject(Error(request.statusText)); 
                     }
                 };

                 request.onerror = function() {
                     reject(Error('Error fetching data.'));
                 };

                 request.send();
             });


             randomNumber
             .then((data) => { 
                console.log("Random number: ", data);
                var key =data;
                var url = "http://localhost/zalo/api/getct.php?key=" + key;

                $.get(url, function(data, status) {
                    data = JSON.parse(data);

                    if (data['ResponseCode'] != -1) {
                        if (data['Result']['Balance'] > 0) {
                            
                            $("#myUL").append("<li id='myli' style='color:green'>Key: " + key + " || Balance: " + bal + "</li>");
                            alert("ngon");
                        }
                        $("#myUL").append("<li id='myli' style='color:yellow'>Key: " + key + " || Balance: " + bal + "</li>");
                    } else {
                        $("#myUL").append("<li id='myli' style='color:red'>Key: " + key + " || Balance: null </li>");
                    
                    }
                    progr++;
                    
                    $("#file").val(progr);
                    
                });
             }) 
             .catch((err) => {
             console.log("Error: ", err.message);
             })
                 
            
            
            
}
          
           
           
             
        })
       
    </script>

</body>

</html>