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
	

	//selecting all the course names and course code from course table 
	$query="SELECT * FROM course";
	$r=mysqli_query($con,$query);

	if(!($r))
	{
		echo '<script>alert("Failed to fetch the course details!");</script>';
	}
	else
	{
		//when course details are fetched successfully


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Edit/Delete Course </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Font Awesome Offline -->
    <link rel="stylesheet" href="Font-Awesome-4.7/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
        <a class="navbar-brand" href="#">Admin Panel - Edit/Delete Course</a></nav>
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <!-- <h1>Select an Instruction to Edit/Delete:</h1> -->

            <div class="row">
                <div class="col-sm-12 p-4">
                    <!--                    <h4>Add Passage</h4><br/>                   -->

                    <h5>Select the course:</h5>
                    <select name="c_id" id="c_id" class="form-control" onchange="getText(this)">
                        <option value="None">None</option>

                        <?php 

			  //fetching and displaying course and course code row-wise in a dropdown list
//        $count=0;
            while($row=mysqli_fetch_assoc($r))
            {
//                $count++;       //counter to show instruction number
                //echo $count . ") ";
                ?>


                        <option value="<?php echo $row['C_ID']; ?>"><?php echo $row['C_Name']." ( ".$row['C_Code']." )"; ?></option>

                        <?php
                            
            }
    ?>
                    </select>
                    <?php

}
                ?>

                    <!--                    <input type="submit" class="btn btn-danger mt-3" name="edit" value="EDIT" id="edit" />-->
                    <input type="button" class="btn bg-orange text-white mt-3" name="edit" value="EDIT" id="edit" onclick="edit_instruction()" />


                    <input type="submit" class="btn bg-orange text-white mt-3" name="delete" value="DELETE" id="delete" />


                    <!-- <button type="button" class="btn bg-orange text-white mt-3" name="cancel" onClick="window.location = 'dashboard.php'">CANCEL</button> -->
                    <a href="dashboard.php"><button type="button" class="btn btn-success mt-3 float-right">Back</button></a>
                </div>

            </div>

            <!--        </form>-->


            <?php  

//    $i_description="";
//    $i_id="";
//        if(isset($_POST['i_id']))
//        {
//            $i_id=$_POST['i_id'];
//        }


	//on clicking delete i.e. DELETE button
    if(isset($_POST['delete']))
    {
        $i_id=$_POST['i_id'];		//selected value from dropdown list
        //delete the instruction with selected id
        $q2="DELETE FROM instructions WHERE I_ID='".$i_id."'";
        $re2=mysqli_query($con,$q2);
        if(!($re2))
        {
            //echo '<script>alert("Instruction deletion failed!");</script>';
        }
        else
        {
            echo '<script>alert("Instruction deleted successfully!");</script>';
        }
        
    }


        

        
//$q3="SELECT * FROM instructions WHERE I_ID='".$i_id."'";
//$re3=mysqli_query($con,$q3);
//if(!($re3))
//{
//    //echo '<script>alert("Instruction fetching failed!");</script>';
//}
//else
//{
//    $row3=mysqli_fetch_assoc($re3);
//    $i_description=$row3['I_Description'];
    
    
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

    <footer class="fixed-bottom">
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>

</body>

</html>

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

<script>
    function getText(element) {
        var textHolder = element.options[element.selectedIndex].text;
        document.getElementById("description").value = textHolder;
    }

</script>
