<script>
    localStorage.setItem('ar',"jkjn");
      // var myArray = [1,2,3,4,5,6];
//       //load saved array
//       if(window.localStorage["savedAnswers"] != null)
//            myArray = JSON.parse(window.localStorage["savedAnswers"]);
//        // modify array
//        myArray.push("radio1");
//        // re-save array
//        window.localStorage["savedAnswers"] = JSON.stringify(myArray);
//    document.write(myArray);
//    myArray.push("hello");
//    document.write(myArray);
    function f()
    {
        if(!(document.getElementById('a').checked))
            {
                document.getElementById('a').checked=true;
                //alert("hello");
            }
    }
    //alert(localStorage.getItem('ar'));
    
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <input type="radio" id="a">hello<br/>
    <input type="radio" id="b">hie<br/>
    <input type="button" onclick="f();" value="save">
</body>
</html>






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