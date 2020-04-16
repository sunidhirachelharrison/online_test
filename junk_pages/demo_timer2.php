<?php

    session_start();
    //$tim=time();
    //Setcookie("startTime",$tim);
    //echo $_COOKIE['startTime'];
    //localStorage.setItem('timer',time());
    //echo localStorage.timer;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timer demo</title>
    
    <script type="text/javascript">
    
        var countdown=30*60*1000;
        var timerId=setInterval(function(){
            countdown-=1000;
            var min=Math.floor(countdown/(1000*60));
            var sec=Math.floor((countdown-(min*60*1000))/1000);
            
//            window.localStorage.setItem("minutes",min);
//            window.localStorage.setItem("seconds",sec);
//            
            if(countdown<=0)
                {
                    clearInterval(timerId);
                    window.alert("time over!");
                }
            else
                {
                    document.getElementById("timer1").innerHTML= "Time left: "+min +" minutes " + sec + " seconds";
                }
                
        },1000);
        
//        window.onload=function(){
//            secs=parseInt(window.localStorage.getItem("seconds"));
//            mins=parseInt(window.localStorage.getItem("minutes"));
//            
//            if(parseInt(mins*secs)){
//                var fiveMinutes=(parseInt(mins*60)+secs);
//            }
//            else{
//                var fiveMinutes=60*5;
//            }
//        };
//        
    </script>
    
</head>
<body>
  
   <form  action="#" method="post">
        <div id="timer1"></div>
        <div id="timer2"></div>
<!--        <input type="submit" value="NEXT">-->
  <input type=hidden id="hiddenfield">
   </form>
    
</body>
</html>