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
	

	//selecting all the test names from test table 
	$query="SELECT * FROM questions WHERE Q_Flag='0' AND Q_Description is not null";
    //$query="SELECT * FROM questions";
	$r=mysqli_query($con,$query);

	if(!($r))
	{
		echo '<script>alert("Failed to fetch the details!");</script>';
	}
	else
	{
		//when question descriptions are fetched successfully


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Marks of Question</title>
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
            <h1>Select question:</h1>

            <div class="row">
                <div class="col-sm-12 p-4" style="background:#e9ecef">
                    <!--                    <h4>Add Passage</h4><br/>                   -->

                    Select the question to set its marks:
                    <select name="q_id" id="q_id" class="form-control">
                        <option value="None">None</option>

                        <?php 

			  //fetching and displaying test names row-wise in a dropdown list
        $co=0;  //counter for no of questions
            while($row=mysqli_fetch_assoc($r))
            {
                $co++;
                ?>

                        <option value="<?php echo $row['Q_ID']; ?>"><?php echo $co . ") " .  $row['Q_Description']; ?></option>

                        <?php
                            
            }
    ?>
                    </select>
                    <?php

}
                ?>




                    <label for="q_marks"><b>Enter marks:</b></label>
                    <input type="number" class="form-control" name="q_marks" />

                    <input type="submit" class="btn aa mt-3" name="update" value="UPDATE" id="update" />

                    <button type="button" class="btn aa mt-3" name="cancel" onClick="window.location = 'dashboard.php'">CANCEL</button>

                </div>

            </div>

        </form>

    </div>

</body>

</html>


<?php  

	//on clicking update i.e. DONE button
    if(isset($_POST['update']))
    {
        $q_id=$_POST['q_id'];		//selected value from dropdown list
        $marks= $_POST['q_marks'];
        
        $q2="UPDATE questions SET Q_Alloted_Marks='".$marks."' WHERE Q_ID='".$q_id."'";
        $re2=mysqli_query($con,$q2);
        if(!($re2))
        {
            echo '<script>alert("Marks update failed!");</script>';
        }
        else
        {
            echo '<script>alert("Marks updated successfully!");</script>';
        }
        
        
    }

?>
