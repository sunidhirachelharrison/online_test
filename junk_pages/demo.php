<?php

    session_start();
    //if(empty($_SESSION['quiz']))
    {
        $_SESSION['quiz']=date('Y-m-d H:i:s');
        //$_SESSION['quiz']=date_date_set()
    }
//echo $_SESSION['quiz'] . "<br/>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timer demo</title>
    
    <script type="text/javascript">
    
        var deadline=new Date().getTime();
        
        var x=setInterval(function(){
            var now=new Date().getTime();
            var t=deadline-now;
            var days=Math.floor(t/(1000*60*60*24));
            var hours=Math.floor((t%(1000*60*60*24))/(1000*60*60));
            var minutes=Math.floor((t%(1000*60*60))/(1000*60));
            var seconds=Math.floor((t%(1000*60))/1000);
            
            document.getElementById("timer1").innerHTML= minutes +" minutes " + seconds + " seconds";
            if(t<0) 
                {
                    clearInterval(x);
                    //document.getElementById("timer1").innerHTML="EXPIRED";
                    window.alert("Time Expired!");
                }
        },1000);
        
        
        
    </script>
    
</head>
<body>
  
   <form  action="#" method="post">
        <div id="timer1"></div>
        <div id="timer2"></div>
        <input type="submit" value="NEXT">
   </form>
    
</body>
</html>