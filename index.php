<?php

        $error = "";

        session_start();


    //Logout remove session and cookie
        if(array_key_exists("logout", $_GET)){

            unset($_SESSION);
            //remove cookie
            setcookie('id', '', time() - 60 * 60);
            $_COOKIE['id'] = "";

            session_destroy();

            //check if logged in and redirect
        }else if ((array_key_exists('id', $_SESSION) AND $_SESSION['id']) OR (array_key_exists('id', $_COOKIE) AND $_COOKIE['id'])){

            //redirect to logged in page
            header("location: loggedIn.php");
        }

        
    if(array_key_exists("submit", $_POST)){

        include("connection.php");


       //check for errors. note( no email or password validation )

        if(!$_POST['email']){


            $error .= "An email address is required<br>";


        }

        if(!$_POST['password']){



            $error .= "a password is required<br>";



        }

        if($error != ""){


            $error .= "<p>There were error(s) in your form: </p>".$error;


        }else{

            //sign up check the sign up form is being used
            if($_POST['signUp']){

                //check email with db
            $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1";

            $result = mysqli_query($link, $query);

            if(mysqli_num_rows($result) >0){


                $error = "Email address is already taken";

            }else{
                //password encryption
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

                //insert user to db
                $query = "INSERT INTO `users` (`email`, `password`) VALUE  ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link, $hash)."')";
            
                //check for error
                if(!mysqli_query($link,$query)){


                    $error = "Could not sign you up";

                }else{
                    //sign up succcesfull create session
                    $id = mysqli_insert_id($link);

                    //set session id = to database id 
                    $_SESSION['id'] = $id;

                    //create cookie if stay logged in checked
                    if ($_POST['stayLoggedIn'] == '1' ){

                        //set cookie for a week
                        setcookie("id", $id, time() + 60 * 60 * 24 * 7);


                    }
            
                    //redirect to logged in page
                    header("location: loggedIn.php");
                }
            
            }
            //else logging in 
            }else{
                //get user details from database that match the email entered
                $query = "SELECT id, email, password FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'"; 
               //run query and set as results
                $result = mysqli_query($link, $query);
                //set row as array of results
                $row = (mysqli_fetch_array($result));
                //set id = to database id 
                $id = $row['id'];
                //set hash as database password
                $hash = $row['password'];

                
                //check for data
                if (mysqli_num_rows($result) == 1) {

                    

                    
                       // check for correct password
                        if (password_verify($_POST['password'],$hash)) {
                            //set session id = to database id
                            $_SESSION['id'] = $id;
                            //create cookie if stay logged in checked
                         if ($_POST['stayLoggedIn'] == '1' ){

                            //set cookie for a week
                         setcookie("id",$id, time() + 60 * 60 * 24 * 7);


                        }
            
                        //redirect to logged in page
                         header("location: loggedIn.php");

                        } else {

                            
                            $error = "Incorrect Password!";
                        }
                    }else {
                        $error = "Invalid Login. Try again, or Sign up.";
                    }


            }

        }



    }


?>

<?php include("header.php"); ?>



 

    <div id="homePageContainer" class="container text-center">

    <h1>Online Journal</h1>

    <div id="error"><?php if ($error!="") {
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
} ?></div>

<!-- sign up form -->
<form method="post" id="signUpForm" class="text-center">

        <p>Intrested? Sign up now!</p>

    <div class="form-group text-left">
        <label  for="email">Email address</label>
        <input type="email" class="form-control" name="email" placeholder="Your Email">
    </div>

    <div class="form-group text-left">
        <label  for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="password">
    </div>

    <div class="form-group form-check">
        
        <input type="checkbox" class="form-check-input"  name="stayLoggedIn" value="1">
        <label class="form-check-label" for="stayLoggedIn">Stay Logged In</label>
    </div>

    <div class="form-group">
    
    <!-- hidden input to check which form is being used -->
        <input type="hidden" name="signUp" value=1>
    
        <input type="submit" class="btn btn-danger" name="submit" value="Sign Up">
    </div>

    <p><a class="toggleForms btn btn-primary">Log In</a></p>

</form>

<!-- log in form -->
<form method="post" id="logInForm" class="text-center">

        <p>Log in with your email and password</p>

    <div class="form-group text-left">
        <label  for="email">Email address</label>
        <input type="email" class="form-control" name="email" placeholder="Your Email">
    </div>

    <div class="form-group text-left">
        <label  for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="password">
    </div>

    <div class="form-group form-check">
        
        <input type="checkbox" class="form-check-input"  name="stayLoggedIn" value="1">
        <label class="form-check-label" for="stayLoggedIn">Stay Logged In</label>
    </div>

    <div class="form-group">
    
    <!-- hidden input to check which form is being used -->
        <input type="hidden" name="signUp" value=0>
    
        <input type="submit" class="btn btn-success" name="submit" value="Log In">
    </div>

    <p><a class="toggleForms btn btn-primary">Sign Up</a></p>

</form>

</div>


<?php include("footer.php"); ?>


