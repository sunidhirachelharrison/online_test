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
    <meta charset="UTF-8">
    <title>Edit Details or Delete User Account</title>
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
        <a class="navbar-brand" href="index.php">Center for Teaching, Learning & Development</a></nav>
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Select a User to Edit Details/Delete Account:</h1>

            <div class="row">
                <div class="col-sm-12 p-4" style="background:#e9ecef">

                    Enter the name or enrollment no/employee ID:
                    <input type="text" name="uname" id="uname" class="form-control" />
                    <input type="submit" class="btn aa mt-3" name="search" value="SEARCH" id="search" onclick="" /><br />

                    <?php
                    
                    //on clicking search i.e. SEARCH button
                    if(isset($_POST['search']))
                    {
//                        $details=trim($_POST['uname']);
                        $detail=mysqli_real_escape_string($con,$_POST['uname']);		//entered value in text box
                        //search the user details with specified name or enrollment no.
                        
                        $q1="SELECT * FROM user WHERE U_Name='".$detail."' or U_Enrollment_No='".$detail."'";
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
                                
                            
                            ?>


                    <div class="container mt-2 mb-5">

                        <div class="table-responsive mt-3" id="div_to_print">

                            <table border="1" class="table table-bordered table-hover" id="result_table">

                                <tr>
                                    <td>Enrollment No.</td>
                                    <td>Name</td>
                                    <td>User Type</td>
                                    <td>Program</td>
                                    <td>Year</td>
                                    <td>Section</td>
                                    <td>Branch</td>
                                    <td>Contact No.</td>
                                    <td>Email ID</td>
                                    <td>Registration Date</td>
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



                    <?php
                            }
                            else
                            {
                                echo '<script>alert("User not found! Please enter the full name or enrollment no. correctly!");</script>';
                            }
                        }

                    }
                    
                    
                    ?>


                    <input type="button" class="btn aa mt-3" name="edit" value="EDIT" id="edit" onclick="getText(this.id);" />


                    <input type="submit" class="btn aa mt-3" name="delete" value="DELETE" id="delete" />


                    <button type="button" class="btn aa mt-3" name="cancel" onClick="window.location = 'dashboard.php'">CANCEL</button>

                </div>

            </div>

            <!--        </form>-->


            <?php  


	//on clicking delete i.e. DELETE button
    if(isset($_POST['delete']))
    {
        $detail=$_POST['uname'];		//selected value from dropdown list
        //delete the instruction with selected id
        $q2="DELETE FROM user WHERE U_Name='".$detail."' or U_Enrollment_No='".$detail."'";
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



            <div id="fields" style="visibility:hidden;">

                Description: <input type='text' class='form-control' id='description' name='description' /><br /><input type='submit' name='save' class='btn aa' value='SAVE' />


            </div>
        </form>

        <?php
    
   


//}

 if(isset($_POST['save']))
{
    
    
    $i_id=$_POST['i_id'];		//selected value from dropdown list
    $i_description=$_POST['description'];
    $q4="UPDATE instructions SET I_Description='".$i_description."' WHERE I_ID='".$i_id."'";
    $re4=mysqli_query($con,$q4);
    if(!($re4))
    {
        //echo '<script>alert("Instruction editing failed!");</script>';
    }
    else
    {
        echo '<script>alert("Instruction updated successfully!");</script>';
    }

    
}


?>


    </div>

</body>

</html>


<!--
<script>
    function edit_instruction() {

        document.getElementById('fields').style.visibility = 'visible';
        //var count = document.getElementById("field_count");
        // var d = document.getElementById("fields");

        //document.getElementById("add").disable=true;

        //  d.innerHTML = "<br />Description: <input type='text' class='form-control' name='description' value='<?php //echo $i_description; ?>' required/><br/><input type='submit' name='save' class='btn aa' value='SAVE'/>";

        //        document.getElementById("delete").disabled = true;

    }
</script>
-->

<script>
    function getText(element) {
        var textHolder = document.getElementById(element).text;
        document.getElementById("description").value = textHolder;
    }

</script>
