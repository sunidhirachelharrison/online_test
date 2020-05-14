<?php
    
    include("DB_connect.php");
    session_start();
    
    if(!(isset($_SESSION['U_Enrollment_No'])))
    {
        header("location:index.php");
    }

    $ro=$_GET['r'];
    $obt_ma=$_GET['m1'];
    $tot_m=$_GET['m2'];
    $name=$_GET['n'];
    $progname=$_GET['progname'];
    $test_id=$_GET['test_id'];
    $course_id=$_GET['courseid'];



    $q="SELECT * FROM result WHERE R_Enrollment_No='".$ro."' AND R_T_ID='".$test_id."' AND R_C_ID='".$course_id."'";
    $r=mysqli_query($con,$q);
    if(!($r))
    {
        echo '<script>alert("Failed to fetch the result of this user!");</script>';
    }
    else
    {
        
        $q_ids=array();
        $marked_answers=array();
        $i=0;
        while($result=mysqli_fetch_assoc($r))
        {
            $q_ids[$i]=$result['R_Q_ID'];
            $marked_answers[$i]=$result['R_Marked_Answer'];
            $i++;
        }

        //counter for marked answer array = $j
        $j=0;
        $correct=0;
        $incorrect=0;
        
        foreach( $q_ids as $id )
        {
            //select record from question table with matching qid
            $qry="SELECT * FROM questions WHERE Q_ID='".$id."'";
            $a=mysqli_query($con,$qry);
            if(!($a))
            {
                echo '<script>alert("Failed to fetch the question with matching Question ID");</script>';
            }
            else
            {
                //fetch correct answer of selected question
                $row=mysqli_fetch_assoc($a);
                $ans=$row['Q_Answer'];
                $marks=$row['Q_Alloted_Marks'];
                if($ans===$marked_answers[$j])
                {
                    
                    $correct++;
                   
                }
                else
                {
                    
                    $incorrect++;
                }
            }
            $j++;
        }
            
    }


        //result from passage_result table
        $j2=0;        
        $correct2=0;
        $incorrect2=0;
        
    $q2="SELECT * FROM passage_result WHERE PR_Enrollment_No='".$ro."' and PR_T_ID='".$test_id."' AND PR_C_ID='".$course_id."'";
    $r2=mysqli_query($con,$q2);
    if(!($r2))
    {
        echo '<script>alert("Failed to fetch the result of passage this user!");</script>';
    }
    else
    {
        
        $q_ids2=array();
        $marked_answers2=array();
        $i2=0;
        while($result2=mysqli_fetch_assoc($r2))
        {
            $q_ids2[$i]=$result2['PR_PQ_ID'];
            $marked_answers2[$i2]=$result2['PR_Marked_Answer'];
            $i2++;
        }
        //counter for marked answer array = $j2

        $j2=0;
        foreach( $q_ids2 as $id2 )
        {
            //select record from question table with matching qid
            $qry2="SELECT * FROM passage_questions WHERE PQ_ID='".$id2."'";
            $a2=mysqli_query($con,$qry2);
            if(!($a2))
            {
                echo '<script>alert("Failed to fetch the question with matching Question ID");</script>';
            }
            else
            {
                //fetch correct answer of selected question
                $row2=mysqli_fetch_assoc($a2);
                $ans2=$row2['PQ_Answer'];
                $marks2=$row2['PQ_Alloted_Marks'];
                if($ans2===$marked_answers2[$j2])
                {
                    
                    $correct2++;
                                        
                }
                else
                {
                    
                    $incorrect2++;
                }
            }
            $j2++;
        }
        
    
        
        
        
    }

    //to count total questions in test
    $sql_fetch_pid="SELECT Prog_ID FROM program WHERE Prog_Name='".$progname."'";
    $re_flag=mysqli_query($con,$sql_fetch_pid);
    $pid="";
    if($re_flag)
    {
        $re_row=mysqli_fetch_assoc($re_flag);
        $pid=$re_row['Prog_ID'];
    }

    $sql_fetch_cid="SELECT C_ID FROM course WHERE C_Prog_ID='".$pid."' and C_Flag='1'";
    $re_flag2=mysqli_query($con,$sql_fetch_cid);
    $cid="";
    if($re_flag2)
    {
        $re_row2=mysqli_fetch_assoc($re_flag2);
        $cid=$re_row2['C_ID'];
    }

    $sql="SELECT * FROM questions WHERE Q_Flag='0' AND Q_Prog_ID='".$pid."' and Q_C_ID='".$course_id."' and Q_Test_ID='".$test_id."'";
    $re=mysqli_query($con,$sql);
    
    if($re)
    {
        $tot_ques=mysqli_num_rows($re);
    }

