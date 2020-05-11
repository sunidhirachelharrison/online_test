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

            }, 300);


        }

        //to show previous question: decrement the counter
        function show_previous() {
            counter = counter - 1;

            if (counter >= 0) {

                showQuestion(selected_qid[counter], counter)

                //code to check the marked options
                setTimeout(function() {
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

    </script>

</head>

<body>
    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;"> <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
        <?php //include("timer1.php"); ?>
    </div>


    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)</a>
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
        <div class="row">
            <div class="col-md-8">
                <nav class="navbar navbar-default title1 aaa fle">
                    <div class="aa">
                        <div id="txtHint"><b>Question and options will be listed here...</b></div>


                    </div>
                </nav>

            </div>
            <div class="col-md-4">
                <nav class="navbar navbar-default title1 aaa">
                    <!--
				<div class="aa1">
					</br>
-->

                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-xl-2 col-2"><Button type="button" id="0" class="btn btn-info clip" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=0;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;1&nbsp;</Button></div>
                            <div class="col-xl-2 col-2"><Button type="button" id="1" class="btn btn-info clip" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=1;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;2&nbsp;</Button></div>
                            <div class="col-xl-2 col-2"><Button type="button" id="2" class="btn btn-info clip" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=2;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;3&nbsp;</Button></div>
                            <div class="col-xl-2 col-2"><Button type="button" id="3" class="btn btn-info clip" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=3;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;4&nbsp;</Button></div>
                            <div class="col-xl-2 col-2"><Button type="button" id="4" class="btn btn-info clip" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=4;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;5&nbsp;</Button></div>
                            <div class="col-xl-2 col-2"><Button type="button" id="5" class="btn btn-info clip" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=5;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;6&nbsp;</Button></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2 col-1"><Button type="button" id="6" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=6;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;7&nbsp;</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="7" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=7;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;8&nbsp;</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="8" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=8;showQuestion(selected_qid[window.counter],window.counter);">&nbsp;9&nbsp;</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="9" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=9;showQuestion(selected_qid[window.counter],window.counter);">10</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="10" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=10;showQuestion(selected_qid[window.counter],window.counter);">11</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="11" class="btn btn-info clip clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=11;showQuestion(selected_qid[window.counter],window.counter);">12</Button></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2 col-1"><Button type="button" id="12" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=12;showQuestion(selected_qid[window.counter],window.counter);">13</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="13" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=13;showQuestion(selected_qid[window.counter],window.counter);">14</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="14" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=14;showQuestion(selected_qid[window.counter],window.counter);">15</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="15" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=15;showQuestion(selected_qid[window.counter],window.counter);">16</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="16" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=16;showQuestion(selected_qid[window.counter],window.counter);">17</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="17" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=17;showQuestion(selected_qid[window.counter],window.counter);">18</Button></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2 col-1"><Button type="button" id="18" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=18;showQuestion(selected_qid[window.counter],window.counter);">19</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="19" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=19;showQuestion(selected_qid[window.counter],window.counter);">20</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="20" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=20;showQuestion(selected_qid[window.counter],window.counter);">21</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="21" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=21;showQuestion(selected_qid[window.counter],window.counter);">22</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="22" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=22;showQuestion(selected_qid[window.counter],window.counter);">23</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="23" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=23;showQuestion(selected_qid[window.counter],window.counter);">24</Button></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2 col-1"><Button type="button" id="24" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=24;showQuestion(selected_qid[window.counter],window.counter);">25</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="25" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=25;showQuestion(selected_qid[window.counter],window.counter);">26</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="26" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=26;showQuestion(selected_qid[window.counter],window.counter);">27</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="27" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=27;showQuestion(selected_qid[window.counter],window.counter);">28</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="28" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=28;showQuestion(selected_qid[window.counter],window.counter);">29</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="29" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=29;showQuestion(selected_qid[window.counter],window.counter);">30</Button></div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2 col-1"><Button type="button" id="30" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=30;showQuestion(selected_qid[window.counter],window.counter);">31</Button></div>&nbsp;
                            <div class="col-xl-2 col-1"><Button type="button" id="31" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=31;showQuestion(selected_qid[window.counter],window.counter);">32</Button></div>&nbsp;
                            <div class="col-xl-2 col-1"><Button type="button" id="32" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=32;showQuestion(selected_qid[window.counter],window.counter);">33</Button></div>
                            <div class="col-xl-2 col-1"><Button type="button" id="33" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=33;showQuestion(selected_qid[window.counter],window.counter);">34</Button></div>&nbsp;
                            <div class="col-xl-2 col-1"><Button type="button" id="34" class="btn btn-info clip mt-3" onclick="document.getElementById('submit').style.visibility = 'visible'; window.counter=34;showQuestion(selected_qid[window.counter],window.counter);">35</Button></div>
                        </div>

                    </div>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <form action="thankyou_page.php" method="post" class="button_set">

                    <input type="button" class="previous p-2 ml-5" id="previous" name="previous" value="PREVIOUS" onclick="show_previous()">

                    <!--                       <input type="button" class="save" id="save" name="save" value="SAVE" >-->


                    <input type="button" id="marked" class="p-2 ml-5" name="marked" value="MARKED FOR REVIEW" onclick="mark_for_review();" />
                    <button name="submit" id="submit" style="visibility:hidden" onclick="done();" class="btn btn-danger float-right p-2 mr-5">SUBMIT</button>

                    <input type="button" class="next float-right p-2 mr-5" id="next" name="next" value="NEXT" onclick="increment()">



                    <br>
                </form>
            </div>
        </div>


        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </div>
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

    function SavePassageResult(m) {
        //var m = <?php //echo json_encode($rw['P_ID']); ?>;
        var reid = <?php echo json_encode($_SESSION['U_Enrollment_No']); ?>;
        //qid=document.getElementById(m).value;
        var qid = m;
        // reid=document.getElementById("enrno").value;
        //alert(reid);
        var radios = document.getElementsByName(m);
        //var x="radio_marked"+window.counter;
        //alert(x);

        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                radio1 = radios[i].value;
                //store marked option in localStorage
                window.localStorage["myAnswers" + counter + m] = radio1;
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
