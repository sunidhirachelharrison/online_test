<?php

    session_start();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timer demo</title>
    
    <script type="text/javascript">
    
        //var deadline=new Date().getTime();
         var startTime=(new Date()).getTime();
        var secondsLeft;
        var timer=window.setInterval(function(){
            
            var now=(new Date()).getTime();
            secondsLeft=1800-((now-startTime)/1000);
            minutes=secondsLeft/(60);
            seconds=(secondsLeft%60)/60;
            document.getElementById("timer1").innerHTML= minutes +" minutes " + seconds + " seconds";
            
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