<?php
    
    include("DB_connect_pdo.php");
    include("DB_connect.php");
    session_start();
    
    $query="SELECT * FROM test";
    $query2="SELECT * FROM program";
    $query3="SELECT * FROM course join program on program.Prog_ID=course.C_Prog_ID";
    //$conn->exec($query);
    $stmt = $conn->query($query);
    $stmt2=  $conn->query($query2);
    $stmt3=$conn->query($query3);
    //$stmt = $conn->prepare("SELECT * FROM test");
    //$stmt->execute();
    //$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    //$result = 
    
        
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>View Attendance</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Font Awesome Offline -->
    <link rel="stylesheet" href="Font-Awesome-4.7/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript">
        function fnExcelReport() {

            //***************************************

            $('#result_table').find('#10').css({
                "width": "0px"
            });

            //****************************************


            var tab_text = 'html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
            tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
            tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
            tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

            tab_text = tab_text + "<center><b>Attendance Sheet</b></center>"

            tab_text = tab_text + "<table border='1px solid'>";
            tab_text = tab_text + $('#result_table').html();
            //tab_text = tab_text + $table.html();

            //tab_text = tab_text + $('#result_table').clone().find('table tr th:nth-child(),table tr td:nth-child(10)).remove().end().prop('
            //outerHTML ')
            tab_text = tab_text + '</table></body></html>';

            var data_type = 'data:application/vnd.ms-excel';

            $('#save').attr('href', data_type + ',' + encodeURIComponent(tab_text));
            $('#save').attr('download', 'Marksheet.xls');

        }

    </script>

    <script language="javascript">
        function PrintDiv() {

            //            var $table = $('#result_table').clone();
            //
            //            $table = filterNthColumn($table, 10); //remove Action column
            //
            //            function filterNthColumn($table, n) {
            //                return $table.find('table tr th:nth-child(10),table tr td:nth-child(10)').remove();
            //            }

            // $('#result_table').find('#10').css({
            // "width": "0px"
            // });
            var divToPrint = document.getElementById('div_to_print');
            var popupWin = window.open('', '_blank', 'width=766,height=300');
            popupWin.document.open();
            popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
        }

    </script>

    <style>
        .bg-orange {
            background: #ea5e0d;
        }

    </style>

</head>

