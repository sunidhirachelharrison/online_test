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



<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Add New Program</title>

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
        <a class="navbar-brand" href="#">Admin Panel - Add New Program</a></nav>

    <div class="container">

        <!-- Page Coding Start -->
        <div class="" id="formModal">
            <div class="modal-dialog modal-lg pt-3 pb-3">
                <form method="post" id="exam_form" action="#">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title">Add New Program</h4>
                            <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-3">Program Name<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" name="p_name" id="p_name" class="form-control" onfocusout="" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input type="submit" name="p_submit" onclick="return validate_progname()" class="btn bg-orange text-white" value="Add" />
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <footer class="fixed-bottom">
            <div class="text-center">
                <p>Copyright &copy; Teerthanker Mahaveer University</p>
            </div>
        </footer>


    </div>

    <!--    </div>-->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->

    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });

    </script>
    <script>
        function validate_progname() {
            var inputval = document.getElementById('p_name').value;

            if (inputval == null || inputval == "" || inputval == " ") {

                alert("Program name can't be blank!");

                document.getElementById("p_name").focus();

                return false;

            }
            for (var i = 0, len = inputval.length; i < len - 1; ++i) {
                if ((inputval.charAt(i) === ' ') && (inputval.charAt(i + 1) === ' ')) {

                    alert('Program name cannot have adjacent spaces!');

                    document.getElementById("p_name").focus();

                    return false;
                }
            }
        }

    </script>
</body>

</html>
