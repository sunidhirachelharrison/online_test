<?php

include("DB_connect.php");
session_start();


if(isset($_POST['add']))
{
    $description=$_POST['description'];
    
    
    $sql="INSERT into instructions(I_ID,I_Description) VALUES(null,'".$description."')";
    
    $r=mysqli_query($con,$sql);
    if(!($r))
    {
        echo '<script>alert("Failed to add the new instruction!");</script>';    
    }
    else
    {
        echo '<script>alert("Instruction added successfully!");</script>';    
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
    <title>Add New Instructions</title>

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
        <a class="navbar-brand" href="#">Admin Panel - Add New Instructions</a></nav>
    <!--     
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Add New Instruction</h1>

            <div class="row">
                <div class="col-sm-8 p-4" style="background:#e9ecef">
                    <h4>Enter the new instruction</h4><br />

                    <label for="description"><b> Description:</b></label>
                    <input type="textarea" class="form-control" name="description" id="description" onfocusout="return validate_instruction(this.value)" required /><br />


                    <input type="submit" class="btn aa mt-3" name="add" value="ADD" id="add" />

                </div>


            </div>

        </form>

    </div> -->

    <div class="container">

        <!-- Page Coding Start -->
        <div class="" id="formModal">
            <div class="modal-dialog modal-lg pt-3 pb-3">
                <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title">Enter the New Instruction</h4>
                            <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-2">Description:<span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="textarea" class="form-control" name="description" id="description" onfocusout="" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input type="submit" name="add" id="add" onclick="return validate_instruction()" class="btn bg-orange text-white" value="Add" />
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


</body>

</html>
<script>
    //    function add_fields() {
    //    var count = document.getElementById("field_count");
    //    var d = document.getElementById("fields");
    //
    //   d.innerHTML += "<br />Question: <input type='text' class='form-control'/><br/>Option A: <input type='text' class='form-control' style='width:150px'/>Option B: <input type='text' class='form-control' style='width:150px'/>Image with option A(if any): <input type='file' class='form-control'/><br/>&nbsp;Image with option B(if any): <input type='file' class='form-control'/><br/>Option C: <input type='text' class='form-control' style='width:100px'/>&nbsp;Image with option C(if any): <input type='file' class='form-control'/><br/>Option D: <input type='text' class='form-control' style='width:100px'/>&nbsp;Image with option D(if any): <input type='file' class='form-control'/><br/>Option E: <input type='text' class='form-control' style='width:100px'/>&nbsp;Image with option E(if any): <input type='file' class='form-control'/><br/>";
    //}
    //    var validating = false;

    function validate_instruction() {
        var inputval = document.getElementById('description').value;
        if (inputval == null || inputval == "" || inputval == " ") {

            alert("Instruction can't be blank");

            document.getElementById("description").focus();

            return false;
        }
        for (var i = 0, len = inputval.length; i < len - 1; ++i) {
            if ((inputval.charAt(i) === ' ') && (inputval.charAt(i + 1) === ' ')) {

                alert('Instruction cannot have adjacent spaces!');

                document.getElementById("description").focus();

                return false;
            }
        }
    }

</script>
