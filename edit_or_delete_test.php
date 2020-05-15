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

//$c_code="";
//$c_name="";
//$courseid="";
//
$t_id="";
$t_name="";
$t_date="";
$t_shiftA="";
$t_shiftB="";
$t_shiftC="";
$t_marks="";
$t_hours="";
$t_minutes="";
$t_questions="";
//$courseid="";
	
//selecting all the test names from test table 
	$query="SELECT * FROM test";
	$r=mysqli_query($con,$query);

	if(!($r))
	{
		echo '<script>alert("Failed to fetch the tests!");</script>';
	}
	else
	{
		//when tests are fetched successfully



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Details or Delete Test/Exam</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        .aa {
            background: #ea5e0d;
            color: white;
        }

        .aa:hover {
            background: #e9ecef;
            color: #ea5e0d;
        }

    </style>
</head>

<body>

    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)</a></nav>
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport1" id="frmExcelImport1" enctype="multipart/form-data">



            <h1>Select the test to Edit Details/Delete :</h1>

            <div class="row">
                <div class="col-sm-12 p-4" style="background:#e9ecef">

                    Select:
                    <select name="t_id" id="t_id" class="form-control" onchange="getText(this)">
                        <option value="None">None</option>

                        <?php 

			  //fetching and displaying instructions row-wise in a dropdown list
//        $count=0;
            while($row=mysqli_fetch_assoc($r))
            {
//                $count++;       //counter to show instruction number
                //echo $count . ") ";
//                $rowval=mysqli_fetch_assoc($row);
                $ob=new DateTime($row['T_Date']);
                    $d=date_format($ob,"d F Y");
                
                
                ?>


                        <option value="<?php echo $row['T_ID']; ?>"><?php echo $row['T_Name']."  ( Dated: ".$d. " )"; ?></option>

                        <?php
                            
            }
    ?>
                    </select>

                    <?php
        
    }
