<?php

include("DB_connect.php");
session_start();

    if(isset($_POST['change_pwd']))
    {
        $qry="SELECT * FROM user WHERE U_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
        $r=mysqli_query($con,$qry);
        if($r)
        {
            $row=mysqli_fetch_assoc($r);
            $db_pwd=$row['U_Password'];
            $current_password=$_POST['current_password'];
            $new_password=$_POST['new_password'];
            $retype_new_password=$_POST['retype_new_password'];
            $a=password_verify($current_password,$db_pwd);
            if($a)
            {
                if($new_password===$retype_new_password)
                {
                    //$hash=password_hash();
                    $new_hash=password_hash($new_password, PASSWORD_ARGON2I); 
                    $query="UPDATE user SET U_Password='".$new_hash."' WHERE U_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
                    $result=mysqli_query($con,$query);
                    if($result)
                    {
                        echo '<script>alert("Password changed successfully");</script>';
                    }
                    else
                    {
                        echo '<script>alert("Failed to change the password!");</script>';
                    }
                }
                else
                {
                    echo '<script>alert("Please re-enter the same new password!");</script>';
                }
            }
            else
            {
                echo '<script>alert("The current password is not valid!");</script>';
            }
            
        }
        else
        {
            echo '<script>alert("Failed to fetch the current password!");</script>';
        }
        
    }
    
      
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/loginstyle.css">

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

    
    <form action="#" method="post">
        
        <div class="container">
           
            <br/><br/><center><h1>Change Password</h1><br/></center>
            
            <div class="row">
                
                <label for="current_password"><b>Current Password:</b></label>
                <input type="password" class="form-control" name="current_password"  required/><br/>
                
                <label for="new_password"><b>New Password:</b></label>
                <input type="password" class="form-control" name="new_password"  required/><br/>
                
                <label for="retype_new_password"><b>Retype New Password:</b></label>
                <input type="password" class="form-control" name="retype_new_password"  required/><br/><br/><br/>
                
                <input type="submit" class="btn btn-primary" name="change_pwd" value="CHANGE PASSWORD"/>
                
                <button type="button" class="btn btn-primary" name="cancel" onClick="window.location = 'dashboard.php'" >CANCEL</button>
                
            </div>
            
        </div>
        
    </form>
</body>
</html>

