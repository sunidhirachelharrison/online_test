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


//select test details
    $fetch_tid="SELECT * FROM test WHERE T_Flag='0'";        
    $flag_tid=mysqli_query($con,$fetch_tid);

    $tid="";
    $tmarks="";
    $tmins="";
    $thours="";
    $totques="";
    if($flag_tid)
    {
        $result3=mysqli_fetch_assoc($flag_tid);
        $tid=$result3['T_ID'];
        $thours=$result3['T_Hours'];
        $tmins=$result3['T_Minutes'];
        $tmarks=$result3['T_Marks'];
        $totques=$result3['T_Questions'];
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
                    <tr><td><center><b>S.No.</b></center></td><td><center><b>Section</b></center></td><td><center><b>Total questions</b></center></td><td><center><b>Total marks</b></center></td><td><center><b>Total Time</center></b></td><td><center><b>Action</b></center></td></tr>';
                    $c=1;

				echo '<tr>
				    <td>
				        <center>'.$c++.'</center>
				    </td>
				    <td>
				        <center>'."Online Assessment".'</center>
				    </td>
				    <td>
				        <center>'.$totques.'</center>
				    </td>
                    <td>
				        <center>'.$tmarks.'</center>
				    </td>
				    <td>
				        <center>'.$thours.' hour '.$tmins.' minutes '.'</center>
				    </td>
				    <td>
				        <center><b><a href="t1.php" onclick="popitup(this.href);return false;" class="btn sub1" style="color:white;margin:0px;background:#ea5e0d;><span class=" glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start New Test</b></span></a></b>&nbsp;<b><a href="resume_test.php" onclick="popitup(this.href);return false;" class="btn sub1" style="color:white;margin:0px;background:#ea5e0d;><span class=" glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Resume Test</b></span></a></b></center>
				    </td>
				</tr>';
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
