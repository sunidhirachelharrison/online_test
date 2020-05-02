<?php

    //including the file for database connection
    include_once 'DB_connect.php';

    //starting the session
    session_start();
    
    //if user is not logged-in , redirect to log-in page
    if(!(isset($_SESSION['U_Enrollment_No'])))
    {
        header("location:index.php");
    }


?>

<!--************************** HTML CODE ********************************-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">


    <title>Welcome | Online Test (CTLD) </title>
    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="images/tmu.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Optional JavaScript -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <style>
        .mar {
            margin-top: 80px;
        }

    </style>

</head>

<body>

    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">Center for Teaching, Learning & Development</a>
    </nav>

    <nav class="navbar navbar-default title1">
        <div class="container-fluid">

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


            </div>
        </div>
    </nav>

    <div class="container-fluid mar">
        <div class="row">

            <div class="col-md-12">
                <?php 
                
                    
                    echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
                    <tr><td><center><b>S.No.</b></center></td><td><center><b>Section</b></center></td><td><center><b>Total questions</b></center></td><td><center><b>Time</center></b></td><td><center><b>Action</b></center></td></tr>';
                    $c=1;

				echo '<tr><td><center>'.$c++.'</center></td><td><center>'."Quantitative Aptitude".'</center></td><td><center>'."35".'</center></td><td><center>'."30 minutes".'</center></td><td><center><b><a href="t1.php" onclick="popitup(this.href);return false;" class="btn sub1" style="color:white;margin:0px;background:#ea5e0d;><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start New Test</b></span></a></b>&nbsp;<b><a href="resume_test.php" onclick="popitup(this.href);return false;" class="btn sub1" style="color:white;margin:0px;background:#ea5e0d;><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Resume Test</b></span></a></b></center></td></tr>';
   ?>
                <script>
                    var a;
                    //function to open test in a new window without menubar
                    function popitup(a) {
                        window.open(a,
                            'open_window',
                            'menubar=no, toolbar=no, location=no, directories=no, status=no, scrollbars=no, resizable=no, dependent, width=800, height=620, left=0, top=0')

                    }

                </script>

                <?php
                
                    // code to add new section
                
                        //echo '<tr><td><center>'.$c++.'</center></td><td><center>'."Verbal Aptitude".'</center></td><td><center>'."15".'</center></td><td><center>'."10 minutes".'</center></td><td><center><b><a href="account2.php" class="btn sub1" style="color:white;margin:0px;background:#ea5e0d;pointer-events:none"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></center></td></tr>';                    
    
                    echo '</table></div></div>';
                
                ?>


            </div>
        </div>
    </div>

</body>

</html>
