<?php

    //starting the session
    session_start();

    //if the user is not logged-in, redirect to login page
    if(!(isset($_SESSION['U_Enrollment_No'])))
    {
        header("location:index.php");
    }


    include("DB_connect.php");  //for database connection


         
    $q_fetch_qids="SELECT * FROM state WHERE S_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
    $q_check=mysqli_query($con,$q_fetch_qids);
    $str="";
    $red_btns="";
    $green_btns="";
    $yellow_btns="";
    $purple_btns="";
    if($q_check)
    {
        $q_val=mysqli_fetch_assoc($q_check);
        $str=$q_val['S_Displayed_Q_IDs'];
        $red_btns=$q_val['S_Red_Btns'];
        $green_btns=$q_val['S_Green_Btns'];
        $yellow_btns=$q_val['S_Yellow_Btns'];
        $purple_btns=$q_val['S_Purple_Btns'];
       
    }

    //retrieving button numbers from string sequence to color the buttons on question palette
    $red_btns=str_replace("+"," ",$red_btns);
    $red_btns=explode(" ",$red_btns);

    $green_btns=str_replace("+"," ",$green_btns);
    $green_btns=explode(" ",$green_btns);

    $yellow_btns=str_replace("+"," ",$yellow_btns);
    $yellow_btns=explode(" ",$yellow_btns);

    $purple_btns=str_replace("+"," ",$purple_btns);
    $purple_btns=explode(" ",$purple_btns);


    $string_ids=str_replace("+"," ",$str);
    $temp=explode(" ",$string_ids);
    $qu=array();    //array to store fetched questions
    $i=0;           //counter to store questions in array $qu
    foreach($temp as $temp1)
    {
        
    
        //select each question from questions table whose flag bit is set to 0(i.e. questions selected for a particular test)
        $sql="SELECT * FROM questions WHERE  Q_ID='".$temp1."' and Q_Flag='0'";
        $row=mysqli_query($con,$sql);
        
        if(!($row))
        {
//            echo '<script>alert("Error in fetching question!");</script>';
        }
        else
        {
           
//            $strng="";        //variable to store question ids as a sequence of string to be stored for state management
            $r=mysqli_fetch_assoc($row);
            
            $qu[$i]=$r['Q_ID'];     //fetch ques. and store in array $qu
            $i++;                   //increment counter

            
            //print_r($qu);
//            shuffle($qu);       //shuffle the order of the questions
            //print_r($qu);
            
        //***********************************************************
            //storing question ids in state table sequence-wise
//            foreach($qu as $st)
//            {
//                $strng=$strng."+".$st;
//            }
//            $q_state="INSERT INTO `state`(`S_ID`, `S_AttemptedQ_IDs`, `S_MarkedQ_IDs`, `S_AttemptedQ_count`, `S_MarkedQ_count`, `S_Timer_info`, `S_Enrollment_No`, `S_Displayed_Q_IDs`, `S_Button_Nos`) VALUES (null,null,null,0,0,'0','".$_SESSION['U_Enrollment_No']."','".$strng."',null)";
//            $q_check=mysqli_query($con,$q_state);

        //************************************************************
            
        }
    }


        $query1="SELECT * FROM test WHERE T_Flag='0'";
        $r1=mysqli_query($con,$query1);
        $t_id="";
        $tname="";
        $tdate="";
        $tmarks="";
        $thours="";
        $tminutes="";
        $tquestions="";
        if(!($r1))
        {
            //failed to fetch the test details to be displayed    
        }
        else
        {
            $r2=mysqli_fetch_assoc($r1);
            $t_id=$r2['T_ID'];
            $tname=$r2['T_Name'];
            $tdate=$r2['T_Date'];
            $tmarks=$r2['T_Marks'];
            $thours=$r2['T_Hours'];
            $tminutes=$r2['T_Minutes'];
            $tquestions=$r2['T_Questions'];
            $obj=new DateTime($tdate);
            $tdate=date_format($obj,"d F Y");
        }
//***********************************************************************************


//select the program id and course id to fetch questions and store results course and program wise

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
        $_SESSION['Course_Code']=$ccode;
        $proid=$ro_flag['Prog_ID'];
//        $_SESSION['U_Prog_ID']=$proid;
 // $_SESSION['U_C_ID']=$cid;
    }


