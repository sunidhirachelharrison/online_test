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
                                    Program:
                                    <select name="program" id="program">
                                        <option value="None">None</option>
                                        <?php
                $name="";
                while($result2=$stmt2->fetch())
                {
                    //$pname=$result2['Prog_Name'];
                    
                ?>
                                        <option value="<?php echo $result2['Prog_ID']; ?>"><?php echo $result2['Prog_Name']; ?></option>

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
                    $sno=0;
                    if(isset($_POST['show']))
                    {
                        $test_id=$_POST['test_ids'];
                        $prog_id=$_POST['program'];
                        $year=$_POST['year'];
                        $section=$_POST['section'];
//                        $session=$_POST['session'];
//                        $sem=$_POST['sem'];
                        
                            echo $test_id . " " . $prog_id . " " . $year . " " . $section;
                    $qry="SELECT distinct(R_Enrollment_No) FROM result WHERE R_T_ID='".$test_id."'";
                    $stmt = $conn->query($qry);
                    
                    $i=0;
                    $rollno=array();
                    while($result=$stmt->fetch())
                    {
                        //$result=$stmt->fetch();
                        $rollno[$i]=$result['R_Enrollment_No'];
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
                                    <center>Attendance <?php //if($prog_id!="None"){echo " of " . $prog_id . " <script>document.write(v);</script> "; } ?></center>
                                </h5>
                                <table border="1" class="table table-bordered table-hover" id="result_table">
                                    <tr>
                                        <th>
                                            <center>S.No.</center>
                                        </th>
                                        <th>Enrollment No.</th>
                                        <th>Name</th>
                                        <th>Program</th>
                                        <th>Test Name</th>
                                        <th>Test Date</th>
                                        <th>Test Time</th>
                                        <th>Test Shift</th>
                                    </tr>
                                    <?php 
                    
                        foreach($rollno as $enrno)
                        {
                            
                            if($prog_id=="None"){
                                $sql1="SELECT * FROM user WHERE U_Enrollment_No='".$enrno."'";
                            }
                            else if($year=="None")
                            {
                                $sql1="SELECT * FROM user WHERE U_Enrollment_No='".$enrno."' AND U_Program='".$prog_id."'";
                            }      
                            else if($section=="None")
                            {
                                $sql1="SELECT * FROM user WHERE U_Enrollment_No='".$enrno."' AND U_Program='".$prog_id."' AND U_Year='".$year."'";
                            }
                            else
                            {
                                $sql1="SELECT * FROM user WHERE U_Enrollment_No='".$enrno."' AND U_Program='".$prog_id."' AND U_Year='".$year."' AND U_Section='".$section."'";
                            }
                            
                            $st1 = $conn->query($sql1);

                            $sql2="SELECT * FROM test WHERE T_ID='".$test_id."'";
                            $st2 = $conn->query($sql2);
//                            $re1=$st1->fetch();
//                            $st = $conn->query($sql1);
                            
                            //$sno=0;
                            $re1=$st1->fetch();
                            $re2=$st2->fetch();
                            
                            $tid=$re2['T_ID'];
                            $tname=$re2['T_Name'];
                            $tdate=$re2['T_Date'];
                            //$ttime=$re2['T_Time'];
                            //$tshift=$re2['T_Shift'];
                            
                            if($re1){
                                $sno++;
                        
                    ?>

                                    <tr>
                                        <td><?php  echo "<center>{$sno}</center>";  ?></td>
                                        <td><?php echo $re1['U_Enrollment_No'];  ?></td>
                                        <td><?php echo $re1['U_Name'];  ?></td>
                                        <td><?php echo $re1['U_Program'];  ?></td>
                                        <td><?php echo $re1['U_Year'];  ?></td>
                                        <td><?php echo $re1['U_Section'];  ?></td>

                                        <td><?php echo $tname;  ?></td>
                                        <td><?php echo $tdate; } ?></td>
                                        <td><?php //echo $ttime;  ?></td>
                                        <td><?php //echo $tshift; } ?></td>

                                    </tr>
                                    <?php }  ?>
                                    <!--                                    <tr>-->
                                    <?php  
//                        if($prog=="None")
//                        {
//                            $qy="SELECT * FROM user";
//                        }
//                        else
//                        {
//                            $qy="SELECT * FROM user WHERE U_Program='".$prog."'";
//                        }
//                        $s = $conn->query($qy);
//                        $r=$s->rowCount();  //to count total strength
//                    
                ?>

                                    <!--
                                        <th colspan="4">
                                            <center>Students Appeared for test :<?php //echo "  ". $sno; ?></center>
                                        </th>
                                        <th colspan="4">
                                            <center>Total Students :<?php //echo "  ". $r; ?></center>
                                        </th>
-->
                                    <!--                                    </tr>-->

                                    <?php }  ?>

                                </table>

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
