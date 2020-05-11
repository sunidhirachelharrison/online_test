<?php
    
    include("DB_Connect.php");


//******************************************

    if(isset($_POST['submit']))
    {
        
        $enrollment_no=mysqli_real_escape_string($con,$_POST['enrollment_no']);
        $name=mysqli_real_escape_string($con,$_POST['name']);
        $program=$_POST['program'];
        $year=$_POST['year'];
        $branch=$_POST['branch'];
        $section=$_POST['section'];
        //$session_beg=$_POST['session_beg'];
        //$session_end=$_POST['session_end'];
        //$session=$session_beg."-".$session_end;
        $mobile_no=mysqli_real_escape_string($con,$_POST['mobile_no']);
        $email_id=mysqli_real_escape_string($con,$_POST['email_id']);
        //$image=$_POST['imageUpload'];
        $image=basename($_FILES['imageUpload']['name']);
        $password=mysqli_real_escape_string($con,$_POST['password']);
        $confirm_password=mysqli_real_escape_string($con,$_POST['confirm_password']);
        $hashed_pwd=password_hash($password, PASSWORD_ARGON2I); 
        $reg_date=$_POST['reg_date'];
        $reg_time=$_POST['reg_time'];
        
        $target_dir="uploads/";
        $target_file=$target_dir.basename($_FILES['imageUpload']['name']);
        $uploadOk=1;
        $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
        if(move_uploaded_file($_FILES['imageUpload']['tmp_name'],$target_file))
        {
            //echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
        }
            
//        $id=$_POST['id'];
        
        //$image=basename($_FILES['imageUpload']['name']);
        $query="INSERT into user(U_ID,U_User_Type,U_Enrollment_No,U_Name,U_Program,U_Year,U_Section,U_Branch,U_Mobile_No,U_Email_ID,U_Image,U_Password,U_Registration_Date,U_Registration_Time) VALUES(null,'student','".$enrollment_no."','".$name."','".$program."','".$year."','".$section."','".$branch."','".$mobile_no."','".$email_id."','".$image."','".$hashed_pwd."','".$reg_date."','".$reg_time."')";
        
        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//to upload image to server
//   if(isset($_POST['uploadbtn']))
//    {
//        $target_dir="uploads/";
//        $target_file=$target_dir.basename($_FILES['imageUpload']['name']);
//        $uploadOk=1;
//        $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
//        if(move_uploaded_file($_FILES['imageUpload']['tmp_name'],$target_file))
//        {
//            echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
//        }
//        else
//        {
//            echo "Sorry! uploading of image failed!";
//        }
//    }
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        
            
        $r=mysqli_query($con,$query);
        if($r)
        {
            echo '<script type="text/javascript">alert("User Registration Successful!");</script>';
        }
        else
        {
            echo '<script type="text/javascript">alert("User Registration Failed!");</script>';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New User Registration</title>
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
        <a class="navbar-brand" href="index.php">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

    </nav>

    <!--
    <div class="containter">
		<div class="d-flex justify-content-center">
			<br /><br/>
			<div class="card" style="margin-top:50px;margin-bottom: 100px;">
-->





    <form action="#" method="post" name="form1" enctype="multipart/form-data" onsubmit="return validateform()">
        <!--
        <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="row">
                <div class="col-xl-12 col-12">
-->
        <div class="containter">
            <!--<div class="d-flex justify-content-center">-->
            <div class="row">
                <div class="col-4"></div>

                <div class="col-4">
                    <div class="card" style="margin-top:50px;margin-bottom: 100px;">
                        <div class="card-header">
                            <h4>User Registration</h4>
                        </div>
                        <div class="card-body">
                            <!--                    <h1>Registration</h1><br/>-->
                            <!--
                    <label for="id"><b>ID:</b></label>
                    <input type="text" class="form-control" name="id" disabled/><br/>
-->
                            <label for="enrollmentno"><b>Enrollment No.:</b></label>
                            <input type="text" class="form-control" id="enrollment_no" name="enrollment_no" onfocusout="return validate_rno(this.value)" required /><br />

                            <label for="name"><b>Full Name:</b></label>
                            <input type="text" class="form-control" name="name" onfocusout="return validate_name(this.value)" id="name" required /><br />

                            <label for="program"><b>Program:</b></label>
                            <select name="program" id="" class="form-control">
                                <option value="none">None</option>

                                <?php 
                    
                        $q="SELECT * FROM program";
                        $x=mysqli_query($con,$q);
                        while($row=mysqli_fetch_assoc($x))
                        {
                            
                        
                    
                    ?>

                                <option value="<?php echo $row['Prog_Name']; ?>"><?php echo $row['Prog_Name']; ?></option>

                                <?php
                        } 
                        ?>
                            </select><br />

                            <label for="year"><b>Year:</b></label>
                            <select name="year" id="" class="form-control">
                                <option value="none">None</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                            </select><br />

                            <label for="section"><b>Section:</b></label>
                            <select name="section" id="" class="form-control">
                                <option value="none">None</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select><br />

                            <label for="branch"><b>Branch:</b></label>
                            <select name="branch" id="" class="form-control">
                                <option value="none">None</option>
                                <option value="CS">CS</option>
                                <option value="Animation">Animation</option>
                                <option value="Mechanical">Mechanical</option>
                                <option value="Civil">Civil</option>
                                <option value="EE">EE</option>
                                <option value="EC">EC</option>
                                <option value="AI">AI</option>
                                <option value="IBM">IBM - </option>
                                <option value="iNurture">iNurture - Cloud</option>
                            </select><br />

                            <!--
                    <label for="session_beg"><b>Session:</b></label><br/>
                   From:<select name="session_beg" id="session_beg" class="form-control col-sm-4">
                        <option value="none">None</option>
-->
                            <!--                        <option value="2020">2020</option>-->
                            <!--
                    </select> 
                    To:<select name="session_end" id="session_end" class="form-control col-sm-4">
                        <option value="none">None</option>
-->
                            <!--                        <option value="2023">2023</option>-->
                            <!--                    </select><br/>                -->

                            <!--   //to show session begin years from current year                 -->
                            <!--
                    <script type="text/javascript">
                        $(function () {
                            //Reference the DropDownList.
                            var ddlYears = $("#session_beg");

                            //Determine the Current Year.
                            var currentYear = (new Date()).getFullYear();

                            //Loop and add the Year values to DropDownList.
                            for (var i = (currentYear-6); i <= currentYear; i++) {
                                var option = $("<option />");
                                option.html(i);
                                option.val(i);
                                ddlYears.append(option);
                            }
                        });
                    </script>
-->
                            <!--   //to show session end years from current year                 -->
                            <!--
                    <script type="text/javascript">
                        $(function () {
                            //Reference the DropDownList.
                            var ddlYears = $("#session_end");

                            //Determine the Current Year.
                            var currentYear = (new Date()).getFullYear();

                            //Loop and add the Year values to DropDownList.
                            for (var i = currentYear; i <= (currentYear+6); i++) {
                                var option = $("<option />");
                                option.html(i);
                                option.val(i);
                                ddlYears.append(option);
                            }
                        });
                    </script>
-->

                            <label for="mobile_no"><b>Mobile_No.:</b></label>
                            <input type="number" class="form-control" placeholder="" name="mobile_no" id="mobile_no" onfocusout="return validate_mobno(this.value)" required /><br />

                            <label for="email_id"><b>Email ID:</b></label>
                            <input type="email" placeholder="" class="form-control" name="email_id" id="email_id" onfocusout="return validate_emailId(this.value)" required /><br />

                            <label for="imageUpload"><b>Image:</b></label>
                            <input type="file" name="imageUpload" id="imageUpload" class="form-control" />
                            <!--                   <button name="uploadbtn">UPLOAD IMAGE</button><br/>-->

                            <label for="password"><b>Password:</b></label>
                            <input type="password" class="form-control" id="password" name="password" onfocusout="return validate_password(this.value)" required /><br />

                            <label for="confirm_password"><b>Confirm Password:</b></label>
                            <input type="password" class="form-control" name="confirm_password" onfocusout="return validate_con_password(this.value)" id="confirm_password" required /><br />


                            <!--                    <label for="reg_date"><b>Registration Date:</b></label>-->
                            <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="reg_date" hidden /><br />


                            <!--                      <label for="reg_time"><b>Registration Time:</b></label>-->
                            <?php  
                        date_default_timezone_set('Asia/Kolkata');             $dt2=date("H:i:s"); ?>
                            <input type="text" class="form-control" id="reg_date" name="reg_time" value="<?php echo $dt2; ?>" hidden /><br />

                            <input type="submit" class="btn aa" name="submit" value="REGISTER" />

                            <button type="button" class="btn aa" name="log_in" onClick="window.location = 'Log_in.php'">LOG IN</button>


                            <!--
                  <script>
                    $(document).ready(function() { 
                         $("#s1").change(function(){ if($("#s1").val()=="faculty"){
                             $("#f1").prop("disabled",false);
                             $("#f2").prop("disabled",true);
                             $("#f3").prop("disabled",true);
                         }
                        else if($("#s1").val()=="participant")
                            {
                                $("#f1").prop("disabled",true);
                                 $("#f2").prop("disabled",false);
                                 $("#f3").prop("disabled",false);
                            }
                        else if($("#s1").val()=="volunteer")
                            {
                                $("#f1").prop("disabled",true);
                                 $("#f2").prop("disabled",false);
                                 $("#f3").prop("disabled",false);
                            }
                        else
                            {
                                $("#f1").prop("disabled",true);
                                 $("#f2").prop("disabled",true);
                                 $("#f3").prop("disabled",true);
                            }
                        });

                    });
                </script>
-->

                        </div>
                    </div>
                    <div class="col-4"></div>
                </div>
            </div>
            <!--
                    <script type="text/javascript">
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth() + 1; //January is 0!

                        var yyyy = today.getFullYear();
                        if (dd < 10) {
                          dd = '0' + dd;
                        } 
                        if (mm < 10) {
                          mm = '0' + mm;
                        } 
                        var today = dd + '/' + mm + '/' + yyyy;
                        //createCookie("d",window.today);
                        //document.getElementById("reg_date").value=today;
                        //alert(today);
                    </script>                   
-->

        </div>
    </form>
</body>
<!--
<script>
    function ValidateEmail(inputText) {
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (inputText.value.match(mailformat)) {
            //document.form1.text1.focus();
            return true;
        } else {
            alert("You have entered an invalid email address!");
            //document.form1.text1.focus();
            return false;
        }
    }
</script>
-->
<script>
    //    function validateform() {
    //        var name = document.myform.name.value;
    //        var password = document.myform.password.value;
    //        var confirm_password = document.myform.confirm_password.value;
    //
    //        if (name == null || name == "") {
    //            alert("Name can't be blank");
    //            return false;
    //        } else if ((password.length < 6) || (confirm_password.length < 6)) {
    //            alert("Password must be at least 6 characters long.");
    //            return false;
    //        } else if (password != confirm_password) {
    //            alert("Confirm Password must be same as Password ");
    //            return false;
    //        }
    //    }
    var validating = false;

    function validate_rno(rno) {
        var letters = /^[A-Za-z0-9]+$/;
        var isValid = letters.test(rno);
        if (rno == null || rno == "") {
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
        } else if (rno.length < 8) {
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
        for (var i = 0, len = rno.length; i < len; ++i) {
            if (rno.charAt(i) === ' ') {
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

    function validate_name(name) {
        var letters = /^[A-Za-z ]+$/;
        var isValid = letters.test(name);
        if (name == null || name == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Name can't be blank");
            setTimeout(function() {
                document.getElementById("name").focus();
                validating = false;
            }, 1);
            return false;
        } else if (name.length < 3) {
            if (validating == false) {
                validating = true;
            }
            alert("Name must be at least 3 characters long.");
            setTimeout(function() {
                document.getElementById("name").focus();
                validating = false;
            }, 1);
            return false;
        } else if (!isValid) {
            if (validating == false) {
                validating = true;
            }
            alert("Name can not contain Special Characters and numbers.");
            setTimeout(function() {
                document.getElementById("name").focus();
                validating = false;
            }, 1);
            return false;
        }
    }

    function validate_mobno(inputval) {
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Mobile no can't be blank");
            setTimeout(function() {
                document.getElementById("mobile_no").focus();
                validating = false;
            }, 1);
            return false;
        } else if (inputval.length != 10) {
            if (validating == false) {
                validating = true;
            }
            alert("Mobile no must be of 10 characters long.");
            setTimeout(function() {
                document.getElementById("mobile_no").focus();
                validating = false;
            }, 1);
            return false;
        }

    }

    function validate_emailId(inputval) {
        var letters = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var isValid = letters.test(inputval);
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Email ID can't be blank");
            setTimeout(function() {
                document.getElementById("email_id").focus();
                validating = false;
            }, 1);
            return false;
        } else if (inputval.length < 5) {
            if (validating == false) {
                validating = true;
            }
            alert("Invalid email ID.");
            setTimeout(function() {
                document.getElementById("email_id").focus();
                validating = false;
            }, 1);
            return false;
        } else if (!isValid) {
            if (validating == false) {
                validating = true;
            }
            alert("Email ID is invalid.");
            setTimeout(function() {
                document.getElementById("email_id").focus();
                validating = false;
            }, 1);
            return false;
        }

    }

    function validate_password(inputval) {
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Password can't be blank");
            setTimeout(function() {
                document.getElementById("password").focus();
                validating = false;
            }, 1);
            return false;
        } else if (inputval.length < 6) {
            if (validating == false) {
                validating = true;
            }
            alert("Password must be at least 6 characters long.");
            setTimeout(function() {
                document.getElementById("password").focus();
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
                    document.getElementById("password").focus();
                    validating = false;
                }, 1);
                return false;
            }
        }
    }

    function validate_con_password(inputval) {
        var pwd = document.getElementById('password').value;
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Password can't be blank");
            setTimeout(function() {
                document.getElementById("confirm_password").focus();
                validating = false;
            }, 1);
            return false;
        } else if (inputval.length < 6) {
            if (validating == false) {
                validating = true;
            }
            alert("Password must be at least 6 characters long.");
            setTimeout(function() {
                document.getElementById("confirm_password").focus();
                validating = false;
            }, 1);
            return false;
        } else if (inputval != pwd) {
            if (validating == false) {
                validating = true;
            }
            alert("Confirm Password must be same as Password.");
            setTimeout(function() {
                document.getElementById("confirm_password").focus();
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
                    document.getElementById("confirm_password").focus();
                    validating = false;
                }, 1);
                return false;
            }
        }
    }

</script>

</html>
