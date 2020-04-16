<?php
    
    include("DB_connect.php");
    if(isset($_POST['radio1']))
    {
        $marked_answer = $_POST['radio1'];
        $qid = $_POST['qid'];
        $enrno = $_POST['reid'];
    
        $q1="SELECT * FROM passage_result WHERE PR_PQ_ID='".$qid."' AND PR_Enrollment_No='".$enrno."'";
        $row=mysqli_query($con,$q1);
        $c=mysqli_num_rows($row);
        if($c>0)
        {
            $q="UPDATE passage_result SET PR_Marked_Answer='".$marked_answer."' WHERE PR_PQ_ID='".$qid."' AND PR_Enrollment_No='".$enrno."'";
        }
        else
        {
            $q="INSERT into passage_result(PR_ID,PR_Enrollment_No,PR_PQ_ID,PR_Marked_Answer,PR_Score,PR_T_ID) VALUES (null,'".$enrno."','".$qid."','".$marked_answer."',0,1)";
        }
        
        //$marked_answer=$_POST['marked_answer'];
        
        $r=mysqli_query($con,$q);
        if(!($r))
        {
            echo '<script>alert("Failed to save data);</script>';
        }
        else
        {
            echo '<script>alert("Success to save data);</script>';
            
        }
        
    }


?>