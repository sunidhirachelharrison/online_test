<?php

    session_start();
    include("DB_connect.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timer demo</title>
    
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    
    <script type="text/javascript">
    
        function startTimer(duration,display)
        {
            var timer=duration,minutes,seconds;
            setInterval(function(){
                minutes=parseInt(timer/60,10);
                seconds=parseInt(timer%60,10);
                minutes=minutes < 10 ? "0" + minutes : minutes;
                seconds=seconds < 10 ? "0" + seconds : seconds;
                display.textContent="Time left: "+ minutes + " minutes " + " " + seconds + " seconds";
                if(--timer<0){
                    timer=duration;
                }
                console.log(parseInt(seconds));
                window.localStorage.setItem("secs",seconds);
                window.localStorage.setItem("mins",minutes);
                
            },1000);
        }
            
        window.onload=function(){
            //localStorage.clear();
            secs=parseInt(window.localStorage.getItem("secs"));
            mins=parseInt(window.localStorage.getItem("mins"));
            
            if(parseInt(mins*secs)){
                var fiveMinutes=(parseInt(mins*60)+secs);
            }
            else{
                //timer for 10 minutes
                var fiveMinutes=60*10;
            }
            display=document.querySelector('#time');
            startTimer(fiveMinutes,display);
        };
        
        function done()
        {
            localStorage.clear();
            
        }
        
    </script>
    
</head>
<body>
  
   <form  action="#" method="post" >
       
        <div id="time" ></div>
        <div id="timer2"></div>
        
<!--
        <button name="next" class="btn btn-primary"  >NEXT</button>
        <button name="submit" onclick="done();" class="btn btn-primary"  >SUBMIT</button>
     
-->
  
   </form>
    
</body>
</html>