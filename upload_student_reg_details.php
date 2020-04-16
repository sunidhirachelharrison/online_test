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


	//$conn = mysqli_connect("localhost","root","test","phpsamples");
	require_once('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
	require_once('spreadsheet-reader-master/SpreadsheetReader.php');


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Questions</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        .aa {
            background: #ea5e0d;
            color: white;
        }

        .aa:hover {
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
        <a class="navbar-brand" href="index.php">Center for Training, Learning & Development</a></nav>
    <div class="container mt-2 mb-5">

        <form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Upload Student Registration Details</h1>
            <div style="background:#e9ecef" class="p-4 ">
                <label>Choose Excel File:</label>
                <input type="file" name="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import" class="btn aa">Upload</button>
            </div>

        </form>

    </div>

    <div class="container mt-2 mb-5">

        <div class="table-responsive mt-3" id="div_to_print">

            <table border="1" class="table table-bordered table-hover" id="result_table">

                <?php
                
            if (isset($_POST["import"]))
{
       
  //$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
    $path=$_FILES['file']['name'];
    $ext=pathinfo($path,PATHINFO_EXTENSION);
    
    if($ext=="xls"|| $ext=="xlsx"){
    
//  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            $count=0;       //counter to skip reading first row of column names in excel sheet
                    
            
            foreach ($Reader as $Row)
            {
                
                $count++;
                if($count==1 && $i==0)      //read only first sheet of workbook i.e. $i==0
                {
                    echo '

                <tr>
                    <td>S.No.</td>
                    <td>Enrollment No.</td>
                    <td>Name</td>
                    <td>Program</td>
                    <td>Year</td>
                    <td>Section</td>
                    <td>Branch</td>
                    <td>Mobile No.</td>
                    <td>Email Id</td>
                </tr>

                ';
                    
                    continue;
                }
          
                $uid="";
                if(isset($Row[0])) {
                    $uid = mysqli_real_escape_string($con,$Row[0]);
                    //echo $sno;
                }
                
                $uenrollno = "";
                if(isset($Row[1])) {
                    $uenrollno = mysqli_real_escape_string($con,$Row[1]);
                    //echo $program_name;
                }
                
                $uname="";
                if(isset($Row[2])) {
                    $uname = mysqli_real_escape_string($con,$Row[2]);
                    //echo $sno;
                }
                
                $uprogram="";
                if(isset($Row[3])) {
                    $uprogram = mysqli_real_escape_string($con,$Row[3]);
                    //echo $sno;
                }
                
                $uyear="";
                if(isset($Row[4])) {
                    $uyear = mysqli_real_escape_string($con,$Row[4]);
                    //echo $sno;
                }
                
                $usection="";
                if(isset($Row[5])) {
                    $usection = mysqli_real_escape_string($con,$Row[5]);
                    if(!($usection=="A"||$usection=="B"||$usection=="C"||$usection=="D"||$usection=="E"||$usection=="F"))
                    {
                        $usection="";
                    }
                    //echo $sno;
                }
                
                $ubranch="";
                if(isset($Row[6])) {
                    $ubranch = mysqli_real_escape_string($con,$Row[6]);
                    //echo $sno;
                }
                
                $umobileno="";
                if(isset($Row[7])) {
                    $umobileno = mysqli_real_escape_string($con,$Row[7]);
                    //echo $sno;
                }
                
                $uemail="";
                if(isset($Row[8])) {
                    $uemail = mysqli_real_escape_string($con,$Row[8]);
                    //echo $sno;
                }
                
                $uimage="";
//                if(isset($Row[9])) {
//                    $uimage = mysqli_real_escape_string($con,$Row[9]);
//                    //echo $sno;
//                }
                
                
                //setting password= enrollment no for each student 
                $upassword="";
                $upassword=password_hash($uenrollno, PASSWORD_ARGON2I); 
//                if(isset($Row[10])) {
//                    $upassword = mysqli_real_escape_string($con,$Row[10]);
//                    //echo $sno;
//                }
                
                
                //setting reg dateusing current system date
                //$uregdate="";
                date_default_timezone_set('Asia/Kolkata');
                $uregdate = date('d-m-y');
                
                
//                if(isset($Row[11])) {
//                    $uregdate = mysqli_real_escape_string($con,$Row[11]);
//                    //echo $sno;
//                }
                
                //setting reg time using current system time
//                $uregtime="";
                $uregtime=date('h:i:s');
//                if(isset($Row[12])) {
//                    $uregtime = mysqli_real_escape_string($con,$Row[12]);
//                    //echo $sno;
//                }
                
                ?>


                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $uenrollno; ?></td>
                    <td><?php echo $uname; ?></td>
                    <td><?php echo $uprogram; ?></td>
                    <td><?php echo $uyear; ?></td>
                    <td><?php echo $usection; ?></td>
                    <td><?php echo $ubranch; ?></td>
                    <td><?php echo $umobileno; ?></td>
                    <td><?php echo $uemail; ?></td>
                </tr>


                <?php
                
                
                
                if (!empty($uid)) {
                    $query = "insert into user(U_ID,U_User_Type,U_Enrollment_No,U_Name,U_Program,U_Year,U_Section,U_Branch,U_Mobile_No,U_Email_ID,U_Image,U_Password,U_Registration_Date,U_Registration_Time) values(null,'student','".$uenrollno."','".$uname."','".$uprogram."', '".$uyear."','".$usection."','".$ubranch."','".$umobileno."','".$uemail."','','".$upassword."','".$uregdate."','".$uregtime."')";
                    $result = mysqli_query($con, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                           // echo $message;
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                         //   echo $message;
                    }
                }
                
             }
            
        
         }
        
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
      echo $message;
  }
}
 
                
                
        ?>


            </table>
        </div>
    </div>


</body>

</html>
