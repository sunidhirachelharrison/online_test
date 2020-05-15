<?php

    include("DB_connect.php");
    //session_start();
    
    $q="SELECT * FROM result WHERE R_Enrollment_No='".$ro."' AND R_T_ID='".$test_id."' AND R_C_ID='".$course_id."'";
    
//$q="SELECT * FROM result WHERE R_Enrollment_No='".$ro."'";
    

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



    <?php 
                            
        
                                    $row=mysqli_fetch_assoc($a);
                                    $question=$row['Q_Description'];
                                    $correct_answer=$row['Q_Answer']; 
                                    if($marked_answers[$j]!==$correct_answer)
                                    {
                                        $no++;

                    ?>

    <div class="table-responsive" id="div_to_print">
        <table class="table table-bordered table-hover">



            <tr>
                <td><?php echo "<b>".$no . ")</b>.  " . $question . "<br/>"; ?></td>
            </tr>
            <tr id="incorrect" style="background:#ff726f;">
                <td><?php echo "<b>Your Answer:</b> ". $marked_answers[$j]."<i class='fa fa-times float-right'></i>". "<br/>"; ?></td>
            </tr>
            <tr id="correct" style="background:lightgreen;">
                <td><?php echo "<b>Correct Answer:</b> ". $correct_answer."<i class='fa fa-check float-right'></i>". "<br/>"; } ?></td>
            </tr>

            <?php    }  $j++; }?>

        </table>
    </div>


    <?php  }  ?>


    <br />




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
