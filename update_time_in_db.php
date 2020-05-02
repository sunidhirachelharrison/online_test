<?php
    
    include("DB_connect.php");
    if(isset($_POST['mins']))
    {
        $minutes = $_POST['mins'];
        $seconds = $_POST['secs'];
        $rollno = $_POST['rollno'];
        $t=$minutes ."+".$seconds;
        $q1="SELECT * FROM state WHERE S_Enrollment_No='".$rollno."'";
        $row=mysqli_query($con,$q1);
        $c=mysqli_num_rows($row);
        if($c>0)
        {
            $q="UPDATE state SET S_Timer_info='".$t."' WHERE S_Enrollment_No='".$rollno."'";
        }
        else
        {
            $q="INSERT INTO `state`(`S_ID`, `S_AttemptedQ_IDs`, `S_MarkedQ_IDs`, `S_AttemptedQ_count`, `S_MarkedQ_count`, `S_Timer_info`, `S_Enrollment_No`, `S_Displayed_Q_IDs`, `S_Button_Nos`) VALUES (,null,null,0,0,'".$t."','".$rollno."',null,null)";
            
//            $q="INSERT into state(PR_ID,PR_Enrollment_No,PR_PQ_ID,PR_Marked_Answer,PR_Score,PR_T_ID) VALUES (null,'".$enrno."','".$qid."','".$marked_answer."',0,1)";
        }
        
        //$marked_answer=$_POST['marked_answer'];
        
        $r=mysqli_query($con,$q);
        if(!($r))
        {
            echo '<script>alert("Failed to save data);</script>';
        }
        else
        {
            echo '<script>alert("Success to update timer info);</script>';
            
        }
        
    }


?>
