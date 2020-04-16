<?php

    session_start();
    include("DB_connect.php");

//************************************************************************* 

    if(isset($_POST['submit']))
    {
        header('Location: quiz2.php');
    }

//*************************************************************************

    
///******************  fetch 35 questions **********************************

    
        
    
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
                var fiveMinutes=60*30;
            }
            display=document.querySelector('#time');
            startTimer(fiveMinutes,display);
        };
        
        function done()
        {
            localStorage.clear();
            //window.location.href="http://localhost/online_test/quiz2.php";
            //window.location='quiz2.php';
            
            //exit();
        }
    </script>

<script>
    function showUser(str) {
    //showUser.str=showUser.str+1;
    //str=str+1;
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
        xmlhttp.open("GET","quiz1.php?q="+str,true);
        xmlhttp.send();
    }
}

    
//    $(document).ready(function(){
//    $(".show_questions").each(function(e) {
//        if (e != 0)
//            $(this).hide();
//    });
//
//    $("#next").click(function(){
//        if ($(".show_questions:visible").next().length != 0)
//            $(".show_questions:visible").next().show().prev().hide();
//        else {
//            $(".show_questions:visible").hide();
//            $(".show_questions:first").show();
//        }
//        return false;
//    });
//
//    $("#prev").click(function(){
//        if ($(".divs div:visible").prev().length != 0)
//            $(".divs div:visible").prev().show().next().hide();
//        else {
//            $(".divs div:visible").hide();
//            $(".divs div:last").show();
//        }
//        return false;
//    });
//});
    
//    $(document).on( "click", ".next", function() {
//    //$(this).closest('.show_questions').hide().next().show();
//        
//        $( document ).on( "click", ".next", function() {
//    $(this).parent().next().toggle();
//});
    
//    $(document).ready(function() {
//    
//    //Store the total number of questions
//var totalQuestions = $('#show_questions').size();
//
////Set the current question to display to 1
//var currentQuestion = 0;
//
////Store the selector in a variable.
////It is good practice to prefix jQuery selector variables with a $
//$questions = $('#show_questions');
//
////Hide all the questions
//$questions.hide();
//
////Show the first question
//$($questions.get(currentQuestion)).fadeIn();
//
////attach a click listener to the HTML element with the id of 'next'
//$('#next').click(function () {
//
//     //fade out the current question,
//     //putting a function inside of fadeOut calls that function 
//     //immediately after fadeOut is completed, 
//     //this is for a smoother transition animation
//     $($questions.get(currentQuestion)).fadeOut(function () {
//
//        //increment the current question by one
//        currentQuestion = currentQuestion + 1;
//
//        //if there are no more questions do stuff
//        if (currentQuestion == totalQuestions) {
//
//            //var result = sum_values()
//                var result = 50;
//            //do stuff with the result
//            alert(result);
//
//        } else {
//
//            //otherwise show the next question
//            $($questions.get(currentQuestion)).fadeIn();
//
//        }
//    });
//
//});
//    });
    </script>

</head>
<body>
    
    
    <form action="#" method="post">
        <div class="container">           
            <div class="row">
                <div id="time" ></div>
                <div id="timer2"></div><br/>
                <h1>Quantitative Aptitude</h1><br/>
                <div class="col-sm-8">
                  <br/>
                   
<!--
                    <button type="button" class="btn btn-primary" name="next" >NEXT</button>
                    
                    <input type="submit" class="btn btn-primary" name="submit" value="SUBMIT"/>
                    
                    
-->
                   <?php
                            $i=0;
                        $q=intval($_GET['q']);
                            if(isset($_POST['next']))
                            {
                                $sql="SELECT * FROM questions WHERE Q_Flag='0' AND Q_ID='".$q."'";
                                $r=mysqli_query($con,$sql);
                                if(!($r))
                                {
                                    echo '<script>alert("Failed to fetch the questions!");</script>';
                                }
                                else
                                {
                                    while($row=mysqli_fetch_assoc($r))
                                    {
                                            $i++;
                                        ?>
                   
                    <div  class="show_questions" id="show_questions" style="background-color:pink;">
                        <?php
                                    echo $row['Q_Description'] . "<br/><br/>";
                        ?>
                        
                        <input type="radio" name="options" value="<?php echo $row['Q_Option_A']; ?>"><?php echo $row['Q_Option_A']; ?><br/>
                        <input type="radio" name="options" value="<?php echo $row['Q_Option_B']; ?>"><?php echo $row['Q_Option_B']; ?><br/>
                        <input type="radio" name="options" value="<?php echo $row['Q_Option_C']; ?>"><?php echo $row['Q_Option_C']; ?><br/>
                        <input type="radio" name="options" value="<?php echo $row['Q_Option_D']; ?>"><?php echo $row['Q_Option_D']; ?><br/>
<!--
                        <?php
                       // echo '<img src="uploads/'.$row['image'];.'">';
                        ?>
-->
                    </div><br/>
                    
                <?php  } }  } ?>

                <button name="next" onclick="showUser(2)" id="next" class="btn btn-primary"  >NEXT</button>
                <button name="submit" onclick="done();" class="btn btn-primary" >SUBMIT</button>

<!--                <input type="submit" name="submit" value="SUBMIT" onclick="done();" class="btn btn-primary">-->
                                
                </div>
                
                <div class="col-sm-4">
                  <br/>
                   
<!--
                    <button type="button" class="btn btn-primary" name="next" >NEXT</button>
                    
                    <input type="submit" class="btn btn-primary" name="submit" value="SUBMIT"/>
-->
                    <div  style="background-color:pink;">

                   <?php
                        for($i=1;$i<=35;$i++)
                        {
                            ?>
                                <button class="btn" style="padding:5px;" name="<?php echo $i; ?>"><?php echo $i; ?></button>&nbsp; &nbsp;
                                
                            <?php
                        }
                        ?>
                   
                    </div>
                </div>
                
            </div>
        </div>
    </form>
    
    
</body>
</html>