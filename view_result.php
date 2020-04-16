<?php
    
    include("DB_connect_pdo.php");
    include("DB_connect.php");
    session_start();
    
    $query="SELECT * FROM test";
    $query2="SELECT * FROM program";
    //$conn->exec($query);
    $stmt = $conn->query($query);
    $stmt2=  $conn->query($query2);
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

    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="images/tmu.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>view exam - CTLD</title>
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

</head>

<body>

    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">Vew Result</a>
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
                    <div class="card-header">Select:</div>
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
                    //$name=$result['T_Name'];
                    //$d=$result['T_Date'];
                ?>
                                        <option value="<?php echo $result['T_ID']; ?>"><?php echo $result['T_Name']."  held  on ".$result['T_Date']; ?></option>

                                        <?php  } ?>
                                    </select><br />

                                    Program:
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


                                    Year:
                                    <select name="year" id="year">
                                        <option value="None">None</option>
                                        <option value="I">I</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                        <option value="V">V</option>
                                    </select><br />

                                    Section:
                                    <select name="section" id="section">
                                        <option value="None">None</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                    </select><br />



                                    <input type="submit" name="show" value="SHOW RESULT" class="btn btn-danger" id="show">
                                </form>
                            </div>

                            <?php  
                    $sno=1;
                    if(isset($_POST['show']))
                    {
                        $test_id=$_POST['test_ids'];
                        $prog_id=$_POST['program'];
                        $year=$_POST['year'];
                        $section=$_POST['section'];
//                        $session=$_POST['session'];
//                        $sem=$_POST['sem'];
                        
                          //  echo $test_id . " " . $prog_id . " " . $year . " " . $section;
                    $qry="SELECT distinct(R_Enrollment_No) FROM result join user
                    ON user.U_Enrollment_No=result.R_Enrollment_No 
                    WHERE R_T_ID='".$test_id."'
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
                            $m=$re3['T_Marks'];
                            $name=$re3['T_Name'];
                            //$tot_ques=$re3['T_Marks'];
                            $obj=new DateTime($re3['T_Date']);
                            $d=date_format($obj,"d F Y");
                        
                            ?>

                            <div class="table-responsive mt-3" id="div_to_print">
                                <h5>
                                    <center>Result <?php if($test_id!="None"){echo " of " . $name . "<br/> Date:  " . $d; } ?></center>
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
                           else if($year=='None')
                           {
                                $q1="SELECT * FROM user u join result r 
                                ON u.U_Enrollment_No=r.R_Enrollment_No
                                WHERE r.R_Enrollment_No='".$rno."' AND u.U_Program='".$prog_id."' 
                                GROUP BY r.R_Enrollment_No";   
                           }
                           else if($section=='None')
                            {
                                $q1="SELECT * FROM user u join result r 
                                ON u.U_Enrollment_No=r.R_Enrollment_No
                                WHERE r.R_Enrollment_No='".$rno."' AND u.U_Program='".$prog_id."'  AND u.U_Year='".$year."'
                                GROUP BY r.R_Enrollment_No";   
                            }
                            else
                            {
                                $q1="SELECT * FROM user u join result r 
                                ON u.U_Enrollment_No=r.R_Enrollment_No
                                WHERE r.R_Enrollment_No='".$rno."' AND u.U_Program='".$prog_id."'  AND u.U_Year='".$year."' AND u.U_Section='".$section."' 
                                GROUP BY r.R_Enrollment_No ";   
                            }
                            
                            //fetch total marks of each student
                            $q2="SELECT SUM(r.R_Score_Quantitative) as 'total1', SUM(pr.PR_Score) as 'total2' , COUNT(*) as 'num' 
                            FROM result r join passage_result pr 
                            WHERE r.R_T_ID='".$test_id."' AND pr.PR_T_ID='".$test_id."' AND r.R_Enrollment_No='".$rno."' AND pr.PR_Enrollment_No='".$rno."'";        
                            
                               
                            $marks=0;
                            $total1=0;
                            $total2=0;
                            $r2=mysqli_query($con,$q2);
                            if($r2 && $r3)
                            {
                                $re2=mysqli_fetch_assoc($r2);
                                
                                $total1=$re2['total1'];
                                //$total1=$total1 + 0;
                                $total2=$re2['total2'];
                                $x=$re2['num']; //to eliminate duplicate sum values
                                if($x!=0)
                                {
                                   $total2=$total2/$x; 
                                }
                                else
                                {
                                   $total2=$total2 +0 ; 
                                }
                                
                                $marks= ($total1 + $total2);
                                
                               // echo $total1. " " . $total2 . "**";
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

                                        <td><?php echo $marks;  ?></td>
                                        <td><?php echo $m;  ?></td>
                                        <td><a href="result_show.php?r=<?php echo $re1['U_Enrollment_No'];  ?>&m1=<?php echo $marks;  ?>&m2=<?php echo $m;  ?>&n=<?php echo $re1['U_Name'];;  ?>">CHECK RESPONSE</a></td>

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
                                <a href="#" id="save" class="btn btn-danger" onClick="javascript:fnExcelReport();">SAVE AS EXCEL SHEET</a>
                            </div>

                            <div class="float-right p-2">
                                <a href="#" id="print" class="btn btn-danger" onClick="javascript:PrintDiv();">PRINT</a>
                            </div>


                            <!--			<div class="float-right p-2"><a href="answers.php"><button type="button" class="btn btn-danger" >Check Answers</button></a></div>-->

                        </div>
                    </div>
                </div>
                <br />
            </div>


        </div>

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
