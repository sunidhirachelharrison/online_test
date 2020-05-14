<?php
    
    include("DB_connect.php");
    if(isset($_POST['radio1']))
    {
        $marked_answer = $_POST['radio1'];
        $qid = $_POST['qid'];
        $c_id = $_POST['c_id'];
        $enrno = $_POST['reid'];
//        $t_id=$_POST['tid'];
    
        //select the current test details
        $sql="SELECT * FROM test WHERE T_Flag='0'";
        $re=mysqli_query($con,$sql);
        $row1=mysqli_fetch_assoc($re);
        $time=date("h:i:sa");
        $shift="";
        if(($row1['T_Time_ShiftA'] < $time) && ($time < $row1['T_Time_ShiftB']))
        {
            $shift="A";
        }
        else if(($row1['T_Time_ShiftB'] < $time) && ($time < $row1['T_Time_ShiftC']))
        {
            $shift="B";
        }
        else
        {
            $shift="C";
        }
        
        
        $q1="SELECT * FROM result WHERE R_Q_ID='".$qid."' AND R_Enrollment_No='".$enrno."' AND R_C_ID='".$c_id."' AND R_T_ID='".$row1['T_ID']."'";
        $row=mysqli_query($con,$q1);
        $c=mysqli_num_rows($row);
        if($c>0)
        {
            $q="UPDATE result SET R_Marked_Answer='".$marked_answer."' WHERE R_Q_ID='".$qid."' AND R_Enrollment_No='".$enrno."' AND R_C_ID='".$c_id."' AND R_T_ID='".$row1['T_ID']."'";
        }
        else
        {
            $q="INSERT into result(R_ID,R_Enrollment_No,R_Q_ID,R_Marked_Answer,R_Score_Quantitative,R_T_ID,R_Shift,R_C_ID) VALUES (null,'".$enrno."','".$qid."','".$marked_answer."',0,'".$row1['T_ID']."','".$shift."','".$c_id."')";
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