//********************************************************************************
    //fetching marked answers of questions in $qu array  and storing in local storage to retain the marked radio options

    $fetched_answers=array();
    $ans_counter=0;
    $passage_ans_id=array();
    $y=0;   //counter to keep track of subquestions
    $passage_ans=array();
    $y2=0;    
    foreach($qu as $id)
    {

        //----------------- fetching from result table --------------------------------
        $sql_fetch_answers="SELECT * FROM result WHERE R_Enrollment_No='".$_SESSION['U_Enrollment_No']."' and R_Q_ID='".$id."' and R_T_ID='".$t_id."' and R_C_ID='".$cid."'";

        $sql_check=mysqli_query($con,$sql_fetch_answers);
        if($sql_check)
        {
            $sql_check_row=mysqli_fetch_assoc($sql_check);
            $fetched_answers[$ans_counter]=$sql_check_row['R_Marked_Answer'];
            $ans_counter++;
        }
        else
        {
            //echo '<script>alert("answers fetching failed!");</script>';
            $ans_counter++;
        }
        
       //------------------- fetching from passage_result table ---------------------- 
        $sql_fetch_passage_id="SELECT * FROM questions WHERE Q_ID='".$id."' and Q_Flag='0' and Q_Test_ID='".$t_id."' and Q_C_ID='".$cid."' and Q_Passage_ID is not null";
        $sql_pid_flag=mysqli_query($con,$sql_fetch_passage_id);
        if($sql_pid_flag)
        {
            $sql_pid_row=mysqli_fetch_assoc($sql_pid_flag);
            $p_id=$sql_pid_row['Q_Passage_ID'];
            if($p_id)
            {
                //fetching subquestions from passage_questions table
                $sql_fetch_pass_qn_id="SELECT * FROM passage_questions WHERE PQ_AssociatedPassage_ID='".$p_id."'";
            
                $sql_pqid_flag2=mysqli_query($con,$sql_fetch_pass_qn_id);
                if($sql_pqid_flag2)
                {
                    while($sql_pqid_row2=mysqli_fetch_assoc($sql_pqid_flag2))
                    {
                        $passage_ans_id[$y]=$sql_pqid_row2['PQ_ID'];
                        $y++;
                    }
                }
            }
            else
            {
                continue;
            }
            
            
        }
        
        //now fetching marked answers of passage sub-questions from passage_result table and storing these answers in $passage_answers array to be later on stored in local storage for state management
        foreach($passage_ans_id as $paid)
        {
            $sql_fetch_passage_answers="SELECT * FROM passage_result WHERE PR_Enrollment_No='".$_SESSION['U_Enrollment_No']."' and PR_T_ID='".$t_id."' and PR_PQ_ID='".$paid."' and PR_C_ID='".$cid."'";
            $pans_flag=mysqli_query($con,$sql_fetch_passage_answers);
            if($pans_flag)
            {
                while($pans_row=mysqli_fetch_assoc($pans_flag))
                {
                    $passage_ans[$y2]=$pans_row['PR_Marked_Answer'];
                    $y2++;
                }
            }
        }
        
        
        
    }
    

//echo '<script>alert('.print_r($passage_ans).'*** '.print_r($fetched_answers).');</script>';
//********************************************************************************

//***************** fetching course name ********************************************


