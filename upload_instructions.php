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
        .bg-orange{
            background: #ea5e0d;
        }
    </style>
</head>

<body>

    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Admin Panel - Upload Instructions</a></nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <span class="align-middle">Import:</span> 
                        <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                            <div class="p-3">
                                <label>Choose Excel File:</label>
                                <input type="file" name="file" accept=".xls,.xlsx">
                                <button type="submit" id="submit" name="import" class="btn bg-orange text-white">Upload</button>
                            </div>
                            </form>     
                    </div>
                </div>
            </div>
        </div>
    </div>




<!-- 
    <div class="container mt-2 mb-5">

        <form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Upload Instructions</h1>
            <div style="background:#e9ecef" class="p-4 ">
                <label>Choose Excel File:</label>
                <input type="file" name="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import" class="btn aa">Upload</button>
            </div>

        </form>

    </div> -->

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
                    <td>Description</td>
                </tr>

                ';
                    
                    continue;
                }
          
                $id="";
                if(isset($Row[0])) {
                    $id = mysqli_real_escape_string($con,$Row[0]);
                    //echo $sno;
                }
                
                $description = "";
                if(isset($Row[1])) {
                    $description = mysqli_real_escape_string($con,$Row[1]);
                    //echo $program_name;
                }            
                
                ?>

                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $description; ?></td>
                </tr>


                <?php
                
                if (!empty($id)) {
                    $query = "insert into instructions(I_ID,I_Description) values(null,'".$description."')";
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
      echo '<script>alert('.$message.');</script>';
  }
}
    
                
                
            ?>


            </table>
        </div>
    </div>



</body>

</html>
