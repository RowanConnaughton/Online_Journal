<?php

     session_start();

    
    //check for content
    if (array_key_exists("content", $_POST)) {
        
        //database connection
        include("connection.php");
        
        //Update journal field in database with contents
        $query = "UPDATE `users` SET `journal` = '".mysqli_real_escape_string($link, $_POST['content'])."' WHERE id = ".mysqli_real_escape_string($link, $_SESSION['id'])." ";
        
        //run query
        mysqli_query($link, $query);

       
        
    }

?>
Hi There