//count total long questions
$sql_p="SELECT * FROM questions WHERE Q_Flag='0' AND Q_Prog_ID='".$pid."' and Q_C_ID='".$course_id."' and Q_Test_ID='".$test_id."' and Q_Passage_ID is not null";
    $re_p=mysqli_query($con,$sql_p);
    $tot_pass="";
    if($re_p)
    {
        $tot_pass=mysqli_num_rows($re_p);
    }


?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="images/tmu.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Result - CTLD</title>

    <script type="text/javascript">
        function fnExcelReport() {
            var tab_text = 'html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
            tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
            tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
            tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

            tab_text = tab_text + "<table border='1px solid'>";
            tab_text = tab_text + $('#result_table').html();
            tab_text = tab_text + '</table></body></html>';

            var data_type = 'data:application/vnd.ms-excel';

            $('#save').attr('href', data_type + ',' + encodeURIComponent(tab_text));
            $('#save').attr('download', 'Marksheet.xls');

        }

    </script>

    <script language="javascript">
        function PrintDiv() {
            var divToPrint = document.getElementById('printdiv');
            var popupWin = window.open('', '_blank', 'width=766,height=300');
            popupWin.document.open();
            popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
        }

    </script>

</head>

<body>

    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <br />
    <!--    <div><?php //echo $c_code. "*********"; ?></div>-->
    <div class="container-fluid">
        <div id="printdiv">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-md-12 p-4">

                    <div class="card">
                        <div class="card-header">Student's Score<br />Enrollment No: <?php  echo $ro . "<br/> Name: " .$name ; ?></div>
                        <div class="card-body">
                            <div id="">

                                <div class="table-responsive" id="div_to_print">
                                    <table class="table table-bordered table-hover" id="result_table">
                                        <tr>
                                            <th>Course Name</th>
                                            <th>Correct</th>
                                            <th>Incorrect</th>
                                            <th>Long Questions</th>

                                            <th>Total Questions in Test</th>
                                            <th>Obtained Marks</th>
                                            <th>Total Marks</th>
                                        </tr>
                                        <th><?php echo $progname; ?></th>
                                        <td><?php echo $correct; ?></td>
                                        <td><?php echo $incorrect ; ?></td>
                                        <td><?php echo $tot_pass ; ?></td>
                                        <!--                                        <td><?php //echo ($tot_ques-($correct + $incorrect)) ; ?></td>-->


                                        <td><?php echo $tot_ques; ?></td>
                                        <td><?php echo $obt_ma; ?></td>
                                        <td><?php echo $tot_m; ?></td>
                                        <!--
        //************* result for verbal aptitude *******************
					<tr>
						<th>Verbal Aptitude</th>
						<td>7</td>
						<td>8</td>
						<td>15</td>
						<td>15</td>
						<td>7</td>
					</tr>
        
-->
                                        <!--
					<tr>
						<th class="text-left">Total</th>
						<td>32</td>
						<td>18</td>
						<td>50</td>
						<td>50</td>
						<td>32</td>
					</tr>
    //*************************************************
