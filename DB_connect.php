<?php

$server     =   "127.0.0.1";   //or use localhost
$username   =   "root";
$password    =   "";
$database   =   "online_test";

try{
    
    $con=mysqli_connect($server, $username, $password, $database);

    if($con)
    {
       //echo "Connection Successful!" . "<br/>";
    }
    
}
catch(Exception $e){
    echo " " . $e->getMessage();
}


?>