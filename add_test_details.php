<?php
	//include('DB_Connect.php');
?>
<?php


    //starting the session
    session_start();
    
    //getting the qid and counter value passed from ajax call
    //$q = intval($_GET['x']);
    //$counter = @$_GET['c'];
    //$marked_answer=@$_GET['marked_value'];
    
    //for database connection
    include("DB_connect.php");


	if(isset($_REQUEST['t_submit']))
	{
		if(($_REQUEST['t_title'] == "") || ($_REQUEST['t_date'] == "") || ($_REQUEST['t_time_shiftA'] == "") && ($_REQUEST['t_time_shiftB'] == "") && ($_REQUEST['t_time_shiftC'] == "")||($_REQUEST['t_marks'] == ""))
		{
			echo '<script>alert("Enter Test Fields!");</script>';
		}
		else
		{
			$title = $_REQUEST['t_title'];
			$date = $_REQUEST['t_date'];
			$time_shiftA = $_REQUEST['t_time_shiftA'];
			if($time_shiftA=="")
			{
				$time_shiftA="null";
			}
			$time_shiftB = $_REQUEST['t_time_shiftB'];
            if($time_shiftB=="")
			{
				$time_shiftB="null";
			}
			$time_shiftC = $_REQUEST['t_time_shiftC'];
            if($time_shiftC=="")
			{
				$time_shiftC="null";
			}
            $t_marks= $_REQUEST['t_marks'];
			
			$sql = "INSERT INTO `test` (`T_Name`,`T_Date`,`T_Time_ShiftA`,`T_Time_ShiftB`,`T_Time_ShiftC`,`T_Marks`,`T_Flag`) VALUES ('$title','$date','$time_shiftA','$time_shiftB','$time_shiftC','$t_marks',null)";
			if(mysqli_query($con,$sql))
			{
				echo "<script>alert('New Test Details Inserted Successfully!');</script>";
			}
			else
			{
                echo "<script>alert('Unable to insert test details!');</script>";
				
			}
		}
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
    <title>Add New Course</title>

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
        <a class="navbar-brand" href="#">Admin Panel - Add New Course</a></nav>
<div class="container">
                <!-- Page Coding Start -->
                <div class="" id="">
            <div class="modal-dialog modal-lg mt-4 mb-4">
                <form method="post" id="exam_form">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title">Add Test Details</h4>
                            <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-2">Test Title <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control" name="t_title" id="t_title" onfocusout="return validate_t_title(this.value)" required />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-2"><span class="">Test Date<span class="text-danger">*</span></span></label>
                                    <div class="col-md-8">
                                    <input type="date" class="form-control" name="t_date" id="t_date" required />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-2">Test Time (Shift A)<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                    <input type="time" class="form-control" name="t_time_shiftA" id="t_time_shiftA" required />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-2">Test Time (Shift B)<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                    <input type="time" class="form-control" name="t_time_shiftB" id="t_time_shiftB" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-2">Test Time (Shift C)<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                    <input type="time" class="form-control" name="t_time_shiftC" id="t_time_shiftC" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-2">Total Marks<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                    <input type="number" class="form-control" name="t_marks" id="t_marks" onfocusout="return validate_t_marks(this.value)" required />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input type="submit" id="add" name="t_submit" class="btn bg-orange text-white" value="Add" />
                        </div>
                    </div>
                </form>
            </div>
        </div>


        </div>





<!-- 
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Add New Test/Exam</h1>

            <div class="row">
                <div class="col-sm-10 p-4" style="background:#e9ecef">
                    <h4>Enter the test details:</h4><br />


                    <label for="t_title"><b>Test Title<span class="text-danger">*</span></b>
                    </label>
                    <input type="text" class="form-control" name="t_title" id="t_title" onfocusout="return validate_t_title(this.value)" required /><br />

                    <label for="t_date"><b>Test Date<span class="text-danger">*</span></b>
                    </label>
                    <input type="date" class="form-control" name="t_date" id="t_date" required /><br />


                    <label for="t_time_shiftA"><b>Test Time (Shift A)<span class="text-danger">*</span></b>
                    </label>
                    <input type="time" class="form-control" name="t_time_shiftA" id="t_time_shiftA" required /><br />

                    <label for="t_time_shiftB"><b>Test Time (Shift B)</b>
                    </label>
                    <input type="time" class="form-control" name="t_time_shiftB" id="t_time_shiftB" /><br />

                    <label for="t_time_shiftC"><b>Test Time (Shift C)</b>
                    </label>
                    <input type="time" class="form-control" name="t_time_shiftC" id="t_time_shiftC" /><br />

                    <label for="t_marks"><b>Total Marks<span class="text-danger">*</span></b>
                    </label>
                    <input type="number" class="form-control" name="t_marks" id="t_marks" onfocusout="return validate_t_marks(this.value)" required /><br />

                    <input type="submit" class="btn aa mt-3" name="t_submit" value="ADD" id="add" />

                </div>


            </div>

        </form>

    </div> -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>

<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->


<script>
    //validation scripts
    var validating = false;

    function validate_t_title(inputval) {
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Test Title can't be blank");
            setTimeout(function() {
                document.getElementById("t_title").focus();
                validating = false;
            }, 1);
            return false;
        }
    }

    function validate_t_date(inputval) {

    }

    function validate_t_time_shiftA(inputval) {

    }

    function validate_t_time_shiftB(inputval) {

    }

    function validate_t_time_shiftC(inputval) {

    }

    function validate_t_marks(inputval) {
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Total Marks can't be blank");
            setTimeout(function() {
                document.getElementById("t_marks").focus();
                validating = false;
            }, 1);
            return false;
        }
    }

</script>
