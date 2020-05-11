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
	

	$query1="SELECT * FROM questions WHERE Q_Description is not null";
	$query2="SELECT * FROM passage";
	$r1=mysqli_query($con,$query1);
	$r2=mysqli_query($con,$query2);
//	$ar_pid=array();
//	$ar_pdesc=array();
//	$j=0;
//	if($r2)
//	{
		
//	}
	
	//fetch and store passage_ids and passag_description in arrays
	if(!($r1))
	{
		echo '<script>alert("Failed to fetch the questions!");</script>';
	}
	else
	{
	  
        $counter=0;
		


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Select Questions for Test/Exam</title>
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
        <a class="navbar-brand" href="index.php">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)</a></nav>

    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Set questions for test/exam:</h1>

            <div class="row">
                <div class="col-sm-12 p-4" style="background:#e9ecef">
                    <!--                    <h4>Add Passage</h4><br/> -->
                    <h3>Select short questions:</h3>
                    <?php 
    
                        while($row1=mysqli_fetch_assoc($r1))
                        {
                            $counter++;
                            
                        
        
                    ?>

                    <p>
                        <input type="checkbox" value="<?php echo $row1['Q_ID']; ?>" id="<?php echo $row1['Q_ID']; ?>" class="form-controls p-2" name="<?php echo $counter; ?>" /><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $counter . ")  " . $row1['Q_Description'] . "<br/>"; 
                        
                        
                        ?>
                    </p>


                    <?php 
                     //  }
                        }
        
                    ?>

                    <h3>Select long questions:</h3>
                    <?php 
    
                        while($row2=mysqli_fetch_assoc($r2))
                        {
                            
                            $counter++;
                           
                        
        
                    ?>


                    <p>
                        <input type="checkbox" value="<?php echo $row2['P_ID']; ?>" id="<?php echo $row2['P_ID']; ?>" class="form-controls p-2" name="<?php echo $counter; ?>" /><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" . $counter . ")  " . $row2['P_Description'] . "<br/>"; 
                        
                        
                        ?>
                    </p>


                    <?php 
                     //  }
                        }
        
                    ?>



                    <?php
        
                    }

                    ?>


                    <input type="submit" class="btn aa mt-3" name="done" id="done" value="DONE" />

                    <button type="button" class="btn aa mt-3" name="cancel" onClick="window.location = 'dashboard.php'">CANCEL</button>

                </div>

            </div>

        </form>

    </div>

</body>

</html>


<?php

if(isset($_POST['done']))
{
    
    //set Q_Flag of all questions to null
    $q1="UPDATE questions SET Q_Flag=null";
    $re1=mysqli_query($con,$q1);
    if(!($re1))
    {
        echo '<script>alert("error in unsetting the questions!");</script>';
    }
    else
    {
        //
    }
    
    
    //set P_Flag of all passages to null
    $qry1="UPDATE passage SET P_Flag=null";
    $res1=mysqli_query($con,$qry1);
    if(!($res1))
    {
        echo '<script>alert("error in unsetting the passages!");</script>';
    }
    else
    {
        //
    }
    
    
    
    
    $x=0;
    $y=0;
    for($i=1;$i<=$counter;$i++) 
    { 
        //$check_val = $_POST[$i] ? 1 : 0;
        if(isset($_POST[$i]))
        { 

            //set Q_Flag to 0 in questions table
            //echo '<script>alert('.$_POST[$i].');</script>';
            
            $q2="UPDATE questions SET Q_Flag='0' WHERE Q_ID='".$_POST[$i]."' or Q_Passage_ID='".$_POST[$i]."'";
            $re2=mysqli_query($con,$q2);
            if(!($re2))
            {
                echo '<script>alert("Failed to set the questions!");</script>';
                $x=0;
                break;
            }
            else
            {
                //echo '<script>alert("Questions have been set successfully!");</script>';
                $x=1;
            }
            
            
            ////set P_Flag to 0 in passage table
            //echo '<script>alert('.$_POST[$i].');</script>';
            
            $q3="UPDATE passage SET P_Flag='0' WHERE P_ID='".$_POST[$i]."'";
            $re3=mysqli_query($con,$q3);
            if(!($re3))
            {
                echo '<script>alert("Failed to set the questions!");</script>';
                $y=0;
                break;
            }
            else
            {
                //echo '<script>alert("Questions have been set successfully!");</script>';
                $y=1;
            }

        } 
        
    }
    if(($x==1)&&($y==1))
    {
        echo '<script>alert("Questions have been set successfully!");</script>';
    }
}



?>
