<?php

    //starting the session
    session_start();

    //if the user is not logged-in, redirect to login page
    if(!(isset($_SESSION['U_Enrollment_No'])))
    {
        header("location:index.php");
    }


    include("DB_connect.php");  //for database connection
    include("timer1.php");      //for timer display on top of the page
      
        //select 35 questions from questions table whose flag bit is set to 0(i.e. questions selected for a particular test)
        $sql="SELECT * FROM questions WHERE Q_Flag='0' limit 35";
        $row=mysqli_query($con,$sql);
        
        if(!($row))
        {
            echo '<script>alert("Error in fetching questions!");</script>';
        }
        else
        {
            $qu=array();    //array to store fetched questions
            $i=0;           //counter to store questions in array $qu
            while($r=mysqli_fetch_assoc($row))
            {
                $qu[$i]=$r['Q_ID'];     //fetch ques. and store in array $qu
                $i++;                   //increment counter
            }
            //print_r($qu);
            shuffle($qu);       //shuffle the order of the questions
            //print_r($qu);
            
            
        }

        $query1="SELECT * FROM test WHERE T_Flag='0'";
        $r1=mysqli_query($con,$query1);
        $tname="";
        $tdate="";
        $tmarks="";
        if(!($r1))
        {
            //failed to fetch the test details to be displayed    
        }
        else
        {
            $r2=mysqli_fetch_assoc($r1);
            $tname=$r2['T_Name'];
            $tdate=$r2['T_Date'];
            $tmarks=$r2['T_Marks'];
            $obj=new DateTime($tdate);
            $tdate=date_format($obj,"d F Y");
        }
                      

?>


