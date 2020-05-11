<?php

//Starting a new session
    session_start();

    //including file for database connection
    include("DB_connect.php");

//***********************************************************************

    $q="SELECT * FROM program";
    $x=mysqli_query($con,$q);
    
                          
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
    
        <!-- Modal Page Coding Start -->
        <div class="" id="formModal">
                <div class="modal-dialog modal-lg mt-5 mb-5">

                    <form method="post" id="exam_form">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal_title">Enter the Course Details:</h4>
                                <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3"><label class="text-right font-weight-bold">Course Code<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                        <input type="text" class="form-control" name="course_code" id="course_code" onfocusout="return validate_course_code(this.value)" required />
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3"><label class="text-right font-weight-bold">Course Name<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                        <input type="text" class="form-control" name="course_name" id="course_name" onfocusout="return validate_course_name(this.value)" required />
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3"><label class="text-right font-weight-bold">Program<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <select name="prog_name" id="prog_name" onfocusout="return validate_prog_name(this.value)" class="form-control">
                                                <option value="None">None</option>
                                                    <?php  
                                                        while($row=mysqli_fetch_assoc($x))
                                                        {
                                                    ?>
                                                        <option value="<?php echo $row['Prog_ID']; ?>"><?php echo $row['Prog_Name']; ?></option>
                                                    <?php 
                                                        }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <input type="submit" name="add" class="btn bg-orange text-white" id="add" value="ADD"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal Page End -->
    
    
    
    
    
<!--     
    
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Add New Course</h1>

            <div class="row">
                <div class="col-sm-10 p-4" style="background:#e9ecef">
                    <h4>Enter the course details:</h4><br />

                    <label for="course_code"><b> Course Code:</b></label>
                    <input type="text" class="form-control" name="course_code" id="course_code" onfocusout="return validate_course_code(this.value)" required /><br />

                    <label for="course_name"><b> Course Name:</b></label>
                    <input type="text" class="form-control" name="course_name" id="course_name" onfocusout="return validate_course_name(this.value)" required /><br />

                    <label for="prog_name"><b>Program:</b></label>
                    <select name="prog_name" id="prog_name" onfocusout="return validate_prog_name(this.value)" class="form-control">
                        <option value="None">None</option>

                        <?php 
                        
                        while($row=mysqli_fetch_assoc($x))
    {

                        ?>

                        <option value="<?php echo $row['Prog_ID']; ?>"><?php echo $row['Prog_Name']; ?></option>

                        <?php
                          
                        }
                        
                        ?>

                    </select><br />


                    <input type="submit" class="btn aa mt-3" name="add" value="ADD" id="add" />

                </div>


            </div>

        </form>

    </div> -->

</body>

</html>
<script>
    //    function add_fields() {
    //    var count = document.getElementById("field_count");
    //    var d = document.getElementById("fields");
    //
    //   d.innerHTML += "<br />Question: <input type='text' class='form-control'/><br/>Option A: <input type='text' class='form-control' style='width:150px'/>Option B: <input type='text' class='form-control' style='width:150px'/>Image with option A(if any): <input type='file' class='form-control'/><br/>&nbsp;Image with option B(if any): <input type='file' class='form-control'/><br/>Option C: <input type='text' class='form-control' style='width:100px'/>&nbsp;Image with option C(if any): <input type='file' class='form-control'/><br/>Option D: <input type='text' class='form-control' style='width:100px'/>&nbsp;Image with option D(if any): <input type='file' class='form-control'/><br/>Option E: <input type='text' class='form-control' style='width:100px'/>&nbsp;Image with option E(if any): <input type='file' class='form-control'/><br/>";
    //}

    var validating = false;

    function validate_course_code(inputval) {
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Course Code can't be blank");
            setTimeout(function() {
                document.getElementById("course_code").focus();
                validating = false;
            }, 1);
            return false;
        } else if (inputval.length < 5) {
            if (validating == false) {
                validating = true;
            }
            alert("Course Code must be at least 5 characters long.");
            setTimeout(function() {
                document.getElementById("course_code").focus();
                validating = false;
            }, 1);
            return false;
        }
        for (var i = 0, len = inputval.length; i < len; ++i) {
            if (inputval.charAt(i) === ' ') {
                if (validating == false) {
                    validating = true;
                }
                alert('Course Code cannot have spaces!');
                setTimeout(function() {
                    document.getElementById("course_code").focus();
                    validating = false;
                }, 1);
                return false;
            }
        }
    }

    function validate_course_name(inputval) {
        if (inputval == null || inputval == "") {
            if (validating == false) {
                validating = true;
            }
            alert("Course Name can't be blank");
            setTimeout(function() {
                document.getElementById("course_name").focus();
                validating = false;
            }, 1);
            return false;
        }
    }

    function validate_prog_name(inputval) {
        if (inputval === "None") {
            if (validating == false) {
                validating = true;
            }
            alert("Please select a Program Name.");
            setTimeout(function() {
                document.getElementById("prog_name").focus();
                validating = false;
            }, 1);
            return false;
        }
    }

</script>

<?php 

if(isset($_POST['add']))
{
    
    $course_code=mysqli_real_escape_string($con,$_POST['course_code']);
    $course_name=mysqli_real_escape_string($con,$_POST['course_name']);
    $prog_id=$_POST['prog_name'];
    
    //search if a course with same code already exists, if yes then dont add new course
    
    $search_q="SELECT * FROM course WHERE C_Code='".$course_code."'";
    $search_q_flag=mysqli_query($con,$search_q);
    $count=mysqli_num_rows($search_q_flag);
    if($count>0)
    {
        echo '<script>alert("A course with the specified code already exists!");</script>';
    }
    else
    {
        $sql_insert_course="INSERT into course(C_ID,C_Code,C_Name,C_Prog_ID,C_Flag) VALUES(null,'".$course_code."','".$course_name."','".$prog_id."','0')";
        
        $sql_insert_course_flag=mysqli_query($con,$sql_insert_course);
        if(!($sql_insert_course_flag))
        {
            echo '<script>alert("Failed to add new course!");</script>';
        }
        else
        {
            echo '<script>alert("New course added successfully!");</script>';
        }
        
    }    
        
}


?>
