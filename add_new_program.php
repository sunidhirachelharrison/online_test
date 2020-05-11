<?php
	
    //Starting a new session
    session_start();

    //including file for database connection
    include("DB_connect.php");


	if(isset($_REQUEST['p_submit']))
	{
		if($_REQUEST['p_name'] == "")
		{
			echo '<script>alert("Program name can not be blank!");</script>';
		}
		else
		{
			$program_name = mysqli_real_escape_string($con,$_REQUEST['p_name']);
			
			$sql = "INSERT INTO `program` (`Prog_Name`) VALUES ('$program_name')";
            $r=mysqli_query($con,$sql);
			if($r)
			{
				echo '<script>alert("New Program added Successfully!");</script>';
			}
			else
			{
                echo '<script>alert("Unable to add new Program!");</script>';
			}
		}
	}
?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <title>| Admin Panel (CTLD) |</title>
    <style>
        .bg-dark1 {
            background: #ea5e0d
        }

    </style>
</head>

<body>
    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>

    <nav class="navbar navbar-expand-sm bg-dark1 navbar-dark">
        <a class="navbar-brand" href="index.php">Admin Panel</a>

        <!--
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Logout</a>
                </li>
            </ul>
        </div>
-->
    </nav>



    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <button type="button" id="sidebarCollapse" class="btn btn-info">
                <i class="fa fa-align-justify"></i>
                <!--<span>Check</span>-->
            </button>
            <h4>&nbsp;&nbsp;Add New Program</h4>
        </nav>
        <!-- Page Coding Start -->
        <div class="" id="formModal">
            <div class="modal-dialog modal-lg">
                <form method="post" id="exam_form" action="#">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title"></h4>

                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Program Name<span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="p_name" id="p_name" class="form-control" onfocusout="return validate_progname(this.value)" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input type="submit" name="p_submit" class="btn btn-success" value="Add" />
                        </div>
                    </div>
                </form>
            </div>
        </div>




    </div>

    <!--    </div>-->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });

    </script>
    <script>
        var validating = false;

        function validate_progname(inputval) {
            //            var inputval = trim(inputval);
            if (inputval == null || inputval == "" || inputval == " ") {
                if (validating == false) {
                    validating = true;
                }
                alert("Program name can't be blank!");
                setTimeout(function() {
                    document.getElementById("p_name").focus();
                    validating = false;
                }, 1);
                return false;

            }
            for (var i = 0, len = inputval.length; i < len - 1; ++i) {
                if ((inputval.charAt(i) === ' ') && (inputval.charAt(i + 1) === ' ')) {
                    if (validating == false) {
                        validating = true;
                    }
                    alert('Program name cannot have adjacent spaces!');
                    setTimeout(function() {
                        document.getElementById("p_name").focus();
                        validating = false;
                    }, 1);
                    return false;
                }
            }
        }

    </script>
</body>

</html>
