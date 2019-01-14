<?php

        //connect to db "host" "user" "password" "database"
        $link = mysqli_connect("", "", "", "");
        
        //check for error in connection
        if (mysqli_connect_error()){


            die ("There was an error connecting to the database");
        
         }
?>