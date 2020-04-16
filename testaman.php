<?php
    //Session Start
    session_start();

    //if the user is not logged-in, redirect to login page
    if(!(isset($_SESSION['U_Enrollment_No'])))
    {
        header("location:index.php");
    }

    include("DB_connect.php");

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
        shuffle($qu);       //shuffle the order of the questions    
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

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="image/tmu.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

    <!-- title -->
    <title>Main Test</title>

    <style>
        .page-title {
            padding: 2rem 0;
            background-color: #edeff2;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: #fff;
        }

        .section {
            padding: 4rem 0;
            display: block;
            position: relative;
            background-color: #ffffff;
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

        .sidebar .widget-title {
            display: block;
            font-size: 18px;
            margin: 0 0 2rem;
            padding: 0;
            line-height: 1;
        }

        .sidebar .widget {
            position: relative;
            display: block;
            margin-bottom: 3rem;
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
    <!-- navbar -->
    <div class="navbar  navbar-default bg-dark navbar-dark fixed-top">
        <a class="navbar-brand" href="#">CTLD</a>
        <a class="navbar-brand pull-right" href="#"><i><?php echo $_SESSION['U_Name'] ." (" . $_SESSION['U_Enrollment_No'] .")";  ?></i></a>
    </div>

    <!-- Page Title and Timer -->
    <div class="page-title lb">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-12">
                    <!-- <br><br><b>CT-1<br>Total-Marks: 40</b> -->
                    <br><br><b><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $tname . "<br/>" . "Total marks: " . $tmarks . "<br/>" . $tdate; ?></b>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                    <br><br><b><?php include("timer1.php"); ?></b>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Section -->
    <section class="section">
        <div class="container">
            <div class="row">

                <!-- Start Question Panel Column -->
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-wrapper">
                        <div class="blog-grid-system">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="blog-box">
                                        <div class="blog-meta big-meta">

                                            <!-- Start Change Div -->

                                            <div class="aa">
                                                <div id="txtHint"><b>Question and options will be listed here...</b></div>

                                            </div>
                                            <!-- End Change Div -->

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <form action="thankyou_page.php" method="post" class="button_set">
                            <div class="row">
                                <div class="col-12 col-lg-12 col-sm-12">
                                    <input type="button" class="previous c" id="previous" name="previous" value="PREVIOUS" onclick="show_previous()" />
                                    <input type="button" id="marked" class="c" name="marked" value="MARK FOR REVIEW" onclick="mark_for_review();" />
                                    <button name="submit" id="submit" style="visibility:hidden" onclick="done();" class="btn-danger float-right d">SUBMIT</button>
                                    <input type="button" class="next float-right c mr-1" id="next" name="next" value="NEXT" onclick="increment()" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr class="invis3">

                </div>
                <!-- End Question Panel Column -->

                <!-- Start Buttons and Instructions Column -->
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <div class="sidebar">

                        <div class="widget">
                            <h2 class="widget-title">Question Number Panel</h2>
                            <div class="blog-list-widget">
                                <div class="container">




                                    <!-- Question Number Panel Button PHP CODE START -->
                                    <!--<div class="row">
                                 <?php 
                                
                                for($z=1;$z<=35;$z++)
                                {
                                    ?>

                            <div class="col-xl-2 col-2 py-2"><Button type="button" id="<?php echo ($z-1); ?>" class="btn btn-info clip" onclick="<?php if($z==35){
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
                            </div>-->


                                    <!-- Question Number Panel Button PHP CODE End -->
                                    <div class="row">
                                        <div class="col-xl-2 col-2"><Button type="button" id="0" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=0;showUser(selected_qid[window.counter],window.counter);">&nbsp;1&nbsp;</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="1" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=1;showUser(selected_qid[window.counter],window.counter);">&nbsp;2&nbsp;</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="2" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=2;showUser(selected_qid[window.counter],window.counter);">&nbsp;3&nbsp;</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="3" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=3;showUser(selected_qid[window.counter],window.counter);">&nbsp;4&nbsp;</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="4" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=4;showUser(selected_qid[window.counter],window.counter);">&nbsp;5&nbsp;</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="5" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=5;showUser(selected_qid[window.counter],window.counter);">&nbsp;6&nbsp;</Button></div>
                                    </div></br>
                                    <div class="row">
                                        <div class="col-xl-2 col-2"><Button type="button" id="6" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=6;showUser(selected_qid[window.counter],window.counter);">&nbsp;7&nbsp;</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="7" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=7;showUser(selected_qid[window.counter],window.counter);">&nbsp;8&nbsp;</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="8" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=8;showUser(selected_qid[window.counter],window.counter);">&nbsp;9&nbsp;</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="9" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=9;showUser(selected_qid[window.counter],window.counter);">10</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="10" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=10;showUser(selected_qid[window.counter],window.counter);">11</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="11" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=11;showUser(selected_qid[window.counter],window.counter);">12</Button></div>
                                    </div><br />
                                    <div class="row">
                                        <div class="col-xl-2 col-2"><Button type="button" id="12" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=12;showUser(selected_qid[window.counter],window.counter);">13</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="13" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=13;showUser(selected_qid[window.counter],window.counter);">14</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="14" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=14;showUser(selected_qid[window.counter],window.counter);">15</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="15" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=15;showUser(selected_qid[window.counter],window.counter);">16</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="16" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=16;showUser(selected_qid[window.counter],window.counter);">17</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="17" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=17;showUser(selected_qid[window.counter],window.counter);">18</Button></div>
                                    </div><br />
                                    <div class="row">
                                        <div class="col-xl-2 col-2"><Button type="button" id="18" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=18;showUser(selected_qid[window.counter],window.counter);">19</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="19" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=19;showUser(selected_qid[window.counter],window.counter);">20</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="20" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=20;showUser(selected_qid[window.counter],window.counter);">21</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="21" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=21;showUser(selected_qid[window.counter],window.counter);">22</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="22" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=22;showUser(selected_qid[window.counter],window.counter);">23</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="23" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=23;showUser(selected_qid[window.counter],window.counter);">24</Button></div>
                                    </div><br />
                                    <div class="row">
                                        <div class="col-xl-2 col-2"><Button type="button" id="24" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=24;showUser(selected_qid[window.counter],window.counter);">25</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="25" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=25;showUser(selected_qid[window.counter],window.counter);">26</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="26" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=26;showUser(selected_qid[window.counter],window.counter);">27</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="27" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=27;showUser(selected_qid[window.counter],window.counter);">28</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="28" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=28;showUser(selected_qid[window.counter],window.counter);">29</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="29" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=29;showUser(selected_qid[window.counter],window.counter);">30</Button></div>
                                    </div><br />
                                    <div class="row">
                                        <div class="col-xl-2 col-2"><Button type="button" id="30" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=30;showUser(selected_qid[window.counter],window.counter);">31</Button></div>&nbsp;
                                        <div class="col-xl-2 col-2"><Button type="button" id="31" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=31;showUser(selected_qid[window.counter],window.counter);">32</Button></div>&nbsp;
                                        <div class="col-xl-2 col-2"><Button type="button" id="32" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=32;showUser(selected_qid[window.counter],window.counter);">33</Button></div>
                                        <div class="col-xl-2 col-2"><Button type="button" id="33" class="btn1" onclick="document.getElementById('submit').style.visibility = 'hidden'; window.counter=33;showUser(selected_qid[window.counter],window.counter);">34</Button></div>&nbsp;
                                        <div class="col-xl-2 col-2"><Button type="button" id="34" class="btn1" onclick="document.getElementById('submit').style.visibility = 'visible'; window.counter=34;showUser(selected_qid[window.counter],window.counter);">35</Button></div>
                                    </div>


                                </div>
                            </div><!-- end blog-list -->
                        </div><!-- end widget -->

                        <!-- Start Banner -->
                        <h2 class="widget-title">Instructions</h2>
                        <div class="widget">
                            <div class="banner-spot clearfix">
                                <div class="banner-img">
                                    <img src="image/banner_03.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <!-- End Banner -->
                    </div><!-- end sidebar -->
                </div>
                <!-- End Buttons and Instructions Column -->

            </div><!-- end row -->
        </div><!-- end container -->
    </section>

    <div class="container mb-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="copyright"><span style="color:black;">@All Right Reserved, </span><a href="#">Teerthanker Mahaveer University</a>...</div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

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

</body>

</html>
