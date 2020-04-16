<?php
    
    include("DB_connect.php");
    include("timer1.php");

   // if(isset($_POST['next']))
   // {
        
    
        $sql="SELECT Q_ID FROM questions WHERE Q_Flag='0'";
        $row=mysqli_query($con,$sql);
        if(!($row))
        {
            echo '<script>alert("Error in fetching questions!");</script>';
        }
        else
        {
            $id=array();
            $i=0;
            //$id_count=mysqli_num_rows($row);
            //for($i=0;$i<$id_count;$i++)
            while($r=mysqli_fetch_assoc($row))
            {
                $id[$i]=$r['Q_ID'];
                $i++;
            }
            //print_r($id);
           // $selected_qid=array_rand($id);
            //echo $selected_qid;
        }
   // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quantitative Aptitude</title>
    
    <script type="text/javascript">
        window.counter=0;
        //var selected_qid="<?php //echo $selected_qid  ?>";
        
           
        function increment()
        {
            //*************************************
//                var id=new Array(<?php //for($c=0;$c<array_keys($id);$c++)
//                                        {
//                                            echo '"'.$id.'"'; 
//                                        }  ?>);
//                document.write(""+id[2]);
            //**************************************
            
            counter=counter+1;
            if(counter<=3) //should be less than =to 35 for fetching 35 quest.
                {
                    var selected_qid=id[1];
                    showUser(counter);
                }
            else{
                //alert("Reached the last question");
                document.getElementById('submit').style.visibility = 'visible';
            }
        }
    function showUser(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            //var ty="Quantitative Aptitude";
            xmlhttp.open("GET","getuser.php?q="+str,true);
            xmlhttp.send();
        }
    }
    </script>
</head>
<body>

    <div id="txtHint"><b>Question and options will be listed here...</b></div>
    
      <form action="account2.php">
       
        <input type="button" class="next" id="next" name="next" value="NEXT" onclick="increment()">
        
        <button name="submit" id="submit" style="visibility:hidden" class="btn btn-primary" >SUBMIT</button>
        
    </form>
    <br>
            
</body>
</html>