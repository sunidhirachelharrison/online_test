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
        <a class="navbar-brand" href="index.php">Vew Attendance</a>
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
                    <div class="card-header">Select Test:</div>
                    <div class="card-body">
                        <div id="">

                            <div class=" p-1">
                                <form action="#" method="post">
                                    Test Name:
                                    <select name="test_ids" id="test_ids" class="">
                                        <?php
                $name="";
                while($result=$stmt->fetch())
                {
                    $name=$result['T_Name'];
                    $d=$result['T_Date'];
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
                                    
                                    $sqlfetch="SELECT * FROM program";
                                    $statemnt= $conn->query($sqlfetch);
                    
                                    while($resultfetch=$statemnt->fetch())
                                    {

                                    
                                    ?>


                                        <option value="<?php echo $resultfetch['Prog_Name'];?>"><?php echo $resultfetch['Prog_Name'];?></option>

                                        <?php 
                                    }
                                        ?>
                                    </select>
                                    <input type="submit" name="show" value="SHOW" class="btn btn-danger" id="show">
                                </form>
                            </div>

                            <?php  
                    $sno=0;
                    if(isset($_POST['show']))
                    {
                        $val=$_POST['test_ids'];
                        $prog=$_POST['program'];
//                        $session=$_POST['session'];
//                        $sem=$_POST['sem'];
                        
                         //   echo $val;
                    $qry="SELECT distinct(R_Enrollment_No),R_Shift FROM result WHERE R_T_ID='".$val."'";
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
                                    <center>Attendance <?php if($prog!="None"){echo " of " . $prog . " <script>document.write(v);</script> "; } ?></center>
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
                    
                        $x=0;
                        foreach($rollno as $enrno)
                        {
                            
                            if($prog=="None"){
                                $sql1="SELECT * FROM user WHERE U_Enrollment_No='".$enrno."'";
                            }
                            else
                            {
                                $sql1="SELECT * FROM user WHERE U_Enrollment_No='".$enrno."' AND U_Program='".$prog."'";
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
                        else
                        {
                            $qy="SELECT * FROM user WHERE U_Program='".$prog."'";
                        }
                        $s = $conn->query($qy);
                        $r=$s->rowCount();  //to count total strength
                    
                ?>

                                        <th colspan="4">
                                            <center>Students Appeared for test :<?php echo "  ". $sno; ?></center>
                                        </th>
                                        <th colspan="4">
                                            <center>Total Students :<?php echo "  ". $r; ?></center>
                                        </th>
                                    </tr>

                                    <?php } ?>

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
