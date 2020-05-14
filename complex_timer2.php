<?php

//session_start();
    include("DB_connect.php");

    //selecting timer info from test table 
	$query="SELECT * FROM state WHERE S_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
	$r=mysqli_query($con,$query);
    $timer_string="";
    $h="";
    $m="";
    $s="";
    
	if(!($r))
	{
		echo '<script>alert("Failed to fetch the timer details!");</script>';
	}
	else
	{
		//when test names are fetched successfully
        $re=mysqli_fetch_assoc($r);
        $timer_string=$re['S_Timer_info'];
        $x=explode(":",$timer_string);
        $h=$x[0];
        $m=$x[1];
        $s=$x[2];

    }
$temp_mins=($h*60)+$m;

$dateFormat = "d F Y -- g:i a";
$targetDate = time() + (($temp_mins*60) + $s);//Change the $temp_mins to however many minutes you want to countdown
$actualDate = time();
$secondsDiff = $targetDate - $actualDate;
$remainingDay     = floor($secondsDiff/60/60/24);
$remainingHour    = floor(($secondsDiff-($remainingDay*60*60*24))/60/60);
$remainingMinutes = floor(($secondsDiff-($remainingDay*60*60*24)-($remainingHour*60*60))/60);
$remainingSeconds = floor(($secondsDiff-($remainingDay*60*60*24)-($remainingHour*60*60))-($remainingMinutes*60));
$actualDateDisplay = date($dateFormat,$actualDate);
$targetDateDisplay = date($dateFormat,$targetDate);
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">-->
<!DOCTYPE html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Quiz System</title>

    <script type="text/javascript">
        var days = <?php echo $remainingDay; ?>

        var hours = <?php echo $remainingHour; ?>

        var minutes = <?php echo $remainingMinutes; ?>

        var seconds = <?php echo $remainingSeconds; ?>

        function setCountDown() {
            seconds--;
            if (seconds < 0) {
                minutes--;
                seconds = 59
            }
            if (minutes < 0) {
                hours--;
                minutes = 59
            }
            if (hours < 0) {
                days--;
                hours = 23
            }

            document.getElementById("remain").innerHTML = hours + " hours " + minutes + " minutes " + seconds + " seconds";

            //document.getElementById("remain").innerHTML = days + " days, " + hours + " hours, " + minutes + " minutes, " + seconds + " seconds";
            SD = window.setTimeout("setCountDown()", 1000);
            if (hours == '00' && minutes == '00' && seconds == '00') {
                seconds = "00";
                window.clearTimeout(SD);
                //window.alert("Time is up. Press OK to continue."); // change timeout message as required
                window.location = "thankyou_page.php" // Add your redirect url
            }

        }

    </script>
</head>

<body onload="setCountDown();">

    <!--    Start Time: <?php //echo $actualDateDisplay; ?><br />-->
    <!--    End Time:<?php //echo $targetDateDisplay; ?><br />-->
    <div id="remain"><?php echo " $remainingHour hours, $remainingMinutes minutes, $remainingSeconds seconds";?></div>


</body>

</html>
