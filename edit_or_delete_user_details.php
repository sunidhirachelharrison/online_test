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

$temp="";
$detail="";
$rollno="";
$name="";
$usertype="";
$program="";
$year="";
$section="";
$branch="";
$mobno=""; 
$emailid="";
$uregtime="";

	
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Edit/Delete User Details</title>

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
        <a class="navbar-brand" href="#">Admin Panel - Edit/Delete User Details</a></nav>

    <div class="container mt-2 mb-3">
        <form action="#" method="post" name="frmExcelImport1" id="frmExcelImport1" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 p-4" style="">
                    <h4>Enter the Enrollment no/employee ID:</h4>
                    <input type="text" name="uname" id="uname" value="<?php echo htmlspecialchars($_POST['uname'] ?? '', ENT_QUOTES); ?>" class="form-control" />
                    <input type="submit" class="btn bg-orange text-white mt-3" name="search" value="SEARCH" id="search" onclick="" />
                    <a href="dashboard.php"><button type="button" class="btn btn-success float-right mt-3">Back</button></a><br>
                    <?php
                    
                    //on clicking search i.e. SEARCH button
                    if(isset($_POST['search']))
                    {
//                        $details=trim($_POST['uname']);
                        $detail=mysqli_real_escape_string($con,$_POST['uname']);		//entered value in text box
                        //search the user details with specified name or enrollment no.
                        
                        $q1="SELECT * FROM user WHERE U_Enrollment_No='".$detail."'";
                        $re1=mysqli_query($con,$q1);
                        if(!($re1)||$detail=="")
                        {
                            echo '<script>alert("Failed to fetch User Account details!");</script>';
                        }
                        else
                        {
                //            echo '<script>alert("User Account deleted successfully!");</script>';
                            
                            $row1=mysqli_fetch_assoc($re1);
                            if($row1['U_Name']!="")
                            {
                                
                            
                            $obj=new DateTime($row1['U_Registration_Date']);
                            $u_reg_date=date_format($obj,"d F Y");
                                
                            
                                $rollno=$row1['U_Enrollment_No'];
                                $temp=$rollno;  //to edit details later on
                                $name=$row1['U_Name'];
                                $usertype=$row1['U_User_Type'];
                                $program=$row1['U_Program'];
                                $year=$row1['U_Year'];
                                $section=$row1['U_Section'];
                                $branch=$row1['U_Branch'];
                                $mobno=$row1['U_Mobile_No']; 
                                $emailid=$row1['U_Email_ID'];
                                $uregtime=$row1['U_Registration_Time']
                                
                            ?>


                    <div class="container mt-5 mb-3">

                        <div class="table-responsive mt-3" id="div_to_print">

                            <table border="1" class="table table-bordered table-hover" id="result_table">

                                <tr>
                                    <th>Enrollment No.</th>
                                    <th>Name</th>
                                    <th>User Type</th>
                                    <th>Program</th>
                                    <th>Year</th>
                                    <th>Section</th>
                                    <th>Branch</th>
                                    <th>Contact No.</th>
                                    <th>Email ID</th>
                                    <th>Registration Date</th>
                                </tr>

                                <tr>
                                    <td><?php echo $row1['U_Enrollment_No']; ?></td>
                                    <td><?php echo $row1['U_Name']; ?></td>
                                    <td><?php echo $row1['U_User_Type']; ?></td>
                                    <td><?php echo $row1['U_Program']; ?></td>
                                    <td><?php echo $row1['U_Year']; ?></td>
                                    <td><?php echo $row1['U_Section']; ?></td>
                                    <td><?php echo $row1['U_Branch']; ?></td>
                                    <td><?php echo $row1['U_Mobile_No']; ?></td>
                                    <td><?php echo $row1['U_Email_ID']; ?></td>
                                    <td><?php echo $u_reg_date; ?></td>
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
                                echo '<script>alert("User not found! Please enter the full name or enrollment no. correctly!");</script>';
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
        $detail=$_POST['uname'];		//entered value 
        //delete the instruction with selected id
        $q2="DELETE FROM user WHERE U_Enrollment_No='".$detail."'";
        $re2=mysqli_query($con,$q2);
        if(!($re2))
        {
            echo '<script>alert("User Account deletion failed!");</script>';
        }
        else
        {
            echo '<script>alert("User Account deleted successfully!");</script>';
        }
        
    }


    
    ?>



            <div id="fields" class="mt-3" style="visibility:hidden;">


                <label for="enrollmentno"><b>Enrollment No:</b></label>
                <input type="text" class="form-control" name="enrollmentno" value="<?php  echo $rollno;  ?>" disabled /><br />

                <label for="name"><b>Full Name.:</b></label>
                <input type="text" class="form-control" name="name" value="<?php  echo $name;  ?>" /><br />

                <label for="program"><b>Program:</b></label>
                <input type="text" class="form-control" name="program" value="<?php  echo $program;  ?>" /><br />

                <label for="year"><b>year:</b></label>
                <input type="text" class="form-control" name="year" value="<?php  echo $year;  ?>" /><br />

                <label for="section"><b>Section :</b></label>
                <input type="text" class="form-control" name="section" value="<?php   echo $section;  ?>" /><br />

                <label for="branch"><b>Branch :</b></label>
                <input type="text" class="form-control" name="branch" value="<?php  echo $branch;  ?>" /><br />


                <label for="mobile_no"><b>Mobile No :</b></label>
                <input type="tel" class="form-control" name="mobile_no" value="<?php  echo $mobno;  ?>" /><br />

                <label for="email_ID"><b>Email ID :</b></label>
                <input type="email" class="form-control" name="email_ID" value="<?php  echo $emailid;  ?>" /><br />


                <label for="reg_date"><b>Registration Date :</b></label>
                <input type="text" class="form-control" name="reg_date" value="<?php  echo $u_reg_date;  ?>" disabled /><br />

                <label for="reg_time"><b>Registration Time :</b></label>
                <input type="text" class="form-control" name="reg_time" value="<?php  echo $uregtime;  ?>" disabled /><br />


                <input type="submit" class="btn bg-orange text-white" onclick="return edit_details()" name="update" value="UPDATE DETAILS" />



            </div>
        </form>

        <?php
    
   




 if(isset($_POST['update']))
{
    $detail=$_POST['uname'];		//entered value
//    $enrollmentno=$_POST['enrollmentno'];
    $fullname=$_POST['name'];
    $prog=$_POST['program'];
    $yr=$_POST['year'];
    $sec=$_POST['section'];
    $ubranch=$_POST['branch'];
    //$session=$_POST['session'];
    $mobileno=$_POST['mobile_no'];
    $uemailid=$_POST['email_ID'];
    
     echo '<script>alert('.$detail.');</script>';
     
    $sql="UPDATE user SET U_Enrollment_No='".$detail."',U_Name='".$fullname."', U_Program='".$prog."', U_Year='".$yr."', U_Section='".$sec."', U_Branch='".$ubranch."',U_Mobile_No='".$mobileno."' ,U_Email_ID='".$uemailid."' WHERE U_Enrollment_No='".$detail."'";
                        

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
        alert("Details updation failed!");
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
