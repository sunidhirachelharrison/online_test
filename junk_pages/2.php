<?php
    
    include("timer2.php");
//    if(isset($_POST['submit']))
//    {
//        header('Location: result.php');
//    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verbal Aptitude</title>
    
    <script>
        window.counter=0;
        function increment()
        {
            counter=counter+1;
            if(counter<=4)
                {
                    showUser(counter);
                }
            else{
                //alert("Reached the last question");
                document.getElementById('submit').style.visibility = 'visible';
            }
        }
    function showUser(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            //var ty="Quantitative Aptitude";
            xmlhttp.open("GET","getuser.php?q="+str,true);
            xmlhttp.send();
        }
    }
    </script>
</head>
<body>

    <div id="txtHint"><b>Question and options will be listed here...</b></div>
    
      <form action="result.php">
       
        <input type="button" class="next" id="next" name="next" value="NEXT" onclick="increment()">
        
        <button name="submit" id="submit" style="visibility:hidden" class="btn btn-primary">SUBMIT</button>
        
    </form>
    <br>
            
</body>
</html>