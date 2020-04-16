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
        <a class="navbar-brand" href="index.php">Center for Teaching, Learning & Development</a></nav>
    <div class="container mt-2 mb-3">

        <form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Upload Questions</h1>
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
                
                
if (isset($_POST['import']))
{
       
  //$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
    $path=$_FILES['file']['name'];
    $ext=pathinfo($path,PATHINFO_EXTENSION);
    
    if($ext=="xls"|| $ext=="xlsx"){
    
  //if(in_array($_FILES["file"]["type"],$allowedFileType)){     //alternate condition; not working properly

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
                    <td>Question Description</td>
                    <td>Image(if any)</td>
                    <td>Option A</td>
                    <td>Image A(if any)</td>
                    <td>Option B</td>
                    <td>Image B(if any)</td>
                    <td>Option C</td>
                    <td>Image C(if any)</td>
                    <td>Option D</td>
                    <td>Image D(if any)</td>
                    <td>Option E</td>
                    <td>Image E(if any)</td>
                    <td>Answer</td>
                    <td>Answer Image(if any)</td>
                    <td>Alloted Marks</td>
                    <td>Level</td>
                    <td>Category</td>
                </tr>

                ';
                    
                    continue;
                }
          
                $qid="";
                if(isset($Row[0])) {
                    $qid = mysqli_real_escape_string($con,$Row[0]);
                    //echo $sno;
                }
                
                $qdescription = "";
                if(isset($Row[1])) {
                    $qdescription = mysqli_real_escape_string($con,$Row[1]);
                    //echo $program_name;
                }
                
                $qimage="";
                if(isset($Row[2])) {
                    $image = mysqli_real_escape_string($con,$Row[2]);
                    //echo $sno;
                }
                
                $optionA="";
                if(isset($Row[3])) {
                    $optionA = mysqli_real_escape_string($con,$Row[3]);
                    //echo $sno;
                }
                
                $imageA="";
                if(isset($Row[4])) {
                    $image = mysqli_real_escape_string($con,$Row[4]);
                    //echo $sno;
                }
                
                $optionB="";
                if(isset($Row[5])) {
                    $optionB = mysqli_real_escape_string($con,$Row[5]);
                    //echo $sno;
                }
                
                $imageB="";
                if(isset($Row[6])) {
                    $image = mysqli_real_escape_string($con,$Row[6]);
                    //echo $sno;
                }
                
                $optionC="";
                if(isset($Row[7])) {
                    $optionC = mysqli_real_escape_string($con,$Row[7]);
                    //echo $sno;
                }
                
                $imageC="";
                if(isset($Row[8])) {
                    $image = mysqli_real_escape_string($con,$Row[8]);
                    //echo $sno;
                }
                
                $optionD="";
                if(isset($Row[9])) {
                    $optionD = mysqli_real_escape_string($con,$Row[9]);
                    //echo $sno;
                }
                
                $imageD="";
                if(isset($Row[10])) {
                    $image = mysqli_real_escape_string($con,$Row[10]);
                    //echo $sno;
                }
                
                $optionE="";
                if(isset($Row[11])) {
                    $optionE = mysqli_real_escape_string($con,$Row[11]);
                    //echo $sno;
                }
                
                $imageE="";
                if(isset($Row[12])) {
                    $image = mysqli_real_escape_string($con,$Row[12]);
                    //echo $sno;
                }
                
                
                $answer="";
                if(isset($Row[13])) {
                    $answer = mysqli_real_escape_string($con,$Row[13]);
                    //echo $sno;
                }
                
                $image="";
                if(isset($Row[14])) {
                    $image = mysqli_real_escape_string($con,$Row[14]);
                    //echo $sno;
                }
                
                $allotedmarks="";
                if(isset($Row[15])) {
                    $allotedmarks = mysqli_real_escape_string($con,$Row[15]);
                    //echo $sno;
                }
                
                $level="";
                if(isset($Row[16])) {
                    $level = mysqli_real_escape_string($con,$Row[16]);
                    //echo $sno;
                }
                
                $type="";
                if(isset($Row[17])) {
                    $type = mysqli_real_escape_string($con,$Row[17]);
                    //echo $sno;
                }


               
            ?>
                <tr>
                    <td><?php echo $qid; ?></td>
                    <td><?php echo $qdescription; ?></td>
                    <td><?php echo $qimage; ?></td>
                    <td><?php echo $optionA; ?></td>
                    <td><?php echo $imageA; ?></td>
                    <td><?php echo $optionB; ?></td>
                    <td><?php echo $imageB; ?></td>
                    <td><?php echo $optionC; ?></td>
                    <td><?php echo $imageC; ?></td>
                    <td><?php echo $optionD; ?></td>
                    <td><?php echo $imageD; ?></td>
                    <td><?php echo $optionE; ?></td>
                    <td><?php echo $imageE; ?></td>
                    <td><?php echo $answer; ?></td>
                    <td><?php echo $image; ?></td>
                    <td><?php echo $allotedmarks; ?></td>
                    <td><?php echo $level; ?></td>
                    <td><?php echo $type; ?></td>
                </tr>



                <?php

        if(!(empty($qid))) {
            $query = "insert into questions(Q_ID,Q_Description,Q_ImageQuestion,Q_Option_A,Q_ImageA,Q_Option_B,Q_ImageB,Q_Option_C,Q_ImageC,Q_Option_D,Q_ImageD,Q_Option_E,Q_ImageE,Q_Answer,Q_ImageAnswer,Q_Alloted_Marks,Q_Level,Q_Type,Q_A_ID,Q_Passage_ID,Q_Flag) values(null,'".$qdescription."','".$qimage."','".$optionA."', '".$imageA."','".$optionB."','".$imageB."','".$optionC."','".$imageC."','".$optionD."','".$imageD."','".$optionE."','".$imageE."','".$answer."','".$image."','".$allotedmarks."','".$level."','".$type."','".$_SESSION['U_ID']."',null,'0')";
            $result = mysqli_query($con, $query);

            if (! empty($result)) {
                $type = "success";
                //$message = "Excel Data Imported into the Database";
                   //echo '<script>alert("Excel Data Imported into the Database");</script>';
            } else {
                $type = "error";
                echo '<script>alert("Failed to import data into the Database");</script>';
            }
        }
        
    }

     }


 }
    else
    {
    echo '<script>alert("Please select excel sheet only!");</script>';
    }
}
//else
//{ 
//$type = "error";
//$message = "Invalid File Type. Upload Excel File.";
//echo $message;
//}


    
    ?>

            </table>

        </div>


    </div>

</body>

</html>
