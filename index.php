<?php

    //starting a new session
    session_start();
    $_SESSION['answer']=array();
    $_SESSION['U_Enrollment_No']="";    //saving current user's Enrollment No in session

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="image/tmu.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>| Online Test (CTLD) |</title>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <style type="text/css">
        body {
            width: 100%;
            background: url(image/book.png);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .intro,
        footer {
            color: white;
        }

        .btn {
            margin-top: 4%;
            display: inline-block;
            padding: 15px 30px;
            border: 2px solid #fff;
            text-transform: uppercase;
            letter-spacing: 0.015em;
            font-size: 18px;
            font-weight: 600;
            line-height: 1;
            color: #fff;
            background: #ea5e0d;

        }

        .btn:hover {
            color: #ea5e0d;
            background: #fff;
        }

        h1 {
            color: #fff;
            text-transform: uppercase;
            font-size: 70px;
            font-weight: 700;
            letter-spacing: 0.015em;
        }

        h1::after {
            content: '';
            width: 300px;
            display: block;
            background: #fff;
            height: 6px;
            margin: 30px auto;
            line-height: 1.1;
        }

        .goodluck {
            color: #fff;
            margin-bottom: 4%;
            margin-top: 50px;
        }

        .bg-dark1 {
            background-color: #343a40 !important;
        }

    </style>

</head>

<body>

    <div class="jumbotron text-left" style="margin-bottom:0; padding: 1rem 1rem;">

        <!--       TMU logo         -->
        <img src="image/logo_uni.png" class="img-fluid" width="300" alt="tmu logo" />
    </div>

    <!--       Nav Bar         -->
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="index.php">Online Assessment - Faculty of Engineering & Computing Sciences (FOE & CS)</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

    </nav>
    <center>
        <div class="intro pt-5">
            <h1>Online Test (CTLD)</h1>
            <a href="Log_in.php" class="btn"> login </a> &emsp;
            <a href="Registration.php" class="btn"> register </a>
            <h2 class="goodluck"> Good &nbsp;Luck. </h2>
        </div>
    </center>

    <!--     Footer Text      -->
    <footer>
        <div class="text-center">
            <p>Copyright &copy; Teerthanker Mahaveer University</p>
        </div>
    </footer>

</body>

</html>
