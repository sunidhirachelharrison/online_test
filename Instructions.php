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


    //fetching instructions from the database
    $qry="SELECT * FROM instructions";
    $row=mysqli_query($con,$qry);
    if($row)
    {
        //declare and initialize a counter $sno for showing serial number of instructions
        $sno=1;
            
    
?>

<!-- ********************** HTML CODE ************************************ -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Instructions</title>

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

    <body>

        <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
            <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
        </div>

        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a class="navbar-brand" href="index.php">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)</a>
        </nav>


        <form action="sections_page.php" method="post">
            <div class="container mt-3">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Instructions</h1><br />
                        <div style="background:#e9ecef" class="p-5">
                            <p>
                                <b>Please read the instructions carefully
                                </b>
                            </p>

                            <table class="table table-light table-striped" border="1">


                                <!--  *******************************************************************  -->

                                <?php 

                                while($r=mysqli_fetch_assoc($row))
                                {  
                                    
                        ?>

                                <!-- displaying  each row of table    -->
                                <tr>

                                    <td>
                                        <?php
                                    
                                        //show serial no
                                        echo "&nbsp;".$sno .")&nbsp; "; 
                                    
                                    ?>
                                    </td>&nbsp;

                                    <td>
                                        <?php 
                                    
                                        //show instruction
                                        echo $r['I_Description']; $sno++;  
                                
                                    }
                                     
                                    ?>
                                    </td>

                                </tr>

                                <?php  
                                    }
                                ?>

                            </table>

                        </div>


                        <input type="submit" class="btn aa mt-4 mb-4" name="submit" value="NEXT" onClick="window.location = 'sections_page.php'" />



                    </div>
                </div>
            </div>
        </form>
    </body>

</html>
