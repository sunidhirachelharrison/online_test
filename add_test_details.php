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
		if(($_REQUEST['t_title'] == "") || ($_REQUEST['t_date'] == "") ||($_REQUEST['t_ques'] == "")||($_REQUEST['t_marks'] == "") || ($_REQUEST['t_hours'] == "") || ($_REQUEST['t_minutes'] == "")||(($_REQUEST['t_time_shiftA'] == "") && ($_REQUEST['t_time_shiftB'] == "") && ($_REQUEST['t_time_shiftC'] == "")))
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
            $t_ques= $_REQUEST['t_ques'];
            $t_marks= $_REQUEST['t_marks'];
            $t_hours= $_REQUEST['t_hours'];
            $t_minutes= $_REQUEST['t_minutes'];
            
			
            //insert test details in test table
			$sql = "INSERT INTO `test` (`T_Name`,`T_Date`,`T_Time_ShiftA`,`T_Time_ShiftB`,`T_Time_ShiftC`,`T_Marks`,`T_Flag`,`T_Hours`,`T_Minutes`,`T_Questions`) VALUES ('$title','$date','$time_shiftA','$time_shiftB','$time_shiftC','$t_marks',null,'$t_hours','$t_minutes','$t_ques')";
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
                                        <input type="text" class="form-control" name="t_title" id="t_title" onfocusout="" required />
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
                                    <label class="col-md-2">Total Questions<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="t_ques" id="t_ques" onfocusout="" required />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-2">Total Marks<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="t_marks" id="t_marks" onfocusout="" required />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-2">Total Time<span class="text-danger">*</span></label>
                                    <div class="col-md-2">
                                        Hours<input type="number" class="form-control" name="t_hours" id="t_hours" onfocusout="" required />
                                        Minutes<input type="number" class="form-control" name="t_minutes" id="t_minutes" onfocusout="" required />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input type="submit" id="add" name="t_submit" class="btn bg-orange text-white" value="Add" onclick="return validate_fields()" />
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
    function validate_fields() {
        var t_title = document.getElementById('t_title').value;
        var t_marks = document.getElementById('t_marks').value;
        var t_ques = document.getElementById('t_ques').value;
        var t_hours = document.getElementById('t_hours').value;
        var t_minutes = document.getElementById('t_minutes').value;

        //validate title
        if (t_title == null || t_title == "") {

            alert("Test Title can't be blank");

            document.getElementById("t_title").focus();

            return false;
        }

        //validate questions
        if (t_ques == null || t_ques == "") {

            alert("Total Questions can't be blank");

            document.getElementById("t_ques").focus();

            return false;
        }

        //validate marks
        if (t_marks == null || t_marks == "") {

            alert("Total Marks can't be blank");

            document.getElementById("t_marks").focus();

            return false;
        }

        //validate hours
        if (t_hours == null || t_hours == "") {

            alert("Hours can't be blank");

            document.getElementById("t_hours").focus();

            return false;
        }

        //validate minutes
        if (t_minutes == null || t_minutes == "") {

            alert("Minutes can't be blank");

            document.getElementById("t_minutes").focus();

            return false;
        }



    }

</script>
