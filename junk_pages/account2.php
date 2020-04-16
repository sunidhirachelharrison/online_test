<?php
    
    include("DB_connect.php");
    include("timer2.php");
      
    
        $sql="SELECT * FROM questions WHERE Q_Flag='0'";
        $row=mysqli_query($con,$sql);
        if(!($row))
        {
            echo '<script>alert("Error in fetching questions!");</script>';
        }
        else
        {
            $qu=array();
            $i=0;
            while($r=mysqli_fetch_assoc($row))
            {
                $qu[$i]=$r['Q_ID'];
                $i++;
            }
            //print_r($qu);
            shuffle($qu);
            //print_r($qu);
        }
                      

?>


<!DOCTYPE html">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>NETCAMP || TEST YOUR SKILL </title>
<link  rel="stylesheet" href="css1/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css1/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css1/main.css">
 <link  rel="stylesheet" href="css1/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>

 
  <script src="js1/bootstrap.min.js"  type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
 <!--alert message-->
<style>
	.aa{
		height: 75%;
	}
	.aa1{
		height: 75%;
	}
</style>
<script type="text/javascript">
        window.counter=0;
        var selected_qid = <?php echo json_encode($qu); ?>;
        showUser(selected_qid[counter]);
        
    //to show next question:increment the counter
        function increment()
        {
            
            counter=counter+1;
            if((counter==0)||(counter<5)) //replace 5 by 14 to fetch 15 questions
            {
                showUser(selected_qid[counter],counter);
                
            }
            else if(counter==5) //replace 5 by 14 to fetch 15 questions
            {
                //displays last question
                showUser(selected_qid[counter],counter);
                document.getElementById('submit').style.visibility = 'visible';
            }
            else
            {
                counter=counter-1;
                //alert("Reached the last question");
            }
        }
    //function to display the question
    function showUser(q_uid,counter)
    {
        if (q_uid == "") {
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
            xmlhttp.open("GET","getuser.php?q="+q_uid+"&c="+(window.counter+1),true);
            xmlhttp.send();
        }
    }
    
    //to show previous question: decrement the counter
    function show_previous()
    {
        counter=counter-1;
        
        if(counter>=0)
        {
            
            showUser(selected_qid[counter]);
            document.getElementById('submit').style.visibility = 'hidden';
        }
        else 
        {
            //alert("Reached first question!");
            document.getElementById('submit').style.visibility = 'hidden';
            counter=counter+1;
        }
        
    }
    
    
    function done()
        {
            localStorage.clear();
            
        }
    </script>

</head>
<body>
<div class="header">
<div class="row">
<div class="col-lg-6">
<span class="logo"><img src="images/tmu.png" width="11%"/></span></div>
<div class="col-md-4 col-md-offset-2">

</div>
</div></div>
<div class="bg">

<!--navigation menu-->
<nav class="navbar navbar-default title1">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><b>CTLD</b></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<!--
      <ul class="nav navbar-nav">
        <li><a href="account.php?q=1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home<span class="sr-only">(current)</span></a></li>
        <li><a href="account.php?q=2"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;History</a></li>
		<li><a href="account.php?q=3"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>&nbsp;Ranking</a></li></ul>
-->
      </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--navigation menu closed-->

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<nav class="navbar navbar-default title1">
				<div class="aa">
					<div id="txtHint"><b>Question and options will be listed here...</b></div>
    
                      <form action="result.php">

                       <input type="button" class="previous" id="previous" name="previous" value="PREVIOUS"  onclick="show_previous()">
                       
                        <input type="button" class="next" id="next" name="next" value="NEXT" onclick="increment()">

                        <button name="submit" id="submit" style="visibility:hidden" onclick="done();" class="btn btn-primary" >SUBMIT</button>

                    </form>
                    <br>
				</div>
			</nav>
		</div>
		<div class="col-md-4">
			<nav class="navbar navbar-default title1">
				<div class="aa1">
					</br>
					<div class="container-fluid">
						<div class="row">
						<div class="col"><button class="btn-primary">1</button></div>
						<div class="col"><button class="btn-primary">2</button></div>
						<div class="col"><button class="btn-primary">3</button></div>
						<div class="col"><button class="btn-primary">4</button></div>
						<div class="col"><button class="btn-primary">5</button></div>
						<div class="w-100"><button class="btn-primary">6</button></div>
					
						<div class="col"><button class="btn-primary">7</button></div>
						<div class="col"><button class="btn-primary">8</button></div>
						<div class="col"><button class="btn-primary">9</button></div>
						<div class="col"><button class="btn-primary">10</button></div>
						<div class="col"><button class="btn-primary">11</button></div>
						<div class="col"><button class="btn-primary">12</button></div>
						</div>
					</div>
				</div>
			</nav>
		</div>
	</div>
</div>


</div>
</body>
</html>
