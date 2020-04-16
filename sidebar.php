<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <title>| Admin Panel (CTLD) |</title>
	<style>
	.bg-dark1{background: #ea5e0d}
	</style>
  </head>
  <body>
   <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">
  		<img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
	</div>

    <nav class="navbar navbar-expand-sm bg-dark1 navbar-dark">
        <a class="navbar-brand" href="index.php">Admin Panel</a>
        
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">Logout</a>
        </li>    
      </ul>
    </div>
</nav>

   <div class="wrapper">
   	<nav id="sidebar">
   		<div class="sidebar-header">
   			<h2>Dashboard</h2>
   		</div>
   		
   		<ul class="list-unstyled components">
   			<li class="active">
   				 <a href="Update_profile_form.php">Edit Details</a>
   			</li>
   			<li>
   				<a href="#">Update Instructions</a>
   			</li>
   			<li>
   				 <a href="#">Update Questions</a>
   			</li>
   			<li>
   				<a href="view_attendance.php">Attendance</a>
   			</li>
   			<li>
   				<a href="#">View Result</a>
   			</li>
			<li>
   				<a href="#">Change Result</a>
   			</li>
			<li>
   				<a href="#">Change Profile Image</a>
   			</li>
			<li>
   				<a href="#">Searching</a>
   			</li>
			<li>
   				<a href="#">Import Instructions</a>
   			</li>
			<li>
   				<a href="#">Import Questions</a>
   			</li>
			<li>
   				<a href="#">Import Student Details</a>
   			</li>
   		</ul>
   		
   	</nav>
   	
   	<div class="container">
   		<nav class="navbar navbar-expand-lg navbar-light bg-light">
   		
   		<button type="button" id="sidebarCollapse" class="btn btn-info">
   			<i class="fa fa-align-justify"></i> <span>Check</span>
   		</button>

		</nav>
  	  	
   	</div>
   	
   </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <script>
	    $(document).ready(function(){
			$('#sidebarCollapse').on('click',function(){
				$('#sidebar').toggleClass('active');
			});
		});  
	</script>
    
  </body>
</html>