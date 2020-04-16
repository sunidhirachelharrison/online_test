 <?php
    
    //Starting a new session
    session_start();

    //including file for database connection
    include("DB_connect.php");

//***********************************************************************

    //if remember checkbox is checked, store enrollment no and password in cookies
    if(isset($_POST['remember']))
    {
        
        $current_time = time();     //get time from the server
        $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  // for 1 month
        
        $username=$_POST['enrollment_no'];
        $password=$_POST['password'];
        
        //storing enrollment no and password in cookies
        setcookie('enrollment_no',$username,$cookie_expiration_time);
        setcookie('password',$password,$cookie_expiration_time);

    }
    else
    {
        
        $current_time = time();
        $cookie_expiration_time = $current_time - (30 * 24 * 60 * 60);
        setcookie('enrollment_no','',$cookie_expiration_time);
        setcookie('password','',$cookie_expiration_time);

    }

//***********************************************************************


    //if Log in button is clicked

    if(isset($_POST['login']))
    {
            
        $username=$_POST['enrollment_no'];
        $password=$_POST['password'];
        
        //fetching entered enrollment no from the db
        $query  =   "SELECT * FROM user WHERE U_Enrollment_No='".$username."'";
        
        $fetch_query=mysqli_query($con,$query);                             
        if (mysqli_num_rows($fetch_query)==1)
        {
              
            //fetching password of associated enrollment no
            $r = mysqli_fetch_assoc($fetch_query); 
            $table_hashed_pwd=$r['U_Password'];
            
            //checking if entered password matches the actual password
            if (password_verify($password, $table_hashed_pwd)) 
            {
                $_SESSION['U_Enrollment_No']=$username;     //storing enrollment no in session
                $_SESSION['U_ID']=$r['U_ID'];     //storing user ID in session
                
                $_SESSION['U_Name']=$r['U_Name'];
//                $_SESSION['status']="logged_in";
//                $_SESSION['ucategory']=$r['U_Type'];
//                $_SESSION['pid']=$r['U_Prog_ID'];
//                $_SESSION['contactno']=$r['U_ContactNo'];
//                $_SESSION['enrno']=$r['U_EnrollmentNo'];
//                $_SESSION['course']=$r['U_CourseName'];
//                $_SESSION['rno']=$r['U_ReceiptNo'];
                
                //if enrollment no and password matches, login is successful
                
                $msg="Valid Credentials! Login Successful!";
                if($r['U_User_Type']=="admin")
                {
                    $_SESSION['U_User_Type']=$username;     //storing user type in session
                    echo "<script type='text/javascript'> alert('$msg');
                window.location.href='dashboard.php';
                </script>";
                    
                }
                else
                {
                    echo "<script type='text/javascript'> alert('$msg');
                window.location.href='Instructions.php';
                </script>"; 
                }
                
                
                echo "Welcome! ". $_SESSION['U_Enrollment_No'] ."<br/>";
                
                
        }
        else
        {
            //if password does not match
            echo '<script type="text/javascript"> alert("Invalid Credentials! Please try again");
                window.location.href="Log_in.php";
                </script>';
        }
    }
        else
        {
            //if user with current enrollment no is not registered
            echo '<script type="text/javascript"> alert("Please enter a valid Enrollment No.");
                window.location.href="Log_in.php";
                </script>';
        }
    }

//closing the connection
mysqli_close($con);

?>

 <!--******************  HTML CODE ***********************************-->
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">

     <title>Log in</title>

     <!-- Required meta tags -->
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Bootstrap CSS -->
     <!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/loginstyle.css">

     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>

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

     <div class="login-container d-flex align-items-center justify-content-center">
         <form method="POST" action="#" class="login-form text-center">
             <h1 class="mb-5 font-weight-light text-uppercase">Log in</h1>

             <div class="form-group">
                 <input type="text" class="form-control rounded-pill form-control-lg" placeholder="Enter Enrollment No./Employee ID" name="enrollment_no" value="<?php  if(isset($_COOKIE['enrollment_no']))
                {
                    //showing enrollment no if cookies are set
                    echo $_COOKIE['enrollment_no'];
    
                }  ?>" required>

             </div>

             <div class="form-group">
                 <input type="password" class="form-control rounded-pill form-control-lg" placeholder="Enter Password" name="password" value="<?php  if(isset($_COOKIE['password']))
                            {
                                //showing password  if cookies are set
                                echo $_COOKIE['password'];
    
                            }  ?>" required>
             </div>

             <div class="forget-link">
                 <div class="form-check">
                     <input type="checkbox" name="remember" class="form-check-input" id="remember">
                     <label for="remember">Remember Me&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                     <a href="Forgot_pwd_form.php">Forget Password?</a>
                 </div>
             </div>

             <button type="Login" name="login" class="btn mt-5 btn-custom btn-block text-uppercase rounded-pill">Login</button>

             <button type="button" class="btn mt-3 btn-custom btn-block text-uppercase rounded-pill" name="cancel" onClick="window.location = 'index.php'">CANCEL</button>

             <p>Don't have an account <a href="Registration.php"><strong>Register Now!</strong></a>


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
