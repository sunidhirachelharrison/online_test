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
	
            
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Searching</title>
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
		<a class="navbar-brand" href="index.php">Center for Teaching, Learning & Development</a></nav>

    <form action="#" method="post">
        <div class="container mt-3 mb-5">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Search</h1>
                    
                    h
                    <label for ="select"><b>Select :</b></label><br/>
                        <input type="radio" name="chooseone" value="U_Program"><label for="Program" checked> Program</label>&nbsp;&nbsp; 
                        <input type="checkbox" name="section" >Section:
<!--                        <input type="text" name="section_value"><br/>-->
                        <select name="section_dd" >
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select><br/>
                        
                    <input type="radio" name="chooseone" value="U_Enrollment_No"><label for="Enrollmentno"> Enrollment No </label><br> 
<!--                    <input type="radio" name="chooseone" value="Section">-->
                       
<!--                    <label for="Section"> Section</label><br> -->
                    <input type="radio" name="chooseone" value="U_Branch"><label for="Branch">Branch</label><br>
<!--                    <input type="radio" name="chooseone" value="U_Semester"><label for="  Semester"> Semester</label><br>-->
                    <input type="radio" name="chooseone" value="U_Year"><label for="Year"> Year</label><br>
<!--                    <input type="radio" name="chooseone" value="Date"><label for="Date"> Date</label><br>-->
                    <input type="radio" name="chooseone" value="T_Name"><label for="CTType"> CT Type</label><br>
                    
                     <label for="value"><b>Value :</b></label>
                    <input type="text" class="form-control" placeholder=" " name="value" required/><br/>                 
                    

                   <input type="submit" class="btn aa " name="submit" value="SHOW"/>
                    
                                
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
                </div>   
                            
            </div>
        </div>                        
    </form>
    <?php
    if(isset($_POST['submit']))
    {
            
        $selected_radio=$_POST['chooseone'];
        $value=$_POST['value'];
        //$section=$_POST['section'];
       
        
        //$query1="SELECT * FROM user u,result r WHERE u.".$selected_radio."like '%".$value."%' AND u.U_Enrollment_No=r.R_Enrollment_No";
        
        $query1="SELECT * FROM user  WHERE ".$selected_radio." like '%".$value."%' ";
        
        
        $query2="";
        //if($selected_radio!="T_Name")
        //{
            $r=mysqli_query($con,$query1);
            if(!($r))
            {
                echo '<script type="text/javascript">alert("Failed to fetch user details");</script>';
            }
            else
            {
                ?>
                <div class="container">
                    
                
    <div style="background:#e9ecef"  class="p-4 mb-5 mt-2" >  
    <table border="2" id="search_result_table">
                   
                   <th>
                       
                       <td>Enrollment No.</td>
                       <td>Name</td>
                       <td>Program</td>
                       <td>Section</td>
                       <td>Branch</td>
                       <td>Year</td>
<!--
                       <td>Quantitative Aptitude Marks</td>                   
                       <td>Verbal Aptitude Marks</td>                   
-->
<!--                       <td>Total Marks</td>                       -->
                    </th>
                    
                    <?php
                
        
                    while($row=mysqli_fetch_assoc($r))
                    {
                        
                        echo "<tr><td></td><td>{$row['U_Enrollment_No']}</td><td>{$row['U_Name']}</td><td>{$row['U_Program']}</td><td>{$row['U_Section']}</td><td>{$row['U_Branch']}</td><td>{$row['U_Year']}</td></tr>";
                        
                    }
                
                    }
        //}
    }


                    
                    ?>
                    
                </table>
    </div>
                
</body>
</html>