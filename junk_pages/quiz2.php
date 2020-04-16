<?php

    session_start();
    include("DB_connect.php");

    if(isset($_POST['submit']))
    {
        header('Location: result.php');
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>quiz</title>
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
                window.localStorage.setItem("seconds",seconds);
                window.localStorage.setItem("minutes",minutes);
                
            },1000);
        }
            
        window.onload=function(){
            secs=parseInt(window.localStorage.getItem("seconds"));
            mins=parseInt(window.localStorage.getItem("minutes"));
            
            if(parseInt(mins*secs)){
                var fiveMinutes=(parseInt(mins*60)+secs);
            }
            else{
                var fiveMinutes=60*10;
            }
            display=document.querySelector('#time');
            startTimer(fiveMinutes,display);
        };
        
        function done()
        {
            localStorage.clear();
//            window.location.href="result.php";
            
        }
    </script>


</head>
<body>
    
    
    <form action="#" method="post">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                  <br/>
                   <div id="time" ></div>
                    <div id="timer2"></div><br/>
                    <h1>Verbal Aptitude</h1><br/>
                    
<!--
                    <button type="button" class="btn btn-primary" name="next" >NEXT</button>
                    
                    <input type="submit" class="btn btn-primary" name="submit" value="SUBMIT"/>
-->
    
                    
                

                <button name="next" class="btn btn-primary"  >NEXT</button>
                <button name="submit" onclick="done();" class="btn btn-primary" >SUBMIT</button>

                                
                </div>
            </div>
        </div>
    </form>
    
    
</body>
</html>