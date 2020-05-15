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

$p_id="";
$p_name="";
$program_id="";
$program_name="";

	
//selecting all the program names from program table 
	$query="SELECT * FROM program";
	$r=mysqli_query($con,$query);

	if(!($r))
	{
		echo '<script>alert("Failed to fetch the programs!");</script>';
	}
	else
	{
		//when programs are fetched successfully



?>


<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Edit/Delete Program</title>

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
        <a class="navbar-brand" href="#">Edit/Delete Program</a></nav>
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport1" id="frmExcelImport1" enctype="multipart/form-data">



            <!-- <h1>Select the program to Edit Details/Delete :</h1> -->

            <div class="row">
                <div class="col-sm-12 p-4" style="">

                    <h4>Select the Program:</h4>
                    <select name="p_id" id="p_id" class="form-control" onchange="getText(this)">
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


                        <option value="<?php echo $row['Prog_ID']; ?>"><?php echo $row['Prog_Name']; ?></option>

                        <?php
                            
            }
    ?>
                    </select>

                    <?php
        
    }
?>



                    <input type="text" name="hidden_field" id="hidden_field" value="<?php echo htmlspecialchars($_POST['p_id'] ?? '', ENT_QUOTES); ?>" class="form-control" hidden />

                    <input type="submit" class="btn bg-orange text-white mt-3" name="search" value="SEARCH" id="search" onclick="" />
                    <a href="dashboard.php"><button type="button" class="btn btn-success float-right mt-3">Back</button></a><br>

                    <?php
                    
                    //on clicking search i.e. SEARCH button
                    if(isset($_POST['search']))
                    {
//                        $details=trim($_POST['uname']);
                        $detail=mysqli_real_escape_string($con,$_POST['p_id']);		//selected value from dropdown box
                        //search the course details with specified course id.
                        
                        $q1="SELECT * FROM program WHERE Prog_ID='".$detail."'";
                        $re1=mysqli_query($con,$q1);
                        if(!($re1)||$detail=="")
                        {
                            echo '<script>alert("Failed to fetch program details!");</script>';
                        }
                        else
                        {
                //            echo '<script>alert("Program deleted successfully!");</script>';
                            
                            $row1=mysqli_fetch_assoc($re1);
                            if($row1['Prog_Name']!="")
                            {
                                
                            
//                            $obj=new DateTime($row1['U_Registration_Date']);
//                            $u_reg_date=date_format($obj,"d F Y");
//                                
//                            
                                $program_id=$row1['Prog_ID'];
//                                $c_code=$row1['C_Code'];
                                $program_name=$row1['Prog_Name'];;  //to edit details later on
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
                                    <th>Program ID</th>
                                    <th>Program Name</th>

                                </tr>

                                <tr>
                                    <td><?php echo $program_id; ?></td>
                                    <td><?php echo $program_name; ?></td>

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
                                echo '<script>alert("Program not found! Please select the correct program!");</script>';
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
        $q2="DELETE FROM program WHERE Prog_ID='".$detail."'";
        $re2=mysqli_query($con,$q2);
        if(!($re2))
        {
            echo '<script>alert("Program deletion failed!");</script>';
        }
        else
        {
            echo '<script>alert("Program deleted successfully!");</script>';
        }
        
    }


    
    ?>



            <div id="fields" class="mt-5" style="visibility:hidden;">


                <label for="x"><b>Program ID:</b></label>
                <input type="text" class="form-control" name="x" value="<?php  echo $program_id;  ?>" disabled /><br />

                <!--
                <label for="c_code"><b>Enrollment No:</b></label>
                <input type="text" class="form-control" name="c_code" value="<?php  //echo $c_code;  ?>" /><br />
-->

                <label for="y"><b>Program Name:</b></label>
                <input type="text" class="form-control" name="y" value="<?php  echo $program_name;  ?>" /><br />


                <input type="submit" class="btn bg-orange text-white" onclick="return edit_details()" name="update" value="UPDATE DETAILS" />



            </div>
        </form>

        <?php
    
   




 if(isset($_POST['update']))
{
    $id=$_POST['hidden_field'];	    //to get the course id
//    $code=$_POST['x'];		//entered value
//    $enrollmentno=$_POST['enrollmentno'];
    $name=$_POST['y'];
     
//    $prog=$_POST['program'];
//    $yr=$_POST['year'];
//    $sec=$_POST['section'];
//    $ubranch=$_POST['branch'];
//    //$session=$_POST['session'];
//    $mobileno=$_POST['mobile_no'];
//    $uemailid=$_POST['email_ID'];
    
//     echo '<script>alert('.$code.');</script>';
     
    $sql="UPDATE program SET Prog_Name='".$name."' WHERE Prog_ID='".$id."'";
                        

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