-->
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <br />


                    <?php 
    
                            include("answers.php");
                        
                //************* now fetch long questions and answers
                $sql1="SELECT * FROM passage_result WHERE PR_Enrollment_No='".$ro."' AND PR_T_ID='".$test_id."' and PR_C_ID='".$course_id."'";
                $row1=mysqli_query($con,$sql1);
                if(!($row1))
                {
                    echo '<script>alert("Failed to fetch the long questions data!");</script>';
                }
                else
                {
                    $ar_pqid=array();
                    $ar_manswer=array();
                    $i=0;
                    while($result1=mysqli_fetch_assoc($row1))
                    {
                        //fetching id of subquestions of a passage
                        $ar_pqid[$i]=$result1['PR_PQ_ID'];
                        $ar_manswer[$i++]=$result1['PR_Marked_Answer'];
                    }

                
                        ?>



                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">Long Questions</div>
                            <div class="card-body">
                                <div id="">

                                    <?php
                    
                    $queryA="SELECT * FROM questions WHERE Q_Flag='0' AND Q_Passage_ID is not null AND Q_Prog_ID='".$pid."' AND Q_C_ID='".$course_id."' AND Q_Test_ID='".$test_id."' ";
                    $rowA=mysqli_query($con,$queryA);
                    $pas_id=array();
                    $x=0;
                    if($rowA)
                    {
                        while($resultA=mysqli_fetch_assoc($rowA))
                        {
                            $pas_id[$x++]=$resultA['Q_Passage_ID'];
                        }

                    }
                    $counter=1;
                    foreach($pas_id as $pid)
                    {

                        $queryB="SELECT P_Description FROM passage WHERE P_ID='".$pid."'";
                        $rowB=mysqli_query($con,$queryB);
                        
                        if($rowB)
                        {
                            $resultB=mysqli_fetch_assoc($rowB);
                            echo $counter++ . ") " . $resultB['P_Description'] . "<br/>";

                    
                    ?>


                                    <div class="row" id="answer_print">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">Correct</div>
                                                <div class="card-body">

                                                    <div class="table-responsive" id="div_to_print_correct_answers2">
                                                        <table class="table table-bordered table-hover">

                                                            <?php 
                    
                    //fetch correct answer and marked answer of each of these questions and display them 
                    
                            $j=0;
                            $wrong_qids=array();
                            $right_qids=array();
                            $wrong_qids_ans=array();
                            $y=1;   //counter for numbering correct subquestions
                    foreach($ar_pqid as $id)
                    {
                        $sql2="SELECT * FROM passage_questions WHERE PQ_ID='".$id."' AND PQ_AssociatedPassage_ID='".$pid."'"; 
                        $row2=mysqli_query($con,$sql2);
                        
                        $c=0;
                        if($row2)
                        {
                            
                            $result2=mysqli_fetch_assoc($row2);
                            $ans=$result2['PQ_Answer']; 
                            if($ans===$ar_manswer[$j++])
                            {
                               
                            //show sub-question with correct answer
                                                        
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $y++ . ") " . $result2['PQ_Description'] . "<br />";?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <?php   echo "Correct Answer: " . $ans . "<br />"; ?>

                                                                </td>
                                                            </tr>

                                                            <?php }
                        else
                        {
                            //else block storee qid of subquestions in array whose answer is wrong
                            $wrong_qids[$c]=$result2['PQ_ID'];
                            $wrong_qids_ans[$c]=$result2['PQ_Description'];
                            $c++;
                        }
                        }} 
                        

                                                            ?>
                                                        </table>
                                                    </div>

                                                    <?php
                                                    


                                                        ?>
                                                </div>

                                            </div>
                                        </div>
                                        <!--                                </div>-->
                                        <!--  display incorrect questions and answers -->








                                        <?php
                            }
                
                                
                                ?>

                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>

                        <?php 
                } //end of passage fetch foreach loop
                                ?>

                        <!-- ****************************************************  -->


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--#####################################################################-->

    <!--
                <div class="float-right p-2">
                    <a href="#" id="save" class="btn btn-danger" onClick="javascript:fnExcelReport();">SAVE AS EXCEL SHEET</a>
                </div>-->

    </div>
    </div>
    <div class="float-right p-2">
        <a href="#" id="print" class="btn btn-danger" onClick="javascript:PrintDiv();">PRINT</a>
    </div>


    <!--                <div class="float-right p-2"><a href="answers.php"><button type="button" class="btn btn-danger">Check Answers</button></a></div>-->
    <!--                    </div>-->




    <!--                </div>-->
    <br />

    <div class="col-1"></div>



    </div>


    <footer class="mt-2">
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
