<?php

    //session_start();
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
                    //timer=duration;
                    //alert("Time Over!");
                    //clear local storage on time over
                    localStorage.clear();
                    //on time over, redirect to verbal aptitude quiz
                    window.location.href = "thankyou_page.php";
                }
                console.log(parseInt(seconds));
                //store the time info in local storage of client
                window.localStorage.setItem("seconds",seconds);
                window.localStorage.setItem("minutes",minutes);
                
            },1000);
        }
            
        window.onload=function(){
            //localStorage.clear();
            secs=parseInt(window.localStorage.getItem("seconds"));
            mins=parseInt(window.localStorage.getItem("minutes"));
            
            if(parseInt(mins*secs)){
                var fiveMinutes=(parseInt(mins*60)+secs);
            }
            else{
                 //timer for 30 minutes
                var fiveMinutes=60*30;
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
       
        <div id="time" style="font-size:20px;text-align:right;margin-top:15; padding: 1rem 4rem;"></div>
        <div id="timer2"></div>
        
<!--
        <button name="next" class="btn btn-primary"  >NEXT</button>
        <button name="submit" onclick="done();" class="btn btn-primary"  >SUBMIT</button>
     
-->
  
   </form>
    
</body>
</html>