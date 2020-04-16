<?php

    include("DB_connect.php");
    session_start();
    
    $q="SELECT * FROM result WHERE R_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
    
    $r=mysqli_query($con,$q);
    if(!($r))
    {
        echo '<script>alert("Failed to fetch the result of this user!");</script>';
    }
    else
    {
        //echo '<script>alert("Success!");</script>';
        $q_ids=array();
        $marked_answers=array();
        $i=0;
        while($result=mysqli_fetch_assoc($r))
        {
            $q_ids[$i]=$result['R_Q_ID'];
            $marked_answers[$i]=$result['R_Marked_Answer'];
            $i++;
        }
        //counter for marked answer array = $j
        $j=0;
        $correct=0;
        $incorrect=0;
        $total_marks=0;
        $obtained_marks=0;
        
                //fetch correct answer of selected question
                
        $no=0;
        
 
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
	<link rel="shortcut icon" href="images/tmu.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <title>view exam - CTLD</title>
	
	</head>
	<body>
	
	<div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
  		<img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
	</div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">Center for Teaching, Learning & Development</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
<br/>
<div class="container-fluid">

	<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">Correct</div>
			<div class="card-body">

                <?php
                
                    foreach( $q_ids as $id )
                    {
                        //select record from question table with matching qid
                        $qry="SELECT * FROM questions WHERE Q_ID='".$id."'";
                        $a=mysqli_query($con,$qry);
                        if(!($a))
                        {
                            echo '<script>alert("Failed to fetch the question with matching Question ID");</script>';
                        }     
                        else
                        {   
                ?>
					
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					
                        <?php 
                            
        
                                    $row=mysqli_fetch_assoc($a);
                                    $question=$row['Q_Description'];
                                    $correct_answer=$row['Q_Answer']; 
                                    if($marked_answers[$j]===$correct_answer)
                                    {
                                        $no++;
                                        
                
                    ?>
                        
						<td><?php echo $no . ").  " . $question . "<br/>"; ?></td>
						<tr style="background:#00FF00;"><th><?php echo "Correct Answer: ". $correct_answer. "<br/>"; } ?></th></tr>

					<?php    }  $j++; }?>
					
				</table>
			</div>
				</div>
				<?php  }  ?>
			
		</div>
		<br/>
        </div>
	<div class="col-6">
	<div class="card">
			<div class="card-header">Incorrect</div>
			<div class="card-body">
			<?php  include("answers_incorrect.php"); ?>
<!--				<div id="">-->
					
<!--			<div class="table-responsive">-->
<!--				<table class="table table-bordered table-hover">-->
				
				
<!--				</table>-->
<!--			</div>-->
					
<!--				</div>-->
			</div>
		</div>
	</div>
</div>

<footer class="mt-2">
		<div class="text-center">
			<p>Copyright &copy; Teerthanker Mahaveer University</p>
		</div>
	</footer>

  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
<!--
   <script>
        
        document.getElementById('incorrect').style.background="red";
        </script>
-->
    </body>
</html>

