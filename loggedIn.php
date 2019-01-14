<?php
    //start session
    session_start();

   // $journalContent = "";
    //check for cookie
   if (array_key_exists("id", $_COOKIE) && $_COOKIE['id']) {
        
    $_SESSION['id'] = $_COOKIE['id'];
    
}


    //check for session 
    if(array_key_exists('id', $_SESSION)){

        

        //connect to data base
        include("connection.php");
        //query to select journal from data base
        $query = "SELECT journal FROM `users` WHERE id = ".mysqli_real_escape_string($link, $_SESSION['id'])." ";

        $row = mysqli_fetch_array(mysqli_query($link, $query));
        //set journal field = to journal content for display in text area
        $journalContent = $row['journal'];

    }else{
        //if not signed in return to index
        header("location: index.php");
    }


    include("header.php");
?>

<nav class="navbar navbar-light bg-light navbar-fixed-top">
  <a class="navbar-brand" href="#">Online Journal</a>
  
    <div class=" mr-sm-2" >
       
      <a href='index.php?logout=1'><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log Out</button></a>
     </div>
</nav>





    <div class="container" id="loggedInContainer">

    <textarea id="journal" class="form-control"><?php  echo $journalContent; ?></textarea>

    
    </div>


<?php

    include("footer.php");

?>