<body>

    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">Admin Panel - Vew Result</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <br />
    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <span class="align-middle">Select:</span>
                        <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                    </div>
                    <div class="card-body">
                        <div id="">

                            <div class=" p-1">
                                <form action="#" method="post">
                                    Test Name:
                                    <select name="test_ids" id="test_ids" class="">
                                        <option value="None">None</option>
                                        <?php
                $name="";
                while($result=$stmt->fetch())
                {
                    $te_name=$result['T_Name'];
                    $te_date=$result['T_Date'];
                    $ob=new DateTime($te_date);
                    $d=date_format($ob,"d F Y");
                ?>
                                        <option value="<?php echo $result['T_ID']; ?>"><?php echo $result['T_Name']."  held  on ".$d; ?></option>

                                        <?php  } ?>
                                    </select><br />

                                    <br>Program:
                                    <select name="program" id="program">
                                        <option value="None">None</option>
                                        <?php
                $name="";
                while($result2=$stmt2->fetch())
                {
                    //$pname=$result2['Prog_Name'];
                    
                ?>
                                        <option value="<?php echo $result2['Prog_Name']; ?>"><?php echo $result2['Prog_Name']; ?></option>

                                        <?php  } ?>
                                    </select><br />
                                    <!--//******************************************************************-->

                                    <br>Course:
                                    <select name="course" id="course">
                                        <option value="None">None</option>
                                        <?php
                $name="";
                $course_id="";
                while($resu3=$stmt3->fetch())
                {
                    //$pname=$result2['Prog_Name'];
                    
                ?>
                                        <option value="<?php echo $resu3['C_ID']; ?>"><?php echo $resu3['C_Name']." ( ".$resu3['C_Code']." - ".$resu3['Prog_Name']." )"; ?></option>

                                        <?php  } ?>
                                    </select><br />



                                    <!--***************************************************************-->
                                    <br>Year:
                                    <select name="year" id="year">
                                        <option value="None">None</option>
                                        <option value="I">I</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                        <option value="V">V</option>
                                    </select><br />

                                    <br>Section:
                                    <select name="section" id="section">
                                        <option value="None">None</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                    </select><br />
                                    <br>


                                    <input type="submit" name="show" value="SHOW RESULT" class="btn bg-orange text-white" id="show" onclick="return validate_dropdowns()">
                                </form>
                            </div>

                            <?php  
                    $sno=1;
                            $course_id="";
                    if(isset($_POST['show']))
                    {
                        $test_id=$_POST['test_ids'];
                        $prog_id=$_POST['program'];
                        $course_id=$_POST['course'];
//                        $_SESSION['temp_course_id']=$course_id;
//                        echo '<script>alert('.$_SESSION['temp_course_id'].');</script>';
                        $year=$_POST['year'];
                        $section=$_POST['section'];
//                        $session=$_POST['session'];
//                        $sem=$_POST['sem'];
                        
                          //  echo $test_id . " " . $prog_id . " " . $year . " " . $section;
                    /*$qry="SELECT distinct(R_Enrollment_No) FROM result join user
                    ON user.U_Enrollment_No=result.R_Enrollment_No 
                    WHERE R_T_ID='".$test_id."'
                    ORDER BY U_Program,U_Branch, U_Year,U_Section,U_Enrollment_No";
                    */
                    $qry="SELECT distinct(R_Enrollment_No) FROM result join user
                    ON user.U_Enrollment_No=result.R_Enrollment_No 
                    WHERE R_T_ID='".$test_id."' AND R_C_ID='".$course_id."'
                    ORDER BY U_Program,U_Branch, U_Year,U_Section,U_Enrollment_No";
                    
                        
                        
                    $stmt = $conn->query($qry);
                    $i=0;
                    //$marks=0;
                    $ar_rollno=array();
                    while($r1=$stmt->fetch())
                    {
                        $ar_rollno[$i]=$r1['R_Enrollment_No'];
                        //echo $ar_rollno[$i];
                        //$marks = $marks + $r1['R_Score_Quantitative'];
                        $i++;
                    }
                        //print_r ($ar_rollno);
                            
                        
                    
                    
                        
            ?>

                            <script>
                                //script to get the text of test name dropdown
                                //function dis() {
                                //var v = document.getElementById('test_ids');
                                //var v = v.options[v.selectedIndex].innerHTML;

                                //}
                                //alert(v);
                                //                                if (v == "None") {
                                //                                    dis();
                                //                                }
                                //
                                //                                function dis(x) {
                                //                                    if (x.value == "None") {
                                //                                        document.getElementById("program").disabled = true;
                                //                                    } else {
                                //                                        document.getElementById("program").disabled = false;
                                //                                    }
                                //
                                //                                }

                                //});

                                //                                $(function() {
                                //                                    $('#test_ids').change(function() {
                                //                                        if ($(this).val() == "None") {
                                //                                            $('program').prop('disabled', true);
                                //                                        } else {
                                //                                            $('program').prop('disabled', false);
                                //                                        }
                                //                                    });
                                //                                });

                            </script>

                            <?php
                            $q3="SELECT * FROM test WHERE T_ID='".$test_id."'";
                            $r3=mysqli_query($con,$q3);
                            $re3=mysqli_fetch_assoc($r3);
                            $m=$re3['T_Marks']; //fetching total marks of the current test
                            $name=$re3['T_Name'];   //fetching name of the current test
                            //$tot_ques=$re3['T_Marks'];
                            $obj=new DateTime($re3['T_Date']);
                            $d=date_format($obj,"d F Y");
                        
                        
                            $q4="SELECT * FROM course WHERE C_ID='".$course_id."'";
                            $r4=mysqli_query($con,$q4);
                            $re4=mysqli_fetch_assoc($r4);
                            $c_name=$re4['C_Name'];
                            $c_code=$re4['C_Code'];
                        
                        
                            ?>

                            <div class="table-responsive mt-3" id="div_to_print">
                                <h5>
                                    <center>Result <?php if($test_id!="None"){echo " of " . $name . "<br/>Course Name:&nbsp;".$c_name."&nbsp;&nbsp;<br/>Course Code: ( ".$c_code." )<br/> Date:  " . $d; } ?></center>
                                </h5>
                                <table border="1" class="table table-bordered table-hover" id="result_table">



                                    <tr>
                                        <th>
                                            <center>S.No.</center>
                                        </th>
                                        <th>Enrollment No.</th>
                                        <th>Name</th>
                                        <th>Program</th>
                                        <th>Branch</th>
                                        <th>Year</th>
                                        <th>Section</th>
                                        <th>Marks Obtained</th>
                                        <th>Total Marks</th>

                                        <th id='10'>CHECK RESPONSE</th>
                                        <!--
                                        <th>Test Name</th>
                                        <th>Test Date</th>
                                        <th>Test Time</th>
                                        <th>Test Shift</th>
-->

                                    </tr>
                                    <?php 
                    
                           foreach($ar_rollno as $rno)
                        {
                        
                            if($prog_id=='None')
                            {
                                $q1="SELECT * FROM user u join result r 
                                ON u.U_Enrollment_No=r.R_Enrollment_No
                                WHERE r.R_Enrollment_No='".$rno."' 
                                GROUP BY r.R_Enrollment_No";       
                            }
                            else if($course_id=='None')
                           {
                               $q1="SELECT * FROM user u join result r 
                                ON u.U_Enrollment_No=r.R_Enrollment_No
                                WHERE r.R_Enrollment_No='".$rno."' AND u.U_Program='".$prog_id."'
                                GROUP BY r.R_Enrollment_No";

                           }
                           else if($year=='None')
                           {
                                $q1="SELECT * FROM user u join result r 
                                ON u.U_Enrollment_No=r.R_Enrollment_No
                                WHERE r.R_Enrollment_No='".$rno."' AND u.U_Program='".$prog_id."'  AND r.R_C_ID='".$course_id."'
                                GROUP BY r.R_Enrollment_No";   
                           }
                           
                           else if($section=='None')
                            {
                                $q1="SELECT * FROM user u join result r 
                                ON u.U_Enrollment_No=r.R_Enrollment_No
                                WHERE r.R_Enrollment_No='".$rno."' AND u.U_Program='".$prog_id."' AND r.R_C_ID='".$course_id."'  AND u.U_Year='".$year."'
                                GROUP BY r.R_Enrollment_No";   
                            }
                            else
                            {
                                $q1="SELECT * FROM user u join result r 
                                ON u.U_Enrollment_No=r.R_Enrollment_No
                                WHERE r.R_Enrollment_No='".$rno."' AND u.U_Program='".$prog_id."' AND r.R_C_ID='".$course_id."'  AND u.U_Year='".$year."' AND u.U_Section='".$section."' AND r.R_T_ID='".$test_id."' 
                                GROUP BY r.R_Enrollment_No ";   
                            }
                            
                            //fetch total marks of each student
                           /* $q2="SELECT SUM(r.R_Score_Quantitative) as 'total1', SUM(pr.PR_Score) as 'total2' , COUNT(*) as 'num' 
                            FROM result r join passage_result pr
                            ON pr.R_T_ID=r.PR_T_ID and pr.R_C_ID=r.PR_C_ID and r.PR_Enrollment_No=pr.R_Enrollment_No
                            WHERE r.R_T_ID='".$test_id."' AND pr.PR_T_ID='".$test_id."' AND r.R_Enrollment_No='".$rno."' AND pr.PR_Enrollment_No='".$rno."' ";        
                            */
                               
                            $q2="SELECT SUM(r.R_Score_Quantitative) as 'total1', COUNT(*) as 'num1',r.R_C_ID as 'rcid' FROM result r WHERE r.R_T_ID='".$test_id."'AND r.R_C_ID='".$course_id."' AND r.R_Enrollment_No='".$rno."' ";    
                               
                            $q5="SELECT SUM(pr.PR_Score) as 'total2', COUNT(*) as 'num2', pr.PR_C_ID  as 'prcid' FROM passage_result pr WHERE  pr.PR_T_ID='".$test_id."' AND pr.PR_Enrollment_No='".$rno."' and pr.PR_C_ID='".$course_id."'";   
                               
                            $marks=0;
                            $total1=0;
                            $total2=0;
//                            $cid="";
//                            $pid="";
                            $r2=mysqli_query($con,$q2);
                            $r5=mysqli_query($con,$q5);
                            if($r2 && $r3)
                            {
                                $re2=mysqli_fetch_assoc($r2);
                                $re5=mysqli_fetch_assoc($r5);
                                $x1=$re2['num1']; //to eliminate duplicate sum values
                                $x2=$re5['num2']; //to eliminate duplicate sum values
                                $total1=$re2['total1'];
                                $total2=$re5['total2'];
                                //$total1=$total1 + 0;
//                                echo "@@@@".$x2."##";
//   echo "***".$total2."//<br/>";
//                                $cid=$re2['rcid'];
                                
//                                if($x2!=0)
//                                {
//                                   //$total2=$total2/$x; 
//                                    $total2=$total2; 
//                                }
//                                else
                                if($x2==0)
                                {
                                   $total2=$total2 +0 ; 
                                }
                                
                                $marks= ($total1 + $total2);
                                
//                                echo $total1. "// " . $total2 . "**";
                            }
                               
                            
                            $r=mysqli_query($con,$q1);
                            while($re1=mysqli_fetch_assoc($r))
                            {
                                
                               
                    ?>

                                    <tr>
                                        <td><?php  echo "<center>{$sno}</center>";  ?></td>
                                        <td><?php echo $re1['U_Enrollment_No'];  ?></td>
                                        <td><?php echo $re1['U_Name'];  ?></td>
                                        <td><?php echo $re1['U_Program'];  ?></td>
                                        <td><?php echo $re1['U_Branch'];  ?></td>
                                        <td><?php echo $re1['U_Year'];  ?></td>
                                        <td><?php echo $re1['U_Section'];  ?></td>
                                        <!--                                        <td><?php //echo $re1['U_Section'];  ?></td>-->

                                        <td><?php echo $marks;  ?></td>
                                        <td><?php echo $m;  ?></td>


                                        <td><a href="result_show.php?r=<?php echo $re1['U_Enrollment_No'];  ?>&m1=<?php echo $marks;  ?>&m2=<?php echo $m;  ?>&n=<?php echo $re1['U_Name']; ?>&progname=<?php echo $re1['U_Program'];  ?>&test_id=<?php echo $test_id;  ?>&courseid=<?php echo $course_id;  ?>">CHECK RESPONSE</a></td>

                                    </tr>
                                    <?php $sno++ ; }}  ?>

                                    <tr>
                                        <th colspan="10">
                                            <center>Total Students Appeared:<?php echo " " . --$sno; ?></center>
                                        </th>
                                    </tr>

                                </table>
                                <?php } ?>
                            </div>

                            <div class="float-right p-2">
                                <a href="#" id="save" class="btn bg-orange text-white" onClick="javascript:fnExcelReport();">SAVE AS EXCEL SHEET</a>
                            </div>

                            <div class="float-right p-2">
                                <a href="#" id="print" class="btn bg-orange text-white" onClick="javascript:PrintDiv();">PRINT</a>
                            </div>


                            <!--			<div class="float-right p-2"><a href="answers.php"><button type="button" class="btn btn-danger" >Check Answers</button></a></div>-->

                        </div>
                    </div>
                </div>
                <br />
            </div>


        </div>

    </div>

    <footer class="mt-5">
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>



    <script>
        function validate_dropdowns() {
            //alert("Validating!");
            var test = document.getElementById('test_ids').value;
            var prog = document.getElementById('program').value;
            var course = document.getElementById('course').value;
            var year = document.getElementById('year').value;
            var section = document.getElementById('section').value;

            if (test == "None") {
                alert("Please select a test/exam!");
                document.getElementById("test_ids").focus();
                return false;
            } else if (prog == "None") {
                alert("Please select a program!");
                document.getElementById("program").focus();
                return false;
            } else if (course == "None") {
                alert("Please select a course!");
                document.getElementById("course").focus();
                return false;
            } else if (year == "None") {
                alert("Please select an year!");
                document.getElementById("year").focus();
                return false;
            }
            //            } else if (section == "None") {
            // alert("Please select a section!");
            // document.getElementById("section").focus();
            // return false;
            // }

        }

    </script>




</body>

</html>
