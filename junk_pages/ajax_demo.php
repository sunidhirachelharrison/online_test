<?php

    include("timer1.php");
    //session_start();
?>


<html>
<head>
<script>
function showUser(str) {
    //showUser.str=showUser.str+1;
    str=str+1;
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
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
</head>
<body>

<form>
<!--
<select name="users" id="users">
  <option value="">Select a question:</option>
  <option value="2">Question 2</option>
  <option value="3">Question 3</option>
  <option value="4">Question 4</option>
  </select>
-->
  
  <div id="users">
      <?php 
             static $i=0;
//        if(!($_SESSION['i']))
//        {
//            $_SESSION['i']=2;
//        }
//        else
//      {
//          
//      }
//      for($i=0;$i<50;$i++)
//      {
//          
//      }
      ?>
  </div>
  
<!--  <label ><b>Search By:</b></label><br/>-->
<!--
            <fieldset id="options" name="options">
               
                <input type="radio" id="A" name="options" value="<?php //echo $row['Q_Option_A']; ?>" checked/><?php //echo $row['Q_Option_A']; ?><br/>
                <input type="radio" id="B" name="options" value="<?php ////echo $row['Q_Option_B']; ?>" /><?php //echo $row['Q_Option_B']; ?><br/>
                <input type="radio" id="C" name="options" value="<?php //echo $row['Q_Option_C']; ?>" /><?php //echo $row['Q_Option_C']; ?><br/>
                <input type="radio" id="D" name="options" value="<?php //echo $row['Q_Option_D']; ?>" /><?php //echo $row['Q_Option_D']; ?><br/>
                //
            </fieldset>
-->
  
      <input type="button" name="next" value="NEXT" id="next" onclick="showUser(<?php echo $i++; ?>)">
  
</form>
<br>
<div id="txtHint"><b>Question info will be listed here...</b></div>

</body>
</html>