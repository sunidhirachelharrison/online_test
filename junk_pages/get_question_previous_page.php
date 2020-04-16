<!DOCTYPE html>
<html>
<head>
    
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, td, th {
        border: 1px solid black;
        padding: 5px;
    }

    th {text-align: left;}
    </style>
    
    <!--  For using jquery   -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
</head>
<body>

<?php
    
    //starting the session
    session_start();
    
    //getting the qid and counter value passed from ajax call
    $q = intval($_GET['q']);
    $counter = @$_GET['c'];
    $marked_answer=@$_GET['marked_value'];
    
    //for database connection
    include("DB_connect.php");
    
    //fetch a question from db with specified id
    $sql="SELECT * FROM questions WHERE Q_ID='".$q."' AND Q_Flag='0'";
    $result = mysqli_query($con,$sql);
    if(!($result))
    {
        echo '<script>alert("Operation failed!");</script>';
    }
    else
    {
        $answers=array();   //array to store options and shuffle them

       $row = mysqli_fetch_array($result); 
        if($row['Q_Passage_ID']==null)
        {

            //echo "" . $row['Q_ID'] . ")  ";
            //echo "" . $row['Q_Description'] . "<br/>";

            $answers=array("{$row['Q_Option_A']}","{$row['Q_Option_B']}","{$row['Q_Option_C']}","{$row['Q_Option_D']}","{$row['Q_Option_E']}");

            $images=array("{$row['Q_Option_A']}"=>"{$row['Q_ImageA']}","{$row['Q_Option_B']}"=>"{$row['Q_ImageB']}","{$row['Q_Option_C']}"=>"{$row['Q_ImageC']}","{$row['Q_Option_D']}"=>"{$row['Q_ImageD']}","{$row['Q_Option_E']}"=>"{$row['Q_ImageE']}");


        //}
        shuffle($answers);
        echo "<b>" . $counter . ")&nbsp </b> ";
        echo "<b>" . $row['Q_Description'] . "</b><br/></br>";
        if($row['Q_ImageQuestion']!='')
        {
           echo "<b><img src='uploads/{$row['Q_ImageQuestion']}'>  </b><br/></br>"; 
        }

        $a=$answers[0];  //storing options names to refer in images array as index
        $b=$answers[1];
        $c=$answers[2];
        $d=$answers[3];
        $e=$answers[4];
?>


<input type="text" id="div_of_qid" value="<?php echo $row['Q_ID']; ?>" hidden>
<input type="text" id="enrno" value="<?php echo $_SESSION['U_Enrollment_No']; ?>" hidden>

<!--<fieldset id="options" name="options">-->
               
                <input type="radio" id="A" name="options" onclick = "SaveOption()" value="<?php echo $answers[0]; ?>" /><?php echo $answers[0]."<br/>";
                if($images[$a]!='')
                {
                    echo "<img src='uploads/{$images["$a"]}'><br/><br/>";
                }
        
            ?>
                    
                <input type="radio" id="B" name="options" onclick = "SaveOption()" value="<?php echo $answers[1]; ?>" /><?php echo $answers[1] ."<br/>";
                if($images[$b]!='')
                {
                    echo "<img src='uploads/{$images["$b"]}'><br/><br/>";
                }
                   
            ?>
    
                <input type="radio" id="C" name="options" onclick = "SaveOption()" value="<?php echo $answers[2]; ?>" /><?php echo $answers[2] ."<br/>";
                if($images[$c]!='')
                {
                   echo "<img src='uploads/{$images["$c"]}'><br/><br/>";
                }
                   
            ?> 
                    
                <input type="radio" id="D" name="options" onclick = "SaveOption()" value="<?php echo $answers[3]; ?>" /><?php echo $answers[3] ."<br/>";
                if($images[$d]!='')
                {
                  echo "<img src='uploads/{$images["$d"]}'><br/><br/>";
                }
                   
            ?>
                    
                <input type="radio" id="E" name="options" onclick = "SaveOption()" value="<?php echo $answers[4]; ?>" /><?php echo $answers[4] ."<br/>";
                if($images[$e]!='')
                {
                  echo "<img src='uploads/{$images["$e"]}'><br/><br/>";
                }
                   
            ?>
                    
                
<!--            </fieldset>-->
<?php     
        }
        else
        {
            //************************************************************
            
            $query="SELECT * FROM passage WHERE P_Passage_ID='".$row['Q_Passage_ID']."'";
            
            $a=mysqli_query($con,$query);
            if(!($a))
            {
                echo '<script>alert("Failed to fetch the passage");</script>';
            }
            else
            {
                   $x=0;        //counter to show the passage only once  
                    $n=array();
                    $j=0;
                while($rw=mysqli_fetch_assoc($a))
                {
                    $x++;   
                    if($x==1)
                    {
                        $n[$j]=$rw['P_ID'];
                                               
                        echo "<b>" . $counter . ")&nbsp </b> ";
                        echo "<b>" . $rw['P_Description'] . "</b><br/></br/>";
                        if($rw['P_PointA']!=null){
                            echo "<b>" . $rw['P_PointA'] . "</b><br/></br/>";
                        }
                        if($rw['P_PointB']!=null){
                            echo "<b>" . $rw['P_PointB'] . "</b><br/></br/>";
                        }
                        if($rw['P_PointC']!=null){
                            echo "<b>" . $rw['P_PointC'] . "</b><br/></br/>";
                        }
                        if($rw['P_PointD']!=null){
                            echo "<b>" . $rw['P_PointD'] . "</b><br/></br/>";
                        }
                        if($rw['P_PointE']!=null){
                            echo "<b>" . $rw['P_PointE'] . "</b><br/></br/>";
                        }
                        if($rw['P_Image']!=null){
                            echo "<b><img src='uploads/{$rw['P_Image']}'>  </b><br/></br>";
                        }
                    }
                    
                    if($rw['P_Q_Description']!=null){
                        echo "<b>" . $rw['P_Q_Description'] . "</b><br/></br/>";
                    }
                    if($rw['P_Q_Image']!=null){
                        echo "<b><img src='uploads/{$rw['P_Q_Image']}'>  </b><br/></br>";
                    }
                    
                    ?>
                    
<!--            <input type="text" id="<?php //echo $rw['P_ID']; ?>" value="<?php// echo $rw['P_ID']; ?>" hidden>-->

                   <script>
                         var m = <?php echo json_encode($i); ?>;
                    </script>
                    
                    <input type="radio" id="A" name="options" onclick = "SavePassageResult(<?php echo $n[$j]; ?>)" value="<?php echo $rw['P_Option_A']; ?>" /><?php echo $rw['P_Option_A'] ."<br/>";
                    if($rw['P_Image_A']!=null)
                    {
                      echo "<img src='uploads/{$rw['P_Image_A']}'><br/><br/>";
                    }
                    ?>
                    
                    <input type="radio" id="B" name="options" onclick = "SavePassageResult(<?php echo $n[$j]; ?>)" value="<?php echo $rw['P_Option_B']; ?>" /><?php echo $rw['P_Option_B'] ."<br/>";
                    if($rw['P_Image_B']!=null)
                    {
                      echo "<img src='uploads/{$rw['P_Image_B']}'><br/><br/>";
                    }
                    
                    ?>
                    
                    <input type="radio" id="C" name="options" onclick = "SavePassageResult(<?php echo $n[$j]; ?>)" value="<?php echo $rw['P_Option_C']; ?>" /><?php echo $rw['P_Option_C'] ."<br/>";
                    if($rw['P_Image_C']!=null)
                    {
                      echo "<img src='uploads/{$rw['P_Image_C']}'><br/><br/>";
                    }
                    
                    ?>
                    
                    <input type="radio" id="D" name="options" onclick = "SavePassageResult(<?php echo $n[$j]; ?>)" value="<?php echo $rw['P_Option_D']; ?>" /><?php echo $rw['P_Option_D'] ."<br/>";
                    if($rw['P_Image_D']!=null)
                    {
                      echo "<img src='uploads/{$rw['P_Image_D']}'><br/><br/>";
                    }
                    
                    ?>
                    
                    <input type="radio" id="E" name="options" onclick = "SavePassageResult(<?php echo $n[$j]; ?>)" value="<?php echo $rw['P_Option_E']; ?>" /><?php echo $rw['P_Option_E'] ."<br/>";
                    if($rw['P_Image_E']!=null)
                    {
                      echo "<img src='uploads/{$rw['P_Image_E']}'><br/><br/>";
                    }
                    $j++;
                    echo "<br/><br/>";
                }
        ?>
                
                    <input type="text" id="enrno" value="<?php echo $_SESSION['U_Enrollment_No']; ?>" hidden>
                
          <?php   }
            
            
            
        //******************************************************
            
        }
    }
    

mysqli_close($con);
?>
</body>
</html>