//    $query2="SELECT * FROM course WHERE C_Flag='1' and C_Prog_ID='1'";
//        $r2=mysqli_query($con,$query2);
//        $c_id="";
//        $c_name="";
//        $c_code="";
//        
//        if(!($r2))
//        {
//            //failed to fetch the test details to be displayed    
//        }
//        else
//        {
//            $r3=mysqli_fetch_assoc($r2);
//            $c_id=$r3['C_ID'];
//            $c_name=$r3['C_Name'];
//            $c_code=$r3['C_Code'];
//           
//        }

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

    </style>
    <script type="text/javascript">
        window.counter = 0;
        var selected_qid = <?php echo json_encode($qu); ?>;
        var tquestions = <?php echo json_encode($tquestions); ?>;
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
                document.getElementById(counter).style.background = '#00FF00';
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
            if ((counter == 0) || (counter < (tquestions - 1))) //replace tquestions by (tquestions-1) to fetch tquestions questions
            {
                showQuestion(selected_qid[counter], counter);

            } else if (window.counter == (tquestions - 1)) //replace 5 by 34 to fetch 35 questions
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
                //***code to mark the passage radios stored in local storage array myP
                else if (localStorage.getItem('myP' + j) != null) {

                    console.log("step14");
                    var radios = document.getElementsByTagName('input');
                    for (var i = 0, length = radios.length; i < length; i++) {
                        console.log("step15");
                        var l = localStorage.getItem('myP' + j);
                        console.log("step16");
                        var p = radios[i].value;
                        console.log("step17");
                        if (p == l) {
                            console.log("step18");
                            radios[i].checked = true;
                            //alert(radios[i]);
                            console.log("step19");
                            //break;
                        }
                    }

                }
                //*****
            }

            //}

            //            color_btns();

        }

    </script>
    <script>
        //script to put fetched answers(from db) in local storage to retain marked radio options

        //fetched_answers are of questions and fetched_passage_answers are of passage_questions
        var fetched_answers = <?php echo json_encode($fetched_answers); ?>;
        var fetched_passage_answers = <?php echo json_encode($passage_ans); ?>;

        //storing both fetched_answers and fetched_passage_answers in local storage
        fetched_answers.forEach(store_it_in_local);

        function store_it_in_local(item, index) {

            window.localStorage["myAnswers" + index] = item;
        }


        fetched_passage_answers.forEach(store_it_in_local2);

        function store_it_in_local2(item, index) {
            window.localStorage["myP" + index] = item;

        }


        //            var temp = index;
        //            if (item == "") {
        //                fetched_passage_answers.forEach(store_it_in_local2, index, temp);
        //
        //                //                    window.localStorage["myAnswers" + index + contr] = item;
        //            }


        //        
        //        fetched_passage_answers.forEach(store_it_in_local2, index);
        //

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
                <div class=""><b><?php include("complex_timer2.php"); ?></b></div>
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
            <div class="col-lg-8">

                <div class="container bl mt-3">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div id="txtHint"><b>Question and options will be listed here...</b></div>
                        </div>
                        <div class="col-12 col-lg-12 col-sm-12">
                            <form action="thankyou_page.php" method="post" class="button_set">
                                <input type="button" class="previous c" id="previous" name="previous" value="PREVIOUS" onclick="show_previous()" />
                                <input type="button" id="marked" class="c" name="marked" value="MARK FOR REVIEW" onclick="mark_for_review();" />
                                <button name="submit" id="submit" style="visibility:hidden" onclick="done();" class="btn-danger float-right d">SUBMIT</button>
                                <input type="button" class="next float-right c mr-1" id="next" name="next" value="NEXT" onclick="increment()" />
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
                    for($z=1;$z<=$tquestions;$z++)
                    {
                ?>
                                    <div class="col-xl-2 col-2 p-2"><Button type="button" id="<?php echo ($z-1); ?>" class="btn btn-info clip" onclick="<?php if($z==$tquestions){
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
        var t_id = <?php echo json_encode($t_id); ?>;

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
            't_id': t_id,
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

<script>
    //    window.onload = color_btns(); //color the btns on page load using saved state of btns
    //    window.onload = setTimeout(color_btns(), 1000); //calling color_btns func after 1000 ms so as to load timer on window load
    color_btns(); //color the btns on page load using saved state of btns
    //    document.getElementById(3).style.background = '#FF0000';

    //    setTimeout(function() {
    // color_btns();
    // }, 400);
    function color_btns() {

        var $red_btns = <?php echo json_encode($red_btns); ?>;
        var $green_btns = <?php echo json_encode($green_btns); ?>;
        var $yellow_btns = <?php echo json_encode($yellow_btns); ?>;
        var $purple_btns = <?php echo json_encode($purple_btns); ?>;

        setTimeout(function() {


            $red_btns.forEach(color_it_red);

            function color_it_red(item) {

                document.getElementById(item - 1).style.background = '#FF0000';

            }

        }, 300);



        setTimeout(function() {
            $green_btns.forEach(color_it_green);

            function color_it_green(item) {
                document.getElementById(item - 1).style.background = '#00FF00';
            }


        }, 400);

        setTimeout(function() {
            $yellow_btns.forEach(color_it_yellow);

            function color_it_yellow(item) {
                document.getElementById(item - 1).style.background = '#FFFF00';
            }



        }, 500);

        setTimeout(function() {
            $purple_btns.forEach(color_it_purple);

            function color_it_purple(item) {
                document.getElementById(item - 1).style.background = '#EE82EE';
            }


        }, 600);

    }

</script>

<script type="text/javascript">
    //script to disable F5 for page refresh
    function disableF5(e) {
        if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault();
    };

    $(document).ready(function() {
        $(document).on("keydown", disableF5);
    });

</script>
<script>
    setInterval(function() {
        var rollno = <?php echo json_encode($_SESSION['U_Enrollment_No']); ?>;
        var pass_data = {
            'hours': hours,
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

    }, 30000);

</script>
