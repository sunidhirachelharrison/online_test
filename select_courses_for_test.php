<?php

    //Starting a new session
    session_start();

    //including file for database connection
    include("DB_connect.php");

    //fetch the course details
    $sql_fetch="SELECT * FROM course, program WHERE Prog_ID=C_Prog_ID order by Prog_Name, C_Code";
    $flag=mysqli_query($con,$sql_fetch);
    $count=1;
    if(!($flag))
    {
        echo '<script>alert("Failed to fetch the course details!");</script>';
    }
    else
    {

    
    

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Select Test</title>

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
        <a class="navbar-brand" href="#">Admin Panel - Select Course For Test/Exam</a></nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <span class="align-middle">Select the courses:</span>
                        <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                    </div>
                    <div class="card-body">
                        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                            <div class="p-3">
                                <label>Tick the courses:</label>

                                <br>

                                <table border="1" class="table table-bordered table-hover" id="result_table">


                                    <tr>
                                        <th>
                                            <center>S.No.</center>
                                        </th>
                                        <th>
                                            <center>Select</center>
                                        </th>
                                        <th>
                                            <center>Course Code</center>
                                        </th>
                                        <th>
                                            <center>Course Name</center>
                                        </th>
                                        <th>
                                            <center>Program Name</center>
                                        </th>

                                    </tr>

                                    <?php
                    
                    while($row=mysqli_fetch_assoc($flag))
                    {
                        
                    
        
        ?>
                                    <tr>
                                        <td>
                                            <center><?php echo $count; ?></center>
                                        </td>
                                        <td>
                                            <center><input type="checkbox" id="<?php echo $row['C_ID']; ?>" name="<?php echo $count; ?>" value="<?php echo $row['C_ID']; ?>"></center>
                                        </td>
                                        <td>
                                            <center><?php echo $row['C_Code']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $row['C_Name']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $row['Prog_Name']; ?></center>
                                        </td>
                                    </tr>
                                    <?php
                        $count++;
                    }
            
                                    ?>
                                </table>
                                <?php
                                
    }
                                ?>
                                <br />

                                <input type="submit" id="select" name="select" class="btn bg-orange text-white" value="SET COURSES" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php


if(isset($_POST['select']))
{
    
    //set the C_Flag=null for all the courses to unset all the courses
    $q1="UPDATE course SET C_Flag=null";
    $re1=mysqli_query($con,$q1);
    if(!($re1))
    {
        echo '<script>alert("error in unsetting the courses!");</script>';
    }
    else
    {
        //
    }
    
    
    
    //set the C_Flag of courses to 1 for selected courses
    $y=0;
    for($i=1;$i<$count;$i++) 
    {
        if(isset($_POST[$i]))      //update only of checked courses
        {
            $q="UPDATE course SET C_Flag='1' WHERE C_ID='".$_POST[$i]."'";
            $re=mysqli_query($con,$q);
            if(!($re))
            {
                echo '<script>alert("Failed to set the course!");</script>';
                $y=0;
                break;
            }
            else
            {
            //echo '<script>alert("Course has been set successfully!");</script>';
                $y=1;
            }
        }
        
        
    }
    if($y==1)
    {
        echo '<script>alert("Courses have been set successfully!");</script>';
    }
            
}


?>
