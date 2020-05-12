<?php
    
    include("DB_connect_pdo.php");
    session_start();
    
    $query="SELECT * FROM test";
    //$conn->exec($query);
    $stmt = $conn->query($query);
    //$stmt = $conn->prepare("SELECT * FROM test");
    //$stmt->execute();
    //$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    //$result = 

    $sql="SELECT * FROM course";
    //$conn->exec($query);
    $stmt_sql = $conn->query($sql);
        
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
            var tab_text = 'html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
            tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
            tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
            tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

            tab_text = tab_text + "<center><b>Attendance Sheet</b></center>"

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
        <a class="navbar-brand" href="#">Admin Panel - Vew Attendance</a>
    </nav>
    <br />
    <div class="container-fluid">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <span class="align-middle">Select Test:</span>
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
                    $name=$result['T_Name'];
                    $d=$result['T_Date'];
                    $ob=new DateTime($d);
                    $d=date_format($ob,"d F Y");
                    
                ?>
                                        <option value="<?php echo $result['T_ID']; ?>"><?php echo $result['T_Name']."  held  on ".$d; ?></option>

                                        <?php  } ?>
                                    </select><br />


                                    <!--
           <select name="session" id="session">
               <option value="None">None</option>
           </select>   
           <script type="text/javascript">
                $(function () {
                    //Reference the DropDownList.
                    var ddlYears = $("#session");

                    //Determine the Current Year.
                    var currentYear = (new Date()).getFullYear();

                    //Loop and add the Year values to DropDownList.
                    for (var i = (currentYear-15); i <= currentYear; i++) {
                        var option = $("<option />");
                        option.html(i);
                        option.val(i);
                        ddlYears.append(option);
                    }
                });
            </script>
            <select name="sem" id="sem">
               <option value="None">None</option>
               <option value="Odd">Odd</option>
               <option value="Even">Even</option>
           </select>
