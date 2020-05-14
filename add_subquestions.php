<?php  

    include("DB_connect.php");
    session_start();
    
    $sql="SELECT * FROM passage";
    $r=mysqli_query($con,$sql);
    if(!($r))
    {
        echo '<script>alert("Failed to fetch the passage descriptions!");</script>';
    }
    else
    {
            
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Add Sub Questions</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Font Awesome Offline -->
    <link rel="stylesheet" href="Font-Awesome-4.7/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        .bg-orange {
            background: #ea5e0d;
        }

    </style>

</head>

<body>

    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Admin Panel - Add Sub Questions</a></nav>
    <div class="container mt-2 mb-3">

        <form method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <!-- <h1>Add Sub-Questions</h1> -->

            <div class="row">
                <div class="col-sm-8 p-4">
                    <h4>Add a new Question to the passage</h4><br>
                    <div class="row">
                        <div class="col-3">
                            Passage Description:
                        </div>
                        <div class="col-9">
                            <select name="p_desc" id="p_desc" class="form-control">
                                <?php
                                        $name="";
                                        while($row=mysqli_fetch_assoc($r))
                                        {
                                        $desc=$row['P_Description'];
                                        // $d=$result['T_Date'];
                                    ?>
                                <option value="<?php echo $row['P_ID']; ?>"><?php echo $row['P_Description']; ?></option>
                                <?php  } ?>
                            </select>
                            <?php
                                }
                                ?>
                        </div>
                    </div>
                    <input type="button" class="btn bg-orange text-white mt-3" name="add" value="ADD QUESTION" id="add" onclick="add_fields()" />
                    <div id="fields">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
  
    if(isset($_POST['submit']))
    {
        $question=mysqli_real_escape_string($con,$_POST['question']);
        $optionA=mysqli_real_escape_string($con,$_POST['optionA']);
        $optionB=mysqli_real_escape_string($con,$_POST['optionB']);
        $optionC=mysqli_real_escape_string($con,$_POST['optionC']);
        $optionD=mysqli_real_escape_string($con,$_POST['optionD']);
        $optionE=mysqli_real_escape_string($con,$_POST['optionE']);
        $answer=mysqli_real_escape_string($con,$_POST['answer']);
        $marks=mysqli_real_escape_string($con,$_POST['marks']);
        $pid=$_POST['p_desc'];
        $questionimage=basename($_FILES['question_image']['name']);
        $imageA=basename($_FILES['imageA']['name']);
        $imageB=basename($_FILES['imageB']['name']);
        $imageC=basename($_FILES['imageC']['name']);
        $imageD=basename($_FILES['imageD']['name']);
        $imageE=basename($_FILES['imageE']['name']);
        $image_answer=basename($_FILES['image_answer']['name']);
        
        //upload question image
        if($questionimage!=null)
        {
            $target_dir="uploads/";
            $target_file=$target_dir.basename($_FILES['question_image']['name']);
            $uploadOk=1;
            $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
            if(move_uploaded_file($_FILES['question_image']['tmp_name'],$target_file))
            {
                //echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
            }
        }
        
        
        
        //upload imageA
        if($imageA!=null)
        {
            $target_dir="uploads/";
            $target_file=$target_dir.basename($_FILES['imageA']['name']);
            $uploadOk=1;
            $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
            if(move_uploaded_file($_FILES['imageA']['tmp_name'],$target_file))
            {
                //echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
            }
        }
        


        //upload imageB
        if($imageB!=null)
        {
            $target_dir="uploads/";
            $target_file=$target_dir.basename($_FILES['imageB']['name']);
            $uploadOk=1;
            $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
            if(move_uploaded_file($_FILES['imageB']['tmp_name'],$target_file))
            {
                //echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
            }
        }
        

        //upload imageC
        if($imageC!=null)
        {
            $target_dir="uploads/";
            $target_file=$target_dir.basename($_FILES['imageC']['name']);
            $uploadOk=1;
            $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
            if(move_uploaded_file($_FILES['imageC']['tmp_name'],$target_file))
            {
                //echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
            }
        }
        

        //upload imageD
        if($imageD!=null)
        {
            $target_dir="uploads/";
            $target_file=$target_dir.basename($_FILES['imageD']['name']);
            $uploadOk=1;
            $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
            if(move_uploaded_file($_FILES['imageD']['tmp_name'],$target_file))
            {
                //echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
            }
        }
        

        //upload imageE
        if($imageE!=null)
        {
            $target_dir="uploads/";
            $target_file=$target_dir.basename($_FILES['imageE']['name']);
            $uploadOk=1;
            $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
            if(move_uploaded_file($_FILES['imageE']['tmp_name'],$target_file))
            {
                //echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
            }
        }
        
        //upload answer image
        if($image_answer!=null)
        {
            $target_dir="uploads/";
            $target_file=$target_dir.basename($_FILES['image_answer']['name']);
            $uploadOk=1;
            $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
            if(move_uploaded_file($_FILES['image_answer']['tmp_name'],$target_file))
            {
                //echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
            }
        }
        
        $q="INSERT into passage_questions(PQ_ID,PQ_AssociatedPassage_ID,PQ_Description,PQ_Image,PQ_Option_A,PQ_Image_A,PQ_Option_B,PQ_Image_B,PQ_Option_C,PQ_Image_C,PQ_Option_D,PQ_Image_D,PQ_Option_E,PQ_Image_E,PQ_Answer,PQ_Answer_Image,PQ_Alloted_Marks) VALUES(null,'".$pid."','".$question."','".$questionimage."','".$optionA."','".$imageA."','".$optionB."','".$imageB."','".$optionC."','".$imageC."','".$optionD."','".$imageD."','".$optionE."','".$imageE."','".$answer."','".$image_answer."','".$marks."')";
        
        $re=mysqli_query($con,$q);
        if(!($re))
        {
            echo '<script>alert("Failed to add the question!);</script>';
        }
        else
        {
            echo '<script>alert("Question added successfully!);</script>';
        }
        
    }
    
?>
    <footer class="mt-5">
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>
</body>

</html>
<script>
    function add_fields() {
        //var count = document.getElementById("field_count");
        var d = document.getElementById("fields");

        //document.getElementById("add").disable=true;

        d.innerHTML += "<br />Question: <input type='text' class='form-control' name='question' required/><br/>Image associated with question(if any): <input type='file' class='form-control' name='question_image'/><br/>Option A: <input type='text' class='form-control' name='optionA' required/>Image with option A(if any): <input type='file' class='form-control' name='imageA'/><br/>Option B: <input type='text' class='form-control' name='optionB' required/>Image with option B(if any): <input type='file' class='form-control' name='imageB'/><br/>Option C: <input type='text' class='form-control' name='optionC' required />&nbsp;Image with option C(if any): <input type='file' class='form-control' name='imageC'/><br/>Option D: <input type='text' class='form-control' name='optionD' required/>&nbsp;Image with option D(if any): <input type='file' class='form-control' name='imageD'/><br/>Option E: <input type='text' class='form-control' name='optionE' />&nbsp;Image with option E(if any): <input type='file' class='form-control' name='imageE'/><br/>Answer: <input type='text' class='form-control' name='answer' />&nbsp;Image with answer(if any): <input type='file' class='form-control' name='image_answer'/><br/>Marks Alloted: <input type='number' class='form-control' name='marks' /><br/><br/><input type='submit' name='submit' class='btn bg-orange text-white' value='DONE'/>";

        document.getElementById("add").disabled = true;

    }

</script>
