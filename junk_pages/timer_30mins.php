<?php

    session_start();
    include("DB_connect.php");
    $query  =   "SELECT * FROM student WHERE erno='1'";
    $fetch_query=mysqli_query($con,$query);
    //$fetch=mysqli_fetch($fetch_query);
    if($fetch_query)
    {
        
        
        
        //currently displaying image only if in same folder
        $row=mysqli_fetch_assoc($fetch_query);
        echo '<img src="uploads/'.$row['image'].'" height="200" width="200" >';
        print_r($row['image']);
    }

    if(isset($_POST['uploadbtn']))
    {
        $target_dir="uploads/";
        $target_file=$target_dir.basename($_FILES['imageUpload']['name']);
        $uploadOk=1;
        $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
        if(move_uploaded_file($_FILES['imageUpload']['tmp_name'],$target_file))
        {
            echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
        }
        else
        {
            echo "Sorry! uploading of image failed!";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timer demo</title>
    
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
  
   <form  action="#" method="post" enctype="multipart/form-data">
        <div id="time"></div>
        <div id="timer2"></div>
        <input type="file" name="imageUpload" id="imageUpload">
        <button name="uploadbtn">UPLOAD IMAGE</button><br/>
        <button name="next">NEXT</button>
        <button name="submit" onclick="done();">SUBMIT</button>
<!--        <input type="submit" name="submit" value="SUBMIT">-->
  <input type=hidden id="hiddenfield">
   </form>
    
</body>
</html>