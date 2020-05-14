<?php

include("DB_connect.php");
session_start();

    if(isset($_POST['change_pwd']))
    {
        $qry="SELECT * FROM user WHERE U_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
        $r=mysqli_query($con,$qry);
        if($r)
        {
            $row=mysqli_fetch_assoc($r);
            $db_pwd=$row['U_Password'];
            $current_password=$_POST['current_password'];
            $new_password=$_POST['new_password'];
            $retype_new_password=$_POST['retype_new_password'];
            $a=password_verify($current_password,$db_pwd);
            if($a)
            {
                if($new_password===$retype_new_password)
                {
                    //$hash=password_hash();
                    $new_hash=password_hash($new_password, PASSWORD_ARGON2I); 
                    $query="UPDATE user SET U_Password='".$new_hash."' WHERE U_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
                    $result=mysqli_query($con,$query);
                    if($result)
                    {
                        echo '<script>alert("Password changed successfully");</script>';
                    }
                    else
                    {
                        echo '<script>alert("Failed to change the password!");</script>';
                    }
                }
                else
                {
                    echo '<script>alert("Please re-enter the same new password!");</script>';
                }
            }
            else
            {
                echo '<script>alert("The current password is not valid!");</script>';
            }
            
        }
        else
        {
            echo '<script>alert("Failed to fetch the current password!");</script>';
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
    <title>Change Password</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/loginstyle.css">

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
        <a class="navbar-brand" href="#">Admin Panel - Change Password</a>
    </nav>

    <!-- Modal Page Coding Start -->
    <div class="" id="formModal">
        <div class="modal-dialog modal-lg mt-5">

            <form method="post" id="exam_form">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Change Password</h4>
                        <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-3"><label class="text-right font-weight-bold">Current Password<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" id="current_password" name="current_password" onfocusout="" required />
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-3"><label class="text-right font-weight-bold">New Password<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" id="new_password" name="new_password" onfocusout="" required />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-3"><label class="text-right font-weight-bold">Retype Password<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" id="retype_new_password" name="retype_new_password" onfocusout="" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="submit" id="change_pwd" name="change_pwd" class="btn bg-orange text-white" value="Change Password" onclick="return validate_pwd()" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Page End -->

    <!-- <form action="#" method="post">

        <div class="container">

            <br /><br />
            <center>
                <h1>Change Password</h1><br />
            </center>

            <div class="row">

                <label for="current_password"><b>Current Password:</b></label>
                <input type="password" class="form-control" id="current_password" name="current_password" onfocusout="return validate_current_password(this.value)" required /><br />

                <label for="new_password"><b>New Password:</b></label>
                <input type="password" class="form-control" id="new_password" name="new_password" onfocusout="return validate_new_password(this.value)" required /><br />

                <label for="retype_new_password"><b>Retype New Password:</b></label>
                <input type="password" class="form-control" id="retype_new_password" name="retype_new_password" onfocusout="return validate_retypenew_password(this.value)" required /><br /><br /><br />

                <input type="submit" class="btn btn-primary" name="change_pwd" value="CHANGE PASSWORD" />

                <button type="button" class="btn btn-primary" name="cancel" onClick="window.location = 'dashboard.php'">CANCEL</button>

            </div>

        </div>

    </form> -->

    <script>
        function validate_pwd() {
            var current_password = document.getElementById('current_password').value;
            var new_password = document.getElementById('new_password').value;
            var retype_new_password = document.getElementById('retype_new_password').value;
            //alert(current_password);

            //validate current password
            if (current_password == null || current_password == "") {
                alert("Invalid current password!Empty or null value not allowed!");
                document.getElementById("current_password").focus();
                return false;
            }
            for (var i = 0, len = current_password.length; i < len; ++i) {
                if (current_password.charAt(i) === ' ') {

                    alert("Invalid current password!Spaces are not allowed!");
                    document.getElementById("current_password").focus();
                    return false;
                }

            }
            //validate new password
            if (new_password == null || new_password == "") {

                alert("Invalid new password!Empty or null value not allowed!");

                document.getElementById("new_password").focus();

                return false;
            } else if (new_password === current_password) {

                alert("New password can not be the same as current password!");

                document.getElementById("new_password").focus();

                return false;
            }
            for (var i = 0, len = new_password.length; i < len; ++i) {
                if (new_password.charAt(i) === ' ') {

                    alert("Invalid new password!Spaces are not allowed!");
                    document.getElementById("new_password").focus();

                    return false;
                }
            }


            //validate retype_new_password
            if (retype_new_password == null || retype_new_password == "") {

                alert("Invalid retype-new password!Empty or null value not allowed!");

                document.getElementById("retype_new_password").focus();

                return false;
            } else if (retype_new_password != new_password) {

                alert("Retyped New password must be the same as new password!");

                document.getElementById("retype_new_password").focus();

                return false;
            }
            for (var i = 0, len = retype_new_password.length; i < len; ++i) {
                if (retype_new_password.charAt(i) === ' ') {

                    alert("Invalid retype new password!Spaces are not allowed!");

                    document.getElementById("retype_new_password").focus();

                    return false;
                }
            }


        }

    </script>


</body>

</html>