-->

                                    </br>Program:
                                    <select name="program" id="program">
                                        <option value="None">None</option>

                                        <?php
                                    
                                    $sqlfetch="SELECT * FROM program";
                                    $statemnt= $conn->query($sqlfetch);
                    
                                    while($resultfetch=$statemnt->fetch())
                                    {

                                    
                                    ?>


                                        <option value="<?php echo $resultfetch['Prog_Name'];?>"><?php echo $resultfetch['Prog_Name'];?></option>

                                        <?php 
                                    }
                                        ?>
                                    </select><br />

                                    <br>Course Name:
                                    <select name="course_ids" id="course_ids" class="">
                                        <option value="None">None</option>
                                        <!--                                        <option value="None">None</option>-->
                                        <?php
                $cname="";
                while($result_2=$stmt_sql->fetch())
                {
                    $cname=$result_2['C_Name'];
                    $ccode=$result_2['C_Code'];
                    $cid=$result_2['C_ID'];
                ?>
                                        <option value="<?php echo $cid; ?>"><?php echo $cname; ?></option>

                                        <?php  } ?>
                                    </select><br />

                                    <br>
                                    <input type="submit" name="show" value="SHOW" class="btn bg-orange text-white" id="show" onclick="return validate_dropdowns()">
                                </form>
                            </div>

                            <?php  
                    $sno=0;
                    if(isset($_POST['show']))
                    {
                        $val=$_POST['test_ids'];
                        $prog=$_POST['program'];
                        $c_id=$_POST['course_ids'];
//                        $session=$_POST['session'];
//                        $sem=$_POST['sem'];
                        
                         //   echo $val;
                    $qry="SELECT distinct(R_Enrollment_No),R_Shift FROM result WHERE R_T_ID='".$val."'";
                        
                    $qry_fetch_names="SELECT * FROM test WHERE T_ID='".$val."'";    //query to fetch the test name and date of selected dropdown 
                        $stmt_fetch_names = $conn->query($qry_fetch_names);
                        $result_fetch_names=$stmt_fetch_names->fetch();
                        $testname=$result_fetch_names['T_Name'];
                        $testdate=$result_fetch_names['T_Date'];
                        $obj=new DateTime($testdate);
                        $testdate=date_format($obj,"d F Y");
//                        if($c_id!=='None')
// {
// $qry="SELECT distinct(R_Enrollment_No),R_Shift FROM result WHERE R_T_ID='".$val."' and R_C_ID='".$c_id."'";
//
// }
// if($c_id!=='None')
// {
// $qry="SELECT distinct(R_Enrollment_No),R_Shift FROM result WHERE R_T_ID='".$val."' and R_C_ID='".$c_id."'";
//
// }
                    $stmt = $conn->query($qry);
                    
                    $i=0;
                    $rollno=array();
                    $shift=array();
                    while($result=$stmt->fetch())
                    {
                        //$result=$stmt->fetch();
                        $rollno[$i]=$result['R_Enrollment_No'];
                        $shift[$i]=$result['R_Shift'];
                        $i++;
                    }
                    
                        
            ?>

                            <script>
                                //script to get the text of test name dropdown
                                var v = document.getElementById('test_ids');
                                var v = v.options[v.selectedIndex].innerHTML;

                            </script>

                            <div class="table-responsive mt-3" id="div_to_print">
                                <h5>
                                    <center>Attendance <?php if($c_id!="None"){ echo "of ".$cname." ("; }
                        if($prog!="None"){ echo "  " . $prog . " ";} echo $testname." held on ".$testdate." ";  if($c_id!="None"){ echo ")"; } ?></center>
                                </h5>
                                <table border="1" class="table table-bordered table-hover" id="result_table">
                                    <tr>
                                        <th>
                                            <center>S.No.</center>
                                        </th>
                                        <th>Enrollment No.</th>
                                        <th>Name</th>
                                        <th>Program</th>
                                        <th>Year</th>
                                        <th>Section</th>
                                        <!--                                        <th>Course Name</th>-->
                                        <th>Test Name</th>
                                        <th>Test Date</th>
                                        <th>Test Time</th>
                                        <th>Test Shift</th>
                                    </tr>
                                    <?php 
                    
                        $x=0;
                        foreach($rollno as $enrno)
                        {
                            
                            if($prog=="None"){
                                $sql1="SELECT * FROM user WHERE U_Enrollment_No='".$enrno."'";
                            }
                            else if($c_id=="None")
                            {
                                $sql1="SELECT * FROM user WHERE U_Enrollment_No='".$enrno."' AND U_Program='".$prog."'";
                            }
                            else
                            {
                                /*
                                $sql1="SELECT * FROM user 
                                WHERE U_Enrollment_No='".$enrno."' AND U_Program='".$prog."'";*/
                                 $sql1="SELECT distinct(U_Enrollment_No),U_Name,U_Program,U_Year,U_Section FROM user u join result r
                            on u.U_Enrollment_No=r.R_Enrollment_No
                            WHERE U_Enrollment_No='".$enrno."' AND U_Program='".$prog."' and r.R_C_ID='".$c_id."'";
                            }
                            
                            $st1 = $conn->query($sql1);

                            $sql2="SELECT * FROM test WHERE T_ID='".$val."'";
                            $st2 = $conn->query($sql2);
//                            $re1=$st1->fetch();
//                            $st = $conn->query($sql1);
                            
                            //$sno=0;
                            $re1=$st1->fetch();
                            $re2=$st2->fetch();
                            
                            $tid=$re2['T_ID'];
                            $tname=$re2['T_Name'];
                            $tdate=$re2['T_Date'];
                            $obj=new DateTime($tdate);
                            $tdate=date_format($obj,"d F Y");
                            if($shift[$x]=='A')
                            {
                                $ttime=$re2['T_Time_ShiftA'];
                                $tshift="A";
                            }
                            else if($shift[$x]=='B')
                            {
                                $ttime=$re2['T_Time_ShiftB'];
                                $tshift="B";                                
                            }
                            else if($shift[$x]=='C')
                            {
                                $ttime=$re2['T_Time_ShiftC'];
                                $tshift="C";   
                            }
                            $x++;
                            if($re1!=null){
                                $sno++;
                        
                    ?>

                                    <tr>
                                        <td><?php  echo "<center>{$sno}</center>";  ?></td>
                                        <td><?php echo $re1['U_Enrollment_No'];  ?></td>
                                        <td><?php echo $re1['U_Name'];  ?></td>
                                        <td><?php echo $re1['U_Program'];  ?></td>
                                        <td><?php echo $re1['U_Year'];  ?></td>
                                        <td><?php echo $re1['U_Section'];  ?></td>
                                        <!--                                        <td><?php //echo $cname;  ?></td>-->
                                        <td><?php echo $tname;  ?></td>
                                        <td><?php echo $tdate;  ?></td>
                                        <td><?php echo $ttime;  ?></td>
                                        <td><?php echo $tshift; } ?></td>
                                    </tr>
                                    <?php }  ?>
                                    <tr>
                                        <?php  
                        if($prog=="None")
                        {
                            $qy="SELECT * FROM user";
                        }
                        else if($c_id=="None")
                        {
                            $qy="SELECT * FROM user WHERE U_Program='".$prog."'";
                        }
                        else 
                        {
                          /*  
                            $qy="SELECT distinct(R_Enrollment_No) FROM user u join result r
                            on u.U_Enrollment_No=r.R_Enrollment_No
                            WHERE u.U_Program='".$prog."' and r.R_C_ID='".$c_id."'";
                            */
                            /*$qy="SELECT distinct(R_Enrollment_No) FROM user u join result r
                            on u.U_Enrollment_No=r.R_Enrollment_No
                            WHERE u.U_Program='".$prog."'";
                        */
                            $qy="SELECT * FROM user WHERE U_Program='".$prog."'";
                        }
                        $s = $conn->query($qy);
                        $r=$s->rowCount();  //to count total strength
                    
                ?>

                                        <th colspan="5">
                                            <center>Students Appeared for test :<?php echo "  ". $sno; ?></center>
                                        </th>
                                        <th colspan="5">
                                            <center>Total Students :<?php echo "  ". $r; ?></center>
                                        </th>
                                    </tr>

                                    <?php } ?>

                                </table>

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

    <footer class="mt-2">
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
            var course = document.getElementById('course_ids').value;


            if (test == "None") {
                alert("Please select a test/exam!");
                document.getElementById("test_ids").focus();
                return false;
            }
            //            } else if (prog == "None") {
            //                alert("Please select a program!");
            //                document.getElementById("program").focus();
            //                return false;
            //            } else if (course == "None") {
            //                alert("Please select a course!");
            //                document.getElementById("course_ids").focus();
            //                return false;
            //            }
        }

    </script>

</body>

</html>
