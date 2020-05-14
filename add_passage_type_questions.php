<?php

include("DB_connect.php");
session_start();

//$q="SELECT MAX(P_Passage_ID) as m FROM passage";
//$x=mysqli_query($con,$q);
//$val;
//if($x)
//{
//   $r=mysqli_fetch_array($x);
//    $val=$r['m'];
//    //echo $val;
//    $val=$val+1;
//    //echo $val;
//}

if(isset($_POST['submit']))
{
    $description=mysqli_real_escape_string($con,$_POST['description']);
    $subpointA=mysqli_real_escape_string($con,$_POST['subpointA']);
    $subpointB=mysqli_real_escape_string($con,$_POST['subpointB']);
    $subpointC=mysqli_real_escape_string($con,$_POST['subpointC']);
    $subpointD=mysqli_real_escape_string($con,$_POST['subpointD']);
    $subpointE=mysqli_real_escape_string($con,$_POST['subpointE']);
    $image=basename($_FILES['p_image']['name']);
    $marks=mysqli_real_escape_string($con,$_POST['marks']);
    $level=mysqli_real_escape_string($con,$_POST['level']);
    $type=mysqli_real_escape_string($con,$_POST['type']);
    $prog_name=mysqli_real_escape_string($con,$_POST['prog_name']);
    $course_code=mysqli_real_escape_string($con,$_POST['course_code']);
    
    $target_dir="uploads/";
    $target_file=$target_dir.basename($_FILES['p_image']['name']);
    $uploadOk=1;
    $imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
    if(move_uploaded_file($_FILES['p_image']['tmp_name'],$target_file))
    {
        //echo "the file ". basename($_FILES["imageUpload"]["name"]). " has been uploaded.";
    }
    
    $sql="INSERT into passage(P_ID,P_Description,P_SubpointA,P_SubpointB,P_SubpointC,P_SubpointD,P_SubpointE,P_Image,P_Marks,P_Level,P_Type,P_A_ID) VALUES(null,'".$description."','".$subpointA."','".$subpointB."','".$subpointC."','".$subpointD."','".$subpointE."','".$image."','".$marks."','".$level."','".$type."','".$_SESSION['U_ID']."')";
    
    $r=mysqli_query($con,$sql);
    if($r)
    {
        //finding program id and course id to be added in question table
        $fetch_pid="SELECT * FROM program WHERE Prog_Name='".$prog_name."'";
        $fetch_cid="SELECT * FROM course WHERE C_Code='".$course_code."'";
        $flag_pid=mysqli_query($con,$fetch_pid);
        $flag_cid=mysqli_query($con,$fetch_cid);
        $pid="";
        $cid="";
        if($flag_pid && $flag_cid)
        {
            $result1=mysqli_fetch_assoc($flag_pid);
            $result2=mysqli_fetch_assoc($flag_cid);
            $pid=$result1['Prog_ID'];
            $cid=$result2['C_ID'];
        }
        
        //add passage_id in questions table
        $q="SELECT * FROM passage WHERE P_Description='".$description."'";
        $re=mysqli_query($con,$q);
        $id="";
        $aid="";
        if($re)
        {
            $result=mysqli_fetch_assoc($re);
            $id=$result['P_ID'];
            $aid=$result['P_A_ID'];
        
        
        $query="INSERT into questions(Q_ID,Q_Description,Q_ImageQuestion,Q_Option_A,Q_ImageA,Q_Option_B,Q_ImageB,Q_Option_C,Q_ImageC,Q_Option_D,Q_ImageD,Q_Option_E,Q_ImageE,Q_Answer,Q_ImageAnswer,Q_Alloted_Marks,Q_Level,Q_Type,Q_A_ID,Q_Passage_ID,Q_Flag,Q_Prog_ID,Q_C_ID) VALUES(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,'".$marks."',null,null,'".$aid."','".$id."','0','".$pid."','".$cid."')";
        $x=mysqli_query($con,$query);
        if(!($x))
        {
            echo '<script type="text/javascript">alert("Failed to add passage ID to questions table!");</script>';
        }
        else
        {
            // passage id successfully added
        }
    }
        echo '<script type="text/javascript">alert("Passage Added Successfully!");</script>';
        header("location:add_subquestions.php");
        
    }
    else
    {
        echo '<script type="text/javascript">alert("Failed to add the passage!");</script>';
    }
    
}
                          
?>