?>



                    <input type="text" name="hidden_field" id="hidden_field" value="<?php echo htmlspecialchars($_POST['t_id'] ?? '', ENT_QUOTES); ?>" class="form-control" hidden />

                    <input type="submit" class="btn aa mt-3" name="search" value="SEARCH" id="search" onclick="" /><br />

                    <?php
                    
                    //on clicking search i.e. SEARCH button
                    if(isset($_POST['search']))
                    {
//                        $details=trim($_POST['uname']);
                        $detail=mysqli_real_escape_string($con,$_POST['t_id']);		//selected value from dropdown box
                        //search the test details with specified test id.
                        
                        $q1="SELECT * FROM test WHERE T_ID='".$detail."'";
                        $re1=mysqli_query($con,$q1);
                        if(!($re1)||$detail=="")
                        {
                            echo '<script>alert("Failed to fetch Test details!");</script>';
                        }
                        else
                        {
                //            echo '<script>alert("Test deleted successfully!");</script>';
                            
                            $row1=mysqli_fetch_assoc($re1);
                            if($row1['T_Name']!="")
                            {
                                
                            
//                            $obj=new DateTime($row1['U_Registration_Date']);
//                            $u_reg_date=date_format($obj,"d F Y");
//                                
//                            
                                $t_id=$row1['T_ID'];
//                                $c_code=$row1['C_Code'];
                                $t_name=$row1['T_Name'];;  //to edit details later on
                                $t_date=$row1['T_Date'];
                                $ob2=new DateTime($t_date);
                                $d2="";
                                $d2=date_format($ob2,"d F Y");
                                $t_shiftA=$row1['T_Time_ShiftA'];
                                $t_shiftB=$row1['T_Time_ShiftB'];
                                $t_shiftC=$row1['T_Time_ShiftC'];
                                $t_marks=$row1['T_Marks'];
                                $t_hours=$row1['T_Hours'];
                                $t_minutes=$row1['T_Minutes'];
                                $t_questions=$row1['T_Questions'];
//                                
                            ?>


                    <div class="container mt-2 mb-5">

                        <div class="table-responsive mt-3" id="div_to_print">

                            <table border="1" class="table table-bordered table-hover" id="result_table">

                                <tr>
                                    <td>Test ID</td>
                                    <td>Test Name</td>
                                    <td>Test Date</td>
                                    <td>Shift A</td>
                                    <td>Shift B</td>
                                    <td>Shift C</td>
                                    <td>Total Marks</td>
                                    <td>Hours</td>
                                    <td>Minutes</td>
                                    <td>Total Questions</td>
                                </tr>

                                <tr>
                                    <td><?php echo $t_id; ?></td>
                                    <td><?php echo $t_name; ?></td>
                                    <td><?php echo $d2; ?></td>
                                    <td><?php echo $t_shiftA; ?></td>
                                    <td><?php echo $t_shiftB; ?></td>
                                    <td><?php echo $t_shiftC; ?></td>
                                    <td><?php echo $t_marks; ?></td>
                                    <td><?php echo $t_hours; ?></td>
                                    <td><?php echo $t_minutes; ?></td>
                                    <td><?php echo $t_questions; ?></td>
                                </tr>

                            </table>
                        </div>
                    </div>



                    <?php
                            }
                            else
                            {
                                echo '<script>alert("Test not found! Please select the correct test!");</script>';
                            }
                        }

                    }
                    
                    
                    ?>


                    <input type="button" class="btn aa mt-3" name="edit" value="EDIT" id="edit" onclick="edit_details();" />


                    <input type="submit" class="btn aa mt-3" name="delete" value="DELETE" id="delete" />


                    <button type="button" class="btn aa mt-3" name="cancel" onClick="window.location = 'dashboard.php'">CANCEL</button>

                </div>

            </div>




            <?php  


	//on clicking delete i.e. DELETE button
    if(isset($_POST['delete']))
    {
        $detail=$_POST['hidden_field'];		//entered value 
        //delete the instruction with selected id
        $q2="DELETE FROM test WHERE T_ID='".$detail."'";
        $re2=mysqli_query($con,$q2);
        if(!($re2))
        {
            echo '<script>alert("Test deletion failed!");</script>';
        }
        else
        {
            echo '<script>alert("Test deleted successfully!");</script>';
        }
        
    }


    
    ?>



            <div id="fields" class="mt-5" style="visibility:hidden;">


                <label for="testid"><b>Test ID:</b></label>
                <input type="text" class="form-control" name="testid" value="<?php  echo $t_id;  ?>" disabled /><br />


                <label for="t_name"><b>Test Name:</b></label>
                <input type="text" class="form-control" name="t_name" value="<?php  echo $t_name;  ?>" /><br />



                <label for="a"><b>Test Date:</b></label>
                <input type="date" class="form-control" name="a" /><br />

                <label for="b"><b>Shift A:</b></label>
                <input type="time" class="form-control" placeholder="hh:mm:ss" name="b" value="<?php  echo $t_shiftA;  ?>" /><br />

                <label for="c"><b>Shift B:</b></label>
                <input type="time" class="form-control" placeholder="hh:mm:ss" name="c" value="<?php echo $t_shiftB;  ?>" /><br />

                <label for="d"><b>Shift C:</b></label>
                <input type="time" class="form-control" placeholder="hh:mm:ss" name="d" value="<?php  echo $t_shiftC;  ?>" /><br />

                <label for="e"><b>Marks:</b></label>
                <input type="number" class="form-control" name="e" value="<?php  echo $t_marks;  ?>" /><br />


                <label for="f"><b>Hours:</b></label>
                <input type="number" class="form-control" name="f" value="<?php  echo $t_hours;  ?>" /><br />

                <label for="g"><b>Minutes:</b></label>
                <input type="number" class="form-control" name="g" value="<?php  echo $t_minutes;  ?>" /><br />

                <label for="h"><b>Questions:</b></label>
                <input type="number" class="form-control" name="h" value="<?php  echo $t_questions;  ?>" /><br />




                <input type="submit" class="btn aa" onclick="return edit_details()" name="update" value="UPDATE DETAILS" />



            </div>
        </form>

        <?php
    
   




 if(isset($_POST['update']))
{
    $id=$_POST['hidden_field'];	    //to get the course id
//    $code=$_POST['c_code'];		//entered value
//    $enrollmentno=$_POST['enrollmentno'];
    $name=$_POST['t_name'];
     
     $tes_date=$_POST['a'];
     $tes_shiftA=$_POST['b'];
     $tes_shiftB=$_POST['c'];
     $tes_shiftC=$_POST['d'];
     $tes_marks=$_POST['e'];
     $tes_hours=$_POST['f'];
     $tes_minutes=$_POST['g'];
     $tes_questions=$_POST['h'];

    
//     echo '<script>alert('.$code.');</script>';
     
    $sql="UPDATE test SET T_Name='".$name."',T_Date='".$tes_date."', T_Time_ShiftA='".$tes_shiftA."', T_Time_ShiftB='".$tes_shiftB."', T_Time_ShiftC='".$tes_shiftC."', T_Marks='".$tes_marks."', T_Hours='".$tes_hours."', T_Minutes='".$tes_minutes."', T_Questions='".$tes_questions."'  WHERE T_ID='".$id."'";
                        

    $check=mysqli_query($con,$sql);

    if($check)
    {
    echo '<script>
        alert("Details Updated Successfully!");
    </script>' . '<br />';
    }
    else
    {
    echo '<script>
        alert("Details updation failed! ");
    </script>' . '<br />';
    }

    
}
        

?>


    </div>

</body>

</html>


<script>
    function edit_details() {

        document.getElementById('fields').style.visibility = 'visible';
        //        return true;

    }

</script>

<!--
/-->
