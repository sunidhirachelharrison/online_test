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
	$query="SELECT * FROM test";
	$r=mysqli_query($con,$query);

	if(!($r))
	{
		echo '<script>alert("Failed to fetch the test details!");</script>';
	}
	else
	{
		//when test names are fetched successfully


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Select Test</title>

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
        <a class="navbar-brand" href="#">Admin Panel - Select Test</a></nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <span class="align-middle">Select:</span>
                        <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                    </div>
                    <div class="card-body">
                        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                            <div class="p-3">
                                <label>Select the test to be held:</label>
                                <select name="test_id" id="test_id" class="form-control">
                                    <!--                                    <option value="None">None</option>-->
                                    <?php 
                                            //fetching and displaying test names row-wise in a dropdown list
                                            while($row=mysqli_fetch_assoc($r))
                                            {
                                        ?>
                                    <option value="<?php echo $row['T_ID']; ?>"><?php echo $row['T_Name'] . "&nbsp;&nbsp;" . $row['T_Date']; ?></option>
                                    <?php                     
                                            }
                                        ?>
                                </select>
                                <?php
                                            }
                                        ?>
                                <br>
                                <input type="submit" id="select" name="select" class="btn bg-orange text-white" value="DONE" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>






</body>

</html>
<!--
<script>
    var validating = false;

    function validate_test_id(inputval) {
        if (inputval == "None") {
            if (validating == false) {
                validating = true;
            }
            alert("Please select a test/exam!");
            setTimeout(function() {
                document.getElementById("test_id").focus();
                validating = false;
            }, 1);
            return false;
        }
    }
</script>
-->

<?php  

	//on clicking select i.e. DONE button
    if(isset($_POST['select']))
    {
        $test_id=$_POST['test_id'];		//selected value from dropdown list
        //unset flag bit of all tests and set those to null
        $q2="UPDATE test SET T_Flag=null WHERE T_ID!='".$test_id."'";
        $re2=mysqli_query($con,$q2);
        if(!($re2))
        {
            //echo '<script>alert("Test selection failed!");</script>';
        }
        else
        {
            //echo '<script>alert("Test has been selected!");</script>';
        }
        
        
        //set flag bit of selected test to 0
        $q="UPDATE test SET T_Flag='0' WHERE T_ID='".$test_id."'";
        $re=mysqli_query($con,$q);
        if(!($re))
        {
            echo '<script>alert("Test selection failed!");</script>';
        }
        else
        {
            echo '<script>alert("Test has been selected!");</script>';
        }
        
    }

?>
