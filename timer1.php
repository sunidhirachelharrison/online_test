<?php
    //session_start();
    include("DB_connect.php");

    //selecting timer info from test table 
	$query="SELECT * FROM test WHERE T_Flag='0'";
	$r=mysqli_query($con,$query);
    $h="";
    $m="";
    
	if(!($r))
	{
		echo '<script>alert("Failed to fetch the timer details!");</script>';
	}
	else
	{
		//when test names are fetched successfully
        $re=mysqli_fetch_assoc($r);
        $h=$re['T_Hours'];
        $m=$re['T_Minutes'];

    }

?>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        var minutes = 0;
        var seconds = 0;

        function startTimer(duration, display) {
            var timer = duration,
                hours, minutes, seconds;
            setInterval(function() {
                hours = parseInt(timer / (60 * 60), 10);
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
                hours = minutes < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                display.textContent = "Time left: " + hours + " hours " + minutes + " minutes " + " " + seconds + " seconds";
                if (--timer < 0) {
                    //timer=duration;
                    //alert("Time Over!");
                    //clear local storage on time over
                    localStorage.clear();
                    //on time over, redirect to verbal aptitude quiz
                    window.location.href = "thankyou_page.php";
                }
                console.log(parseInt(seconds));
                //store the time info in local storage of client
                window.localStorage.setItem("seconds", seconds);
                window.localStorage.setItem("minutes", minutes);
                window.localStorage.setItem("hours", hours);

            }, 1000);
        }

        window.onload = function() {
            //localStorage.clear();
            secs = parseInt(window.localStorage.getItem("seconds"));
            mins = parseInt(window.localStorage.getItem("minutes"));
            hou = parseInt(window.localStorage.getItem("hours"));
            var h = <?php echo json_encode($h); ?>;
            var m = <?php echo json_encode($m); ?>;

            if (parseInt(hou * mins * secs)) {
                var fiveMinutes = ((parseInt(hou) * (parseInt(mins * 60))) + secs);
            } else {
                //timer for 30 minutes
                //                var fiveMinutes = 60 * 30;
                var fiveMinutes = h * m;
            }
            display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };

        function done() {
            localStorage.clear();

        }

    </script>

</head>

<body>

    <form action="#" method="post">
        <div id="time" style="font-size:17px;"></div>
        <div id="timer2"></div>
    </form>

</body>

</html>
