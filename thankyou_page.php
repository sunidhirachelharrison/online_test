 <?php
    
    //Starting a new session
    session_start();

    //including file for database connection
    include("DB_connect.php");


    if(!(isset($_SESSION['U_Enrollment_No'])))
    {
        header("location:index.php");
    }


    $j=0;
    $correct=0;
    $incorrect=0;
    $total_marks=0;
    $obtained_marks=0;

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
                //fetch correct answer of selected question
                $row=mysqli_fetch_assoc($a);
                $ans=$row['Q_Answer'];
                $marks=$row['Q_Alloted_Marks'];
                if($ans===$marked_answers[$j])
                {
                    $total_marks = $total_marks + $marks;
                    $obtained_marks = $obtained_marks + $marks;
                    $correct++;
                    
                    //if answer is correct, update the score of that question in result table
                    $sql1="UPDATE result SET R_Score_Quantitative='".$marks."' WHERE R_Enrollment_No='".$_SESSION['U_Enrollment_No']."' AND R_Q_ID='".$id."' ";
                    $res1=mysqli_query($con,$sql1);
                    if(!($res1))
                    {
                        echo '<script>alert("Failed to update the score of this question!");</script>';
                    }
                    else
                    {
                       //score successfully updated in result table for specific question 
                    }
                }
                else
                {
                    $total_marks = $total_marks + $marks;
                    $incorrect++;
                }
            }
            $j++;
        }
            
    }


    //result from passage_result table
    $j2=0;
    $correct2=0;
    $incorrect2=0;
    $total_marks2=0;
    $obtained_marks2=0;
    
    $q2="SELECT * FROM passage_result WHERE PR_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
    $r2=mysqli_query($con,$q2);
    if(!($r2))
    {
        echo '<script>alert("Failed to fetch the result of passage this user!");</script>';
    }
    else
    {
        //echo '<script>alert("Success!");</script>';
        $q_ids2=array();
        $marked_answers2=array();
        $i2=0;
        while($result2=mysqli_fetch_assoc($r2))
        {
            $q_ids2[$i]=$result2['PR_PQ_ID'];
            $marked_answers2[$i2]=$result2['PR_Marked_Answer'];
            $i2++;
        }
        //counter for marked answer array = $j2
        $j2=0;
        foreach( $q_ids2 as $id2 )
        {
            //select record from question table with matching qid
            $qry2="SELECT * FROM passage_questions WHERE PQ_ID='".$id2."'";
            $a2=mysqli_query($con,$qry2);
            if(!($a2))
            {
                echo '<script>alert("Failed to fetch the question with matching Question ID");</script>';
            }
            else
            {
                //fetch correct answer of selected question
                $row2=mysqli_fetch_assoc($a2);
                $ans2=$row2['PQ_Answer'];
                $marks2=$row2['PQ_Alloted_Marks'];
                if($ans2===$marked_answers2[$j2])
                {
                    $total_marks2 = $total_marks2 + $marks2;
                    $obtained_marks2 = $obtained_marks2 + $marks2;
                    $correct2++;
                    
                    //if answer is correct, update the score of that passage_question in passage_result table
                    $sql2="UPDATE passage_result SET PR_Score='".$marks2."' WHERE PR_Enrollment_No='".$_SESSION['U_Enrollment_No']."' AND PR_PQ_ID='".$id2."' ";
                    $res2=mysqli_query($con,$sql2);
                    if(!($res2))
                    {
                        echo '<script>alert("Failed to update the score of this passage question!");</script>';
                    }
                    else
                    {
                       //score successfully updated in passage_result table for specific question 
                    }
                    
                }
                else
                {
                    $total_marks2 = $total_marks2 + $marks2;
                    $incorrect2++;
                }
            }
            $j2++;
        }
        
    
        
        
        
    }

//    $marks = $obtained_marks + $obtained_marks2;
// $tot_marks = $total_marks + $total_marks2;
// $correct_q = $correct + $correct2;
// $incorrect_q = $incorrect + $incorrect2;
//
// $sql="INSERT into result_record() VALUES()";

    //closing the connection
    mysqli_close($con);

?>

 <!--******************  HTML CODE ***********************************-->
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">

     <title>Thank You</title>

     <!-- Required meta tags -->
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Bootstrap CSS -->
     <!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/loginstyle.css">

     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <style>
         .lform {
             width: 600px;
             height: 300px;
             margin-top: 20px;
         }

         .btn {

             color: #fff;
             background: #ea5e0d;
             border: 1px solid #ea5e0d;

         }

         .btn:hover {
             color: #ea5e0d;
             background: #fff;
             border: 1px solid #ea5e0d;
         }

     </style>

 </head>

 <body>

     <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
         <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
     </div>

     <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
         <a class="navbar-brand" href="index.php">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
             <span class="navbar-toggler-icon"></span>
         </button>

     </nav>

     <div class="login-container d-flex align-items-center justify-content-center">
         <form method="POST" action="#" class="login-form text-center lform">
             <h1 class="mb-4 font-weight-light text-uppercase"><b>Thank You!!</b></h1>
             <h3>For Taking the Test!!</h3>
             <h3>We hope you were able to perform as per your expectations.</h3>
             <br>

             <input type="button" name="Logout" class="btn btn-primary " onclick="window.location = 'log_out.php'" value="Log Out">


         </form>


     </div>

     <!-- Optional JavaScript -->
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <!--
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    -->


 </body>

 </html>
