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
    <meta charset="UTF-8">
    <title>Add New Instruction</title>
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
        <a class="navbar-brand" href="index.php">Center for Teaching, Learning & Development</a></nav>
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Add New Instruction</h1>

            <div class="row">
                <div class="col-sm-8 p-4" style="background:#e9ecef">
                    <h4>Enter the new instruction</h4><br />

                    <label for="description"><b> Description:</b></label>
                    <input type="textarea" class="form-control" name="description" id="description" required /><br />


                    <input type="submit" class="btn aa mt-3" name="add" value="ADD" id="add" />

                </div>


            </div>

        </form>

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

</script>
