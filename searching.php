<?php
    
    //including the file for database connection
    include("DB_connect.php");
	

    //starting the session
    session_start();
	

	//if user is not logged in, forward to login page
    if(!(isset($_SESSION['U_Enrollment_No'])))
    {
        header("location:index.php");
    }
	
            
?>

<!DOCTYPE html>
<html lang="en">
<head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Searching</title>

    <!-- Bootstrap CSS -->  
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Font Awesome Offline -->
    <link rel="stylesheet" href="Font-Awesome-4.7/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        .bg-orange{
            background: #ea5e0d;
        }
    </style>

</head>
<body>
    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Admin Panel - Searching</a></nav>

    <form action="#" method="post">
        <div class="container mt-3 mb-5">
            <div class="row">
                <div class="col-sm-12">
                    <h4>Select Search Criteria:</h4>

                    <!-- <label for="select"><b>Select search criteria :</b></label><br /> -->
                    <input type="radio" name="chooseone" id="1" value="U_Program"><label for="Program" checked> &nbsp;Program</label>
                    <br />
                    
                    <input type="radio" name="chooseone" id="2" value="U_Enrollment_No"><label for="Enrollmentno"> &nbsp;Enrollment No </label><br>
                    
                    <input type="radio" name="chooseone" id="3" value="U_Branch"><label for="Branch">&nbsp;Branch</label><br>
                    <input type="radio" name="chooseone" id="4" value="U_Year"><label for="Year"> &nbsp;Year</label><br>
                    
                    <label for="value"><b>Value :</b></label>
                    <input type="text" class="form-control" placeholder=" " id="value" name="value" required /><br />


                    <input type="submit" class="btn bg-orange text-white" name="submit" value="SHOW" onclick="return validate_value()" />


                </div>

                <!--
                  <script>
                    $(document).ready(function() { 
                         $("#s1").change(function(){ if($("#s1").val()=="faculty"){
                             $("#f1").prop("disabled",false);
                             $("#f2").prop("disabled",true);
                             $("#f3").prop("disabled",true);
                         }
                        else if($("#s1").val()=="participant")
                            {
                                $("#f1").prop("disabled",true);
                                 $("#f2").prop("disabled",false);
                                 $("#f3").prop("disabled",false);
                            }
                        else if($("#s1").val()=="volunteer")
                            {
                                $("#f1").prop("disabled",true);
                                 $("#f2").prop("disabled",false);
                                 $("#f3").prop("disabled",false);
                            }
                        else
                            {
                                $("#f1").prop("disabled",true);
                                 $("#f2").prop("disabled",true);
                                 $("#f3").prop("disabled",true);
                            }
                        });

                    });
                </script>
                  
-->
            </div>

        </div>

    </form>
    <?php
    if(isset($_POST['submit']))
    {
            
        $selected_radio=$_POST['chooseone'];
        $value=$_POST['value'];
        //$section=$_POST['section'];
       
        
        //$query1="SELECT * FROM user u,result r WHERE u.".$selected_radio."like '%".$value."%' AND u.U_Enrollment_No=r.R_Enrollment_No";
        
        $query1="SELECT * FROM user  WHERE ".$selected_radio." like '%".$value."%' order by U_User_Type,U_Program, U_Branch, U_Year,U_Section,U_Enrollment_No ";
        
        
        $query2="";
        //if($selected_radio!="T_Name")
        //{
            $r=mysqli_query($con,$query1);
            if(!($r))
            {
                echo '<script type="text/javascript">alert("Failed to fetch user details");</script>';
            }
            else
            {
                ?>
    <div class="container">


        <div style="" class=" mb-5">
            <div class="table-responsive mt-3" id="div_to_print">

                <table border="2" class="table table-bordered table-hover" id="search_result_table">
                    <tr>
                        <th>S.No.</th>
                        <th>Enrollment No.</th>
                        <th>Name</th>
                        <th>User Type</th>
                        <th>Program</th>
                        <th>Branch</th>
                        <th>Year</th>
                        <th>Section</th>
                        <th>Mobile No.</th>
                        <th>Email ID</th>
                        <th>Date of Registration</th>
                        <th>Time of Registration</th>

                        <!--
                       <td>Quantitative Aptitude Marks</td>                   
                       <td>Verbal Aptitude Marks</td>                   
-->
                        <!--                       <td>Total Marks</td>                       -->
                    </tr>

                    <?php
                
                    $sno=1;
                    while($row=mysqli_fetch_assoc($r))
                    {
                        $d=$row['U_Registration_Date'];
                        $ob=new DateTime($d);
                        $d=date_format($ob,"d F Y");
                            
                        echo "<tr><th>{$sno}</th><td>{$row['U_Enrollment_No']}</td><td>{$row['U_Name']}</td><td>{$row['U_User_Type']}</td><td>{$row['U_Program']}</td><td>{$row['U_Branch']}</td><td>{$row['U_Year']}</td><td>{$row['U_Section']}</td><td>{$row['U_Mobile_No']}</td><td>{$row['U_Email_ID']}</td><td>{$d}</td><td>{$row['U_Registration_Time']}</td></tr>";
                        
                        $sno++;
                        
                    }
                
                    }
        //}
    }


                    
                    ?>

                </table>
            </div>

        </div>
        <input type="button" onClick="javascript:PrintDiv();" value="PRINT" class="btn bg-orange text-white">
        <!--        <input type="button" id="save" onClick="javascript:fnExcelReport();" value="SAVE AS EXCEL SHEET">-->
        <a href="#" id="save" class="btn bg-orange text-white" onClick="javascript:fnExcelReport();">SAVE AS EXCEL SHEET</a>
    </div>



    <div class="container">

        <div class="float-right p-2">

        </div>

        <!--
        <div class="float-right p-2">
            <a href="#" id="print" class="btn bg-orange text-white" onClick="javascript:PrintDiv();">PRINT</a>
        </div>
-->

    </div>



    <script>
        function validate_value() {
            var field = document.getElementById('value').value;
            var x = 0;
            for ($i = 1; $i < 5; $i++) {
                var radio_options = document.getElementById($i);
                if (radio_options.checked) {
                    x = 1;
                    break;
                }
            }

            if (field == "" || field == null || field == " ") {
                alert("Please enter some value");
                document.getElementById("value").focus();
                return false;

                //                } else if () {

            } else if (x == 0) {
                alert("Please select a radio option");
                return false;
            }
        }

    </script>

    <script type="text/javascript">
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

    <script type="text/javascript">
        function fnExcelReport() {

            //***************************************
            //code to hide a column in excel sheet
            //            $('#result_table').find('#10').css({
            //                "width": "0px"
            //            });

            //****************************************


            var tab_text = 'html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
            tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
            tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
            tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

            tab_text = tab_text + "<center><b>Registered Users Information</b></center>"

            tab_text = tab_text + "<table border='1px solid'>";
            tab_text = tab_text + $('#search_result_table').html();
            //tab_text = tab_text + $table.html();

            //tab_text = tab_text + $('#result_table').clone().find('table tr th:nth-child(),table tr td:nth-child(10)).remove().end().prop('
            //outerHTML ')
            tab_text = tab_text + '</table></body></html>';

            var data_type = 'data:application/vnd.ms-excel';

            $('#save').attr('href', data_type + ',' + encodeURIComponent(tab_text));
            $('#save').attr('download', 'Search_Results.xls');

        }

    </script>
<footer class="mt-5">
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>


</body>

</html>
