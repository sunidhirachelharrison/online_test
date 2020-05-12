<?php
    
    //including the file for database connection
    include("DB_connect.php");
	

    //starting the session
    session_start();
	

	//if user is not logged in, forward to login page
    // if(!(isset($_SESSION['U_Enrollment_No'])) || ($_SESSION['User']!="admin") )
    // {
    //    echo '<script>alert("You do not have the priviledge to reset the password! Please contact the admin!")</script>';
    //     header("location:index.php");
    // }
    
	
            
?>

<!DOCTYPE html>
<html lang="en">
<head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Add New Instructions</title>

    <!-- Bootstrap CSS -->  
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Font Awesome Offline -->
    <link rel="stylesheet" href="Font-Awesome-4.7/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        .bg-orange{
            background: #ea5e0d;
        }
        th,td{
            text-align: center;
        }
    </style>

</head>
<body>
    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Admin Panel - Reset Password of User</a></nav>

    <form action="#" method="post">
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-sm-12">
                    <!-- <h1>Reset Password</h1> -->

                    <label for="value"><b>Enter Enrollment No/Employee ID of user:</b></label>
                    <input type="text" class="form-control" placeholder="" id="enrollment_no" name="enrollment_no" value="<?php echo htmlspecialchars($_POST['enrollment_no'] ?? '', ENT_QUOTES); ?>" onfocusout="return validate_enrno(this.value)" required /><br />


                    <input type="submit" class="btn bg-orange text-white" name="find_user" value="FIND USER" />
                    <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>

                </div>

            </div>

        </div>

        <?php
    
    if(isset($_POST['find_user']))
    {
            
        $enrollment_no=mysqli_real_escape_string($con,$_POST['enrollment_no']);
//        $value=$_POST['value'];
        //$section=$_POST['section'];
       
        
        //$query1="SELECT * FROM user u,result r WHERE u.".$selected_radio."like '%".$value."%' AND u.U_Enrollment_No=r.R_Enrollment_No";
        
        $query1="SELECT * FROM user WHERE U_Enrollment_No='".$enrollment_no."'";
        
        
        $query2="";
        //if($selected_radio!="T_Name")
        //{
            $r=mysqli_query($con,$query1);
            if(!($r))
            {
                echo '<script type="text/javascript">alert("Failed to fetch user details");</script>';
            }
            else
            {
                ?>
        <div class="container">


            <div style="" class="mb-5">
                <table border="" id="search_result_table" style="width:100%;" >

                    

                    <th>Enrollment No.</th>
                    <th>Name</th>
                    <th>User Type</th>
                    <th>Program</th>
                    <th>Section</th>
                    <th>Branch</th>
                    <th>Year</th>
                    <!--
                       <td>Quantitative Aptitude Marks</td>                   
                       <td>Verbal Aptitude Marks</td>                   
-->
                    <!--                       <td>Total Marks</td>                       -->
                    

                    <?php
                
        
                    while($row=mysqli_fetch_assoc($r))
                    {
                        
                        
                        echo "<tr><td>{$row['U_Enrollment_No']}</td><td>{$row['U_Name']}</td><td>{$row['U_User_Type']}</td><td>{$row['U_Program']}</td><td>{$row['U_Section']}</td><td>{$row['U_Branch']}</td><td>{$row['U_Year']}</td></tr>";
                        
                    }
                
                    }
        //}
    }


                    
                    ?>
            </div>
            </table>

        </div>
        <div class="container">
        <!--    <form action="#" method="post">-->
        <div class="row">
            <!-- <div class="col-md-1"></div> -->
            <div class="col-md-2"><label class="text-right font-weight-bold">New Password<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-4">
                <input type="password" class="form-control" id="new_password" name="new_password" onfocusout="return validate_new_password(this.value)" />
            </div>
            <div class="col-6"></div>
        </div>
        <br>
        <div class="row">
            <!-- <div class="col-md-1"></div> -->
            <div class="col-md-2"><label class="text-right font-weight-bold">Retype Password<span class="text-danger">*</span></label>
            </div>
            <div class="col-md-4">
                <input type="password" class="form-control" id="retype_new_password" name="retype_new_password" onfocusout="return validate_retypenew_password(this.value)" />
            </div>
            <div class="col-6"></div>
        </div>
