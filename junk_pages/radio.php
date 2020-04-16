<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form name="Form1" method="get" id="color" style="font-size: 100%" action="#">  
    <input type="radio"  name="radio1"  id="radio1" onclick = "MyAlert()" value="blue"/>Blue  <br />  
    <p> <input type="radio"  name="radio1" id="radio1" onclick = "MyAlert()" value="red"/>Red  
    </form>
</body>
</html>
  

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript"> 
    var radio1;
function MyAlert()  {  
    
    var radios = document.getElementsByName('radio1');
    
    for (var i = 0, length = radios.length; i < length; i++) {
      if (radios[i].checked) {
        // do whatever you want with the checked radio
        //alert(radios[i].value);
         radio1=radios[i].value;
          //alert(radio1);
        // only one radio can be logically checked, don't check the rest
        break;
      }
    }
    
    //var radio1=$('input[type="radio"]:checked').val();
    //var radio1=document.querySelector('input[name="radio1"]:checked').value;
    var pass_data = {
            'radio1' : radio1,
        };
        //alert(pass_data);
        $.ajax({
            url : "save_result.php",
            type : "POST",
            data : pass_data,
            success : function(data) {
            }
        });
        return false;
    }  
</script>
<?php
//if(isset($_GET['radio1'])){
//      $radio1=$_GET['radio1'];
//    echo $radio1;
//}
   
?>


