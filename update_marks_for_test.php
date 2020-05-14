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
    <title>Set Marks For Test/Exam</title>

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
        <a class="navbar-brand" href="#">Admin Panel - Set Test/Exam Marks</a></nav>
    
    
        <div class="container">
                <!-- Page Coding Start -->
                <div class="" id="">
            <div class="modal-dialog modal-lg mt-4 mb-4">
            <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title">Select the test to set its Marks</h4>
                            <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-3">Select Test/Exam:<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                    <select name="test_id" id="test_id" class="form-control">
                                        <option value="None">None</option>
                                            <?php 
			                                    //fetching and displaying test names row-wise in a dropdown list
                                                while($row=mysqli_fetch_assoc($r))
                                                {
                                                    $obj=new DateTime($row['T_Date']);
                                                    $d=date_format($obj,"d F Y");
                                            ?>
                                                    <option value="<?php echo $row['T_ID']; ?>"><?php echo $row['T_Name'] . "&nbsp;&nbsp;Dated: " . $d; ?></option>
                                            <?php 
                                                }
                                            ?>
                                    </select>
                                            <?php
                                                }
                                            ?>
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-3"><span class="">Enter Total Marks:</span></label>
                                    <div class="col-md-7">
                                    <input type="number" class="form-control" name="test_marks" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input type="submit" id="update" name="update" class="btn bg-orange text-white" value="UPDATE"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        </div>

        <footer class="fixed-bottom">
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>

    
    <!-- <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Select test/exam:</h1>

            <div class="row">
                <div class="col-sm-12 p-4" style="background:#e9ecef">
                                        <h4>Add Passage</h4><br/>                   -->
<!-- 
                    Select the test to set its marks:
                    <select name="test_id" id="test_id" class="form-control">
                        <option value="None">None</option>

                        <?php 

			  
            while($row=mysqli_fetch_assoc($r))
            {
                $obj=new DateTime($row['T_Date']);
                            $d=date_format($obj,"d F Y");
                
                ?>

                        <option value="<?php echo $row['T_ID']; ?>"><?php echo $row['T_Name'] . "&nbsp;&nbsp;Dated: " . $d; ?></option>

                        <?php
                            
            }
    ?>
                    </select>
                    <?php


                ?> -->




                    <!-- <label for="test_marks"><b>Enter total marks:</b></label>
                    <input type="number" class="form-control" name="test_marks" />

                    <input type="submit" class="btn aa mt-3" name="update" value="UPDATE" id="update" />

                    <button type="button" class="btn aa mt-3" name="cancel" onClick="window.location = 'dashboard.php'">CANCEL</button>

                </div>

            </div>

        </form>

    </div> -->

</body>

</html>


<?php  

	//on clicking update i.e. DONE button
    if(isset($_POST['update']))
    {
        $test_id=$_POST['test_id'];		//selected value from dropdown list
        $marks= $_POST['test_marks'];
        
        $q2="UPDATE test SET T_Marks='".$marks."' WHERE T_ID='".$test_id."'";
        $re2=mysqli_query($con,$q2);
        if(!($re2))
        {
            echo '<script>alert("Marks update failed!");</script>';
        }
        else
        {
            echo '<script>alert("Marks updated!");</script>';
        }
        
        
    }

?>
