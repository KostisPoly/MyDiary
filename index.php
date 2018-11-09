
<?php
    session_start();
    $error = "";

    if (array_key_exists("logout", $_GET)) {
        unset($_SESSION);
        setcookie("id", "", time()-60*60);
        $_COOKIE['id'] = "";
    }else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) 
    OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header('Location: loggedinpage.php');
    }


    if(array_key_exists("submit", $_POST)){
        
        $host = 'localhost';
        $user = 'diary_user';
        $pass = 123;
        $db = 'my_diary_database';
        $link = mysqli_connect($host,$user,$pass,$db);
        if (mysqli_connect_error()) {
            die("Database error!");
        }
        if (!$_POST['email']) {
            $error .= "Please insert an email address</br>";
        }
        if (!$_POST['password']) {
            $error .= "A password is required</br>";
        }
        if ($error !="") {
            $error =  "<p>There were errors in your form:</p>".$error;
        }else {
            if ($_POST['signUp'] == '1') {
                
            
                $query = "SELECT id FROM users WHERE email = 
                '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
                $result = mysqli_query($link, $query);
                if (mysqli_num_rows($result) > 0) {
                    $error = "That email is already in use";
                }else {
                    $query = "INSERT INTO users (email, password) VALUES 
                    ('".mysqli_real_escape_string($link, $_POST['email'])."',
                    '".mysqli_real_escape_string($link, $_POST['password'])."')";
                    
                    
                    if (!mysqli_query($link, $query)) {
                        $error = "<p>Could not sign in!</p>";
                    }else {
                        echo "Successfull Sign up!";
                        $query = "UPDATE users SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE
                        id = ".mysqli_insert_id($link)." LIMIT 1";
                        mysqli_query($link, $query);
                    
                        $_SESSION['id'] = mysqli_insert_id($link);
                        if ($_POST['stayLoggedIn'] == '1') {
                            setcookie("id", mysqli_insert_id($link), time()*60*60*24*30);
                        }
                        
                        header("Location: loggedinpage.php");
                    }
                }
            } else {
                $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                $result = mysqli_query($link, $query); 
                $row = mysqli_fetch_array($result);
                if (isset($row)) {//Not array_key_exists raises warning on empty array argument!
                    $hashedPassword = md5(md5($row['id']).$_POST['password']);
                    
                    if ($hashedPassword == $row['password']) {
                        $_SESSION['id'] = $row['id'];

                        if ($_POST['stayLoggedIn'] == '1') {
                            setcookie("id", $row['id'], time()+60*60*24*30);
                        }

                        header("Location: loggedinpage.php");
                    }else {
                        $error = "Invalid email/password combination!";
                    }
                }else {
                    $error = "Email/password combination doesnt exist!";
                }

            }    
        }
    }



?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style type="text/css">
        .container{
            margin-top: 15%;
            width: 40%;
            text-align: center;
        }
        
        body{
            color: black;
            background: url(lib/writingdiary.jpeg) no-repeat center center fixed;
            background-size: cover;
        }
        #loginForm{
            display: none;
        }
    </style>
    <title>My Online Diary!</title>
  </head>
  <body>
  <div class="container">
      
    <h1>Hello, Diary!</h1>

    <div id="error" class="text-danger">
    <?php echo $error; ?>
</div>
<form method="post" id="signUpForm" >
    <fieldset class= "form-group">
        <input class="form-control" type="email" name="email" placeholder="enter email">
    </fieldset>
    <fieldset class= "form-group">
        <input class="form-control" type="password" name="password" placeholder="enter password">
    </fieldset>
    <div class="checkbox">
        <input  type="checkbox" name="stayLoggedIn" value=1>Stay Logged In.
    </div>
    <fieldset class= "form-group">
        <input class="btn btn-info" type="submit" name="submit" value="Sign Up!">
        <input  type="hidden" name="signUp" value="1">
    </fieldset>

    <p class="mt-5 text-primary">Already a member then...</p>
    <p><a id="showLogInForm" class="btn btn-warning">Log In</a></p>
</form>

<form method="post" id="loginForm">
    <fieldset class= "form-group">
        <input class="form-control" type="email" name="email" placeholder="enter email">
    </fieldset>
    <fieldset class= "form-group">
        <input class="form-control" type="password" name="password" placeholder="enter password">
    </fieldset>
    <div class="checkbox">
        <input  type="checkbox" name="stayLoggedIn" value=1>Stay Logged In.
    </div>
    <fieldset class= "form-group">
        <input class="btn btn-info" type="submit" name="submit" value="Log In!">
        <input  type="hidden" name="signUp" value="0">
    </fieldset>

    <p class="mt-5 text-primary">Not a member?</p>
    <p><a id="showSignUpForm" class="btn btn-warning">Sign Up</a></p>
</form>

</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
    <script>
        $("#showLogInForm").click(function(){
            $("#signUpForm").toggle();
            $("#loginForm").toggle();
        });
        
        $("#showSignUpForm").click(function(){
            $("#signUpForm").toggle();
            $("#loginForm").toggle();
        });
    </script>
  
  </body>
</html>

