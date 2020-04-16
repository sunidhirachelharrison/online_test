<!DOCTYPE html>
<html>

<head>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        td,
        th {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            text-align: left;
        }

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

    <input type="radio" id="A" name="options" onclick="SaveOption()" value="<?php echo $answers[0]; ?>" /><?php echo $answers[0]."<br/>";
                if($images[$a]!='')
                {
                    echo "<img src='uploads/{$images["$a"]}'><br/><br/>";
                }
        
            ?>

    <input type="radio" id="B" name="options" onclick="SaveOption()" value="<?php echo $answers[1]; ?>" /><?php echo $answers[1] ."<br/>";
                if($images[$b]!='')
                {
                    echo "<img src='uploads/{$images["$b"]}'><br/><br/>";
                }
                   
            ?>

    <input type="radio" id="C" name="options" onclick="SaveOption()" value="<?php echo $answers[2]; ?>" /><?php echo $answers[2] ."<br/>";
                if($images[$c]!='')
                {
                   echo "<img src='uploads/{$images["$c"]}'><br/><br/>";
                }
                   
            ?>

    <input type="radio" id="D" name="options" onclick="SaveOption()" value="<?php echo $answers[3]; ?>" /><?php echo $answers[3] ."<br/>";
                if($images[$d]!='')
                {
                  echo "<img src='uploads/{$images["$d"]}'><br/><br/>";
                }
                   
            ?>

    <input type="radio" id="E" name="options" onclick="SaveOption()" value="<?php echo $answers[4]; ?>" /><?php echo $answers[4] ."<br/>";
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
            
            $query="SELECT * FROM passage p join passage_questions q WHERE p.P_ID='".$row['Q_Passage_ID']."' AND q.PQ_AssociatedPassage_ID=p.P_ID";
            
            $a=mysqli_query($con,$query);
            if(!($a))
            {
                echo '<script>alert("Failed to fetch the passage");</script>';
            }
            else
            {
                $cou=0;
                while($rw=mysqli_fetch_assoc($a))
                {
                    $cou++;
                    if($cou==1) //display passage once only
                    {
                        echo "<b>" .$counter . ") " . $rw['P_Description'] ."<br/>";
                        echo "<ul><li>" . $rw['P_SubpointA'] . "</li>";
                        echo "<li>" . $rw['P_SubpointB'] . "</li>";
                        echo "<li>" . $rw['P_SubpointC'] . "</li>";
                        echo "<li>" . $rw['P_SubpointD'] . "</li>";
                        echo "<li>" . $rw['P_SubpointE'] . "</li></b><br/>";
                        
                        if($rw['P_Image']!=null)
                        {
                          echo "<img src='uploads/{$rw['P_Image']}'><br/><br/>";
                        }
                        
                    }
                    
                    //display each question of passage
                    echo $cou . ") " . $rw['PQ_Description'] ."<br/>";
                    if($rw['PQ_Image']!=null) //image with question
                        {
                          echo "<img src='uploads/{$rw['PQ_Image']}'><br/><br/>";
                        }
                    
                    ?>

    <input type="radio" id="A" name="<?php echo $rw['PQ_ID']; ?>" onclick="SavePassageResult(this.name,<?php echo $cou; ?>)" value="<?php echo $rw['PQ_Option_A']; ?>" /><?php echo $rw['PQ_Option_A'] ."<br/>";
                    if($rw['PQ_Image_A']!=null)
                    {
                      echo "<img src='uploads/{$rw['PQ_Image_A']}'><br/><br/>";
                    }
                    ?>

    <input type="radio" id="B" name="<?php echo $rw['PQ_ID']; ?>" onclick="SavePassageResult(this.name,<?php echo $cou; ?>)" value="<?php echo $rw['PQ_Option_B']; ?>" /><?php echo $rw['PQ_Option_B'] ."<br/>";
                    if($rw['PQ_Image_B']!=null)
                    {
                      echo "<img src='uploads/{$rw['PQ_Image_B']}'><br/><br/>";
                    }
                    
                    ?>

    <input type="radio" id="C" name="<?php echo $rw['PQ_ID']; ?>" onclick="SavePassageResult(this.name,<?php echo $cou; ?>)" value="<?php echo $rw['PQ_Option_C']; ?>" /><?php echo $rw['PQ_Option_C'] ."<br/>";
                    if($rw['PQ_Image_C']!=null)
                    {
                      echo "<img src='uploads/{$rw['PQ_Image_C']}'><br/><br/>";
                    }
                    
                    ?>

    <input type="radio" id="D" name="<?php echo $rw['PQ_ID']; ?>" onclick="SavePassageResult(this.name,<?php echo $cou; ?>)" value="<?php echo $rw['PQ_Option_D']; ?>" /><?php echo $rw['PQ_Option_D'] ."<br/>";
                    if($rw['PQ_Image_D']!=null)
                    {
                      echo "<img src='uploads/{$rw['PQ_Image_D']}'><br/><br/>";
                    }
                    
                    ?>

    <input type="radio" id="E" name="<?php echo $rw['PQ_ID']; ?>" onclick="SavePassageResult(this.name,<?php echo $cou; ?>)" value="<?php echo $rw['PQ_Option_E']; ?>" /><?php echo $rw['PQ_Option_E'] ."<br/>";
                    if($rw['PQ_Image_E']!=null)
                    {
                      echo "<img src='uploads/{$rw['PQ_Image_E']}'><br/><br/>";
                    }

                     echo '<br/><br/>';   
                        
                }
            }

        }
    }
    
            
            
            
        //******************************************************
            
        
    

mysqli_close($con);
?>

    <script>
        //if (window.localStorage.getItem('myAnswers' + window.counter) == )
        //var radios = document.getElementsByName('options');
        //var x="radio_marked"+window.counter;
        //alert(x);

        // if (localStorage.getItem('myAnswers' + counter) != null) {
        // var l = localStorage.getItem('myAnswers' + counter);
        // //document.getElementById('A').checked = true;
        // alert(localStorage.getItem('myAnswers' + counter));
        // var radios = document.getElementsByName('options');
        // for (var i = 0, length = radios.length; i < length;) { // //alert(radios[i].value); // var p=radios[i].value; // if (p==l) { // //radios[i].checked=true; // //document.getElementById('A').checked=true; // //alert(localStorage.getItem('myAnswers' + counter)); // //alert(radios[i].value); // alert("well done"); // break; // } else { // alert("false"); // } // i++; // } // } else { // alert("hello"); // }

        //  var countr = <?php //echo json_encode($counter-1); ?>;
        //    if (localStorage.getItem('myAnswers' + countr) != null) {
        // var l = localStorage.getItem('myAnswers' + counter);
        // // //document.getElementById('A').checked = true;
        // // alert(localStorage.getItem('myAnswers' + counter));
        // // var radios = document.getElementsByName('options');
        // for (var i = 0, length = radios.length; i < length;) { // alert(radios[i].value); // //var p=radios[i].value; // //if (p==l) { // //radios[i].checked=true; // //document.getElementById('A').checked=true; 
        //  alert(localStorage.getItem('myAnswers' + counter)); // //alert(radios[i].value); // alert("well done"); // break; // } else { // alert("false"); // } // i++; // } // } else { // alert("hello"); // //alert(localStorage.getItem('myAnswers' + counter)); 
        //   alert(countr); // // break; // // } // } 
        //}

    </script>

</body>

</html>