<!DOCTYPE html>
<html lang="en">
<head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <link rel="shortcut icon" href="image/tmu.png">
    <title>Add Passage Type Questions</title>

    <!-- Bootstrap CSS -->  
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Font Awesome Offline -->
    <link rel="stylesheet" href="Font-Awesome-4.7/css/font-awesome.min.css">

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
        <a class="navbar-brand" href="#">Admin Panel - Add Passage Type Questions</a></nav>
    
        <div class="container">
                <!-- Page Coding Start -->
                <div class="" id="">
            <div class="modal-dialog modal-lg mt-4 mb-4">
                <form method="post" id="exam_form">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title">Add Passage</h4>
                            <a href="dashboard.php"><button type="button" class="btn btn-success float-right">Back</button></a>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-3">Question Description: <span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                    <input type="textarea" class="form-control" name="description" id="description" required />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <label class="col-md-3"><span class="">Sub-point A(if any):</span></label>
                                    <div class="col-md-7">
                                    <input type="textarea" class="form-control" name="subpointA" id="subpointA" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Sub-point B(if any): </label>
                                    <div class="col-md-7">
                                    <input type="textarea" class="form-control" name="subpointB" id="subpointB" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Sub-point C(if any):</label>
                                    <div class="col-md-7">
                                    <input type="textarea" class="form-control" name="subpointC" id="subpointC" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Sub-point D(if any):</label>
                                    <div class="col-md-7">
                                    <input type="textarea" class="form-control" name="subpointD" id="subpointD" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Sub-point E(if any):</label>
                                    <div class="col-md-7">
                                    <input type="textarea" class="form-control" name="subpointE" id="subpointE" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Image(if any):</label>
                                    <div class="col-md-7">
                                    <input type="file" name="p_image" id="p_image" class="form-control" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Marks Alloted:<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                    <input type="text" class="form-control" name="marks" id="marks" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Question Level:<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                    <input type="text" class="form-control" name="level" id="level" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Question Category:<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                    <input type="text" class="form-control" name="type" id="type" />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Program Name:<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                    <input type="text" class="form-control" name="prog_name" id="prog_name" required/>
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-1"></div>
                                    <label class="col-md-3">Course Code:<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                    <input type="text" class="form-control" name="course_code" id="course_code" required />
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <input type="submit" id="submit" name="submit" class="btn bg-orange text-white" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
        </div>


        </div>

        <footer class="mt-5">
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>

<!-- 
    
    <div class="container mt-2 mb-3">

        <form action="#" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <h1>Add Passage Type Question</h1>

            <div class="row">
                <div class="col-sm-6 p-4" style="background:#e9ecef">
                    <h4>Add Passage</h4><br />

                    <label for="description"><b>Question Description:</b></label>
                    <input type="textarea" class="form-control" name="description" id="description" required /><br />

                    <label for="subpointA"><b>Sub-point A(if any):</b></label>
                    <input type="textarea" class="form-control" name="subpointA" id="subpointA" /><br />

                    <label for="subpointB"><b>Sub-point B(if any):</b></label>
                    <input type="textarea" class="form-control" name="subpointB" id="subpointB" /><br />

                    <label for="subpointC"><b>Sub-point C(if any):</b></label>
                    <input type="textarea" class="form-control" name="subpointC" id="subpointC" /><br />

                    <label for="subpointD"><b>Sub-point D(if any):</b></label>
                    <input type="textarea" class="form-control" name="subpointD" id="subpointD" /><br />

                    <label for="subpointE"><b>Sub-point E(if any):</b></label>
                    <input type="textarea" class="form-control" name="subpointE" id="subpointE" /><br />

                    <label for="p_image"><b>Image(if any):</b></label>
                    <input type="file" name="p_image" id="p_image" class="form-control" />

                    <label for="marks"><b>Marks Alloted:</b></label>
                    <input type="text" class="form-control" name="marks" id="marks" /><br />

                    <label for="level"><b>Question Level:</b></label>
                    <input type="text" class="form-control" name="level" id="level" /><br />

                    <label for="type"><b>Question Category:</b></label>
                    <input type="text" class="form-control" name="type" id="type" /><br />

                    <label for="prog_name"><b>Program Name:</b></label>
                    <input type="text" class="form-control" name="prog_name" id="prog_name" required/><br  />

                    <label for="course_code"><b>Course Code:</b></label>
                    <input type="text" class="form-control" name="course_code" id="course_code" required /><br />

                    <input type="submit" class="btn btn-danger mt-3" name="submit" value="SUBMIT" id="submit" />

                </div> -->

                <!--
                <div class="col-sm-6 p-4" style="background:#e9ecef">
                    <h4>Add Sub Questions</h4>
                    
-->
                <!--
                    <label for="field_count"><b>Enter the number of sub-questions to be added:</b></label>
                    <input type="number" class="form-control" name="field_count" id="field_count" required/>&nbsp;
-->

                <!--
                    <input type="button" value="ADD A QUESTION" class="btn aa mt-2" name="add_q" id="add_q" onclick="add_fields()"><br/>
                    
                    
                    <div id="fields">
                        
                        
                    </div>
                    
                </div>
-->
<!-- 
            </div>

        </form>

    </div> -->

</body>

</html>
<script>
    //    function add_fields() {
    //    var count = document.getElementById("field_count");
    //    var d = document.getElementById("fields");
    //
    //   d.innerHTML += "<br />Question: <input type='text' class='form-control'/><br/>Option A: <input type='text' class='form-control' style='width:150px'/>Option B: <input type='text' class='form-control' style='width:150px'/>Image with option A(if any): <input type='file' class='form-control'/><br/>&nbsp;Image with option B(if any): <input type='file' class='form-control'/><br/>Option C: <input type='text' class='form-control' style='width:100px'/>&nbsp;Image with option C(if any): <input type='file' class='form-control'/><br/>Option D: <input type='text' class='form-control' style='width:100px'/>&nbsp;Image with option D(if any): <input type='file' class='form-control'/><br/>Option E: <input type='text' class='form-control' style='width:100px'/>&nbsp;Image with option E(if any): <input type='file' class='form-control'/><br/>";
    //}

</script>
