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
	
	
   //  echo "Welcome!  " . $_SESSION['User'] . "<br/>";

    $q="SELECT * FROM user WHERE U_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
    $result=mysqli_query($con,$q);
    $r=mysqli_fetch_assoc($result);
    if(!($r))
   {   
        echo '<script>alert("Failed to fetch the details!");</script>';
    }
else{
    

        //$_SESSION['uid']=$r['U_ID'];
        //echo $_SESSION['uid'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View/Update Details</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <style>
        .aa{
            background: #ea5e0d;
            color: white;
        }
        .aa:hover{
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

   
<form action="#" method="post">
    
    <div class="container mt-2 mb-5">
       <h1>Update Details</h1>
        <div class="row">
            <div class="col-sm-10 p-4" style="background:#e9ecef">

                
                <label for="enrollmentno"><b>Enrollment No:</b></label>
                <input type="text" class="form-control" name="enrollmentno" value="<?php  echo $r['U_Enrollment_No'];  ?>" /><br/>
                
                <label for="name"><b>Full Name.:</b></label>
                <input type="text" class="form-control" name="name" value="<?php  echo $r['U_Name'];  ?>" /><br/>
                
                <label for="program"><b>Program:</b></label>
                <input type="text" class="form-control" name="program" value="<?php  echo $r['U_Program'];  ?>" /><br/>
                
                <label for="year"><b>year:</b></label>
                <input type="text" class="form-control" name="year" value="<?php  echo $r['U_Year'];  ?>"/><br/>

                <label for="section"><b>Section :</b></label>
                <input type="text" class="form-control" name="section" value="<?php  echo $r['U_Section'];  ?>" /><br/>

                <label for="branch"><b>Branch :</b></label>
                <input type="text" class="form-control" name="branch" value="<?php  echo $r['U_Branch'];  ?>" /><br/>

<!--
                <label for="session"><b>Session :</b></label>
                <input type="text" class="form-control" name="session" value="<?php  //echo $r['U_Session'];  ?>" /><br/>
-->

                <label for="mobile_no"><b>Mobile No :</b></label>
                <input type="tel" class="form-control" name="mobile_no" value="<?php  echo $r['U_Mobile_No'];  ?>" /><br/>
                
                <label for="email_ID"><b>Email ID :</b></label>
                <input type="email" class="form-control" name="email_ID" value="<?php  echo $r['U_Email_ID'];  ?>" /><br/>
                
<!--
                <label for="image_old"><b>Image :</b></label>
                <input type="text" class="form-control" name="image_old" value="<?php  //echo $r['U_Image'];  ?>" /><br/>
                
-->
<!--
                <label for="password_old"><b>Password :</b></label>
                <input type="text" class="form-control" name="password_old" value="<?php  //echo $r['U_Password'];  ?>" disabled/><br/>
-->
                
                <label for="reg_date"><b>Registration Date :</b></label>
                <input type="text" class="form-control" name="reg_date" value="<?php  echo $r['U_Registration_Date'];  ?>" disabled/><br/>
                
                <label for="reg_time"><b>Registration Time :</b></label>
                <input type="text" class="form-control" name="reg_time" value="<?php  echo $r['U_Registration_Time'];  ?>" disabled/><br/>
                <?php
                        }
                ?>
                
                <input type="submit" class="btn aa" name="update" value="UPDATE DETAILS"/>
                <button type="button" class="btn aa" name="cancel" onClick="window.location = 'dashboard.php'" >CANCEL</button>
                
            </div>
                
                
<!--
                <script>
                    $(document).ready(function() { 
                         $("#s1").change(function(){ if($("#s1").val()=="faculty"){
                             $("#f1").prop("disabled",false);
                             $("#f2").prop("disabled",true);
                             $("#f3").prop("disabled",true);
                         }
                        else if($("#s1").val()=="participant")
                            {
                                $("#f1").prop("disabled",true);
                                 $("#f2").prop("disabled",false);
                                 $("#f3").prop("disabled",false);
                            }
                        else if($("#s1").val()=="volunteer")
                            {
                                $("#f1").prop("disabled",true);
                                 $("#f2").prop("disabled",false);
                                 $("#f3").prop("disabled",false);
                            }
                        else
                            {
                                $("#f1").prop("disabled",true);
                                 $("#f2").prop("disabled",true);
                                 $("#f3").prop("disabled",true);
                            }
                        });

                    });
                </script>
                
-->
                
                <?php

                    //include("DB_connect.php");
                    if(isset($_POST['update'])){

                        $enrollmentno=$_POST['enrollmentno'];
                        $name=$_POST['name'];
                        $program=$_POST['program'];
                        $year=$_POST['year'];
                        $section=$_POST['section'];
                        $branch=$_POST['branch'];
                        //$session=$_POST['session'];
                        $mobileno=$_POST['mobile_no'];
                        $emailid=$_POST['email_ID'];
                        //$image=$_POST['image'];
                        //$password=$_POST['password'];
                        //$hashed_pwd=password_hash($password, PASSWORD_ARGON2I); 
                        //$regdate=$_POST['reg_date'];
                        //$regtime=$_POST['reg_time'];
                        
                            $sql="UPDATE user SET   U_Enrollment_No='".$enrollmentno."',U_Name='".$name."', U_Program='".$program."', U_Year='".$year."', U_Section='".$section."', U_Branch='".$branch."',U_Mobile_No='".$mobileno."' ,U_Email_ID='".$emailid."' WHERE U_Enrollment_No='".$_SESSION['U_Enrollment_No']."'";
                        
                        
                        
                        $check=mysqli_query($con,$sql);

                        if($check)
                        {
                            echo '<script>alert("Profile Updated Successfully!");</script>' . '<br/>';
                        }
                        else
                        {
                            echo '<script>alert("Profile updation failed!");</script>' . '<br/>';
                        }

                    }
                ?>
                
                
                

                    
        </div>
        
    </div>
</form>

</body>
</html>