<!DOCTYPE html">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NETCAMP || TEST YOUR SKILL </title>
    <link rel="stylesheet" href="css1/bootstrap.min.css" />
    <link rel="stylesheet" href="css1/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="css1/main.css">
    <link rel="stylesheet" href="css1/font.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="js1/bootstrap.min.js" type="text/javascript"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <!--alert message-->
    <style>
        .aaa {
            height: 150%;
        }

        .aaaa {
            height: 120%;
        }

        .btn1 {
            background: #fff;
            border: 2px solid #ea5e0d;
            color: #ea5e0d;
        }

        .btn1:hover {
            background: #ea5e0d;
            border: 2px solid #fff;
            color: #fff;
        }


        .navbar {
            align-items: left;
            align-items: top;
        }

        .fle {
            display: inherit;
        }

        .xx {
            border-radius: 50%;
        }

        .c {
            background: #ea5e0d;
            color: #fff;
            border: 1px solid #ea5e0d;
            border-radius: 2px;
        }

        .d {
            border-radius: 4px;
        }


        .clip {
            clip-path: polygon(50% 0%, 100% 25%, 100% 100%, 50% 100%, 0% 100%, 0% 25%);
        }

        .button_set {
            align-items: bottom;
        }

        .next1 {
            margin-right: 80px;
        }

        #txtHint {
            padding: 25px;
        }

    </style>
    <script type="text/javascript">
        window.counter = 0;
        var selected_qid = <?php echo json_encode($qu); ?>;
        showQuestion(selected_qid[counter]);

        //to show next question:increment the counter
        function increment() {
            //************************************************************
            //    var marked_value;
            //            var qid=<?php //echo json_encode($selected_qid[counter]); ?>;
            if (document.getElementById('A').checked) {
                //marked_value = document.getElementById('A').value;
                document.getElementById(counter).style.background = '#00FF00';
            } else if (document.getElementById('B').checked) {
                //marked_value = document.getElementById('B').value;
                document.getElementById(counter).style.background = '#FF0000';
            } else if (document.getElementById('C').checked) {
                //marked_value = document.getElementById('C').value;
                document.getElementById(counter).style.background = '#00FF00';
            } else if (document.getElementById('D').checked) {
                //marked_value = document.getElementById('D').value;
                document.getElementById(counter).style.background = '#00FF00';
            } else if (document.getElementById('E').checked) {
                //marked_value = document.getElementById('D').value;
                document.getElementById(counter).style.background = '#00FF00';
            } else {
                document.getElementById(counter).style.background = '#FF0000';
            }
            //            
            //            saveResult(marked_value,qid);

            //**************************************************************
            counter = counter + 1;
            if ((counter == 0) || (counter < 34)) //replace 5 by 34 to fetch 35 questions
            {
                showQuestion(selected_qid[counter], counter);

            } else if (window.counter == 34) //replace 5 by 34 to fetch 35 questions
            {
                //displays last question
                showQuestion(selected_qid[counter], window.counter);
                document.getElementById('submit').style.visibility = 'visible';
            } else {
                counter = counter - 1;
                //alert("Reached the last question");
            }
        }
        //function to display the question
        function showQuestion(q_uid, counter) {
            if (q_uid == "") {
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
                        //callback();
                    }
                };
                //var ty="Quantitative Aptitude";
                xmlhttp.open("GET", "get_question.php?q=" + q_uid + "&c=" + (window.counter + 1), true);
                xmlhttp.send();
            }
            //if (localStorage.getItem('myAnswers' + counter) != null) {
            // var l = localStorage.getItem('myAnswers' + counter);
            // // //document.getElementById('A').checked = true;
            // // alert(localStorage.getItem('myAnswers' + counter));
            // // var radios = document.getElementsByName('options');
            // for (var i = 0, length = radios.length; i < length;) { // alert(radios[i].value); // //var p=radios[i].value; // //if (p==l) { // //radios[i].checked=true; // //document.getElementById('A').checked=true; // //alert(localStorage.getItem('myAnswers' + counter)); // //alert(radios[i].value); // alert("well done"); // break; // } else { // alert("false"); // } // i++; // } // } else { // alert("hello"); 
            //alert(localStorage.getItem('myAnswers' + counter)); // // alert(radios[i]); // // break; // // } // } 
            //}

            //code to check the marked options
            setTimeout(function() {

                check_radio_option();

            }, 300);


        }

        //to show previous question: decrement the counter
        function show_previous() {
            counter = counter - 1;

            if (counter >= 0) {

                showQuestion(selected_qid[counter], counter)

                //code to check the marked options
                setTimeout(function() {

                    check_radio_option();

                }, 300);





                document.getElementById('submit').style.visibility = 'hidden';
            } else {
                //alert("Reached first question!");
                document.getElementById('submit').style.visibility = 'hidden';
                counter = counter + 1;

            }

            //if (localStorage.getItem('myAnswers' + counter) != null) {
            // var l = localStorage.getItem('myAnswers' + counter);
            // // //document.getElementById('A').checked = true;
            // // alert(localStorage.getItem('myAnswers' + counter));
            // // var radios = document.getElementsByName('options');
            // for (var i = 0, length = radios.length; i < length;) { // alert(radios[i].value); // //var p=radios[i].value; // //if (p==l) { // //radios[i].checked=true; // //document.getElementById('A').checked=true; 
            //   alert(localStorage.getItem('myAnswers' + counter)); // //alert(radios[i].value); // alert("well done"); // break; // } else { // alert("false"); // } // i++; // } // } else { // alert("hello"); // //alert(localStorage.getItem('myAnswers' + counter)); // // alert(radios[i]); // // break; // // } // } 
            // }


            // f();

        }

        function done() {
            localStorage.clear();
            //self.close();
            window.open('thankyou_page.php', '_blank');
            self.close();
            //window.location.href("result_show.php");
        }


        //function to save the marked answer on clicking of next button
        //    function saveResult(marked_value,qid)
        //    {
        //        if (marked_value == "") {
        //            document.getElementById("txtHint").innerHTML = "";
        //            return;
        //        } else {
        //            if (window.XMLHttpRequest) {
        //                // code for IE7+, Firefox, Chrome, Opera, Safari
        //                xmlhttp = new XMLHttpRequest();
        //            } else {
        //                // code for IE6, IE5
        //                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        //            }
        //            xmlhttp.onreadystatechange = function() {
        //                if (this.readyState == 4 && this.status == 200) {
        //                    document.getElementById("txtHint").innerHTML = this.responseText;
        //                }
        //            };
        //            //var ty="Quantitative Aptitude";
        //            xmlhttp.open("GET","save_result.php?marked_value="+marked_value+"&qid="+qid,true);
        //            xmlhttp.send();
        //        }
        //    }

        //function to mark a question for review
        function mark_for_review() {
            if (document.getElementById('A').checked) {
                //marked_value = document.getElementById('A').value;
                document.getElementById(counter).style.background = '#FFFF00';
                //$(button).find(".glyphicon").addClass("glyphicon-ok");
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else if (document.getElementById('B').checked) {
                //marked_value = document.getElementById('B').value;
                document.getElementById(counter).style.background = '#FFFF00';
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else if (document.getElementById('C').checked) {
                //marked_value = document.getElementById('C').value;
                document.getElementById(counter).style.background = '#FFFF00';
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else if (document.getElementById('D').checked) {
                //marked_value = document.getElementById('D').value;
                document.getElementById(counter).style.background = '#FFFF00';
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else if (document.getElementById('E').checked) {
                //marked_value = document.getElementById('D').value;
                document.getElementById(counter).style.background = '#FFFF00';
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else {
                document.getElementById(counter).style.background = '#EE82EE';
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            }

        }


        function check_radio_option() {
            if (localStorage.getItem('myAnswers' + counter) != null) {
                console.log("step2");
                var radios = document.getElementsByName('options');
                for (var i = 0, length = radios.length; i < length; i++) {
                    console.log("step3");
                    var l = localStorage.getItem('myAnswers' + counter);
                    console.log("step4");
                    var p = radios[i].value;
                    console.log("step5");
                    if (p == l) {
                        console.log("step6");
                        radios[i].checked = true;
                        //alert(radios[i]);

                        console.log("step7");
                        break;
                    }
                }
            }
            //extra code for passage
            //var cou;
            //else {
            for (var j = 0; j < 10; j++) {
                if (localStorage.getItem('myAnswers' + counter + j) != null) {
                    console.log("step8");
                    var radios = document.getElementsByTagName('input');
                    for (var i = 0, length = radios.length; i < length; i++) {
                        console.log("step9");
                        var l = localStorage.getItem('myAnswers' + counter + j);
                        console.log("step10");
                        var p = radios[i].value;
                        console.log("step11");
                        if (p == l) {
                            console.log("step12");
                            radios[i].checked = true;
                            //alert(radios[i]);
                            console.log("step13");
                            //break;
                        }
                    }
                }
            }

            //}


        }

    </script>

</head>

<body>
    <div class="jumbotron" style="margin-bottom:0; padding: 1rem 1rem;"> <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />

        <header class="text-center"><b>
                <?php echo $tname . "<br/>" . $tdate . "<br/>" . "Total marks: " . $tmarks . "<br/>"; ?>
                <!--            <img src="image/logo_uni.png" class="img-fluid float-right" width="200" alt="tmu logo" />-->
            </b>
        </header>

    </div>

    <!--
    <div class="jumbotron text-right" style="margin-bottom:0; padding: 1rem 1rem;">
        hello
    </div>
-->

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"  . $_SESSION['U_Name'] . " ( " . $_SESSION['U_Enrollment_No'] . ")";  ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

    </nav>

    <!--
<div class="header">
<div class="row">
<div class="col-lg-6">
<span class="logo"><img src="images/tmu.png" width="11%"/></span></div>
<div class="col-md-4 col-md-offset-2">

</div>
</div></div>
<div class="bg">
-->

    <!--navigation menu-->
    <!--
<nav class="navbar navbar-default title1">
  <div class="container-fluid">
     Brand and toggle get grouped for better mobile display 
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><b>CTLD</b></a>
    </div>
-->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <!--    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">-->
    <!--
      <ul class="nav navbar-nav">
        <li><a href="account.php?q=1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home<span class="sr-only">(current)</span></a></li>
        <li><a href="account.php?q=2"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;History</a></li>
		<li><a href="account.php?q=3"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>&nbsp;Ranking</a></li></ul>
-->
    <!--</div><!-- /.navbar-collapse -->
    <!--</div><!-- /.container-fluid -->
    <!--</nav>-->
    <!--navigation menu closed-->

    <div class="container-fluid">

        <!--
        <div class="row">
            <div class="col-md-8">
                <nav class="navbar navbar-default title1 aaa">
                    <div class="container float-center">
                        <?php //echo $tname . "<br/>" . $tdate . "<br/>" . "Total marks: " . $tmarks . "<br/>"; ?>
                    </div>
                </nav>
            </div>
        </div>
-->

        <div class="row">
            <div class="col-md-8">
                <nav class="navbar navbar-default title1 aaaa fle">
                    <div class="aa">
                        <div id="txtHint"><b>Question and options will be listed here...</b></div>


                    </div>
                </nav>

            </div>
            <div class="col-md-4">
                <nav class="navbar navbar-default title1 aaaa">
                    <!--
				<div class="aa1">
					</br>
-->
                    <!--
                    <div>
                        <img src="image/not_visited.png" class="img-fluid" width="80" alt="" />not visited



                        <img src="image/not_answered_and_marked_for_review.png" class="img-fluid" width="80" alt="" />marked for review
                    </div>


                    <div>
                        <img src="image/answered.png" class="img-fluid" width="80" alt="" />answered

                        <img src="image/answered_and_marked_for_review.png" class="img-fluid" width="80" alt="" />answered and marked for review
                    </div>

                    <div>
                        <img src="image/visited_and_not_answered.png" class="img-fluid" width="80" alt="" />not answered
                    </div>-->



                    <div class="container">

                        <div class="row">


                            <?php 
                                
                                for($z=1;$z<=35;$z++)
                                {
                                    ?>

                            <div class="col-xl-2 col-2 p-2"><Button type="button" id="<?php echo ($z-1); ?>" class="btn btn-info clip " onclick="<?php if($z==35){
                                    ?>
                                    
                                    document.getElementById('submit').style.visibility = 'visible';
                                    
                                    <?php
                                    }
                                    else
                                    {
                                        ?>document.getElementById('submit').style.visibility = 'hidden';

                                    <?php
                                    }  ?>
                                 window.counter=<?php echo ($z-1); ?>;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;<?php echo $z; ?>&nbsp;</Button></div>

                            <?php
                                }
                            
                            ?>


                        </div>


                    </div>



                </nav>
            </div>
        </div>


        <div class="row">
            <div class="col-8">
                <form action="thankyou_page.php" method="post" class="button_set">

                    <input type="button" class="previous c p-2 ml-5" id="previous" name="previous" value="PREVIOUS" onclick="show_previous()">

                    <!--                       <input type="button" class="save" id="save" name="save" value="SAVE" >-->


                    <input type="button" id="marked" class="c p-2 ml-5" name="marked" value="MARKED FOR REVIEW" onclick="mark_for_review();" />
                    <button name="submit" id="submit" style="visibility:hidden" onclick="done();" class="btn btn-danger float-right d p-2 mr-5">SUBMIT</button>

                    <input type="button" class="next float-right c p-2 mr-5" id="next" name="next" value="NEXT" onclick="increment()">



                    <!--                    <br>-->
                </form>
            </div>
        </div>


    </div>

    <footer class="mt-5 pt-5">
        <div class="text-center p-5">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>


    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!--    </div>-->
</body>

</html>

<script type="text/javascript">
    var radio1;
    var qid;
    var reid;
    var marked_array = [6]; //change size to no of questions
    // initialize
    var myAnswers = [];
    localStorage.removeItem('myAnswers');


    function SaveOption() {
        qid = document.getElementById("div_of_qid").value;

        reid = document.getElementById("enrno").value;
        //alert(reid);
        var radios = document.getElementsByName('options');
        //var x="radio_marked"+window.counter;
        //alert(x);


        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                radio1 = radios[i].value;
                //save marked answer in localStorage
                //localStorage.(document.getElementById("div_of_qid").value) = radio1;

                //                if (i == 0) {
                //                    myAnswers.push(radio1);
                //                    window.localStorage["myAnswers"] = JSON.stringify(myAnswers);
                //                } else {


                window.localStorage["myAnswers" + counter] = radio1;
                // load saved array
                // if (window.localStorage["myAnswers" + counter] != null)
                //  myAnswers = JSON.parse(window.localStorage["myAnswers" + counter]);
                // modify array
                //myAnswers.push(radio1);
                // re-save array
                //window.localStorage["myAnswers" + counter] = JSON.stringify(myAnswers);
                //}


                break;
            }
        }

        var pass_data = {
            'radio1': radio1,
            'qid': qid,
            'reid': reid,
        };
        //alert(pass_data);
        $.ajax({
            url: "save_result.php",
            type: "POST",
            data: pass_data,
            success: function(data) {}
        });
        return false;
    }

    function SavePassageResult(m, cou) {
        //var m = <?php //echo json_encode($rw['P_ID']); ?>;
        var reid = <?php echo json_encode($_SESSION['U_Enrollment_No']); ?>;
        //qid=document.getElementById(m).value;
        var qid = m;
        var coun = cou;
        // reid=document.getElementById("enrno").value;
        //alert(reid);
        var radios = document.getElementsByName(m);
        //var x="radio_marked"+window.counter;
        //alert(x);

        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                radio1 = radios[i].value;
                //store marked option in localStorage
                window.localStorage["myAnswers" + counter + coun] = radio1;
                break;
            }
        }

        var pass_data = {
            'radio1': radio1,
            'qid': qid,
            'reid': reid,
        };
        //alert(pass_data);
        $.ajax({
            url: "save_passage_result.php",
            type: "POST",
            data: pass_data,
            success: function(data) {}
        });
        return false;
    }

</script>

<script>
    //script to disable right click
    document.addEventListener("contextmenu", function(e) {
        e.preventDefault();
    }, false);

</script>