<br>
        <input type="submit" class="btn bg-orange text-white" name="reset_password" id="reset_password" value="RESET PASSWORD" />
        </div>
    </form>
    <footer class="mt-5">
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>
</body>
<script>
    var validating = false;

    function validate_enrno(inputval) {
        var letters = /^[A-Za-z0-9]+$/;
        var isValid = letters.test(inputval);
        if (inputval == null || inputval == "" || inputval == " ") {
            if (validating == false) {
                validating = true;
            }
            alert("Enrollment no can't be blank");
            setTimeout(function() {
                document.getElementById("enrollment_no").focus();
                validating = false;
            }, 1);
            //            document.form1.rno.focus();
            //            name.focus();
            //            document.getElementById("enrollment_no").select();
            return false;
        } else if (inputval.length < 8) {
            if (validating == false) {
                validating = true;
            }
            alert("Enrollment no must be at least 8 characters long.");
            setTimeout(function() {
                document.getElementById("enrollment_no").focus();
                validating = false;
            }, 1);
            return false;
        } else if (!isValid) {
            if (validating == false) {
                validating = true;
            }
            alert("Enrollment No can not contain Special Characters.");
            setTimeout(function() {
                document.getElementById("enrollment_no").focus();
                validating = false;
            }, 1);
            return false;
        }
        for (var i = 0, len = inputval.length; i < len; ++i) {
            if (inputval.charAt(i) === ' ') {
                if (validating == false) {
                    validating = true;
                }
                alert('Enrollment no cannot have spaces!');
                setTimeout(function() {
                    document.getElementById("enrollment_no").focus();
                    validating = false;
                }, 1);
                return false;
            }
        }
    }

    function validate_new_password(inputval) {
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Password can't be blank");
            setTimeout(function() {
                document.getElementById("new_password").focus();
                validating = false;
            }, 1);
            return false;
        } else if (inputval.length < 6) {
            if (validating == false) {
                validating = true;
            }
            alert("Password must be at least 6 characters long.");
            setTimeout(function() {
                document.getElementById("new_password").focus();
                validating = false;
            }, 1);
            return false;
        }
        for (var i = 0, len = inputval.length; i < len; ++i) {
            if (inputval.charAt(i) === ' ') {
                if (validating == false) {
                    validating = true;
                }
                alert('Password cannot have spaces!');
                setTimeout(function() {
                    document.getElementById("new_password").focus();
                    validating = false;
                }, 1);
                return false;
            }
        }
    }

    function validate_retypenew_password(inputval) {
        var pwd = document.getElementById('new_password').value;
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Password can't be blank");
            setTimeout(function() {
                document.getElementById("retype_new_password").focus();
                validating = false;
            }, 1);
            return false;
        } else if (inputval.length < 6) {
            if (validating == false) {
                validating = true;
            }
            alert("Password must be at least 6 characters long.");
            setTimeout(function() {
                document.getElementById("retype_new_password").focus();
                validating = false;
            }, 1);
            return false;
        } else if (inputval != pwd) {
            if (validating == false) {
                validating = true;
            }
            alert("Confirm Password must be same as Password.");
            setTimeout(function() {
                document.getElementById("retype_new_password").focus();
                validating = false;
            }, 1);
            return false;
        }
        for (var i = 0, len = inputval.length; i < len; ++i) {
            if (inputval.charAt(i) === ' ') {
                if (validating == false) {
                    validating = true;
                }
                alert('Password cannot have spaces!');
                setTimeout(function() {
                    document.getElementById("retype_new_password").focus();
                    validating = false;
                }, 1);
                return false;
            }
        }
    }

</script>

</html>


<?php

    if(isset($_POST['reset_password']))
    {
            
        $new_password=mysqli_real_escape_string($con,$_POST['new_password']);
        $retype_new_password=mysqli_real_escape_string($con,$_POST['retype_new_password']);
        $enrno=mysqli_real_escape_string($con,$_POST['enrollment_no']);
        //        $value=$_POST['value'];
        //$section=$_POST['section'];
       
        
        if($new_password===$retype_new_password)
                {
                    //$hash=password_hash();
//            echo '<script>alert('.$erno.');</script>';
                    $new_hash=password_hash($new_password, PASSWORD_ARGON2I); 
                    $query="UPDATE user SET U_Password='".$new_hash."' WHERE U_Enrollment_No='".$enrno."'";
                    $result=mysqli_query($con,$query);
                    if($result)
                    {
                        echo '<script>alert("Password reset successfully");</script>';
                    }
                    else
                    {
                        echo '<script>alert("Failed to reset the password!");</script>';
                    }
                }
                else
                {
                    echo '<script>alert("Please re-enter the same new password!");</script>';
                }
    }


?>
