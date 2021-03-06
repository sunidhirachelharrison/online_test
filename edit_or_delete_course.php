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

$c_code="";
$c_name="";
$courseid="";
	
//selecting all the course names from test table 
	$query="SELECT * FROM course";
	$r=mysqli_query($con,$query);

	if(!($r))
	{
		echo '<script>alert("Failed to fetch the courses!");</script>';
	}
	else
	{
		//when instructions are fetched successfully



?>


<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Edit/Delete Course</title>

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
        <a class="navbar-brand" href="#">Admin Panel - Edit/Delete Course</a></nav>
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport1" id="frmExcelImport1" enctype="multipart/form-data">



            <!-- <h1>Select the course to Edit Details/Delete :</h1> -->

            <div class="row">
                <div class="col-sm-12 p-4" style="">

                    <h4>Select Course:</h4>
                    <select name="c_id" id="c_id" class="form-control" onchange="getText(this)">
                        <option value="None">None</option>

                        <?php 

			  //fetching and displaying instructions row-wise in a dropdown list
//        $count=0;
            while($row=mysqli_fetch_assoc($r))
            {
//                $count++;       //counter to show instruction number
                //echo $count . ") ";
//                $rowval=mysqli_fetch_assoc($row);
                ?>


                        <option value="<?php echo $row['C_ID']; ?>"><?php echo $row['C_Name']." ( ".$row['C_Code']." )"; ?></option>

                        <?php
                            
            }
    ?>
                    </select>

                    <?php
        
    }
?>



                    <input type="text" name="hidden_field" id="hidden_field" value="<?php echo htmlspecialchars($_POST['c_id'] ?? '', ENT_QUOTES); ?>" class="form-control" hidden />

                    <input type="submit" class="btn bg-orange text-white mt-3" name="search" value="SEARCH" id="search" onclick="" />
                    <a href="dashboard.php"><button type="button" class="btn btn-success float-right mt-3">Back</button></a><br>
                    <?php
                    
                    //on clicking search i.e. SEARCH button
                    if(isset($_POST['search']))
                    {
//                        $details=trim($_POST['uname']);
                        $detail=mysqli_real_escape_string($con,$_POST['c_id']);		//selected value from dropdown box
                        //search the course details with specified course id.
                        
                        $q1="SELECT * FROM course WHERE C_ID='".$detail."'";
                        $re1=mysqli_query($con,$q1);
                        if(!($re1)||$detail=="")
                        {
                            echo '<script>alert("Failed to fetch Course details!");</script>';
                        }
                        else
                        {
                //            echo '<script>alert("Course deleted successfully!");</script>';
                            
                            $row1=mysqli_fetch_assoc($re1);
                            if($row1['C_Name']!="")
                            {
                                
                            
//                            $obj=new DateTime($row1['U_Registration_Date']);
//                            $u_reg_date=date_format($obj,"d F Y");
//                                
//                            
                                $courseid=$row1['C_ID'];
                                $c_code=$row1['C_Code'];
                                $c_name=$row1['C_Name'];;  //to edit details later on
//                                $name=$row1['U_Name'];
//                                $usertype=$row1['U_User_Type'];
//                                $program=$row1['U_Program'];
//                                $year=$row1['U_Year'];
//                                $section=$row1['U_Section'];
//                                $branch=$row1['U_Branch'];
//                                $mobno=$row1['U_Mobile_No']; 
//                                $emailid=$row1['U_Email_ID'];
//                                $uregtime=$row1['U_Registration_Time']
//                                
                            ?>


                    <div class="container mt-3 mb-3">

                        <div class="table-responsive mt-3" id="div_to_print">

                            <table border="1" class="table table-bordered table-hover" id="result_table">

                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>

                                </tr>

                                <tr>
                                    <td><?php echo $c_code; ?></td>
                                    <td><?php echo $c_name; ?></td>

                                </tr>

                            </table>
                        </div>
                    </div>

                    <input type="button" class="btn bg-orange text-white mt-3" name="edit" value="EDIT" id="edit" onclick="edit_details();" />


<input type="submit" class="btn bg-orange text-white mt-3" name="delete" value="DELETE" id="delete" />


                    <?php
                            }
                            else
                            {
                                echo '<script>alert("Course not found! Please select the correct course!");</script>';
                            }
                        }

                    }
                    
                    
                    ?>


                    
<!-- 
                    <button type="button" class="btn aa mt-3" name="cancel" onClick="window.location = 'dashboard.php'">CANCEL</button> -->

                </div>

            </div>




            <?php  


	//on clicking delete i.e. DELETE button
    if(isset($_POST['delete']))
    {
        $detail=$_POST['hidden_field'];		//entered value 
        //delete the instruction with selected id
        $q2="DELETE FROM course WHERE C_ID='".$detail."'";
        $re2=mysqli_query($con,$q2);
        if(!($re2))
        {
            echo '<script>alert("Course deletion failed!");</script>';
        }
        else
        {
            echo '<script>alert("Course deleted successfully!");</script>';
        }
        
    }


    
    ?>



            <div id="fields" class="mt-3 mb-3" style="visibility:hidden;">


                <label for="courseid"><b>Course ID:</b></label>
                <input type="text" class="form-control" name="courseid" value="<?php  echo $courseid;  ?>" disabled /><br />

                <label for="c_code"><b>Enrollment No:</b></label>
                <input type="text" class="form-control" name="c_code" value="<?php  echo $c_code;  ?>" /><br />

                <label for="c_name"><b>Course Name:</b></label>
                <input type="text" class="form-control" name="c_name" value="<?php  echo $c_name;  ?>" /><br />


                <input type="submit" class="btn bg-orange text-white" onclick="return edit_details()" name="update" value="UPDATE DETAILS" />



            </div>
        </form>

        <?php
    
   




 if(isset($_POST['update']))
{
    $id=$_POST['hidden_field'];	    //to get the course id
    $code=$_POST['c_code'];		//entered value
//    $enrollmentno=$_POST['enrollmentno'];
    $name=$_POST['c_name'];
     
//    $prog=$_POST['program'];
//    $yr=$_POST['year'];
//    $sec=$_POST['section'];
//    $ubranch=$_POST['branch'];
//    //$session=$_POST['session'];
//    $mobileno=$_POST['mobile_no'];
//    $uemailid=$_POST['email_ID'];
    
     echo '<script>alert('.$code.');</script>';
     
    $sql="UPDATE course SET C_Code='".$code."',C_Name='".$name."' WHERE C_ID='".$id."'";
                        

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
        alert("Details updation failed! This course code already exists!");
    </script>' . '<br />';
    }

    
}
        

?>


    </div>

    <footer class="mt-3">
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>

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
