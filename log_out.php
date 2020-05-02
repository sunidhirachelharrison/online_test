<?php  
        session_start();
        include("DB_connect.php");

        //delete record from state table
        $q="DELETE from state WHERE S_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
        $r=mysqli_query($con,$q);


        session_destroy();
        header("location:index.php");
    
?>
