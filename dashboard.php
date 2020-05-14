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

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Admin Panel | Dashboard</title>

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style1.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Font Awesome Offline -->
    <link rel="stylesheet" href="Font-Awesome-4.7/css/font-awesome.min.css">

    <style>
        .bg-dark1 {
            background: #ea5e0d;
        }

        a {
            color: #fff;
        }

        a:hover {
            color: #fff;
            text-decoration: none;
        }

        .dropdown:hover>.dropdown-menu {
            display: block;
        }

        .dropdown>.dropdown-toggle:active {
            /*Without this, clicking will make it sticky*/
            pointer-events: none;
        }

        .dropdown-menu {
            /* background: #ea5e0d9e; */
            background: #e9ecef;

        }

        .dropdown-item:hover {
            background-color: #ea5e0d;
            color: #fff;
        }

        .dropdown a:hover {
            color: #fff;
        }

    </style>

    <style type="text/css">
        body {
            width: 100%;
            background: url(image/book.png);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .intro,
        footer {
            color: white;
        }

        .btn {
            margin-top: 2%;
            display: inline-block;
            padding: 14px 17px;
            border: 2px solid #fff;
            text-transform: uppercase;
            letter-spacing: 0.015em;
            font-size: 18px;
            font-weight: 600;
            line-height: 1;
            color: #fff;
            background: #ea5e0d;


        }

        /* 
        .btn:hover {
            color: #ea5e0d;
            background: #fff;
            border: 2px solid #ea5e0d;
        } */

        h1 {
            color: #fff;
            text-transform: uppercase;
            font-size: 60px;
            font-weight: 700;
            letter-spacing: 0.015em;
        }

        h1::after {
            content: '';
            width: 300px;
            display: block;
            background: #fff;
            height: 6px;
            margin: 20px auto;
            line-height: 1.1;
        }

        .goodluck {
            color: #fff;
            margin-bottom: 3%;
            margin-top: 45px;
        }

        .bg-dark2 {
            background-color: #343a40 !important;
        }

    </style>


    <script>
        function showPage(x) {
            if (x == "") {
                document.getElementById("formModal").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("formModal").innerHTML = this.responseText;
                    }
                };
                //var ty="Quantitative Aptitude";
                xmlhttp.open("GET", "xx.php?x=" + x, true);
                xmlhttp.send();
            }
        }

    </script>



</head>

<body>
    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>

    <nav class="navbar navbar-expand-sm bg-dark1 navbar-dark">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">


                <li class="nav-item active">
                    <a class="nav-link" href="change_password.php">Change Password</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="searching.php">Search User Details</a>
                </li>

                <li class="dropdown p-2">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Import</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="upload_questions.php">Import/Upload Questions from Excel Sheet</a></li>
                        <li><a class="dropdown-item" href="upload_student_reg_details.php">Import/Upload Student Registration Details from Excel Sheet</a></li>
                        <li><a class="dropdown-item" href="upload_instructions.php">Import/Upload Instructions from Excel Sheet</a></li>
                    </ul>
                </li>
                <li class="dropdown p-2">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="add_test_details.php">Add New Test/Exam </a></li>
                        <li><a class="dropdown-item" href="add_new_course.php">Add New Course </a></li>
                        <li><a class="dropdown-item" href="add_new_program.php">Add New Program </a></li>
                        <li><a class="dropdown-item" href="add_passage_type_questions.php">Add Long Question </a></li>
                        <li><a class="dropdown-item" href="add_subquestions.php">Add Sub Questions to a Long Question </a></li>
                        <li><a class="dropdown-item" href="add_new_instructions.php">Add New Instruction</a></li>
                    </ul>
                </li>
                <li class="dropdown p-2">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Edit/Delete</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="Update_profile_form.php">Edit my profile details</a></li>
                        <li><a class="dropdown-item" href="edit_or_delete_user_details.php">Edit/Delete User details</a></li>
                        <li><a class="dropdown-item" href="edit_or_delete_instructions.php">Edit/Delete Instructions</a></li>
                        <li><a class="dropdown-item" href="update_marks_for_test.php">Edit Marks of a Test</a></li>
                        <li><a class="dropdown-item" href="">Edit/Delete Test Details</a></li>
                        <li><a class="dropdown-item" href="">Edit/Delete Program Details</a></li>
                        <li><a class="dropdown-item" href="edit_or_delete_course.php">Edit/Delete Course Details</a></li>
                        <li><a class="dropdown-item" href="">Edit/Delete Questions</a></li>
                    </ul>
                </li>
                <li class="dropdown p-2">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Others</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="select_test.php">Set Test to be conducted</a></li>
                        <li><a class="dropdown-item" href="select_courses_for_test.php">Set Courses whose test is to be conducted</a></li>
                        <li><a class="dropdown-item" href="reset_password_of_user.php">Reset Password of another user</a></li>
                    </ul>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="view_result.php">View Result</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="view_attendance.php">View Attendance&nbsp;&nbsp;&nbsp;</a>
                </li>

            </ul>
            <!--
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="log_out.php">Logout</a>
                </li>
            </ul>
-->
        </div>
    </nav>

    <center>
        <div class="intro pt-5"><br /><br /><br /><br />
            <h1>Online Assessment</h1>

            <a href="log_out.php" class="btn"> Log out </a> &emsp;
            <a href="Registration.php" class="btn"> New Registration </a>
            <h2 class="goodluck">FOE & CS</h2>
        </div>
    </center>

    <!--     Footer Text      -->
    <footer>
        <div class="text-center">
            <p class="text-white">Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });

    </script>
</body>

</html>
