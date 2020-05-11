<?php
    
    //starting the session
    session_start();
    
    //getting the qid and counter value passed from ajax call
    $q = intval($_GET['x']);
    header("location:$q");

?>

