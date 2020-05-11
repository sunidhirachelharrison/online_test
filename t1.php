<?php

    //starting the session
    session_start();

    //if the user is not logged-in, redirect to login page
    if(!(isset($_SESSION['U_Enrollment_No'])))
    {
        header("location:index.php");
    }


    include("DB_connect.php");  //for database connection
          //for timer display on top of the page
      

//select the program id and course id to fetch questions and stor results course and program wise

    $sq="SELECT * FROM program p join course c
    ON c.C_Prog_ID=p.Prog_ID
    WHERE p.Prog_Name='".$_SESSION['U_Program']."'";
    $ro=mysqli_query($con,$sq);
    $cid="";
    $cname="";
    $ccode="";
    $proid="";
    if(!($ro))
    {
        echo '<script>alert("Error in fetching program and course details!");</script>';
    }
    else
    {
        $ro_flag=mysqli_fetch_assoc($ro);
        $cid=$ro_flag['C_ID'];
        $cname=$ro_flag['C_Name'];
        $ccode=$ro_flag['C_Code'];
        $proid=$ro_flag['Prog_ID'];
//        $_SESSION['U_Prog_ID']=$proid;
 // $_SESSION['U_C_ID']=$cid;
    }


        //select 35 questions from questions table whose flag bit is set to 0(i.e. questions selected for a particular test)
        $sql="SELECT * FROM questions WHERE Q_Flag='0' and Q_Prog_ID='".$proid."' and Q_C_ID='".$cid."' limit 120";
        $row=mysqli_query($con,$sql);
        
        if(!($row))
        {
            echo '<script>alert("Error in fetching questions!");</script>';
        }
        else
        {
            $qu=array();    //array to store fetched questions
            $i=0;           //counter to store questions in array $qu
            $strng="";        //variable to store question ids as a sequence of string to be stored for state management
            while($r=mysqli_fetch_assoc($row))
            {
                $qu[$i]=$r['Q_ID'];     //fetch ques. and store in array $qu
                $i++;                   //increment counter
                
            }
            //print_r($qu);
            shuffle($qu);       //shuffle the order of the questions
            //print_r($qu);
            
        //***********************************************************
            //storing question ids in state table sequence-wise
            $zz=0;
            foreach($qu as $st)
            {
                if($zz==0)
                {
                    $strng=$strng."".$st;
                }
                else
                {
                    $strng=$strng."+".$st;
                }
                $zz++;
            }
            $q_state="INSERT INTO `state`(`S_ID`, `S_AttemptedQ_IDs`, `S_MarkedQ_IDs`, `S_AttemptedQ_count`, `S_MarkedQ_count`, `S_Timer_info`, `S_Enrollment_No`, `S_Displayed_Q_IDs`, `S_Current_QNo`, `S_Red_Btns`, `S_Green_Btns`, `S_Purple_Btns`, `S_Yellow_Btns`) VALUES (null,null,null,0,0,'0:0','".$_SESSION['U_Enrollment_No']."','".$strng."',null,null,null,null,null)";
            $q_check=mysqli_query($con,$q_state);

        //************************************************************
            
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
                  
//***************** fetching course name ********************************************


//    $query2="SELECT * FROM course WHERE C_Flag='1' and C_Prog_ID='1'";
// $r2=mysqli_query($con,$query2);
// $c_id="";
//// $c_name="";
// $c_code="";
//
// if(!($r2))
// {
// //failed to fetch the test details to be displayed
// }
// else
// {
// $r3=mysqli_fetch_assoc($r2);
// $c_id=$r3['C_ID'];
// $c_name=$r3['C_Name'];
// $c_code=$r3['C_Code'];
//
// }

//***********************************************************************************

?>


<!DOCTYPE html">
<html>

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

        body {
            background: #e9ecef;
        }

        .bl {
            background: #fff;
            height: 96%;
        }

        #txtHint {
            padding: 25px;
        }

        .sd {
            position: absolute;
            bottom: 10;
        }

        .dd {
            position: relative;
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
                store_btn_color_state(counter, "green");
            } else if (document.getElementById('B').checked) {
                //marked_value = document.getElementById('B').value;
                document.getElementById(counter).style.background = '#00FF00';
                store_btn_color_state(counter, "green");
            } else if (document.getElementById('C').checked) {
                //marked_value = document.getElementById('C').value;
                document.getElementById(counter).style.background = '#00FF00';
                store_btn_color_state(counter, "green");
            } else if (document.getElementById('D').checked) {
                //marked_value = document.getElementById('D').value;
                document.getElementById(counter).style.background = '#00FF00';
                store_btn_color_state(counter, "green");
            } else if (document.getElementById('E').checked) {
                //marked_value = document.getElementById('D').value;
                document.getElementById(counter).style.background = '#00FF00';
                store_btn_color_state(counter, "green");
            } else {
                document.getElementById(counter).style.background = '#FF0000';
                store_btn_color_state(counter, "red");
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
                store_btn_color_state(counter, "yellow");
                //$(button).find(".glyphicon").addClass("glyphicon-ok");
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else if (document.getElementById('B').checked) {
                //marked_value = document.getElementById('B').value;
                document.getElementById(counter).style.background = '#FFFF00';
                store_btn_color_state(counter, "yellow");
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else if (document.getElementById('C').checked) {
                //marked_value = document.getElementById('C').value;
                document.getElementById(counter).style.background = '#FFFF00';
                store_btn_color_state(counter, "yellow");
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else if (document.getElementById('D').checked) {
                //marked_value = document.getElementById('D').value;
                document.getElementById(counter).style.background = '#FFFF00';
                store_btn_color_state(counter, "yellow");
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else if (document.getElementById('E').checked) {
                //marked_value = document.getElementById('D').value;
                document.getElementById(counter).style.background = '#FFFF00';
                store_btn_color_state(counter, "yellow");
                window.counter = window.counter + 1;
                showQuestion(selected_qid[window.counter], window.counter);
            } else {
                document.getElementById(counter).style.background = '#EE82EE';
                store_btn_color_state(counter, "purple");
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

    <script>
        function store_btn_color_state(btn_number, btn_color) {

            var reid = <?php echo json_encode($_SESSION['U_Enrollment_No']); ?>;

            var pass_data = {
                'btn_number': (btn_number + 1),
                'btn_color': btn_color,
                'rollno': reid,
            };
            //alert(pass_data);
            $.ajax({
                url: "update_btn_color_state_in_db.php",
                type: "POST",
                data: pass_data,
                success: function(data) {}
            });
            return false;

        }

    </script>

</head>

<body onselectstart="return false" onkeydown="if ((arguments[0] || window.event).ctrlKey) return false">

    <!-- TMU Logo with Header -->
    <div class="jumbotron" style="margin-bottom:0; padding: 1rem 1rem;">
        <div class="row">
            <div class="col-12 col-lg-4 align-self-start">
                <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
            </div>
            <div class="col-12 col-lg-4 align-self-center"><br>
                <div class="text-center"><b><?php echo $tname . "<br/>". $cname . "("  . $ccode . ")<br/>" . $tdate . "<br/>" . "Total marks: " . $tmarks . "<br/>"; ?></b></div>
            </div>
            <div class="col-12 col-lg-4 text-center align-self-end"><br>
                <div class=""><b><?php include("timer1.php"); ?></b></div>
            </div>
        </div>
    </div>

    <!-- navbar -->
    <div class="navbar  navbar-default bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)</a>
        <a class="navbar-brand pull-right" href="#"><i><?php echo $_SESSION['U_Name'] ." (" . $_SESSION['U_Enrollment_No'] .")";  ?></i></a>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 dd">

                <div class="container bl mt-3">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div id="txtHint"><b>Question and options will be listed here...</b></div>
                        </div>
                        <div class="col-12 col-lg-12 col-sm-12 sd">
                            <form action="thankyou_page.php" method="post" class="button_set">
                                <input type="button" class="previous c" id="previous" name="previous" value="PREVIOUS" onclick="show_previous()" />
                                <input type="button" id="marked" class="c" name="marked" value="MARK FOR REVIEW" onclick="mark_for_review();" />
                                <button name="submit" id="submit" style="visibility:hidden" onclick="done();" class="btn-danger float-right d">SUBMIT</button>
                                <input type="button" class="next float-right c mr-1" id="next" name="next" value=" SAVE & NEXT" onclick="increment()" />
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">

                <div class="container mt-3 bl">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="container">
                                <div class="row">
                                    <?php 
                    for($z=1;$z<=35;$z++)
                    {
                ?>
                                    <div class="col-xl-2 col-2 p-2"><Button type="button" id="<?php echo ($z-1); ?>" class="btn btn-info clip" onclick="<?php if($z==35){
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
                            <br>
                            <img src="image/instructions.jpg" class="img-fluid pb-3" width=100% height=190>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- <footer class="mt-5 pt-5">
        <div class="text-center p-5">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer> -->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

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
        var c_id = <?php echo json_encode($cid); ?>;

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
            'c_id': c_id,
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
        var c_id = <?php echo json_encode($cid); ?>;

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
            'c_id': c_id,
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

<!--
<script>
    setInterval(function() {
        var rollno = <?php //echo json_encode($_SESSION['U_Enrollment_No']); ?>;
        var pass_data = {
            'mins': minutes,
            'secs': seconds,
            'rollno': rollno,
        };
        //        alert(pass_data);
        $.ajax({
            url: "update_time_in_db.php",
            type: "POST",
            data: pass_data,
            success: function(data) {}
        });
        //        return false;

    }, 1000);

</script>
-->
